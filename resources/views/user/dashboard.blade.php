<!-- resources/views/dashboard.blade.php -->

@extends('layouts.newindex')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Card untuk Tabel Dokumen -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h5>Dashboard User</h5>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container mt-4">
                    <form action="{{ route('cek-pembelian.process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nomor_hp" class="form-label">Masukkan Nomor Telepon</label>
                            <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" placeholder="085861765261" value="{{ old('nomor_hp') }}" required>
                            @error('nomor_hp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if (session('nomor_hp_not_found'))
                                <div class="alert alert-danger mt-2">
                                    {{ session('nomor_hp_not_found') }}
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Cek</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="profileModalLabel">Masukkan Nama Profil</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- Form untuk input nama profil -->
              <form action="{{ route('dashboard.process') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                      <label for="nomor_hp" class="form-label">Masukkan Nomor Telepon</label>
                      <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" placeholder="085861765261" value="{{ old('nomor_hp') }}" required>
                      @error('nomor_hp')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
              
                  <div class="mb-3">
                      <label for="profilenama" class="form-label">Masukkan Nama Profil</label>
                      <input type="text" class="form-control @error('profilenama') is-invalid @enderror" id="profilenama" name="profilenama" placeholder="Nama Anda" value="{{ old('profilenama') }}" required>
                      @error('profilenama')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
              
                  <button type="submit" class="btn btn-primary">Simpan Nama Profil</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <!-- Footer -->
    <div class="mt-5">
        <footer class="footer">
            <div class="container">
                <span class="text-muted"></span>
            </div>
        </footer>
    </div>
</div>
@endsection

@push('scripts')
<!-- JavaScript untuk Modal dan Tooltips -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Penanganan Modal Edit Dokumen
        var editDocumentModal = document.getElementById('editDocumentModal');
        var editDocumentForm = document.getElementById('editDocumentForm');
        var currentDokumenParagraph = editDocumentModal.querySelector('#currentDokumen');
        var judulInput = editDocumentModal.querySelector('#judul');

        editDocumentModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Tombol yang memicu modal
            var documentId = button.getAttribute('data-id');
            var linkDokumen = button.getAttribute('data-link_dokumen');
            var judul = button.getAttribute('data-judul');

            // Set action form ke rute yang benar menggunakan route helper
            var updateUrl = '{{ route("dashboard.update", ":id") }}'.replace(':id', documentId);
            editDocumentForm.action = updateUrl;

            // Update link dokumen saat ini
            if (linkDokumen) {
                currentDokumenParagraph.innerHTML = `
                    <a href="${linkDokumen}" target="_blank" class="text-primary d-flex align-items-center">
                        <i class="fas fa-download me-2"></i>Lihat Dokumen
                    </a>
                `;
            } else {
                currentDokumenParagraph.innerHTML = '<span class="text-muted"><i class="fas fa-info-circle me-1"></i>Tidak ada dokumen tersedia.</span>';
            }

            // Isi input judul dengan nilai saat ini
            judulInput.value = judul;

            // Reset input file
            var fileInput = editDocumentModal.querySelector('#new_link_dokumen');
            fileInput.value = '';
        });

        // Jika ada error, tampilkan modal tetap terbuka
        @if ($errors->any())
            var editModal = new bootstrap.Modal(document.getElementById('editDocumentModal'));
            editModal.show();
        @endif
    });
</script>

<!-- Optional: Inisialisasi Select2 jika digunakan di tempat lain -->
<script>
    $(document).ready(function() {
        $('.select2').select2({
            templateResult: formatState,
            templateSelection: formatState
        });
    
        function formatState (state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $('<span style="margin-right: 5px;"><i class="fas fa-list"></i></span><span>' + state.text + '</span>');
            return $state;
        };
    });
</script>
@endpush
@section('pengaturan')
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
          <h6 class="mb-0">Sidebar Colors</h6>
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
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
          <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default" onclick="sidebarType(this)">Dark</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
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
        <a class="btn bg-gradient-primary w-100" data-bs-toggle="modal" data-bs-target="#profileModal">Masukkan Nama Profil</a>
        <a class="btn bg-gradient-dark w-100" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </div>
    </div>
  </div>
  @endsection


