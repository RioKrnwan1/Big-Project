@extends('layouts.main')

@section('content')
<style>
    .badge-soft-5 { background: #dcfce7; color: #166534; padding: 5px 10px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; }
    .badge-soft-4 { background: #dbeafe; color: #1e40af; padding: 5px 10px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; }
    .badge-soft-3 { background: #fef9c3; color: #854d0e; padding: 5px 10px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; }
    .badge-soft-2 { background: #ffedd5; color: #9a3412; padding: 5px 10px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; }
    .badge-soft-1 { background: #fee2e2; color: #991b1b; padding: 5px 10px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark">Aturan Penilaian</h3>
    <a href="{{ route('subcriterias.create') }}" class="btn btn-primary rounded-pill px-4">
        <i class="fas fa-plus me-2"></i>Tambah Aturan Baru
    </a>
</div>

<div class="row">
    @forelse($groupedSubs as $criteriaId => $subs)
        
        @php
            $namaKriteria = $subs->first()->criteria->name;
            $satuan = 'g'; // Default gram
            
            // Cek jika nama kriteria mengandung "Energi"
            if (stripos($namaKriteria, 'Energi') !== false) {
                $satuan = 'kcal';
            }
        @endphp

        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom pt-3 pb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        
                        <h5 class="fw-bold text-primary mb-0">
                            <i class="fas fa-tag me-2"></i>{{ $namaKriteria }} 
                            <span class="text-muted fs-6">({{ $satuan }})</span>
                        </h5>
                        
                        <span class="badge bg-light text-dark border">{{ $subs->first()->criteria->code }}</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Range (Min - Max)</th>
                                <th>Nilai</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subs as $s)
                            <tr>
                                <td class="ps-4 text-muted fw-medium">
                                    {{ $s->range_min }} 
                                    <span class="mx-2">&mdash;</span> 
                                    {{ $s->range_max }}
                                </td>
                                <td>
                                    @if($s->value == 5) <span class="badge-soft-5">Sangat Baik (5)</span>
                                    @elseif($s->value == 4) <span class="badge-soft-4">Baik (4)</span>
                                    @elseif($s->value == 3) <span class="badge-soft-3">Cukup (3)</span>
                                    @elseif($s->value == 2) <span class="badge-soft-2">Buruk (2)</span>
                                    @else <span class="badge-soft-1">Sangat Buruk (1)</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('subcriterias.edit', $s->id) }}" class="btn btn-sm text-warning border-0 bg-transparent p-0 me-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('subcriterias.destroy', $s->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm text-danger border-0 bg-transparent p-0" onclick="return confirm('Hapus?')" title="Hapus">
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
    @empty
        <div class="col-12 text-center py-5">
            <h5 class="text-muted">Belum ada aturan penilaian. Silakan tambah data.</h5>
        </div>
    @endforelse
</div>
@endsection