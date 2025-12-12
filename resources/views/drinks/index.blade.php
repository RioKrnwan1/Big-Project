@extends('layouts.main')

@section('content')
<div class="card card-modern">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold text-primary mb-1">Master Data Minuman</h5>
                <small class="text-muted">Data nutrisi per kemasan (Energi, Protein, Lemak, Karbo)</small>
            </div>
            <a href="{{ route('drinks.create') }}" class="btn btn-primary rounded-pill shadow-sm">
                <i class="fas fa-plus me-2"></i>Tambah Data
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light text-uppercase small text-muted">
                    <tr>
                        <th class="py-3 ps-4">Nama Produk</th>
                        <th>Energi</th>
                        <th>Protein</th>
                        <th>Lemak</th>
                        <th>Karbo</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drinks as $d)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-wine-bottle text-secondary"></i>
                                </div>
                                {{ $d->name }}
                            </div>
                        </td>
                        <td><span class="fw-bold text-primary">{{ $d->calories }}</span> <small class="text-muted">kcal</small></td>
                        <td><span class="fw-bold text-dark">{{ $d->protein }}</span> <small class="text-muted">g</small></td>
                        <td><span class="fw-bold text-dark">{{ $d->fat }}</span> <small class="text-muted">g</small></td>
                        <td><span class="fw-bold text-dark">{{ $d->carbs }}</span> <small class="text-muted">g</small></td>
                        
                        <td class="text-end pe-4">
                            <a href="{{ route('drinks.edit', $d->id) }}" class="btn btn-sm btn-outline-warning border-0 bg-transparent" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('drinks.destroy', $d->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger border-0 bg-transparent" onclick="return confirm('Hapus item ini?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection