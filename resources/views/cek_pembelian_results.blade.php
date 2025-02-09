@extends('layouts.index')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Card untuk Tabel Dokumen -->
        <div class="card mb-4">
<div class="container">

    <!-- Form Pencarian dan Filter Tampilan Per Halaman -->
        <form method="GET" action="{{ url()->current() }}" class="mb-3" style="margin: 20px; padding: 10px;">
            <h2 style="margin-top: 10px;">Cek Pembelian </h2>
            <div class="row align-items-end" style="margin: 10px; padding: 10px;">
                <!-- Input Pencarian -->
            <div class="col-md-3 col-12 mb-3 mb-md-0">
                <label for="search" class="form-label">Cari berdasarkan Judul</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Masukkan judul dokumen">
            </div>
            <!-- Pilihan Tampilan Per Halaman -->
            <div class="col-md-2 col-12 mb-3 mb-md-0">
                <label for="per_page" class="form-label">Tampilkan per halaman</label>
                <select name="per_page" class="form-control" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
            <!-- Tombol Cari -->
           
            
            <!-- Tombol Transaksi dan History Transaksi -->
            
        </div>
    </form>

    <!-- Container untuk Notifikasi -->
    <div id="notification-container"></div>

    <!-- Notifikasi Pembayaran Sukses menggunakan Blade -->
    @if (session('payment_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('payment_success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($documents && $documents->count() > 0)
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Informasi</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dokumen</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Diproses Pada</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documents as $index => $document)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>
                    <div class="d-flex px-2 py-1">
                        <div>
                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ $document->judul }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $document->nomor_hp }}</p>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <a href="{{ $document->link_dokumen }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2 d-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Dokumen">
                        <i class="fa fa-file-alt me-1"></i> Lihat Dokumen
                    </a>
                    @if ($document->token && $document->token->status == 'completed')
                        <a href="{{ route('dashboard.download', $document->id) }}" class="btn btn-sm btn-primary mb-2 d-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Unduh Dokumen">
                            <i class="fas fa-download me-1"></i> Unduh
                        </a>
                    @endif
                </td>
                <td class="text-center">
                    @if ($document->token)
                        @php
                            $status = ucfirst(str_replace('_', ' ', $document->token->status));
                            $badgeClass = match($document->token->status) {
                                'pending' => 'bg-secondary',
                                'in_progress' => 'bg-warning text-dark',
                                'completed' => 'bg-success',
                                default => 'bg-light text-dark',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">
                            {{ $status }}
                        </span>
                    @else
                        <span class="badge bg-light text-dark">Tidak tersedia</span>
                    @endif
                </td>
                <td>
                    <span class="text-secondary text-xs font-weight-bold">
                        {{ $document->created_at->format('d-m-Y H:i') }}
                    </span>
                </td>
                <td class="text-center">
                    @if ($document->status_pembayaran == 'belum_bayar')
                        <a href="{{ route('pembayaran.methods', ['document_id' => $document->id]) }}" class="btn btn-sm btn-success">
                            <i class="fa fa-credit-card"></i> Bayar
                        </a>
                    @else
                        <span class="badge bg-success">Sudah Dibayar</span>
                    @endif
                </td>
                
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <!-- Tombol Previous dan Next Kustom -->
    <div class="d-flex justify-content-between">
        <!-- Tombol Previous -->
        @if ($documents->onFirstPage())
            <button class="btn btn-secondary" disabled>
                <i class="fa fa-arrow-left"></i> Previous
            </button>
        @else
            <a href="{{ $documents->previousPageUrl() }}" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> Previous
            </a>
        @endif

        <!-- Tombol Next -->
        @if ($documents->hasMorePages())
            <a href="{{ $documents->nextPageUrl() }}" class="btn btn-primary">
                Next <i class="fa fa-arrow-right"></i>
            </a>
        @else
            <button class="btn btn-secondary" disabled>
                Next <i class="fa fa-arrow-right"></i>
            </button>
        @endif
    </div>

    @else
        <p>Tidak ada dokumen ditemukan.</p>
    @endif

    <div class="mt-5">
        <footer class="footer">
            <div class="container">
                <span class="text-muted"></span>
            </div>
        </footer>
    </div>
</div>
@endsection
@section('settings_panel')
<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fas fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3 ">
        <div class="float-start">
			<h5 class="mt-3 mb-0">Pengaturan Tenshibot</h5>
			<p>Lihat opsi dasboard kami.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="fa fa-close"></i>
          </button>
        </div>
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0 overflow-auto">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Warna Sidebar</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Tipe Sidenav</h6>
          <p class="text-sm">Pilih antara 2 tipe sidenav yang berbeda.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
          <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default" onclick="sidebarType(this)">Dark</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">Anda dapat mengubah tipe sidenav hanya pada tampilan desktop.</p>
        <!-- Navbar Fixed -->
        <div class="d-flex my-3">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <!-- Dark Mode Toggle -->
        <div class="mt-2 mb-5 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <a class="btn bg-gradient-primary w-100" href="{{ route('transaksi.history', ['nomor_hp' => $nomor_hp]) }}">History Transaksi</a>
        <a class="btn bg-gradient-dark w-100" href="{{ route('cek-turnitin.index') }}">Kembali</a>
      </div>
    </div>
  </div>
@endsection
@section('namauser')
<span class="d-sm-inline d-none">
    @if ($document->profilenama)
        {{ $document->profilenama }} 
    @else
        {{ $document->nomor_hp }} 
    @endif
</span>
@endsection

