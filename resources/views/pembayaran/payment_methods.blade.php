@extends('layouts.index')

@section('content')

<div class="row">
    <div class="col-12">
        <!-- Card untuk Tabel Dokumen -->
        <div class="card mb-4">

<div class="container">
    @if(isset($snapToken))
        <!-- Tampilan Checkout dengan Snap Token -->
        <h2>Checkout</h2>
        <p>Total Pembayaran: Rp {{ number_format($transaksi->amount, 0, ',', '.') }}</p>
        <p>Nomor HP: {{ $nomor_hp }}</p> <!-- Menggunakan nomor_hp dari controller -->
        <p>Snap Token: {{ $snapToken }}</p> <!-- Debugging -->

        <!-- Tombol "Bayar Sekarang" bertipe button dan tidak berada dalam form -->
        <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
    @else
        <!-- Tampilan Pemilihan Metode Pembayaran -->
        <h2>Metode Pembayaran</h2>
        <p>Pilih metode pembayaran yang Anda inginkan untuk dokumen ini.</p>

        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="document_id" value="{{ $document->id }}">
            <input type="hidden" name="nomor_hp" value="{{ $document->nomor_hp }}">
            <input type="hidden" name="profilenama" value="{{ $document->profilenama }}">

            <!-- Lainnya -->
            <div class="mb-4">
                <h4>QRIS</h4>
                <div class="row">
                    <!-- QRIS -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="qris" name="payment_method" value="qris" class="d-none">
                            <label for="qris" class="card-body text-center">
                                <img src="{{ asset('images/qris.png') }}" alt="QRIS" class="img-fluid mb-2" style="max-width: 50px;">
                                <h5 class="card-title">QRIS</h5>
                            </label>
                        </div>
                    </div>

            <!-- Kartu Kredit -->
            <div class="mb-4">
                <h4>Kartu Kredit</h4>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="credit_card" name="payment_method" value="credit_card" class="d-none">
                            <label for="credit_card" class="card-body text-center">
                                <i class="fas fa-credit-card fa-2x mb-2"></i>
                                <h5 class="card-title">Kartu Kredit</h5>
                            </label>
                        </div>
                    </div>
                    <!-- Tambahkan metode Kartu Kredit lainnya jika diperlukan -->
                </div>
            </div>

            <!-- Virtual Account -->
            <div class="mb-4">
                <h4>Virtual Account</h4>
                <div class="row">
                    <!-- Virtual Account BCA -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="bca_va" name="payment_method" value="bca_va" class="d-none">
                            <label for="bca_va" class="card-body text-center">
                                <i class="fas fa-university fa-2x mb-2"></i>
                                <h5 class="card-title">VA BCA</h5>
                            </label>
                        </div>
                    </div>

                    <!-- Virtual Account Permata -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="permata_va" name="payment_method" value="permata_va" class="d-none">
                            <label for="permata_va" class="card-body text-center">
                                <i class="fas fa-university fa-2x mb-2"></i>
                                <h5 class="card-title">VA Permata</h5>
                            </label>
                        </div>
                    </div>

                    <!-- Virtual Account BNI -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="bni_va" name="payment_method" value="bni_va" class="d-none">
                            <label for="bni_va" class="card-body text-center">
                                <i class="fas fa-university fa-2x mb-2"></i>
                                <h5 class="card-title">VA BNI</h5>
                            </label>
                        </div>
                    </div>

                    <!-- Virtual Account BRI -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="bri_va" name="payment_method" value="bri_va" class="d-none">
                            <label for="bri_va" class="card-body text-center">
                                <i class="fas fa-university fa-2x mb-2"></i>
                                <h5 class="card-title">VA BRI</h5>
                            </label>
                        </div>
                    </div>

                    <!-- Virtual Account CIMB -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="cimb_va" name="payment_method" value="cimb_va" class="d-none">
                            <label for="cimb_va" class="card-body text-center">
                                <i class="fas fa-university fa-2x mb-2"></i>
                                <h5 class="card-title">VA CIMB</h5>
                            </label>
                        </div>
                    </div>

                    <!-- Virtual Account Danamon -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="danamon_va" name="payment_method" value="danamon_va" class="d-none">
                            <label for="danamon_va" class="card-body text-center">
                                <i class="fas fa-university fa-2x mb-2"></i>
                                <h5 class="card-title">VA Danamon</h5>
                            </label>
                        </div>
                    </div>

                    <!-- Virtual Account Maybank -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="maybank_va" name="payment_method" value="maybank_va" class="d-none">
                            <label for="maybank_va" class="card-body text-center">
                                <i class="fas fa-university fa-2x mb-2"></i>
                                <h5 class="card-title">VA Maybank</h5>
                            </label>
                        </div>
                    </div>

                    <!-- Virtual Account Mega -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="mega_va" name="payment_method" value="mega_va" class="d-none">
                            <label for="mega_va" class="card-body text-center">
                                <i class="fas fa-university fa-2x mb-2"></i>
                                <h5 class="card-title">VA Mega</h5>
                            </label>
                        </div>
                    </div>

                    <!-- Virtual Account Panin -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="panin_va" name="payment_method" value="panin_va" class="d-none">
                            <label for="panin_va" class="card-body text-center">
                                <i class="fas fa-university fa-2x mb-2"></i>
                                <h5 class="card-title">VA Panin</h5>
                            </label>
                        </div>
                    </div>

                    <!-- Virtual Account Lainnya -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="other_va" name="payment_method" value="other_va" class="d-none">
                            <label for="other_va" class="card-body text-center">
                                <i class="fas fa-university fa-2x mb-2"></i>
                                <h5 class="card-title">VA Bank Lainnya</h5>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- E-Wallet -->
            <div class="mb-4">
                <h4>E-Wallet</h4>
                <div class="row">
                    <!-- GoPay -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="gopay" name="payment_method" value="gopay" class="d-none">
                            <label for="gopay" class="card-body text-center">
                                <img src="{{ asset('images/gopay.png') }}" alt="GoPay" class="img-fluid mb-2" style="max-width: 50px;">
                                <h5 class="card-title">GoPay</h5>
                            </label>
                        </div>
                    </div>

                    <!-- DANA -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="dana" name="payment_method" value="dana" class="d-none">
                            <label for="dana" class="card-body text-center">
                                <img src="{{ asset('images/dana.png') }}" alt="DANA" class="img-fluid mb-2" style="max-width: 50px;">
                                <h5 class="card-title">DANA</h5>
                            </label>
                        </div>
                    </div>

                    <!-- OVO -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="ovo" name="payment_method" value="ovo" class="d-none">
                            <label for="ovo" class="card-body text-center">
                                <img src="{{ asset('images/ovo.png') }}" alt="OVO" class="img-fluid mb-2" style="max-width: 50px;">
                                <h5 class="card-title">OVO</h5>
                            </label>
                        </div>
                    </div>

                    <!-- ShopeePay -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="shopeepay" name="payment_method" value="shopeepay" class="d-none">
                            <label for="shopeepay" class="card-body text-center">
                                <img src="{{ asset('images/shopeepay.png') }}" alt="ShopeePay" class="img-fluid mb-2" style="max-width: 50px;">
                                <h5 class="card-title">ShopeePay</h5>
                            </label>
                        </div>
                    </div>

                    <!-- LinkAja -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="linkaja" name="payment_method" value="linkaja" class="d-none">
                            <label for="linkaja" class="card-body text-center">
                                <img src="{{ asset('images/linkaja.png') }}" alt="LinkAja" class="img-fluid mb-2" style="max-width: 50px;">
                                <h5 class="card-title">LinkAja</h5>
                            </label>
                        </div>
                    </div>

                    <!-- Kredivo -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="kredivo" name="payment_method" value="kredivo" class="d-none">
                            <label for="kredivo" class="card-body text-center">
                                <img src="{{ asset('images/kredivo.png') }}" alt="Kredivo" class="img-fluid mb-2" style="max-width: 50px;">
                                <h5 class="card-title">Kredivo</h5>
                            </label>
                        </div>
                    </div>

                    <!-- Akulaku -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="akulaku" name="payment_method" value="akulaku" class="d-none">
                            <label for="akulaku" class="card-body text-center">
                                <img src="{{ asset('images/akulaku.png') }}" alt="Akulaku" class="img-fluid mb-2" style="max-width: 50px;">
                                <h5 class="card-title">Akulaku</h5>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Retail Outlet -->
            <div class="mb-4">
                <h4>Retail Outlet</h4>
                <div class="row">
                    <!-- Indomaret -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="indomaret" name="payment_method" value="indomaret" class="d-none">
                            <label for="indomaret" class="card-body text-center">
                                <img src="{{ asset('images/indomaret.png') }}" alt="Indomaret" class="img-fluid mb-2" style="max-width: 50px;">
                                <h5 class="card-title">Indomaret</h5>
                            </label>
                        </div>
                    </div>

                    <!-- Alfamart -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="alfamart" name="payment_method" value="alfamart" class="d-none">
                            <label for="alfamart" class="card-body text-center">
                                <img src="{{ asset('images/alfamart.png') }}" alt="Alfamart" class="img-fluid mb-2" style="max-width: 50px;">
                                <h5 class="card-title">Alfamart</h5>
                            </label>
                        </div>
                    </div>
                </div>
            </div>


                    <!-- Transfer Bank -->
                    <div class="col-md-3 mb-3">
                        <div class="card payment-method-card">
                            <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" class="d-none">
                            <label for="bank_transfer" class="card-body text-center">
                                <i class="fas fa-exchange-alt fa-2x mb-2"></i>
                                <h5 class="card-title">Transfer Bank</h5>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            @error('payment_method')
                <div class="text-danger mb-3">
                    {{ $message }}
                </div>
            @enderror

            <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
        </form>
    @endif
</div>

@if(isset($snapToken) && isset($nomor_hp))
    <!-- Tambahkan script Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM fully loaded and parsed'); // Debugging

            var payButton = document.getElementById('pay-button');

            if(payButton){
                console.log('pay-button ditemukan'); // Debugging
                console.log("payButton", payButton)
                payButton.addEventListener('click', function(){
                    console.log('Tombol "Bayar Sekarang" diklik'); // Debugging
                    // alert('Tombol "Bayar Sekarang" diklik!'); // Opsional: Hapus setelah debugging

                    // Pastikan nomor_hp tersedia sebelum mengarahkan ke route pembayaran.cancel
                    var nomorHp = '{{ $nomor_hp }}';
                    if(nomorHp){
                        snap.pay('{{ $snapToken }}', {
                            onSuccess: function(result){
                                console.log('payment success:', result);
                                window.location.href = '{{ route('pembayaran.success', ['trxId' => $transaksi->invoice_number]) }}';
                            },
                            onPending: function(result){
                                console.log('payment pending:', result);
                                window.location.href = '{{ route('pembayaran.cancel', ['nomor_hp' => $nomor_hp]) }}';
                            },
                            onError: function(result){
                                console.log('payment error:', result);
                                alert('Terjadi kesalahan saat pembayaran.');
                            },
                            onClose: function(){
                                console.log('customer closed the popup without finishing the payment');
                                alert('Pembayaran dibatalkan.');
                            }
                        });
                    } else {
                        console.log('Nomor HP tidak tersedia, tidak dapat mengarahkan ke pembatalan pembayaran.');
                        alert('Nomor HP tidak tersedia, pembayaran dibatalkan.');
                    }
                });
            } else {
                console.log('pay-button tidak ditemukan'); // Debugging
            }
        });
    </script>
@endif

<style>
    .payment-method-card {
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
    .payment-method-card:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .payment-method-card input[type="radio"]:checked + label {
        border: 2px solid #007bff;
        background-color: #e7f1ff;
    }
    .payment-method-card label {
        display: block;
        padding: 20px;
        text-align: center;
        cursor: pointer;
    }
    /* Hide the default radio button */
    .payment-method-card input[type="radio"] {
        display: none;
    }
    /* Optional: Adjust card title font size */
    .payment-method-card .card-title {
        font-size: 1rem;
        margin-top: 10px;
    }
</style>

@endsection
