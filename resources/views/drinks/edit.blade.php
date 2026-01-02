@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Minuman</h5>
        <a href="{{ route('drinks.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('drinks.update', $drink->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-12">
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">
                            <i class="fas fa-wine-bottle text-primary me-2"></i>Nama Minuman
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $drink->name) }}" 
                               required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="calories" class="form-label fw-semibold">
                            <i class="fas fa-bolt text-primary me-2"></i>Energi / Kalori (kcal)
                        </label>
                        <input type="number" 
                               step="0.01"
                               class="form-control @error('calories') is-invalid @enderror" 
                               id="calories" 
                               name="calories" 
                               value="{{ old('calories', $drink->calories) }}" 
                               required>
                        @error('calories')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="protein" class="form-label fw-semibold">
                            <i class="fas fa-dumbbell text-primary me-2"></i>Protein (gram)
                        </label>
                        <input type="number" 
                               step="0.01"
                               class="form-control @error('protein') is-invalid @enderror" 
                               id="protein" 
                               name="protein" 
                               value="{{ old('protein', $drink->protein) }}" 
                               required>
                        @error('protein')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="carbs" class="form-label fw-semibold">
                            <i class="fas fa-bread-slice text-primary me-2"></i>Karbohidrat (gram)
                        </label>
                        <input type="number" 
                               step="0.01"
                               class="form-control @error('carbs') is-invalid @enderror" 
                               id="carbs" 
                               name="carbs" 
                               value="{{ old('carbs', $drink->carbs) }}" 
                               required>
                        @error('carbs')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="fat" class="form-label fw-semibold">
                            <i class="fas fa-droplet text-primary me-2"></i>Lemak (gram)
                        </label>
                        <input type="number" 
                               step="0.01"
                               class="form-control @error('fat') is-invalid @enderror" 
                               id="fat" 
                               name="fat" 
                               value="{{ old('fat', $drink->fat) }}" 
                               required>
                        @error('fat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="mb-4">
                        <label for="image" class="form-label fw-semibold">
                            <i class="fas fa-image text-primary me-2"></i>Gambar Baru (Opsional)
                        </label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, PNG, GIF. Max: 2MB</small>
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('drinks.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
