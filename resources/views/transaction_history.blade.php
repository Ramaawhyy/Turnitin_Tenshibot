@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Transaksi</h2>

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

    @if($transactions->count() > 0)
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul Dokumen</th>
                    <th>Nomor HP</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Referensi Pembayaran</th>
                    <th>Dibuat Pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $index => $transaction)
                    <tr>
                        <td>{{ $transactions->firstItem() + $index }}</td>
                        <td>{{ $transaction->cekPlagiasi->judul }}</td>
                        <td>{{ $transaction->cekPlagiasi->nomor_hp }}</td>
                        <td>Rp. {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                        <td>
                            @if($transaction->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($transaction->status === 'completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($transaction->status === 'failed')
                                <span class="badge bg-danger">Failed</span>
                            @endif
                        </td>
                        <td>{{ $transaction->payment_reference }}</td>
                        <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            @if($transaction->status === 'completed')
                                <a href="{{ route('transactions.download', $transaction->id) }}" class="btn btn-sm btn-primary">Unduh Dokumen</a>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $transactions->links() }}
        </div>
    @else
        <p>Anda belum melakukan transaksi.</p>
    @endif
</div>
@endsection
