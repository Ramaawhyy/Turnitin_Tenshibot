<!-- resources/views/pembayaran/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Mulai Pembayaran</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- jQuery, Popper.js, dan Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pO4nW6h6G5Yd6+bK+qM1X8xXX8jWmv3iD4kV0qlp6Qz4F1kDVdL+6zJ2ZZq0ZQj/KG++3ez+7vY0UEFI6CMRWw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Mulai Pembayaran</h1>
        <p><strong>Nomor Dokumen:</strong> {{ $document->judul }}</p>
        <p><strong>Status Pembayaran:</strong> {{ ucfirst($document->status_pembayaran) }}</p>

        <!-- Menampilkan Pesan Error -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Menampilkan Pesan Sukses Message -->
        @if(session('success_message'))
            <div class="alert alert-success">
                {{ session('success_message') }}
            </div>
        @endif

        <!-- Menampilkan Pesan Sukses dalam Modal jika ada transaksi -->
        @if(session('success_transaction'))
            @php
                $transaksi = session('success_transaction');
            @endphp
            <!-- Modal Notifikasi Sukses -->
            <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Permintaan Pembayaran Berhasil</h5>
                  </div>
                  <div class="modal-body">
                    <p><strong>Pembayaran berhasil dibuat. Silakan lakukan pembayaran melalui link yang diberikan.</strong></p>
                    <p><strong>Invoice Number:</strong> {{ $transaksi->invoice_number ?? 'N/A' }}</p>
                    <p><strong>Total Amount:</strong> Rp. {{ number_format($transaksi->amount ?? 0, 2, ',', '.') }}</p>
                  </div>
                  <div class="modal-footer">
                    <a href="{{ route('pembayaran.index', ['id' => $document->id]) }}" class="btn btn-primary">Kembali</a>
                  </div>
                </div>
              </div>
            </div>
        
            <script>
                $(document).ready(function(){
                    $('#successModal').modal('show');
                });
            </script>
        @endif

        <!-- Menampilkan Form Pembayaran jika belum dibayar -->
        @if($document->status_pembayaran != 'sudah_bayar')
            <form action="{{ route('pembayaran.process') }}" method="POST">
                @csrf
                <input type="hidden" name="document_id" value="{{ $document->id }}">
                <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
            </form>
        @else
            <div class="alert alert-success mt-3">
                Pembayaran telah selesai.
            </div>
        @endif
    </div>
</body>
</html>
<script type="text/javascript">
    var checkoutButton = document.getElementById('checkout-button');
    // Example: the payment page will show when the button is clicked
    checkoutButton.addEventListener('click', function () {
        loadJokulCheckout('https://jokul.doku.com/checkout/link/SU5WFDferd561dfasfasdfae123c20200510090550775'); // Replace it with the response.payment.url you retrieved from the response
    });
</script>
