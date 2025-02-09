<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CekPlagiasi;
use App\Models\Token;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\Permission;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CekPlagiasiController extends Controller
{
    // Menampilkan form dan daftar dokumen
    public function index()
    {
        $documents = CekPlagiasi::all();
        return view('cekturnitin', compact('documents'));
    }

    // Menyimpan form dan mengirim token
    public function store(Request $request)
    {
        Log::info("Memulai proses penyimpanan dokumen.");

        // Aturan validasi awal
        $rules = [
            'dokumen' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'nomor_hp' => [
                'required',
                'regex:/^(\+62|62|0)8[1-9][0-9]{6,}$/',
                'digits_between:10,15',
            ],
            'judul' => 'nullable|string|max:255',
            'exclude_daftar_pustaka' => 'sometimes|boolean',
            'exclude_kutipan' => 'sometimes|boolean',
        ];

        // Tambahkan aturan validasi untuk 'Exclude Match' jika checkbox dicentang
        if ($request->has('exclude_match_checkbox') && $request->exclude_match_checkbox) {
            Log::info("Exclude Match dicentang.");

            // Validasi untuk Percentage jika checkbox Percentage dicentang
            if ($request->has('exclude_match_percentage_checkbox') && $request->exclude_match_percentage_checkbox) {
                $rules['exclude_match_percentage_value'] = 'required|numeric|min:0|max:100';
                Log::info("Exclude Match Percentage dicentang.");
            }

            // Validasi untuk Words jika checkbox Words dicentang
            if ($request->has('exclude_match_words_checkbox') && $request->exclude_match_words_checkbox) {
                $rules['exclude_match_words_value'] = 'required|numeric|min:0';
                Log::info("Exclude Match Words dicentang.");
            }

            // Validasi bahwa setidaknya salah satu dari Percentage atau Words dicentang
            $request->validate([
                'exclude_match_percentage_checkbox' => 'required_without:exclude_match_words_checkbox',
                'exclude_match_words_checkbox' => 'required_without:exclude_match_percentage_checkbox',
            ]);
        }

        // Validasi data
        try {
            Log::info("Melakukan validasi data.");
            $validated = $request->validate($rules);
            Log::info("Validasi data berhasil.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("Validasi gagal: " . $e->getMessage());
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        // Normalisasi nomor HP
        $normalizedPhoneNumber = $this->normalizePhoneNumber($validated['nomor_hp']);

        Log::info("Nomor HP setelah normalisasi: $normalizedPhoneNumber");

        // Tangani file upload
        $file = $request->file('dokumen');
        $filename = time() . '_' . $file->getClientOriginalName();

        Log::info("Memulai proses upload file: $filename");

        try {
            $shareableLink = $this->uploadToGoogleDrive($file, $filename);

            if (!$shareableLink) {
                Log::error("Gagal mengunggah dokumen ke Google Drive: $filename");
                return redirect()->back()->with('error', 'Gagal mengunggah dokumen ke Google Drive.');
            }

            Log::info("Berhasil mengunggah ke Google Drive: $filename, Link: $shareableLink");

            // Proses Exclude Match
            $exclude_match_percentage = null;
            $exclude_match_words = null;

            if ($request->has('exclude_match_checkbox') && $request->exclude_match_checkbox) {
                if ($request->has('exclude_match_percentage_checkbox') && $request->exclude_match_percentage_checkbox) {
                    $exclude_match_percentage = $validated['exclude_match_percentage_value'];
                    Log::info("Exclude Match Percentage: $exclude_match_percentage");
                }

                if ($request->has('exclude_match_words_checkbox') && $request->exclude_match_words_checkbox) {
                    $exclude_match_words = $validated['exclude_match_words_value'];
                    Log::info("Exclude Match Words: $exclude_match_words");
                }
            }

            // Simpan data ke database
            $document = CekPlagiasi::create([
                'judul' => $validated['judul'] ?? null,
                'nomor_hp' => $normalizedPhoneNumber,
                'exclude_daftar_pustaka' => $validated['exclude_daftar_pustaka'] ?? false,
                'exclude_kutipan' => $validated['exclude_kutipan'] ?? false,
                'exclude_match_percentage' => $exclude_match_percentage,
                'exclude_match_words' => $exclude_match_words,
                'dokumen' => $filename,
                'link_dokumen' => $shareableLink,
                'user_id' => Auth::check() ? Auth::id() : null,
            ]);

            Log::info("Berhasil membuat record di database untuk dokumen: $filename dengan ID: " . $document->id);

            // Buat token
            $token = Str::upper(Str::random(10));
            Token::create([
                'cek_plagiasi_id' => $document->id,
                'token' => $token,
                'status' => 'pending',
                'user_id' => Auth::check() ? Auth::id() : null,
            ]);

            Log::info("Berhasil membuat token: $token untuk dokumen ID: " . $document->id);

            // Kirim notifikasi WhatsApp dengan token
            $this->sendWhatsAppNotification($document, $token);

            Log::info("Berhasil mengirim notifikasi WhatsApp untuk dokumen ID: " . $document->id . " dengan token: $token");

            return redirect()->back()->with('success', 'Dokumen berhasil diunggah dan sedang diperiksa. Token telah dikirim ke WhatsApp Anda.');
        } catch (\Exception $e) {
            Log::error("Gagal menyimpan dokumen atau mengirim notifikasi: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data atau mengirim notifikasi.');
        }
    }

    // Fungsi untuk normalisasi nomor telepon
    private function normalizePhoneNumber($phoneNumber)
    {
        // Hapus karakter non-digit
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Hapus awalan '0', '62', atau '+62'
        $phoneNumber = preg_replace('/^0/', '', $phoneNumber);
        $phoneNumber = preg_replace('/^62/', '', $phoneNumber);
        $phoneNumber = preg_replace('/^\+62/', '', $phoneNumber);

        // Tambahkan kode negara '62' di depan
        return '62' . $phoneNumber;
    }

    // Mengupload file ke Google Drive
    private function uploadToGoogleDrive($file, $filename)
    {
        try {
            $serviceAccountPath = storage_path('app' . DIRECTORY_SEPARATOR . 'google-service-account.json');
            Log::info("Menggunakan service account di: $serviceAccountPath");

            if (!file_exists($serviceAccountPath)) {
                Log::error("File service account tidak ditemukan di: $serviceAccountPath");
                return null;
            }

            $client = new Client();
            $client->setAuthConfig($serviceAccountPath);
            $client->addScope(Drive::DRIVE);

            $driveService = new Drive($client);

            Log::info("Menginisialisasi Drive API Client.");

            $fileMetadata = new Drive\DriveFile([
                'name' => $filename,
                'parents' => [env('GOOGLE_DRIVE_FOLDER_ID')],
            ]);

            Log::info("Memulai upload file ke Google Drive: $filename");

            $uploadedFile = $driveService->files->create($fileMetadata, [
                'data' => file_get_contents($file->getRealPath()),
                'mimeType' => $file->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id',
            ]);

            $fileId = $uploadedFile->id;

            Log::info("Berhasil mengunggah file ke Google Drive dengan ID: $fileId");

            $permission = new Permission();
            $permission->setType('anyone');
            $permission->setRole('reader');
            $driveService->permissions->create($fileId, $permission);

            Log::info("Berhasil membuat permission untuk file ID: $fileId");

            $file = $driveService->files->get($fileId, ['fields' => 'webViewLink, webContentLink']);

            Log::info("Mengambil link shareable untuk file ID: $fileId");

            return $file->webViewLink;
        } catch (\Exception $e) {
            Log::error("Gagal mengunggah ke Google Drive: " . $e->getMessage());
            return null;
        }
    }

    // Mengirim notifikasi WhatsApp dengan token
    private function sendWhatsAppNotification($document, $token)
    {
        try {
            $apiKey = env('FONNTE_API_KEY');
            if (empty($apiKey)) {
                Log::error("FONNTE_API_KEY tidak ditemukan di .env.");
                return;
            }

            Log::info('API Key Length: ' . strlen($apiKey));

            // Nomor tujuan admin dan pengguna dalam format internasional tanpa '+'
            $nomor_admin = '6285861765261';
            $nomor_pengguna = $document->nomor_hp; // Nomor sudah dinormalisasi

            // Mendapatkan URL publik ke dokumen dari Google Drive
            $dokumenUrl = $document->link_dokumen;

            if (!$dokumenUrl) {
                Log::error("Link dokumen tidak tersedia untuk dokumen ID: " . $document->id);
                return;
            }

            // Memendekkan URL menggunakan fungsi shortenUrl (opsional)
            $shortUrl = $this->shortenUrl($dokumenUrl);

            // Pastikan link dimulai dengan 'https://'
            if (strpos($shortUrl, 'http') !== 0) {
                $shortUrl = 'https://' . ltrim($shortUrl, '/');
            }

            Log::info("Short URL yang akan digunakan dalam pesan: $shortUrl");

            // Membuat link wa.me untuk nomor pengguna
            $waMeLink = 'https://wa.me/' . $nomor_pengguna;

            // Membuat pesan untuk Admin (tanpa token)
            $messageToAdmin = "Dokumen baru telah diunggah.\n";
            $messageToAdmin .= "Judul: " . ($document->judul ?? 'Tidak ada judul') . "\n";
            $messageToAdmin .= "Nomor HP Pengguna: $nomor_pengguna\n";
            $messageToAdmin .= "Exclude Daftar Pustaka: " . ($document->exclude_daftar_pustaka ? 'Ya' : 'Tidak') . "\n";
            $messageToAdmin .= "Exclude Kutipan: " . ($document->exclude_kutipan ? 'Ya' : 'Tidak') . "\n";
            $messageToAdmin .= "Exclude Match Percentage: " . ($document->exclude_match_percentage ?? '-') . "%\n";
            $messageToAdmin .= "Exclude Match Words: " . ($document->exclude_match_words ?? '-') . "\n";
            $messageToAdmin .= "Link Dokumen:\n";
            
            $messageToAdmin .= $shortUrl . "\n"; // Pastikan link berada di baris tersendiri

            Log::info("Membuat pesan WhatsApp untuk Admin: $messageToAdmin");

            // Menyiapkan data untuk dikirim ke Admin
            $postDataAdmin = [
                'target' => $nomor_admin, // Mengirim ke Admin
                'message' => $messageToAdmin,
                'delay' => '2',
                'typing' => 'false',
            ];

            // Kirim pesan ke Admin
            $this->sendMessageViaFonnte($postDataAdmin, 'Admin');

            // Membuat pesan untuk Customer (hanya token)
            $messageToCustomer = "Halo,\n";
            $messageToCustomer .= "Dokumen Anda telah berhasil diunggah dan sedang kami proses untuk pengecekan plagiarisme.\n";
            $messageToCustomer .= "Terima kasih telah menggunakan Tenshi Bot untuk memastikan keaslian karya Anda.\n";
            $messageToCustomer .= "Untuk informasi lebih lanjut atau bantuan, silakan hubungi kami melalui WhatsApp:\n";
            // $messageToCustomer .= "$waMeLink\n";
            $messageToCustomer .= "Kami siap membantu Anda kapan saja!\n";
            

            Log::info("Membuat pesan WhatsApp untuk Customer: $messageToCustomer");

            // Menyiapkan data untuk dikirim ke Customer
            $postDataCustomer = [
                'target' => $nomor_pengguna, // Mengirim ke Customer
                'message' => $messageToCustomer,
                'delay' => '2',
                'typing' => 'false',
            ];

            // Kirim pesan ke Customer
            $this->sendMessageViaFonnte($postDataCustomer, 'Customer');

        } catch (\Exception $e) {
            Log::error("Exception saat mengirim pesan WhatsApp: " . $e->getMessage());
        }
    }

    // Fungsi tambahan untuk mengirim pesan melalui Fonnte
    private function sendMessageViaFonnte($postData, $recipientType)
    {
        try {
            $apiKey = env('FONNTE_API_KEY');
            if (empty($apiKey)) {
                Log::error("FONNTE_API_KEY tidak ditemukan di .env.");
                return;
            }

            // Inisialisasi cURL
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => http_build_query($postData),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $apiKey,
                    'Content-Type: application/x-www-form-urlencoded',
                ),
            ));

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
                Log::error("cURL Error saat mengirim pesan WhatsApp ke $recipientType: " . $error_msg);
            }

            curl_close($curl);

            // Logging respons dari API
            Log::info("Response HTTP Code dari Fonnte API untuk $recipientType: $httpCode");
            Log::info("Response Body dari Fonnte API untuk $recipientType: $response");

            $responseData = json_decode($response, true);

            if (isset($responseData['status']) && $responseData['status'] == true) {
                Log::info("Pesan WhatsApp berhasil dikirim ke $recipientType.");
            } else {
                $errorMessage = isset($responseData['reason']) ? $responseData['reason'] : (isset($responseData['message']) ? $responseData['message'] : 'Unknown error');
                Log::error("Gagal mengirim pesan WhatsApp ke $recipientType. Response: $errorMessage");
            }
        } catch (\Exception $e) {
            Log::error("Exception saat mengirim pesan WhatsApp ke $recipientType: " . $e->getMessage());
        }
    }

    // Memendekkan URL menggunakan Bitly
    private function shortenUrl($longUrl)
    {
        try {
            Log::info("Memulai proses shorten URL untuk: $longUrl");

            $accessToken = env('BITLY_ACCESS_TOKEN');
            if (empty($accessToken)) {
                Log::error("Access token Bitly tidak ditemukan. Pastikan Anda telah menambahkannya ke file .env.");
                return $longUrl;
            }

            $url = 'https://api-ssl.bitly.com/v4/shorten';

            $data = [
                'long_url' => $longUrl,
                'domain' => 'bit.ly',
            ];

            $payload = json_encode($data);

            $headers = [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json',
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);

            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                Log::error("cURL Error saat memendekkan URL: " . $error_msg);
                curl_close($ch);
                return $longUrl;
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $json = json_decode($result, true);

            if ($httpCode == 200 && isset($json['link'])) {
                $shortUrl = $json['link'];
                Log::info("Short URL yang didapat: $shortUrl");
                return $shortUrl;
            } else {
                $errorMessage = isset($json['message']) ? $json['message'] : 'Unknown error';
                Log::error("Gagal memendekkan URL. HTTP Code: $httpCode, Error: $errorMessage");
                return $longUrl;
            }
        } catch (\Exception $e) {
            Log::error("Exception saat memendekkan URL: " . $e->getMessage());
            return $longUrl;
        }
    }

    // Menampilkan halaman untuk pengguna memasukkan token
    public function showTokenForm()
    {
        return view('enter_token');
    }

    // Menampilkan detail berdasarkan token
    public function showDetails(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string|exists:tokens,token',
        ]);

        $token = Token::where('token', $validated['token'])->first();

        if (!$token) {
            return redirect()->back()->with('error', 'Token tidak ditemukan.');
        }

        $document = $token->cekTurnitin;
        $status = $token->status;

        return view('token_details', compact('document', 'status'));
    }

    // Update status dari admin (superadmin)
    public function updateStatus(Request $request, Token $token)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $token->status = $validated['status'];
        $token->save();

        // Anda bisa menambahkan notifikasi kepada pengguna jika diperlukan

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    public function processToken(Request $request)
    {
        // Validasi input token
        $request->validate([
            'token' => 'required|string',
        ]);

        $tokenInput = $request->input('token');
        Log::info('Token yang dimasukkan:', ['token' => $tokenInput]);

        // Cari dokumen berdasarkan token
        $document = CekPlagiasi::whereHas('token', function ($query) use ($tokenInput) {
            $query->where('token', $tokenInput);
        })->with('token')->first();

        if ($document) {
            Log::info('Dokumen ditemukan:', ['document_id' => $document->id]);
            // Simpan data dokumen dan status ke sesi
            session()->flash('document', [
                'judul' => $document->judul,
                'nomor_hp' => $document->nomor_hp,
                'dokumen' => $document->link_dokumen,
            ]);
            session()->flash('status', $document->token->status);
        } else {
            Log::warning('Dokumen tidak ditemukan untuk token:', ['token' => $tokenInput]);
            // Jika token tidak ditemukan, set error message
            session()->flash('token_error', 'Token yang Anda masukkan tidak valid atau tidak ditemukan.');
        }

        // Arahkan kembali ke halaman sebelumnya
        return redirect()->back();
    }

    public function processPhoneNumber(Request $request)
    {
        $validated = $request->validate([
            'nomor_hp' => [
                'required',
                'regex:/^(\+62|62|0)8[1-9][0-9]{6,}$/',
                'digits_between:10,15',
            ],
        ]);

        // Normalisasi nomor telepon
        $nomor_hp = $this->normalizePhoneNumber($validated['nomor_hp']);

        // Redirect to results page
        return redirect()->route('cek-pembelian.results', ['nomor_hp' => $nomor_hp]);
    }

    public function showPurchases(Request $request, $nomor_hp)
    {
        $nomor_hp_suffix = substr($nomor_hp, -8);
    
        // Ambil parameter 'search' dan 'per_page' dari request
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default 10 jika tidak ada
    
        // Validasi nilai 'per_page'
        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }
    
        // Membuat query dasar
        $query = CekPlagiasi::where('nomor_hp', 'like', '%' . $nomor_hp_suffix)
            ->with('token')
            ->whereHas('token'); // Pastikan hanya dokumen dengan token yang diambil
    
        // Tambahkan kondisi pencarian jika parameter 'search' ada
        if ($search) {
            $query->where('judul', 'like', '%' . $search . '%');
        }
    
        // Paginasi dengan jumlah item per halaman sesuai 'per_page'
        $documents = $query->orderBy('created_at', 'desc')->paginate($perPage);
    
        if ($documents->isEmpty()) {
            return view('cek_pembelian_results', ['documents' => null, 'nomor_hp' => $nomor_hp])->with('error', 'Tidak ada data pembelian untuk nomor ini.');
        }
    
        // Menambahkan status_class ke setiap dokumen
        $documents->getCollection()->transform(function ($doc) {
            $doc->status_class = $this->getStatusClass($doc->token->status);
            return $doc;
        });
    
        return view('cek_pembelian_results', compact('documents', 'nomor_hp'));
    }
    
    
    
    /**
     * Memetakan status ke kelas CSS.
     *
     * @param string $status
     * @return string
     */
    private function getStatusClass($status)
    {
        return match ($status) {
            'pending' => 'primary',
            'in_progress' => 'warning',
            'completed' => 'success',
            default => 'secondary',
        };
    }

    public function showDocument($id)
{
    try {
        // Temukan dokumen berdasarkan ID
        $document = CekPlagiasi::findOrFail($id);

        // Dapatkan path file dokumen
        $filePath = storage_path('app/public' . $document->link_dokumen);

        // Periksa apakah file ada
        if (!file_exists($filePath)) {
            Log::error("File dokumen tidak ditemukan: $filePath");
            abort(404, 'File tidak ditemukan.');
        }

        // Sajikan file kepada pengguna
        return response()->file($filePath);
    } catch (\Exception $e) {
        Log::error("Error saat menyajikan dokumen: " . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengakses dokumen.');
    }
}

// public function notify(Request $request, $trxId)
// {
//     Log::info('DOKU Notification Received', [
//         'trxId' => $trxId,
//         'data' => $request->all()
//     ]);

//     $transaksi = Transaksi::where('invoice_number', $trxId)->first();

//     if ($transaksi) {
//         if ($transaksi->cek_plagiasi->status_pembayaran === 'sudah_bayar') {
//             Log::info('Pembayaran sudah selesai untuk trxId: ' . $trxId);

//             $cek_plagiasi = CekPlagiasi::where('id', $transaksi->cek_plagiasi_id)->first();
//             $nomor_hp = $cek_plagiasi->nomor_hp;

//             // Redirect ke halaman hasil dengan nomor telepon dan pesan sukses
//             return redirect()->route('cek-pembelian.results', ['nomor_hp' => $nomor_hp])
//                              ->with('payment_success', 'Pembayaran sudah selesai untuk transaksi Anda.');
//         }

//         DB::transaction(function () use ($transaksi) {
//             Log::info('Memulai transaksi database untuk Transaksi ID: ' . $transaksi->id);
//             $document = $transaksi->cek_plagiasi;

//             if ($document) {
//                 $document->update(['status_pembayaran' => 'sudah_bayar']);
//                 Log::info('Status pembayaran diperbarui menjadi sudah_bayar untuk CekPlagiasi ID: ' . $document->id);
//             } else {
//                 Log::error('CekPlagiasi tidak ditemukan untuk Transaksi ID: ' . $transaksi->id);
//                 throw new \Exception('CekPlagiasi tidak ditemukan.');
//             }
//         });

//         Log::info('Pembayaran berhasil diperbarui untuk Transaksi ID: ' . $transaksi->id);

//         // Ambil nomor telepon setelah update
//         $cek_plagiasi = CekPlagiasi::where('id', $transaksi->cek_plagiasi_id)->first();
//         $nomor_hp = $cek_plagiasi->nomor_hp;

//         // Redirect ke halaman hasil dengan nomor telepon dan pesan sukses
//         return redirect()->route('cek-pembelian.results', ['nomor_hp' => $nomor_hp])
//                          ->with('payment_success', 'Pembayaran berhasil dilakukan.');
//     } else {
//         Log::error('Transaksi tidak ditemukan untuk trxId: ' . $trxId);
//         return response()->json(['status' => 'error', 'message' => 'Transaksi tidak ditemukan.'], 404);
//     }
// }

public function notify(Request $request, $trxId)
{
    Log::info('Midtrans Notification Received', [
        'trxId' => $trxId,
        'data' => $request->all()
    ]);

    // Memanggil fungsi callback dari PembayaranController
    app()->call('App\Http\Controllers\PembayaranController@callback', ['request' => $request]);

    // Jika ingin melakukan sesuatu setelah callback, tambahkan di sini

    return response()->json(['message' => 'OK']);
}

private function handleGagal($transaksi, $cek_plagiasi)
    {
        $currentStatus = $cek_plagiasi->status_pembayaran;

        if ($currentStatus !== 'belum_bayar') {
            // Mulai transaksi database untuk memperbarui status pembayaran
            DB::transaction(function () use ($transaksi, $cek_plagiasi) {
                Log::info('Memulai transaksi database untuk Transaksi ID: ' . $transaksi->id);

                // Update status pembayaran menjadi 'belum_bayar'
                $cek_plagiasi->update(['status_pembayaran' => 'belum_bayar']);
                Log::info('Status pembayaran diperbarui menjadi belum_bayar untuk CekPlagiasi ID: ' . $cek_plagiasi->id);
            });

            Log::info('Pembayaran gagal diperbarui untuk Transaksi ID: ' . $transaksi->id);
        } else {
            Log::info('Status pembayaran sudah ' . $currentStatus . ' untuk trxId: ' . $transaksi->invoice_number);
        }

        // Ambil nomor telepon setelah update
        $nomor_hp = $cek_plagiasi->nomor_hp;

        // Redirect kembali dengan pesan error
        return redirect()->route('cek-pembelian.results', ['nomor_hp' => $nomor_hp])
                         ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
    }

    /**
     * Fungsi untuk menangani status pembayaran tidak diterima (warning).
     */
    private function handleWarning($cek_plagiasi)
    {
        // Atur status_pembayaran menjadi 'belum_bayar'
        DB::transaction(function () use ($cek_plagiasi) {
            $cek_plagiasi->update(['status_pembayaran' => 'belum_bayar']);
            Log::info('Status pembayaran diatur menjadi belum_bayar karena status tidak diterima.');
        });

        // Ambil nomor telepon setelah update
        $nomor_hp = $cek_plagiasi->nomor_hp;

        // Redirect ke halaman hasil pembelian dengan pesan warning
        return redirect()->route('cek-pembelian.results', ['nomor_hp' => $nomor_hp])
                         ->with('warning', 'Status pembayaran tidak diterima. Transaksi Anda belum terbayar.');
    }

    /**
     * Fungsi untuk menangani status pembayaran yang tidak dikenali.
     */
    private function handleUnknownStatus($cek_plagiasi, $newStatus)
    {
        Log::warning('Status pembayaran tidak dikenali: ' . $newStatus);

        // Atur status_pembayaran menjadi 'belum_bayar'
        DB::transaction(function () use ($cek_plagiasi) {
            $cek_plagiasi->update(['status_pembayaran' => 'belum_bayar']);
            Log::info('Status pembayaran diatur menjadi belum_bayar karena status tidak dikenali.');
        });

        // Ambil nomor telepon setelah update
        $nomor_hp = $cek_plagiasi->nomor_hp;

        // Redirect ke halaman hasil pembelian dengan pesan warning
        return redirect()->route('cek-pembelian.results', ['nomor_hp' => $nomor_hp])
                         ->with('warning', 'Status pembayaran tidak dikenali. Transaksi Anda belum terbayar.');
    }


private function verifySignature($request)
{
    $signatureHeader = $request->header('Signature');
    $body = $request->getContent();

    $digest = base64_encode(hash('sha256', $body, true));

    $components = [
        'Client-Id' => $request->header('Client-Id'),
        'Request-Id' => $request->header('Request-Id'),
        'Request-Timestamp' => $request->header('Request-Timestamp'),
        'Request-Target' => $request->getPathInfo(),
        'Digest' => $digest,
    ];

    $signatureComponent = '';
    foreach ($components as $key => $value) {
        $signatureComponent .= $key . ':' . $value . "\n";
    }

    $computedSignature = 'HMACSHA256=' . base64_encode(hash_hmac('sha256', $signatureComponent, env('DOKU_SHARED_KEY'), true));

    return hash_equals($signatureHeader, $computedSignature);
}

public function callback(Request $request)
    {
        Log::info('Callback method called.');

        // Inisialisasi konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        // Buat objek Notification dari Midtrans
        try {
            $notif = new \Midtrans\Notification();
            Log::info('Notification object created.');
        } catch (\Exception $e) {
            Log::error('Error creating notification object: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing notification.'], 500);
        }

        $order_id = $notif->order_id;
        $status = $notif->transaction_status;
        $type = $notif->payment_type;
        $fraud = $notif->fraud_status;

        Log::info("Notification received for Order ID: $order_id, Status: $status, Type: $type, Fraud Status: $fraud");

        // Cari transaksi berdasarkan order_id (invoice_number)
        $transaksi = Transaksi::where('invoice_number', $order_id)->first();

        if (!$transaksi) {
            Log::error('Transaksi tidak ditemukan untuk order_id: ' . $order_id);
            return response()->json(['message' => 'Transaksi tidak ditemukan.'], 404);
        }

        Log::info("Transaksi ditemukan: ID {$transaksi->id}, Status sebelum update: {$transaksi->status_pembayaran}");

        // Pemetaan status Midtrans ke enum yang ada
        if ($status == 'settlement' || ($status == 'capture' && $type == 'credit_card' && $fraud == 'accept')) {
            // Pembayaran berhasil
            $transaksi->status_pembayaran = 'sudah_bayar';
        } else {
            // Pembayaran belum berhasil atau gagal, tetap 'belum_bayar'
            $transaksi->status_pembayaran = 'belum_bayar';
        }

        $transaksi->save();
        Log::info('Transaksi status updated to: ' . $transaksi->status_pembayaran);

        // Jika pembayaran berhasil, perbarui status_pembayaran pada CekPlagiasi
        if ($transaksi->status_pembayaran == 'sudah_bayar') {
            // Dapatkan model CekPlagiasi terkait
            $cekPlagiasi = $transaksi->cek_plagiasi;

            if ($cekPlagiasi) {
                Log::info("CekPlagiasi ditemukan: ID {$cekPlagiasi->id}, Status sebelum update: {$cekPlagiasi->status_pembayaran}");
                $cekPlagiasi->status_pembayaran = 'sudah_bayar';
                $cekPlagiasi->save();
                Log::info("Status pembayaran diperbarui menjadi 'sudah_bayar' untuk CekPlagiasi ID: {$cekPlagiasi->id}");
            } else {
                Log::error('CekPlagiasi tidak ditemukan untuk Transaksi ID: ' . $transaksi->id);
            }
        }

        return response()->json(['message' => 'OK'], 200);
    }





}
