<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CekPlagiasi;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransPembayaranController extends Controller
{
    /**
     * Konfigurasi Midtrans.
     */
    public function __construct()
    {
        $midtrans = config('services.midtrans');

        Config::$serverKey = $midtrans['server_key'];
        Config::$clientKey = $midtrans['client_key'];
        Config::$isProduction = $midtrans['is_production'];
        Config::$isSanitized = $midtrans['is_sanitized'];
        Config::$is3ds = $midtrans['is_3ds'];
    }

    /**
     * Tampilkan halaman metode pembayaran Midtrans.
     *
     * @param int $document_id
     * @return \Illuminate\View\View
     */
    public function showPaymentMethods($document_id)
    {
        $document = CekPlagiasi::findOrFail($document_id);

        if ($document->status_pembayaran == 'sudah_bayar') {
            return redirect()->route('cek-pembelian.results', ['nomor_hp' => $document->nomor_hp])
                             ->with('success', 'Dokumen ini sudah dibayar.');
        }

        return view('pembayaran.payment_methods', compact('document'));
    }

    /**
     * Proses inisiasi pembayaran menggunakan Midtrans.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
   public function process(Request $request)
{
    // Define all supported payment methods in Midtrans
    $supportedPaymentMethods = [
        'credit_card',
        'bca_va',
        'bni_va',
        'permata_va',
        'bri_va',
        'maybank_va',
        'other_va',      // For banks not explicitly listed
        'gopay',
        'shopeepay',
        'dana',
        'ovo',
        'link_aja',
        'indomaret',
        'alfamart',
        'qris',
        // Add other payment methods as needed
    ];

    // Validate input
    $request->validate([
        'document_id' => 'required|exists:cek_plagiasi,id',
        'payment_method' => 'required|string|in:' . implode(',', $supportedPaymentMethods),
        'nomor_hp' => 'required|numeric|digits_between:10,15', // Ensures phone number length
        'profilenama' => 'nullable|string|max:255', // Optional field
    ]);

    // Retrieve the document
    $document = CekPlagiasi::findOrFail($request->document_id);
    $amount = 2000; // Adjust the payment amount as needed
    $invoiceNumber = 'INV-MT-' . time() . '-' . $document->id;

    // Create a new transaction record
    $transaksi = Transaksi::create([
        'cek_plagiasi_id' => $document->id,
        'invoice_number' => $invoiceNumber,
        'amount' => $amount,
        'payment_method' => $request->payment_method,
        'profilenama' => $request->profilenama,
    ]);

    // Log transaction creation for debugging
    Log::info('Transaksi dibuat dengan nomor_hp: ' . $request->nomor_hp);

    // Prepare transaction details for Midtrans
    $transaction_details = [
        'order_id' => $transaksi->invoice_number,
        'gross_amount' => $transaksi->amount,
    ];

    // Prepare customer details
    $customer_details = [
        'first_name' => $document->nama_pelanggan ?? 'Pelanggan',
        'email' => $document->email_pelanggan ?? 'email@example.com',
        'phone' => $request->nomor_hp, // Use phone number from request
    ];

    // Initialize transaction data with common details
    $payment_method = $request->payment_method;
    $transaction_data = [
        'transaction_details' => $transaction_details,
        'customer_details' => $customer_details,
        'payment_type' => $payment_method,
        'enabled_payments' => [$payment_method], // Enable only the selected payment method
    ];

    // Customize payload based on the selected payment method
    switch ($payment_method) {
        // Virtual Account Payments
        case 'bca_va':
        case 'bni_va':
        case 'permata_va':
        case 'bri_va':
        case 'maybank_va':
        case 'other_va':
            $bank = strtoupper(explode('_va', $payment_method)[0]);
            $transaction_data['bank_transfer'] = [
                'bank' => $bank,
            ];
            break;

        // E-Wallets
        case 'gopay':
            // Add GoPay specific parameters if needed
            break;

        case 'shopeepay':
            // Add ShopeePay specific parameters if needed
            break;

        case 'dana':
            // Add DANA specific parameters if needed
            break;

        case 'ovo':
            // Add OVO specific parameters if needed
            break;

        case 'link_aja':
            // Add LinkAja specific parameters if needed
            break;

        // Retail Store Payments
        case 'indomaret':
            $transaction_data['cstore'] = [
                'store' => 'INDOMARET',
            ];
            break;

        case 'alfamart':
            $transaction_data['cstore'] = [
                'store' => 'ALFAMART',
            ];
            break;

        // QR Code Payments
        case 'qris':
            $transaction_data['payment_type'] = 'qris';
            // QRIS doesn't require additional parameters
            break;

        // Credit Card Payments
        case 'credit_card':
            // Optionally add credit card specific parameters, e.g., installments
            // $transaction_data['credit_card'] = [
            //     'installment' => [
            //         'required' => true,
            //         'terms' => [3, 6, 12],
            //     ],
            // ];
            break;

        // Add more cases as needed for other payment methods

        default:
            // Handle any unsupported payment methods gracefully
            Log::warning('Unsupported payment method selected: ' . $payment_method);
            return redirect()->back()->with('error', 'Metode pembayaran tidak didukung.');
    }

    try {
        // Obtain Snap Token from Midtrans
        $snapToken = Snap::getSnapToken($transaction_data);

        // Log the generated Snap Token for debugging
        Log::info('Snap Token dihasilkan: ' . $snapToken);

        // Retrieve phone number from the request
        $nomor_hp = $request->nomor_hp;

        // Return the payment view with necessary data
        return view('pembayaran.payment_methods', compact('snapToken', 'transaksi', 'document', 'nomor_hp'));
    } catch (\Exception $e) {
        // Log any errors encountered while generating the Snap Token
        Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat transaksi.');
    }
}


         
    

    /**
     * Menangani notifikasi dari Midtrans.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
  public function callback(Request $request)
{
    Log::info('Callback method called.');

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

    // Update status transaksi berdasarkan status dari Midtrans
    switch ($status) {
        case 'capture':
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaksi->status_pembayaran = 'challenge';
                } else {
                    $transaksi->status_pembayaran = 'success';
                }
            }
            break;
        case 'settlement':
            $transaksi->status_pembayaran = 'success';
            break;
        case 'pending':
            $transaksi->status_pembayaran = 'pending';
            break;
        case 'deny':
            $transaksi->status_pembayaran = 'deny';
            break;
        case 'expire':
            $transaksi->status_pembayaran = 'expire';
            break;
        case 'cancel':
            $transaksi->status_pembayaran = 'cancel';
            break;
        default:
            $transaksi->status_pembayaran = 'pending';
            break;
    }

    $transaksi->save();
    Log::info('Transaksi status updated to: ' . $transaksi->status_pembayaran);

    // Jika pembayaran berhasil, perbarui status_pembayaran pada CekPlagiasi
    if ($transaksi->status_pembayaran == 'success') {
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

    

    
    

    /**
     * Perbarui nama profil untuk semua entri dengan nomor_hp yang sama.
     *
     * @param \App\Models\Transaksi $transaksi
     * @return void
     */
    private function updateProfileName($transaksi)
    {
        $nomor_hp = $transaksi->nomor_hp;
        $profilenama = $transaksi->profilenama;

        // Cari semua entri dengan nomor_hp yang sama dan perbarui profilenama
        CekPlagiasi::where('nomor_hp', $nomor_hp)
            ->update(['profilenama' => $profilenama]);

        Log::info("Nama profil diperbarui menjadi '{$profilenama}' untuk nomor_hp: {$nomor_hp}");
    }

    /**
     * Tampilkan halaman sukses pembayaran.
     *
     * @param string $trxId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showSuccess($trxId)
    {
        $transaksi = Transaksi::where('invoice_number', $trxId)->first();
    
        if ($transaksi) {
            $cekPlagiasi = $transaksi->cek_plagiasi;
    
            if ($cekPlagiasi && $cekPlagiasi->nomor_hp) {
                $nomor_hp = $cekPlagiasi->nomor_hp;
    
                $cekPlagiasi_id = $transaksi->cek_plagiasi_id;

                $cekPlagiasi = CekPlagiasi::find($cekPlagiasi_id);
                // dd($cekPlagiasi);

                if ($cekPlagiasi) {
                    $cekPlagiasi->status_pembayaran = 'sudah_bayar';
                    $cekPlagiasi->save();
                
                    return redirect()->route('cek-pembelian.results', ['nomor_hp' => $nomor_hp])
                                     ->with('payment_success', 'Pembayaran berhasil dilakukan.');
                } else {
                    return redirect()->route('cek-pembelian.results', ['nomor_hp' => $nomor_hp])
                                     ->with('payment_failure', 'Gagal memperbarui status pembayaran.');
                }
                return redirect()->route('cek-pembelian.results', ['nomor_hp' => $nomor_hp])
                                 ->with('payment_success', 'Pembayaran berhasil dilakukan.');
            } else {
                Log::error('Nomor HP tidak ditemukan untuk Transaksi ID: ' . $transaksi->id);
                return redirect()->route('home')
                                 ->with('error', 'Nomor HP tidak ditemukan.');
            }
        }
    
        Log::error('Transaksi tidak ditemukan untuk trxId: ' . $trxId);
        return redirect()->route('home')
                         ->with('error', 'Transaksi tidak ditemukan.');
    }
    
    /**
     * Tampilkan halaman pembatalan pembayaran.
     *
     * @param string $nomor_hp
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showCancel($nomor_hp)
    {
        return redirect()->route('cek-pembelian.results', ['nomor_hp' => $nomor_hp])
                         ->with('payment_cancel', 'Pembayaran dibatalkan.');
    }

    /**
     * Tampilkan riwayat transaksi berdasarkan nomor telepon.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function history(Request $request)
    {
        // Ambil nomor telepon dari query parameter
        $nomor_hp = $request->input('nomor_hp');

        // Validasi nomor telepon
        if (!$nomor_hp) {
            return redirect()->back()->with('error', 'Nomor telepon tidak ditemukan.');
        }

        // Ambil transaksi yang terkait dengan nomor telepon
        $transaksis = Transaksi::whereHas('cek_plagiasi', function($query) use ($nomor_hp) {
            $query->where('nomor_hp', $nomor_hp);
        })->orderBy('created_at', 'desc')->paginate(10)->appends(['nomor_hp' => $nomor_hp]);

        return view('transaksi.history', compact('transaksis', 'nomor_hp'));
    }

    

}
