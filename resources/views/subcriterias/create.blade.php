@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Range Nilai Baru</h5>
        <a href="{{ route('subcriterias.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('subcriterias.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="criteria_id" class="form-label fw-semibold">
                            <i class="fas fa-sliders-h text-primary me-2"></i>Kriteria
                        </label>
                        <select class="form-control @error('criteria_id') is-invalid @enderror" 
                                id="criteria_id" 
                                name="criteria_id" 
                                required>
                            <option value="">Pilih Kriteria</option>
                            @foreach(\App\Models\Criteria::all() as $criteria)
                            <option value="{{ $criteria->id }}" {{ old('criteria_id') == $criteria->id ? 'selected' : '' }}>
                                {{ $criteria->code }} - {{ $criteria->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('criteria_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="value" class="form-label fw-semibold">
                            <i class="fas fa-star text-primary me-2"></i>Nilai (Skala 1-5)
                        </label>
                        <input type="number" 
                               class="form-control @error('value') is-invalid @enderror" 
                               id="value" 
                               name="value" 
                               value="{{ old('value') }}" 
                               placeholder="1, 2, 3, 4, atau 5"
                               min="1"
                               max="5"
                               required>
                        @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="range_min" class="form-label fw-semibold">
                            <i class="fas fa-arrow-down text-primary me-2"></i>Range Minimum
                        </label>
                        <input type="number" 
                               step="0.1"
                               class="form-control @error('range_min') is-invalid @enderror" 
                               id="range_min" 
                               name="range_min" 
                               value="{{ old('range_min') }}" 
                               placeholder="Contoh: 0"
                               required>
                        @error('range_min')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="range_max" class="form-label fw-semibold">
                            <i class="fas fa-arrow-up text-primary me-2"></i>Range Maximum
                        </label>
                        <input type="number" 
                               step="0.1"
                               class="form-control @error('range_max') is-invalid @enderror" 
                               id="range_max" 
                               name="range_max" 
                               value="{{ old('range_max') }}" 
                               placeholder="Contoh: 5"
                               required>
                        @error('range_max')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="alert alert-info border-0">
                <i class="fas fa-info-circle me-2"></i>
                <small>Range maximum harus lebih besar dari range minimum</small>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Data
                </button>
                <a href="{{ route('subcriterias.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
