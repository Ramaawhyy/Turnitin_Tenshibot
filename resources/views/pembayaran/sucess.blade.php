<!-- resources/views/pembayaran/success.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran {{ $cek_plagiasi->status_pembayaran == 'sudah_bayar' ? 'Berhasil' : 'Gagal' }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">

        @if ($cek_plagiasi->status_pembayaran == "sudah_bayar")
            <h1 class="text-success">Pembayaran Berhasil</h1>
            <p><strong>Transaction ID:</strong> {{ $transaksi->invoice_number }}</p>
            <p><strong>Total Amount:</strong> Rp. {{ number_format($transaksi->amount, 0, ',', '.') }}</p>
        @else
            <h1 class="text-danger">Pembayaran Gagal</h1>
            <p><strong>Transaction ID:</strong> {{ $transaksi->invoice_number }}</p>
            <p><strong>Silakan coba lagi atau hubungi layanan pelanggan.</strong></p>
        @endif

    </div>
    <div class="container text-center mt-4">
        @php
            // Mendapatkan nomor_hp dari transaksi atau session
            $nomor_hp = $transaksi->nomor_hp ?? session('nomor_hp');
        @endphp
        @if ($nomor_hp)
            <a href="{{ route('cek-pembelian', ['nomor_hp' => $nomor_hp]) }}" class="btn btn-primary">
                Lihat Hasil Pembelian
            </a>
        @endif
    </div>
</body>
</html>
