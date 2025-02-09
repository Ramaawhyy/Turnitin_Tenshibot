<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CekPlagiasi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Google\Service\Drive\Permission;
use Google\Service\Drive;
use Google\Client;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    /**
     * Menampilkan daftar dokumen.
     */

    public function user()
    {
        return view('user.dashboard');  // Tampilkan dashboard user biasa
    }


    public function index(Request $request)
    {
        
        $user = Auth::user();

        // Cek role pengguna
        if ($user->role == 'user') {
            return view('user.dashboard');  // Jika superadmin, tampilkan dashboard superadmin
        }
        // Mengambil input pencarian dan per_page, dengan default per_page 10
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        // Validasi per_page agar hanya menerima 10, 25, 50, atau 100
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        // Mengambil semua dokumen dengan relasi 'token', diurutkan berdasarkan tanggal pembuatan terbaru
        $query = CekPlagiasi::with('token')->orderBy('created_at', 'desc');

        // Filter berdasarkan status (opsional)
        if ($request->has('status') && in_array($request->status, ['pending', 'in_progress', 'completed'])) {
            $query->whereHas('token', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        // Penerapan pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('nomor_hp', 'like', '%' . $search . '%');
                // Tambahkan field lain yang ingin dicari jika perlu
            });
        }

        // Menambahkan pagination dengan per_page yang ditentukan
        $documents = $query->paginate($perPage)->withQueryString();

        // Logging untuk debugging
        Log::info('Dashboard - Documents retrieved:', ['count' => $documents->count()]);

        return view('dashboard', compact('documents', 'search', 'perPage'));
    }

    /**
     * Menampilkan formulir edit dokumen.
     */
    public function edit($id)
    {
        // Mengambil dokumen berdasarkan ID
        $document = CekPlagiasi::findOrFail($id);
        return view('dashboard.edit', compact('document')); // Ubah nama view sesuai kebutuhan
    }

    public function updateDocumentFile(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:255',
            'profilenama' => 'nullable|string|max:255',
            'link_dokumen' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240', // Maks 10MB
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'link_dokumen.mimes' => 'Format file yang diterima: PDF, DOC, DOCX, TXT.',
            'link_dokumen.max' => 'Maksimal ukuran file adalah 10MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Temukan dokumen
        $document = CekPlagiasi::findOrFail($id);

        // Update field teks
        $document->judul = $request->judul;
        $document->nomor_hp = $request->nomor_hp;
        $document->profilenama = $request->profilenama;

        // Handle file upload jika ada
        if ($request->hasFile('link_dokumen')) {
            // Inisialisasi Google Drive Client
            $serviceAccountPath = storage_path('app' . DIRECTORY_SEPARATOR . 'google-service-account.json');
            if (!file_exists($serviceAccountPath)) {
                Log::error("File service account tidak ditemukan di: $serviceAccountPath");
                return redirect()->back()->with('error', 'Konfigurasi Google Drive tidak ditemukan.');
            }

            $client = new Client();
            $client->setAuthConfig($serviceAccountPath);
            $client->addScope(Drive::DRIVE);
            $driveService = new Drive($client);

            // Hapus file lama dari Google Drive jika ada (Opsional)
            if ($document->google_drive_file_id) {
                try {
                    $driveService->files->delete($document->google_drive_file_id);
                    Log::info("File lama di Google Drive berhasil dihapus: " . $document->google_drive_file_id);
                } catch (\Exception $e) {
                    Log::error("Gagal menghapus file lama di Google Drive: " . $e->getMessage());
                    // Anda bisa memilih untuk melanjutkan atau menghentikan proses di sini
                }
            }

            // Simpan file baru ke Google Drive
            $file = $request->file('link_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();

            Log::info("Memulai proses upload file baru ke Google Drive: $filename");

            // Upload file ke Google Drive
            $fileMetadata = new Drive\DriveFile([
                'name' => $filename,
                'parents' => [env('GOOGLE_DRIVE_FOLDER_ID')],
            ]);

            $uploadedFile = $driveService->files->create($fileMetadata, [
                'data' => file_get_contents($file->getRealPath()),
                'mimeType' => $file->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id,webViewLink',
            ]);

            $fileId = $uploadedFile->id;
            $webViewLink = $uploadedFile->webViewLink;

            // Membuat file dapat diakses oleh siapa saja dengan link
            $permission = new Permission();
            $permission->setType('anyone');
            $permission->setRole('reader');
            $driveService->permissions->create($fileId, $permission);

            Log::info("Berhasil mengunggah ke Google Drive: $filename, Link: $webViewLink, File ID: $fileId");

            // Update link_dokumen dan google_drive_file_id pada dokumen
            $document->link_dokumen = $webViewLink; // Menyimpan link Google Drive ke link_dokumen
            $document->google_drive_file_id = $fileId; // Menyimpan file ID dari Google Drive
            $document->dokumen = $filename; // Menyimpan nama file baru jika diperlukan
            $document->is_edited = 1; // Menandai dokumen sebagai telah diedit
        }

        // Simpan perubahan
        $document->save();

        // Log update
        Log::info('Dashboard - Document updated:', ['id' => $document->id]);

        return redirect()->route('dashboard')->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Memperbarui status dokumen.
     */
    public function updateStatus(Request $request, $id)
    {
        // Validasi input status
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,in_progress,completed',
        ], [
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status tidak valid.',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Nilai status tidak valid.');
        }

        // Mengambil dokumen berdasarkan ID
        $document = CekPlagiasi::findOrFail($id);
        $token = $document->token;

        if ($token) {
            // Memperbarui status token
            $token->status = $request->status;
            $token->save();

            // Logging pembaruan status
            Log::info('Dashboard - Token status updated:', ['document_id' => $id, 'new_status' => $request->status]);

            return back()->with('success', 'Status berhasil diperbarui.');
        }

        return back()->with('error', 'Token tidak ditemukan.');
    }

    public function showDocument($id)
    {
        try {
            // Temukan dokumen berdasarkan ID
            $document = CekPlagiasi::findOrFail($id);

            // Dapatkan path file dokumen
            $filePath = storage_path('app/public/' . $document->link_dokumen);

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

    public function download($id) 
    { 
        // Mengambil dokumen berdasarkan ID 
        $document = CekPlagiasi::findOrFail($id); 
    
        // Memeriksa apakah dokumen memiliki google_drive_file_id 
        if (!$document->google_drive_file_id) { 
            return redirect()->back()->with('error', 'Dokumen tidak tersedia untuk diunduh.'); 
        } 
    
        // Path ke file service account JSON 
        $serviceAccountPath = storage_path('app/google-service-account.json'); 
    
        // Memeriksa keberadaan file service account 
        if (!file_exists($serviceAccountPath)) { 
            Log::error("File service account tidak ditemukan di: $serviceAccountPath"); 
            return redirect()->back()->with('error', 'Konfigurasi Google Drive tidak ditemukan.');
        } 
    
        // Inisialisasi Google Client 
        $client = new Client(); 
        $client->setAuthConfig($serviceAccountPath); 
        $client->addScope(Drive::DRIVE_READONLY); // Gunakan scope READONLY jika hanya untuk unduh 
    
        // Inisialisasi Google Drive Service 
        $driveService = new Drive($client); 
    
        try { 
            // Mendapatkan konten file dari Google Drive 
            $response = $driveService->files->get($document->google_drive_file_id, [ 
                'alt' => 'media' 
            ]); 
    
            // Mendapatkan nama file 
            $filename = $document->dokumen; 
    
            // Menginisiasi unduhan dengan streamed response 
            return response()->stream(function () use ($response) { 
                while (!$response->getBody()->eof()) { 
                    echo $response->getBody()->read(1024); 
                } 
            }, 200, [ 
                'Content-Type' => 'application/octet-stream', 
                'Content-Disposition' => 'attachment; filename="' . $filename . '"', 
            ]); 
        } catch (\Exception $e) { 
            Log::error("Gagal mengunduh dokumen dari Google Drive: " . $e->getMessage()); 
            return redirect()->back()->with('error', 'Gagal mengunduh dokumen.');
        } 
    }

    public function process(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'nomor_hp' => 'required|numeric',  // Validasi nomor telepon
            'profilenama' => 'required|string',  // Validasi nama profil
        ]);

        // Mencari semua data berdasarkan nomor telepon
        $cekPlagiasi = CekPlagiasi::where('nomor_hp', $request->nomor_hp)->get();

        if ($cekPlagiasi->isNotEmpty()) {
            // Jika ada data dengan nomor telepon tersebut, update nama profil untuk semua entri
            foreach ($cekPlagiasi as $data) {
                $data->profilenama = $request->profilenama;
                $data->save(); // Simpan perubahan untuk setiap data
            }

            // Kembali ke dashboard dengan pesan sukses
            return redirect()->route('dashboard')->with('success', 'Nama profil berhasil diupdate untuk semua nomor telepon tersebut!');
        } else {
            // Jika nomor telepon tidak ditemukan, beri pesan error
            return redirect()->back()->with('nomor_hp_not_found', 'Nomor telepon tidak ditemukan!');
        }
    }

}
