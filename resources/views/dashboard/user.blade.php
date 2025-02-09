
{{-- Menampilkan Form Token --}}
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title text-center">Masukkan Token Anda</h5>
        @if(session('token_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('token_error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('token.process') }}" method="POST" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="token" class="form-label">Token</label>
                <input type="text" class="form-control" name="token" placeholder="Masukkan token Anda" required>
                @error('token')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">Lihat Detail</button>
        </form>
    </div>
</div>

{{-- Menampilkan Detail Token Jika Sudah Dimasukkan --}}
@if(session('document') && session('status'))
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title text-center">Detail Token</h5>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Nomor HP</th>
                        <th>Dokumen</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ session('document.judul') ?? '-' }}</td>
                        <td>{{ session('document.nomor_hp') }}</td>
                        <td>
                            <a href="{{ Storage::url(session('document.dokumen')) }}" target="_blank" class="btn btn-outline-secondary btn-sm">Lihat Dokumen</a>
                        </td>
                        <td>
                            @php
                                $statusClass = match(session('status')) {
                                    'pending' => 'secondary',
                                    'in_progress' => 'warning',
                                    'completed' => 'success',
                                    default => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', session('status'))) }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif
