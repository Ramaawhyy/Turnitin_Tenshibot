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
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button> 
                            </div> 
                        @endif 
                         
                        @if (session('error')) 
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }} 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button> 
                            </div> 
                        @endif 

                        <!-- Form Pencarian dan Filter Per Halaman --> 
                        <div class="d-flex justify-content-between align-items-center mb-3"> 
                            <!-- Search Bar --> 
                            <form action="{{ route('dashboard') }}" method="GET" class="d-flex align-items-center"> 
                                <div class="input-group"> 
                                    <span class="input-group-text text-body" onclick="this.closest('form').submit();"><i class="fas fa-search" aria-hidden="true"></i></span> 
                                    <input type="text" name="search" class="form-control" placeholder="Cari dokumen..." value="{{ request('search') }}"> 
                                </div> 
                            </form> 

                            <!-- Filter Per Halaman --> 
                            <form action="{{ route('dashboard') }}" method="GET" class="d-flex align-items-center"> 
                                <label for="per_page" class="me-2 mb-0">Tampilkan:</label> 
                                <select name="per_page" id="per_page" class="form-select" onchange="this.form.submit()"> 
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option> 
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option> 
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option> 
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option> 
                                </select> 
                            </form> 
                        </div> 

                        <!-- Memeriksa apakah ada dokumen --> 
                        @if ($documents->count() > 0) 
                            <!-- Menampilkan Informasi Halaman --> 
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
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Rubah Dokumen</th> 
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Pembayaran</th> 
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Diproses Pada</th> 
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th> 
                                        </tr> 
                                    </thead> 
                                    <tbody>
                                        @foreach ($documents as $index => $document)
                                            <tr>
                                                <!-- Informasi -->
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <!-- Avatar atau Icon -->
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
                                                        <a href="{{ Storage::url($document->link_dokumen) }}" target="_blank" class="btn btn-sm btn-success mb-2 d-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Dokumen">
                                                            <i class="fas fa-eye me-1"></i> Lihat
                                                        </a>
                                                        @if ($document->token)
                                                            <form action="{{ route('dashboard.updateStatus', $document->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <select name="status" class="form-select form-select-sm select2" onchange="this.form.submit()" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Status">
                                                                    <option value="pending" {{ $document->token->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="in_progress" {{ $document->token->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                                    <option value="completed" {{ $document->token->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                                </select>
                                                            </form>
                                                        @else
                                                            <span class="text-muted"><i class="fas fa-info-circle me-1"></i>Tidak tersedia</span>
                                                        @endif
                                                    </div>
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
                                                    <!-- Tombol Edit Dokumen dengan Data Attributes -->
                                                    <button type="button" class="btn btn-primary btn-sm me-1 edit-button" data-bs-toggle="modal" 
                                                        data-bs-target="#editDocumentModal" 
                                                        data-id="{{ $document->id }}" 
                                                        data-judul="{{ $document->judul }}" 
                                                        data-nomor_hp="{{ $document->nomor_hp }}" 
                                                        data-link_dokumen="{{ $document->link_dokumen }}" 
                                                        title="Edit Dokumen">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </button> 
                            
                                                    <!-- Tombol Hapus Dokumen (Jika Diperlukan) -->
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
                                  
                                <!-- Modal Edit Document -->
                                <div class="modal fade" id="editDocumentModal" tabindex="-1" aria-labelledby="editDocumentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="" id="editDocumentForm" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editDocumentModalLabel">Edit Dokumen</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Judul Dokumen sebagai Teks -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Judul Dokumen:</label>
                                                        <p id="currentJudul" class="form-control-plaintext">
                                                            <!-- Diisi oleh JavaScript -->
                                                        </p>
                                                    </div>
                                
                                                    <!-- Hidden Input untuk Judul (Jika Diperlukan) -->
                                                    <input type="hidden" name="judul" id="hiddenJudul">
                                
                                                    <!-- Nomor HP -->
                                                    <div class="mb-3">
                                                        <label for="new_nomor_hp" class="form-label">Nomor HP Baru</label>
                                                        <input type="text" class="form-control" id="new_nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}" required>
                                                        @error('nomor_hp')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                
                                                    <!-- Link Dokumen Saat Ini -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Link Dokumen Saat Ini:</label>
                                                        <p id="currentDokumen" class="form-control-plaintext">
                                                            <!-- Diisi oleh JavaScript -->
                                                        </p>
                                                    </div>
                                
                                                    <!-- Upload Dokumen Baru -->
                                                    <div class="mb-3">
                                                        <label for="new_link_dokumen" class="form-label">
                                                            <i class="fas fa-upload me-2"></i> Unggah Dokumen Baru
                                                        </label>
                                                        <input type="file" class="form-control" id="new_link_dokumen" name="link_dokumen" accept=".pdf,.doc,.docx,.txt">
                                                        <div class="form-text">Format yang diterima: PDF, DOC, DOCX, TXT. Maksimal 10MB.</div>
                                                    </div>
                                
                                                    <!-- Display Validation Errors -->
                                                    @if($errors->any())
                                                        <div class="alert alert-danger">
                                                            <ul class="mb-0">
                                                                @foreach($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Custom Pagination dengan Tombol Previous, Next, dan Nomor Halaman --> 
                                <div class="d-flex justify-content-between align-items-center mt-3"> 
                                    <!-- Tombol Previous --> 
                                    @if ($documents->onFirstPage()) 
                                        <button class="btn btn-secondary" disabled> 
                                            <i class="fas fa-arrow-left"></i> Previous 
                                        </button> 
                                    @else 
                                        <a href="{{ $documents->appends(request()->except('page'))->previousPageUrl() }}" class="btn btn-primary"> 
                                            <i class="fas fa-arrow-left"></i> Previous 
                                        </a> 
                                    @endif 

                                    <!-- Nomor Halaman --> 
                                    <nav aria-label="Page navigation example"> 
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
                                        <a href="{{ $documents->appends(request()->except('page'))->nextPageUrl() }}" class="btn btn-primary"> 
                                            Next <i class="fas fa-arrow-right"></i> 
                                        </a> 
                                    @else 
                                        <button class="btn btn-secondary" disabled> 
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
<!-- JavaScript untuk Mengisi Modal dan Inisialisasi Tooltip -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editModal = document.getElementById('editDocumentModal');
        
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Tombol yang memicu modal
                var id = button.getAttribute('data-id');
                var judul = button.getAttribute('data-judul');
                var nomor_hp = button.getAttribute('data-nomor_hp');
                var link_dokumen = button.getAttribute('data-link_dokumen');

                console.log('ID:', id);
                console.log('Judul:', judul);
                console.log('Nomor HP:', nomor_hp);
                console.log('Link Dokumen:', link_dokumen);

                // Update konten modal
                var modalTitle = editModal.querySelector('.modal-title');
                var form = editModal.querySelector('#editDocumentForm');

                // Set action form
                form.action = '{{ url("/dashboard/update") }}/' + id;

                // Set judul sebagai teks
                var currentJudul = editModal.querySelector('#currentJudul');
                if (currentJudul) {
                    currentJudul.textContent = judul;
                }

                // Set hidden input judul
                var hiddenJudul = editModal.querySelector('#hiddenJudul');
                if (hiddenJudul) {
                    hiddenJudul.value = judul;
                }

                // Set nilai input nomor_hp
                var nomorHpInput = editModal.querySelector('#new_nomor_hp');
                if (nomorHpInput) {
                    nomorHpInput.value = nomor_hp;
                }

                // Set link dokumen saat ini
                var currentDokumen = editModal.querySelector('#currentDokumen');
                if (currentDokumen) {
                    if(link_dokumen){
                        currentDokumen.innerHTML = '<a href="{{ Storage::url("") }}/' + link_dokumen + '" target="_blank">Lihat Dokumen</a>';
                    } else {
                        currentDokumen.textContent = 'Tidak tersedia';
                    }
                }
            });
        }

        // Inisialisasi Bootstrap Tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
<!-- Inisialisasi Select2 -->
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
        }
    });
</script>
@endpush