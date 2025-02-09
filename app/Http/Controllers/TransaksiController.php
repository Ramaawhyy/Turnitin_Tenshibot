<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\CekPlagiasi;

class TransaksiController extends Controller
{
    public function history(Request $request)
    {
        // Ambil nomor telepon dari query parameter
        $nomor_hp = $request->input('nomor_hp');

        // Validasi nomor telepon
        if (!$nomor_hp) {
            return redirect()->back()->with('error', 'Nomor telepon tidak ditemukan.');
        }

        // Ambil transaksi yang terkait dengan nomor telepon dan status pembayaran sudah_bayar
        $transaksis = Transaksi::whereHas('cek_plagiasi', function($query) use ($nomor_hp) {
            $query->where('nomor_hp', $nomor_hp)
                  ->where('status_pembayaran', 'sudah_bayar');
        })->orderBy('created_at', 'desc')->paginate(10)->appends(['nomor_hp' => $nomor_hp]);

        return view('transaksi.history', compact('transaksis', 'nomor_hp'));
    }
}
