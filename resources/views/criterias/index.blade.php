@extends('layouts.main')

@section('content')
<div class="card card-modern">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold text-primary mb-1">Data Kriteria & Bobot</h5>
                <small class="text-muted">Total persentase bobot harus 1 (100%)</small>
            </div>
            <a href="{{ route('criterias.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-plus me-2"></i>Tambah
            </a>
        </div>

        <table class="table table-hover align-middle">
            <thead class="bg-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama Kriteria</th>
                    <th>Atribut</th>
                    <th>Bobot</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($criterias as $c)
                <tr>
                    <td><span class="badge bg-dark">{{ $c->code }}</span></td>
                    <td class="fw-bold">{{ $c->name }}</td>
                    <td>
                        @if($c->attribute == 'benefit')
                            <span class="badge bg-success text-uppercase">Benefit</span>
                        @else
                            <span class="badge bg-danger text-uppercase">Cost</span>
                        @endif
                    </td>
                    <td class="fw-bold text-primary">{{ $c->weight }}</td>
                    <td>
                        <a href="{{ route('criterias.edit', $c->id) }}" class="btn btn-sm btn-outline-warning border-0"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('criterias.destroy', $c->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection