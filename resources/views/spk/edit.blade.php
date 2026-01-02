@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Hasil Tersimpan</h5>
        <a href="{{ route('spk.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('spk.update', $savedResult->id) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama Hasil <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $savedResult->name) }}" 
                       required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label fw-semibold">Catatan</label>
                <textarea class="form-control" 
                          id="notes" 
                          name="notes" 
                          rows="4">{{ old('notes', $savedResult->notes) }}</textarea>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <small>Data hasil perhitungan tidak dapat diubah. Hanya nama dan catatan yang bisa diedit.</small>
            </div>

            <hr class="my-4">

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
@endsection
