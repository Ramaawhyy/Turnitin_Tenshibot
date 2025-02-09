@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pembayaran Pengecekan Plagiarisme</h2>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card" style="max-width: 600px; margin: auto;">
        <div class="card-body">
            <h5 class="card-title">Transaksi Pembayaran</h5>
            <p>Jumlah yang harus dibayar: <strong>Rp. 2.000</strong></p>
            <form action="{{ route('transactions.processPayment', $cekPlagiasi->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="payment_reference" class="form-label">Referensi Pembayaran</label>
                    <input type="text" class="form-control" id="payment_reference" name="payment_reference" placeholder="Masukkan referensi pembayaran" required>
                    <div class="form-text">Masukkan referensi pembayaran Anda (mis. nomor transaksi).</div>
                </div>
                <button type="submit" class="btn btn-primary">Bayar</button>
            </form>
        </div>
    </div>
</div>
@endsection
