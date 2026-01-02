@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('comparisons.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <h5 class="fw-bold">Edit Perbandingan</h5>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('comparisons.update', $comparison->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Perbandingan <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $comparison->name) }}" 
                           placeholder="Misal: Perbandingan Minuman Rendah Kalori"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Pilih Minuman untuk Dibandingkan <span class="text-danger">*</span></label>
                    <small class="text-muted d-block mb-2">Pilih minimal 2 minuman</small>
                    
                    @if($drinks->count() > 0)
                    <div class="row">
                        @foreach($drinks as $drink)
                        <div class="col-md-6 mb-2">
                            <div class="form-check p-3 border rounded @error('drink_ids') border-danger @enderror" style="background: #f8f9fa;">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="drink_ids[]" 
                                       value="{{ $drink->id }}" 
                                       id="drink_{{ $drink->id }}"
                                       {{ in_array($drink->id, old('drink_ids', $comparison->drink_ids)) ? 'checked' : '' }}>
                                <label class="form-check-label w-100" for="drink_{{ $drink->id }}">
                                    <strong>{{ $drink->name }}</strong>
                                    <div class="small text-muted">
                                        Kalori: {{ $drink->calories }} | Protein: {{ $drink->protein }}g | 
                                        Karbo: {{ $drink->carbohydrates }}g | Lemak: {{ $drink->fat }}g
                                    </div>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @error('drink_ids')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    @else
                    <div class="alert alert-warning">
                        Belum ada minuman. <a href="{{ route('drinks.create') }}">Tambahkan minuman</a> terlebih dahulu.
                    </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Catatan (Optional)</label>
                    <textarea class="form-control" 
                              id="notes" 
                              name="notes" 
                              rows="3" 
                              placeholder="Tambahkan catatan untuk perbandingan ini...">{{ old('notes', $comparison->notes) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Perbandingan
                    </button>
                    <a href="{{ route('comparisons.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
