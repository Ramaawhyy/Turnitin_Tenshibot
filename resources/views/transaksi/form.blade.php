@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Masukkan Token Anda</h2>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('transaction.search') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="token">Token Unik</label>
            <input type="text" class="form-control" name="token" id="token" placeholder="Masukkan token unik Anda" required>
            @error('token')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Lihat Detail Transaksi</button>
    </form>
</div>
@endsection
