<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\CekPlagiasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PaymentCompleted;

class TransactionController extends Controller
{
    /**
     * Menampilkan halaman pembayaran.
     *
     * @param int $cekPlagiasiId
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showPaymentForm($cekPlagiasiId)
    {
        $cekPlagiasi = CekPlagiasi::with('token', 'transaction')->findOrFail($cekPlagiasiId);

        // Pastikan user adalah pemilik dokumen
        if ($cekPlagiasi->user_id !== Auth::id()) {
            return redirect()->route('transactions.history')->with('error', 'Anda tidak memiliki akses ke dokumen ini.');
        }

        // Pastikan dokumen sudah diproses oleh superadmin dan belum ada transaksi
        if (!$cekPlagiasi->token || $cekPlagiasi->token->status !== 'completed') {
            return redirect()->route('transactions.history')->with('error', 'Dokumen belum diproses oleh superadmin.');
        }

        if ($cekPlagiasi->transaction) {
            return redirect()->route('transactions.history')->with('error', 'Transaksi sudah dibuat untuk dokumen ini.');
        }

        return view('payment_form', ['cekPlagiasi' => $cekPlagiasi]);
    }

    /**
     * Memproses pembayaran.
     *
     * @param Request $request
     * @param int $cekPlagiasiId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function processPayment(Request $request, $cekPlagiasiId)
    {
        $cekPlagiasi = CekPlagiasi::with('token', 'transaction')->findOrFail($cekPlagiasiId);
    
        // Validasi kepemilikan dan status
        if ($cekPlagiasi->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke dokumen ini.');
        }
    
        if (!$cekPlagiasi->token || $cekPlagiasi->token->status !== 'completed') {
            return redirect()->back()->with('error', 'Dokumen belum diproses oleh superadmin.');
        }
    
        if ($cekPlagiasi->transaction) {
            return redirect()->back()->with('error', 'Transaksi sudah dibuat untuk dokumen ini.');
        }
    
        // Validasi input
        $validated = $request->validate([
            'payment_reference' => 'required|string|max:255',
        ]);
    
        try {
            // Buat transaksi
            $transaction = Transaction::create([
                'cek_plagiasi_id' => $cekPlagiasi->id,
                'user_id' => Auth::id(),
                'amount' => 2000, // Rp. 2.000
                'status' => 'completed', // Asumsikan pembayaran langsung selesai (simulasi)
                'payment_reference' => $validated['payment_reference'],
            ]);
    
            // Kirim notifikasi kepada pengguna
            Notification::send(Auth::user(), new PaymentCompleted($transaction));
    
            Log::info("Transaksi berhasil dibuat untuk dokumen ID: {$cekPlagiasi->id}, Transaksi ID: {$transaction->id}");
    
            // Cek apakah request adalah AJAX
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Pembayaran berhasil. Anda dapat mengunduh dokumen Anda.']);
            }
    
            return redirect()->route('transactions.history')->with('success', 'Pembayaran berhasil. Anda dapat mengunduh dokumen Anda.');
        } catch (\Exception $e) {
            Log::error("Gagal membuat transaksi: " . $e->getMessage());
    
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memproses pembayaran. Silakan coba lagi.'], 500);
            }
    
            return redirect()->back()->with('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan riwayat transaksi pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function history()
    {
        $transactions = Transaction::with('cekPlagiasi.token')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('transaction_history', ['transactions' => $transactions]);
    }

    /**
     * Mengunduh dokumen setelah pembayaran.
     *
     * @param int $transactionId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function downloadDocument($transactionId)
    {
        $transaction = Transaction::with('cekPlagiasi.token')->findOrFail($transactionId);

        // Pastikan transaksi milik user
        if ($transaction->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke dokumen ini.');
        }

        // Pastikan transaksi sudah selesai
        if ($transaction->status !== 'completed') {
            return redirect()->back()->with('error', 'Transaksi belum selesai.');
        }

        // Link dokumen dari Google Drive
        $dokumenUrl = $transaction->cekPlagiasi->link_dokumen;

        if (!$dokumenUrl) {
            return redirect()->back()->with('error', 'Link dokumen tidak tersedia.');
        }

        // Redirect ke link dokumen
        return redirect($dokumenUrl);
    }
}