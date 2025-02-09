<!-- resources/views/dashboard.blade.php -->

@extends('layouts.newindex')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Card untuk Tabel Dokumen -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h5>Dashboard Superadmin</h5>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container mt-4">

                        <!-- Menampilkan Pesan Sukses dan Error -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Form Pencarian dan Filter Per Halaman -->
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                            <!-- Form Pencarian -->
                            <form action="{{ route('dashboard') }}" method="GET" class="d-flex align-items-center mb-2 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text text-body" onclick="this.closest('form').submit();"><i class="fas fa-search" aria-hidden="true"></i></span>
                                    <input type="text" name="search" class="form-control" placeholder="Cari dokumen..." value="{{ request('search') }}">
                                </div>
                            </form>

                            <!-- Form Filter Per Halaman -->
                            <div class="col-md-2">
                                <label for="per_page" class="form-label">Tampilkan per halaman</label>
                                <select name="per_page" class="form-control" onchange="this.form.submit()">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                        </div>

                        <!-- Cek Apakah Ada Dokumen -->
                        @if ($documents->count() > 0)
                            <!-- Informasi Pagination -->
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <p class="mb-0">
                                        Menampilkan {{ $documents->firstItem() }} sampai {{ $documents->lastItem() }} dari {{ $documents->total() }} entri
                                    </p>
                                </div>
                            </div>

                            <!-- Tabel Dokumen -->
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Informasi</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Dokumen</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Pengerjaan</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Pembayaran</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Diproses Pada</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($documents as $document)
                                        <tr>
                                            <!-- Informasi Dokumen -->
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <div class="avatar avatar-sm me-3 bg-primary text-white d-flex align-items-center justify-content-center rounded-circle">
                                                            <i class="fas fa-file-alt"></i>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $document->judul }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $document->nomor_hp }}</p>
                                                    </div>
                                                </div>
                                            </td>
                    
                                            <!-- Rubah Dokumen -->
                                            <td> 
                                                <div class="d-flex flex-column"> 
                                                    <!-- Tombol Lihat Dokumen -->
                                                    <a href="{{ $document->link_dokumen }}" target="_blank" class="btn btn-sm btn-success mb-2 w-100 d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Dokumen"> 
                                                        <i class="fas fa-eye me-1"></i> Lihat 
                                                    </a> 
                                            
                                                    <!-- Tombol Unduh Dokumen -->
                                                    <a href="{{ route('dashboard.download', $document->id) }}" class="btn btn-sm btn-primary mb-2 w-100 d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Unduh Dokumen">
                                                        <i class="fas fa-download me-1"></i> Unduh
                                                    </a>
                                                   
                                                </div> 
                                            </td>
                                            <!-- Status Pengerjaan -->
                                            <td>
                                                @if ($document->token) 
                                                <form action="{{ route('dashboard.updateStatus', $document->id) }}" method="POST"> 
                                                    @csrf 
                                                    @method('PATCH') 
                                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Status"> 
                                                        <option value="pending" {{ $document->token->status == 'pending' ? 'selected' : '' }}>Pending</option> 
                                                        <option value="in_progress" {{ $document->token->status == 'in_progress' ? 'selected' : '' }}>In Progress</option> 
                                                        <option value="completed" {{ $document->token->status == 'completed' ? 'selected' : '' }}>Completed</option> 
                                                    </select> 
                                                </form> 
                                            @else 
                                                <span class="text-muted"><i class="fas fa-info-circle me-1"></i>Tidak tersedia</span> 
                                            @endif 
                                            </td>
                    
                                            <!-- Status Pembayaran -->
                                            <td class="align-middle text-center text-sm">
                                                @if ($document->status_pembayaran == 'sudah_bayar')
                                                    <span class="badge badge-sm bg-gradient-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Pembayaran Telah Diterima">
                                                        <i class="fas fa-check-circle me-1"></i> Sudah Dibayar
                                                    </span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Pembayaran Belum Diterima">
                                                        <i class="fas fa-times-circle me-1"></i> Belum Dibayar
                                                    </span>
                                                @endif
                                            </td>
                    
                                            <!-- Diproses Pada -->
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <i class="fas fa-calendar-alt me-1"></i>{{ $document->created_at->format('d-m-Y H:i') }}
                                                </span>
                                            </td>
                    
                                            <!-- Aksi -->
                                            <td class="align-middle text-center">
                                                <!-- Tombol Edit Dokumen -->
                                                <a href="{{ route('dashboard.edit', $document->id) }}" class="btn btn-primary btn-sm me-1" title="Edit Dokumen">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                                
                                                <!-- Tombol Hapus Dokumen (Opsional) -->
                                                {{-- 
                                                <form action="{{ route('dashboard.destroy', $document->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Dokumen">
                                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                                    </button>
                                                </form> 
                                                --}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                                <!-- Modal Edit Dokumen -->
                                <div class="modal fade" id="editDocumentModal" tabindex="-1" aria-labelledby="editDocumentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form id="editDocumentForm" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="editDocumentModalLabel"><i class="fas fa-edit me-2"></i> Edit Dokumen</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Menampilkan Error Validasi -->
                                                    @if ($errors->any())
                                                        <div class="alert alert-danger">
                                                            <ul class="mb-0">
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    <!-- Menampilkan Dokumen Saat Ini -->
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-file-alt me-2"></i> Dokumen Saat Ini:</label>
                                                        <p id="currentDokumen">
                                                            <!-- Diisi oleh JavaScript -->
                                                        </p>
                                                    </div>
                                                    
                                                    <!-- Unggah Dokumen Baru -->
                                                    <div class="mb-3">
                                                        <label for="new_link_dokumen" class="form-label"><i class="fas fa-upload me-2"></i> Unggah Dokumen Baru</label>
                                                        <input type="file" class="form-control" id="new_link_dokumen" name="link_dokumen" accept=".pdf,.doc,.docx,.txt">
                                                        <div class="form-text">Format yang diterima: PDF, DOC, DOCX, TXT. Maksimal 10MB.</div>
                                                    </div>
                                                    
                                                    <!-- Field Judul -->
                                                    <div class="mb-3">
                                                        <label for="judul" class="form-label">Judul</label>
                                                        <input type="text" class="form-control" id="judul" name="judul" required>
                                                    </div>
                                                    <!-- Tambahkan field lain jika diperlukan -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i> Tutup</button>
                                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Simpan Perubahan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Pagination Kustom -->
                            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                                <!-- Tombol Previous -->
                                @if ($documents->onFirstPage())
                                    <button class="btn btn-secondary mb-2 mb-md-0" disabled>
                                        <i class="fas fa-arrow-left"></i> Previous
                                    </button>
                                @else
                                    <a href="{{ $documents->appends(request()->except('page'))->previousPageUrl() }}" class="btn btn-primary mb-2 mb-md-0">
                                        <i class="fas fa-arrow-left"></i> Previous
                                    </a>
                                @endif

                                <!-- Nomor Halaman -->
                                <nav aria-label="Page navigation example" class="mb-2 mb-md-0">
                                    <ul class="pagination mb-0">
                                        @foreach ($documents->getUrlRange(1, $documents->lastPage()) as $page => $url)
                                            @if ($page == $documents->currentPage())
                                                <li class="page-item active" aria-current="page">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </nav>

                                <!-- Tombol Next -->
                                @if ($documents->hasMorePages())
                                    <a href="{{ $documents->appends(request()->except('page'))->nextPageUrl() }}" class="btn btn-primary mb-2 mb-md-0">
                                        Next <i class="fas fa-arrow-right"></i>
                                    </a>
                                @else
                                    <button class="btn btn-secondary mb-2 mb-md-0" disabled>
                                        Next <i class="fas fa-arrow-right"></i>
                                    </button>
                                @endif
                            </div>
                        @else
                            <!-- Pesan Jika Tidak Ada Dokumen -->
                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                Tidak ada dokumen ditemukan.
                            </div>
                        @endif
                    </div>
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
@section('plugin')


