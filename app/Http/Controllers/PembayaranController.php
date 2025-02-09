<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CekPlagiasi;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    /**
     * Generate HMAC SHA256 signature.
     *
     * @param string $component
     * @return string
     */
    private function generateSignature($component)
    {
        return base64_encode(hash_hmac('sha256', $component, config('services.doku.shared_key'), true));
    }

    /**
     * Show the payment page.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        $document = CekPlagiasi::findOrFail($id);

        if ($document->status_pembayaran == 'sudah_bayar') {
            return redirect()->back()->with('success', 'Dokumen ini sudah dibayar.');
        }

        return view('pembayaran.index', compact('document'));
    }

    /**
     * Process the payment initiation.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function process(Request $request)
{
    $request->validate([
        'document_id' => 'required|exists:cek_plagiasi,id',
        'payment_method' => 'required|string|in:' . implode(',', config('services.doku.payment.payment_method_types')),
    ]);

    $document = CekPlagiasi::findOrFail($request->document_id);
    $amount = 2000; // Define the payment amount
    $invoiceNumber = 'INV-PL-' . time() . '-' . $document->id;

    // Buat transaksi dengan 'payment_method'
    $transaksi = Transaksi::create([
        'cek_plagiasi_id' => $document->id,
        'invoice_number' => $invoiceNumber,
        'amount' => $amount,
        'status_pembayaran' => 'pending', // Pastikan status diset ke 'pending'
        'payment_method' => $request->payment_method, // Simpan metode pembayaran yang dipilih
    ]);

    $data = $this->preparePaymentData($document, $amount, $invoiceNumber, $transaksi, $request->payment_method);
    return $this->sendPaymentRequest($data, $transaksi);
}


    /**
     * Prepare payment data to send to DOKU API.
     *
     * @param \App\Models\CekPlagiasi $document
     * @param float $amount
     * @param string $invoiceNumber
     * @param \App\Models\Transaksi $transaksi
     * @param string $paymentMethod
     * @return array
     */
    private function preparePaymentData($document, $amount, $invoiceNumber, $transaksi, $paymentMethod)
{
    // Mendapatkan nomor HP dari transaksi terkait
    $nomor_hp = $transaksi->cek_plagiasi->nomor_hp;

    // URL untuk notifikasi pembayaran
    $notifyUrl = route('cek-turnitin.notify', ['trxId' => $transaksi->invoice_number]);

    // URL untuk sukses pembayaran
    $successUrl = route('pembayaran.success', ['trxId' => $transaksi->invoice_number]);

    // URL untuk batal pembayaran dengan parameter status=cancel
    $cancelUrl = route('cek-pembelian.results', ['nomor_hp' => $nomor_hp, 'status' => 'cancel']);

    Log::info('Notify URL: ' . $notifyUrl);
    Log::info('Success URL: ' . $successUrl);
    Log::info('Cancel URL: ' . $cancelUrl);

    return [
        'merchant_id' => config('services.doku.merchant_id'),
        'order' => [
            'invoice_number' => $invoiceNumber,
            'amount' => $amount,
            'currency' => 'IDR',
            'description' => 'Pembayaran Cek Plagiasi',
            'callback_url' => $notifyUrl, // URL notifikasi pembayaran
            'callback_url_cancel' => $cancelUrl, // URL batal pembayaran dengan parameter
            'auto_redirect' => false,
        ],
        'payment' => [
            'payment_due_date' => config('services.doku.payment.payment_due_date'), // 60 minutes
            'type' => config('services.doku.payment.type'), // 'SALE', 'INSTALLMENT', 'AUTHORIZE'
            'payment_method_types' => [$paymentMethod], // Metode pembayaran yang dipilih
        ],
        'customer' => [
            'name' => $document->nama_pelanggan ?? 'Pelanggan',
            'email' => $document->email_pelanggan ?? 'email@example.com',
            'phone' => $document->phone_pelanggan ?? '081234567890',
        ],
    ];
}


    /**
     * Send payment request to DOKU API.
     *
     * @param array $data
     * @param \App\Models\Transaksi $transaksi
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    private function sendPaymentRequest($data, $transaksi)
    {
        $dataString = json_encode($data);
    
        $requestId = uniqid();
        $timestamp = gmdate("Y-m-d\TH:i:s\Z");
        $digest = base64_encode(hash('sha256', $dataString, true));
    
        $requestTarget = "/checkout/v1/payment";
    
        $signatureComponent = "Client-Id:" . config('services.doku.client_id') . "\n" .
                              "Request-Id:" . $requestId . "\n" .
                              "Request-Timestamp:" . $timestamp . "\n" .
                              "Request-Target:" . $requestTarget . "\n" .
                              "Digest:" . $digest;
    
        $signature = $this->generateSignature($signatureComponent);
    
        // Log details for debugging
        Log::info('Sending Data: ' . $dataString);
        Log::info('Digest: ' . $digest);
        Log::info('Signature Component: ' . $signatureComponent);
        Log::info('Signature: ' . $signature);
    
        // Prepare headers for the request
        $headers = [
            'Content-Type' => 'application/json',
            'Client-Id' => config('services.doku.client_id'),
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
            'Signature' => 'HMACSHA256=' . $signature,
        ];
    
        // Get API URL from config
        $apiUrl = config('services.doku.api_url');
        Log::info('DOKU_API_URL: ' . $apiUrl);
    
        try {
            // Send POST request to DOKU API
            $response = Http::withHeaders($headers)
                            ->post($apiUrl . '/checkout/v1/payment', $data);
    
            // Log response for debugging
            Log::info('DOKU Response Status: ' . $response->status());
            Log::info('DOKU Response Body: ' . $response->body());
    
            if ($response->successful()) {
                $responseData = $response->json();
                Log::info('DOKU Payment Success:', $responseData);
    
                // Retrieve payment URL from response
                $paymentUrl = $responseData['response']['payment']['url'] ?? null;
    
                if ($paymentUrl) {
                    return redirect()->away($paymentUrl);
                }
    
                // If no payment URL, redirect back with a success message
                return redirect()->route('pembayaran.success', ['trxId' => $transaksi->invoice_number])
                                 ->with('success_message', 'Pembayaran berhasil dibuat. Silakan lakukan pembayaran melalui link yang diberikan.');
            } else {
                Log::error('DOKU Payment Error: ' . $response->body());
                return redirect()->back()->with('error', 'Pembayaran gagal. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            Log::error('DOKU Payment Exception: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
    }
    
    /**
     * Verify the signature of the notification.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
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

        $computedSignature = 'HMACSHA256=' . base64_encode(hash_hmac('sha256', $signatureComponent, config('services.doku.shared_key'), true));

        return hash_equals($signatureHeader, $computedSignature);
    }

    /**
     * Handle the notification from DOKU.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $trxId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
   

    // Add any additional methods as required, such as createVA, virtualAccount, virtualAccountCallback, redirectToPaymentLink

    /**
     * Placeholder for creating Virtual Account.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function createVA(Request $request)
    {
        // Implement Virtual Account creation logic if needed
    }

    /**
     * Placeholder for Virtual Account processing.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function virtualAccount(Request $request)
    {
        // Implement Virtual Account processing logic if needed
    }

    /**
     * Placeholder for Virtual Account callback.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $trxId
     * @return \Illuminate\Http\Response
     */
    public function virtualAccountCallback(Request $request, $trxId)
    {
        // Implement Virtual Account callback logic if needed
    }

    /**
     * Redirect to payment link.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToPaymentLink()
    {
        // Implement redirection to payment link if needed
    }

    public function showPaymentMethods($document_id)
    {
        $document = CekPlagiasi::findOrFail($document_id);

        if ($document->status_pembayaran == 'sudah_bayar') {
            return redirect()->route('cek-pembelian.results', ['nomor_hp' => $document->nomor_hp])
                             ->with('success', 'Dokumen ini sudah dibayar.');
        }

        return view('pembayaran.payment_methods', compact('document'));
    }

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