@extends('layouts.navbar')

@section('content')
<style>
    .file-drop-area {
    position: relative;
    width: 100%;
    padding: 15px;
    border: 2px dashed #ccc;
    border-radius: 5px;
    background: #fafafa;
    text-align: center;
    cursor: pointer;
}

.file-input {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0;
    cursor: pointer;
}

@media (max-width: 768px) {
    .card {
        width: 100% !important;
        margin-bottom: 20px;
    }

    .d-flex {
        flex-direction: column;
    }

    .file-drop-area {
        padding: 10px;
    }

    .file-icon {
        font-size: 2rem;
    }

    .file-name {
        font-size: 0.9rem;
    }

    .btn {
        width: 100%;
    }
}
</style>
    <div class="d-flex justify-content-between">
        <div class="card mr-2" style="width: 75%; height: 150%; border: 1px solid #DADADA; border-radius: 15px;">
            <div class="card-body">
                <h2 class="text-center">Cek Plagiarisme Turnitin No Repository</h2>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <form action="{{ route('cek-turnitin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="dokumen">Masukan Dokumen Anda</label>
                        <div class="file-drop-area">
                            <input type="file" class="form-control file-input" name="dokumen" accept=".pdf,.doc,.docx" required>
                            <div class="file-icon">
                                <i class="fas fa-file-alt fa-3x text-muted"></i>
                            </div>
                            <p class="file-name mt-2 text-muted">Seret Dokumen atau klik untuk memilih beberapa dokumen! (PDF, DOC, DOCX, maksimal 10MB)</p>
                        </div>
                        @error('dokumen')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <div class="form-group">
                        <label for="judul">Judul (Optional)</label>
                        <input type="text" class="form-control" name="judul" placeholder="Judul" value="{{ old('judul') }}">
                        @error('judul')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nomor_hp">Nomor HP</label>
                        <input type="text" class="form-control" name="nomor_hp" placeholder="Masukkan nomor HP (mis. 085861765261)" value="{{ old('nomor_hp') }}" required>
                        @error('nomor_hp')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="exclude_daftar_pustaka" value="0"> <!-- default value jika checkbox tidak dicentang -->
                        <input type="checkbox" class="form-check-input form-check-input-lg" name="exclude_daftar_pustaka" id="exclude_daftar_pustaka" value="1" {{ old('exclude_daftar_pustaka') ? 'checked' : '' }}>
                        <label class="form-check-label" for="exclude_daftar_pustaka">Kecualikan Daftar Pustaka</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="exclude_kutipan" value="0"> <!-- default value jika checkbox tidak dicentang -->
                        <input type="checkbox" class="form-check-input form-check-input-lg" name="exclude_kutipan" id="exclude_kutipan" value="1" {{ old('exclude_kutipan') ? 'checked' : '' }}>
                        <label class="form-check-label" for="exclude_kutipan">Kecualikan Kutipan</label>
                    </div>

                    <!-- Exclude Match Checkbox -->
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="exclude_match_checkbox" value="0"> <!-- default value jika checkbox tidak dicentang -->
                        <input type="checkbox" class="form-check-input form-check-input-lg" name="exclude_match_checkbox" id="exclude_match_checkbox" value="1" {{ old('exclude_match_checkbox') ? 'checked' : '' }}>
                        <label class="form-check-label" for="exclude_match_checkbox">Exclude Match</label>
                    </div>

                    <!-- Container untuk opsi Exclude Match -->
                    <div id="excludeMatchOptions" class="mb-3" style="display: {{ old('exclude_match_checkbox') ? 'block' : 'none' }};">
                        <!-- Checkbox untuk Percentage -->
                        <div class="form-check form-switch mb-2">
                            <input type="checkbox" class="form-check-input form-check-input-lg" name="exclude_match_percentage_checkbox" id="exclude_match_percentage_checkbox" value="1" {{ old('exclude_match_percentage_checkbox') ? 'checked' : '' }}>
                            <label class="form-check-label" for="exclude_match_percentage_checkbox">Exclude Match Percentage</label>
                        </div>
                        <!-- Input untuk Percentage -->
                        <div class="mb-3" id="percentageInput" style="display: {{ old('exclude_match_percentage_checkbox') ? 'block' : 'none' }};">
                            <label for="exclude_match_percentage_value" class="form-label">Nilai Percentage (%)</label>
                            <input type="number" name="exclude_match_percentage_value" min="0" max="100" class="form-control" value="{{ old('exclude_match_percentage_value') }}">
                            @error('exclude_match_percentage_value')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Checkbox untuk Words -->
                        <div class="form-check form-switch mb-2">
                            <input type="checkbox" class="form-check-input form-check-input-lg" name="exclude_match_words_checkbox" id="exclude_match_words_checkbox" value="1" {{ old('exclude_match_words_checkbox') ? 'checked' : '' }}>
                            <label class="form-check-label" for="exclude_match_words_checkbox">Exclude Match Words</label>
                        </div>
                        <!-- Input untuk Words -->
                        <div class="mb-3" id="wordsInput" style="display: {{ old('exclude_match_words_checkbox') ? 'block' : 'none' }};">
                            <label for="exclude_match_words_value" class="form-label">Jumlah Kata</label>
                            <input type="number" name="exclude_match_words_value" min="0" class="form-control" value="{{ old('exclude_match_words_value') }}">
                            @error('exclude_match_words_value')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                <!-- Tombol Submit dengan Spinner -->
                

                    {{-- Tombol submit dengan spinner --}}
                    <button type="submit" class="btn btn-primary">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Submit Tugas
                    </button>
                </form>

              
                {{-- @if($documents->count())
                    <h3 class="mt-4">Daftar Dokumen yang Diunggah</h3>
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Nomor HP</th>
                                <th>Dokumen</th>
                                <th>Diproses Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $index => $doc)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $doc->judul ?? '-' }}</td>
                                    <td>{{ $doc->nomor_hp }}</td>
                                    <td>
                                        <a href="{{ Storage::url($doc->dokumen) }}" target="_blank">Lihat Dokumen</a>
                                    </td>
                                    <td>{{ $doc->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="mt-4">Belum ada dokumen yang diunggah.</p>
                @endif --}}
            </div>
        </div>

        <div class="card mr-2" style="width: 20%; height: 10%; border: 1px solid #DADADA; border-radius: 15px;">
            <div class="card-body">
                <h5>Daftar Biaya</h5>
                <p>Rp. 2.000 untuk pengecekan plagiarisme</p>
                
                <p class="text-primary">Cek Pembelian untuk mengunduh hasil pengecekan.</p>
                               <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cekPembelianModal">Cek Disini</button>
                
            </div>
        </div>
        <!-- Modal Cek Pembelian -->
<div class="modal fade" id="cekPembelianModal" tabindex="-1" aria-labelledby="cekPembelianModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('cek-pembelian.process') }}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="cekPembelianModalLabel">Cek Pembelian</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
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
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Cek</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
        {{-- <div class="card ml-2" style="width: 20%; height: 100%;">
            <div class="card-body">
                <h5>Daftar Biaya</h5>
                <p>Rp. 2.000 untuk pengecekan plagiarisme</p>

                @if (session('transaksi'))
                    <a href="{{ route('transaksi.proses') }}" class="btn btn-success">Lanjutkan ke Pembayaran</a>
                @else
                    <p class="text-primary">Cek Pembelian untuk mengunduh hasil pengecekan.</p>
                    <button class="btn btn-primary" disabled>Cek Disini</button>
                @endif
            </div>
        </div> --}}
    </div>

    <script>
        document.querySelector('input[type="file"]').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            document.querySelector('.file-name').textContent = fileName;
        });

        // Menambahkan class spinner ketika form di-submit
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const button = this.querySelector('button[type="submit"]');
                if(button){
                    button.querySelector('.spinner-border').classList.remove('d-none');
                    button.disabled = true;
                }
            });
        });
    </script>
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Menampilkan nama file yang dipilih
            document.querySelector('input[type="file"]').addEventListener('change', function(e) {
                var fileName = e.target.files[0].name;
                document.querySelector('.file-name').textContent = fileName;
            });

            // Menambahkan spinner ketika form di-submit
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const button = this.querySelector('button[type="submit"]');
                    if(button){
                        button.querySelector('.spinner-border').classList.remove('d-none');
                        button.disabled = true;
                    }
                });
            });

            // Menangani tampilan opsi Exclude Match
            const excludeMatchCheckbox = document.getElementById('exclude_match_checkbox');
            const excludeMatchOptions = document.getElementById('excludeMatchOptions');
            const excludeMatchPercentageCheckbox = document.getElementById('exclude_match_percentage_checkbox');
            const excludeMatchWordsCheckbox = document.getElementById('exclude_match_words_checkbox');
            const percentageInput = document.getElementById('percentageInput');
            const wordsInput = document.getElementById('wordsInput');

            excludeMatchCheckbox.addEventListener('change', function() {
                if(this.checked){
                    excludeMatchOptions.style.display = 'block';
                } else {
                    excludeMatchOptions.style.display = 'none';
                    // Reset semua checkbox dan input fields
                    excludeMatchPercentageCheckbox.checked = false;
                    excludeMatchWordsCheckbox.checked = false;
                    percentageInput.style.display = 'none';
                    wordsInput.style.display = 'none';
                    percentageInput.querySelector('input').value = '';
                    wordsInput.querySelector('input').value = '';
                }
            });

            // Menangani tampilan input berdasarkan checkbox Percentage
            excludeMatchPercentageCheckbox.addEventListener('change', function() {
                if(this.checked){
                    percentageInput.style.display = 'block';
                } else {
                    percentageInput.style.display = 'none';
                    percentageInput.querySelector('input').value = '';
                }
            });

            // Menangani tampilan input berdasarkan checkbox Words
            excludeMatchWordsCheckbox.addEventListener('change', function() {
                if(this.checked){
                    wordsInput.style.display = 'block';
                } else {
                    wordsInput.style.display = 'none';
                    wordsInput.querySelector('input').value = '';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    var fileInput = document.querySelector('.file-input');
    var fileArea = document.querySelector('.file-drop-area');
    var fileMsg = document.querySelector('.file-name');

    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            fileMsg.textContent = fileInput.files[0].name;
        } else {
            fileMsg.textContent = 'Drag and drop your file here or click to select.';
        }
    });

    fileArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        fileArea.classList.add('hover');
    });

    fileArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        fileArea.classList.remove('hover');
    });

    fileArea.addEventListener('drop', function(e) {
        e.preventDefault();
        fileArea.classList.remove('hover');
        // Get files from the event
        fileInput.files = e.dataTransfer.files;
        // Update the label text
        if (fileInput.files.length > 0) {
            fileMsg.textContent = fileInput.files[0].name;
        }
    });
});

    </script>
@endsection
