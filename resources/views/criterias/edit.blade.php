@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Kriteria</h5>
        <a href="{{ route('criterias.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('criterias.update', $criteria->id) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="code" class="form-label fw-semibold">
                            <i class="fas fa-code text-primary me-2"></i>Kode Kriteria
                        </label>
                        <input type="text" 
                               class="form-control @error('code') is-invalid @enderror" 
                               id="code" 
                               name="code" 
                               value="{{ old('code', $criteria->code) }}" 
                               required>
                        @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">
                            <i class="fas fa-tag text-primary me-2"></i>Nama Kriteria
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $criteria->name) }}" 
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
                        <label for="attribute" class="form-label fw-semibold">
                            <i class="fas fa-exchange-alt text-primary me-2"></i>Atribut
                        </label>
                        <select class="form-control @error('attribute') is-invalid @enderror" 
                                id="attribute" 
                                name="attribute" 
                                required>
                            <option value="">Pilih Atribut</option>
                            <option value="cost" {{ old('attribute', $criteria->attribute) == 'cost' ? 'selected' : '' }}>Cost (Semakin kecil semakin baik)</option>
                            <option value="benefit" {{ old('attribute', $criteria->attribute) == 'benefit' ? 'selected' : '' }}>Benefit (Semakin besar semakin baik)</option>
                        </select>
                        @error('attribute')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="weight" class="form-label fw-semibold">
                            <i class="fas fa-weight text-primary me-2"></i>Bobot (0-1)
                        </label>
                        <input type="number" 
                               step="0.01"
                               class="form-control @error('weight') is-invalid @enderror" 
                               id="weight" 
                               name="weight" 
                               value="{{ old('weight', $criteria->weight) }}" 
                               min="0"
                               max="1"
                               required>
                        @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Total bobot semua kriteria harus = 1.0</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="mb-4">
                        <label for="column_ref" class="form-label fw-semibold">
                            <i class="fas fa-database text-primary me-2"></i>Referensi Kolom Database
                        </label>
                        <select class="form-control @error('column_ref') is-invalid @enderror" 
                                id="column_ref" 
                                name="column_ref" 
                                required>
                            <option value="">Pilih Kolom</option>
                            <option value="calories" {{ old('column_ref', $criteria->column_ref) == 'calories' ? 'selected' : '' }}>calories (Kalori / Energi)</option>
                            <option value="protein" {{ old('column_ref', $criteria->column_ref) == 'protein' ? 'selected' : '' }}>protein (Protein)</option>
                            <option value="carbs" {{ old('column_ref', $criteria->column_ref) == 'carbs' ? 'selected' : '' }}>carbs (Karbohidrat)</option>
                            <option value="fat" {{ old('column_ref', $criteria->column_ref) == 'fat' ? 'selected' : '' }}>fat (Lemak)</option>
                        </select>
                        @error('column_ref')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-1">Kolom database yang akan digunakan untuk perhitungan SPK</small>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('criterias.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
