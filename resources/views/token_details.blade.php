@extends('layouts.navbar')

@section('content')
    <div class="container mt-5">
        <h2>Detail Pengecekan Plagiarisme</h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card" style="border: 1px solid #DADADA; border-radius: 15px;">
            <div class="card-body">
                <h4>Judul: {{ $document->judul ?? 'Tidak ada judul' }}</h4>
                <p><strong>Nomor HP:</strong> {{ $document->nomor_hp }}</p>
                <p><strong>Exclude Daftar Pustaka:</strong> {{ $document->exclude_daftar_pustaka ? 'Ya' : 'Tidak' }}</p>
                <p><strong>Exclude Kutipan:</strong> {{ $document->exclude_kutipan ? 'Ya' : 'Tidak' }}</p>
                <p><strong>Exclude Match:</strong> {{ $document->exclude_match }}%</p>
                <p><strong>Link Dokumen:</strong> <a href="{{ $document->link_dokumen }}" target="_blank">Lihat Dokumen</a></p>
                <p><strong>Status Pengecekan:</strong> 
                    @if($status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($status == 'in_progress')
                        <span class="badge bg-info">Dalam Proses</span>
                    @elseif($status == 'completed')
                        <span class="badge bg-success">Selesai</span>
                    @endif
                </p>
            </div>
        </div>

        <a href="{{ route('cek-turnitin.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
@endsection
