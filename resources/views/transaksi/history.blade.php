@extends('layouts.index')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Card untuk Tabel Dokumen -->
        <div class="card mb-4">
            <div class="container" style="padding: 50px;">
                <h4 style="font-weight: bold;">History Transaksi untuk Nomor HP: {{ $nomor_hp }}</h4>

                <!-- Debugging -->
                <p>Current Page: {{ $transaksis->currentPage() }}</p>
                <p>Total Pages: {{ $transaksis->lastPage() }}</p>
                <p>Has Next Page: {{ $transaksis->hasMorePages() ? 'Yes' : 'No' }}</p>

                <!-- Notifikasi Sukses -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Notifikasi Error -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($transaksis && $transaksis->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Informasi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Invoice</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Metode Pembayaran</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksis as $index => $transaksi)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $transaksi->cek_plagiasi->judul }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $transaksi->cek_plagiasi->nomor_hp }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $transaksi->invoice_number }}</td>
                                        <td class="text-center">Rp {{ number_format($transaksi->amount, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            {{ $transaksi->payment_method_display ?? 'Belum Dipilih' }}
                                        </td>
                                        <td class="text-center">{{ $transaksi->created_at->format('d-m-Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Custom Pagination -->
                    <div class="d-flex justify-content-between mt-3">
                        @if ($transaksis->onFirstPage())
                            <button class="btn btn-secondary" disabled>
                                <i class="fa fa-arrow-left"></i> Previous
                            </button>
                        @else
                            <a href="{{ $transaksis->previousPageUrl() }}" class="btn btn-primary">
                                <i class="fa fa-arrow-left"></i> Previous
                            </a>
                        @endif

                        @if ($transaksis->hasMorePages())
                            <a href="{{ $transaksis->nextPageUrl() }}" class="btn btn-primary">
                                Next <i class="fa fa-arrow-right"></i>
                            </a>
                        @else
                            <button class="btn btn-secondary" disabled>
                                Next <i class="fa fa-arrow-right"></i>
                            </button>
                        @endif
                    </div>
                @else
                    <p class="mt-3">Tidak ada transaksi ditemukan untuk nomor ini.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('settings_panel')
<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fa fa-cog py-2"> </i>
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
        <a class="btn bg-gradient-dark w-100" href="{{ route('cek-pembelian.results', ['nomor_hp' => $nomor_hp]) }}">Kembali</a>
      </div>
    </div>
  </div>
@endsection
