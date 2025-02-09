@extends('layouts.app2')

@section('content')
<div class="container text-center">
    <h2>Pembayaran QRIS</h2>

    <p>Silakan scan kode QR di bawah ini menggunakan aplikasi pembayaran yang mendukung QRIS.</p>
    <p>Jumlah Pembayaran: Rp{{ number_format($amount, 0, ',', '.') }}</p>

    <img src="{{ $qr_url }}" alt="QRIS Code" style="max-width: 300px;">

    <p class="mt-4">Setelah melakukan pembayaran, silakan tunggu beberapa saat untuk sistem memverifikasi pembayaran Anda.</p>
</div>
@endsection
