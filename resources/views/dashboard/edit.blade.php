@extends('layouts.newindex') <!-- Pastikan Anda menggunakan layout yang sesuai -->

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Card untuk Tabel Dokumen -->
        <div class="card mb-4">
<div class="container p-5">
            <h2>Edit Dokumen</h2>
            <form method="POST" action="{{ route('dashboard.updateDocumentFile', $document->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Judul Dokumen -->
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Dokumen:</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $document->judul) }}" required>
                    @error('judul')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Nomor HP -->
                <div class="mb-3">
                    <label for="nomor_hp" class="form-label">Nomor HP Baru</label>
                    <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp', $document->nomor_hp) }}" required>
                    @error('nomor_hp')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Link Dokumen Saat Ini -->
                <div class="mb-3">
                    <label class="form-label">Link Dokumen Saat Ini:</label>
                    <p class="form-control-plaintext">
                        <a href="{{ Storage::url($document->link_dokumen) }}" target="_blank">Lihat Dokumen</a>
                    </p>
                </div>

                <!-- Upload Dokumen Baru -->
                <div class="mb-3">
                    <label for="link_dokumen" class="form-label">
                        <i class="fas fa-upload me-2"></i> Unggah Dokumen Baru
                    </label>
                    <input type="file" class="form-control" id="link_dokumen" name="link_dokumen" accept=".pdf,.doc,.docx,.txt">
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

                <div class="d-flex justify-content-end">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Inisialisasi Bootstrap Tooltip (Jika Diperlukan) -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script> 

<!-- Inisialisasi Select2 (Jika Diperlukan) -->
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
