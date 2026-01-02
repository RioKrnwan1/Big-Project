@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Profile Card -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Profile Saya</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff&size=128" 
                         class="rounded-circle mb-3" 
                         style="border: 4px solid #6366f1; width: 128px; height: 128px;">
                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-0">{{ $user->email }}</p>
                    <small class="text-muted">Terdaftar sejak {{ $user->created_at->format('d M Y') }}</small>
                </div>

                <hr class="my-4">

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">
                            <i class="fas fa-user text-primary me-2"></i>Nama Lengkap
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">
                            <i class="fas fa-envelope text-primary me-2"></i>Email
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info border-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>Kosongkan field password jika tidak ingin mengubah password</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="fas fa-lock text-primary me-2"></i>Password Baru
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Minimal 8 karakter">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    <i class="fas fa-lock text-primary me-2"></i>Konfirmasi Password
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('spk.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="fas fa-calendar-alt fa-2x" style="color: #6366f1;"></i>
                        </div>
                        <h6 class="text-muted mb-1">Member Sejak</h6>
                        <h5 class="fw-bold mb-0">{{ $user->created_at->diffForHumans() }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="fas fa-shield-alt fa-2x" style="color: #10b981;"></i>
                        </div>
                        <h6 class="text-muted mb-1">Account Status</h6>
                        <h5 class="fw-bold mb-0"><span class="badge bg-success">Active</span></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="fas fa-clock fa-2x" style="color: #f59e0b;"></i>
                        </div>
                        <h6 class="text-muted mb-1">Last Update</h6>
                        <h5 class="fw-bold mb-0">{{ $user->updated_at->diffForHumans() }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
