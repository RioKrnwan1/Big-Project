@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Perbandingan Minuman</h5>
        <a href="{{ route('comparisons.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Buat Perbandingan
        </a>
    </div>

    @if($comparisons->count() > 0)
        @foreach($comparisons as $comparison)
        <div class="card mb-4">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-bold">{{ $comparison->name }}</h6>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>{{ $comparison->created_at->format('d M Y H:i') }}
                            @if($comparison->notes)
                            <span class="ms-2"><i class="fas fa-sticky-note me-1"></i>{{ Str::limit($comparison->notes, 50) }}</span>
                            @endif
                        </small>
                    </div>
                    <div>
                        <a href="{{ route('comparisons.edit', $comparison->id) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('comparisons.destroy', $comparison->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus perbandingan ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            @if(isset($comparisonResults[$comparison->id]))
            @php
                $result = $comparisonResults[$comparison->id];
                $drinks = $result['drinks'];
                $scores = $result['scores'];
                $data = $result['data'];
            @endphp
            <div class="card-body">
                {{-- Summary Stats --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded border-start border-success border-3" style="background: #f8fff8;">
                            <small class="text-muted">Terbaik</small>
                            <h6 class="mb-0 fw-bold text-success">{{ $data['best']['name'] }}</h6>
                            <small>Skor: {{ number_format($data['best']['score'], 4) }}</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded border-start border-primary border-3" style="background: #f8f9ff;">
                            <small class="text-muted">Rata-rata</small>
                            <h6 class="mb-0 fw-bold text-primary">{{ number_format($data['average'], 4) }}</h6>
                            <small>Dari {{ $drinks->count() }} minuman</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded border-start border-danger border-3" style="background: #fff8f8;">
                            <small class="text-muted">Terendah</small>
                            <h6 class="mb-0 fw-bold text-danger">{{ $data['worst']['name'] }}</h6>
                            <small>Skor: {{ number_format($data['worst']['score'], 4) }}</small>
                        </div>
                    </div>
                </div>

                {{-- Comparison Table --}}
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Minuman</th>
                                <th>Kalori</th>
                                <th>Protein</th>
                                <th>Karbo</th>
                                <th>Lemak</th>
                                <th>Skor SPK</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drinks as $drink)
                            @php
                                $drinkScore = $scores->firstWhere('name', $drink->name);
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $drink->name }}</strong>
                                    @if($drinkScore && $drinkScore['name'] === $data['best']['name'])
                                    <i class="fas fa-crown text-warning ms-1"></i>
                                    @endif
                                </td>
                                <td>{{ $drink->calories }} kcal</td>
                                <td>{{ $drink->protein }}g</td>
                                <td>{{ $drink->carbohydrates }}g</td>
                                <td>{{ $drink->fat }}g</td>
                                <td>
                                    <span class="badge {{ $drinkScore && $drinkScore['name'] === $data['best']['name'] ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $drinkScore ? number_format($drinkScore['score'], 4) : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($drinkScore)
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar {{ $drinkScore['name'] === $data['best']['name'] ? 'bg-success' : 'bg-primary' }}" 
                                             role="progressbar" 
                                             style="width: {{ $data['percentages'][$drinkScore['name']] }}%">
                                            {{ $data['percentages'][$drinkScore['name']] }}%
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Score Differences --}}
                @if(count($data['differences']) > 0)
                <div class="mt-3">
                    <small class="text-muted fw-bold">SELISIH SKOR:</small>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @foreach($data['differences'] as $diff)
                        <span class="badge bg-light text-dark border">
                            {{ $diff['drink1'] }} ↔ {{ $diff['drink2'] }}: 
                            <strong>Δ {{ number_format($diff['difference'], 4) }}</strong>
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @else
            <div class="card-body text-center text-muted">
                <i class="fas fa-exclamation-triangle"></i> Data tidak lengkap untuk perbandingan ini
            </div>
            @endif
        </div>
        @endforeach
    @else
    <div class="card">
        <div class="card-body">
            <div class="text-center py-5 text-muted">
                <i class="fas fa-balance-scale" style="font-size: 64px; opacity: 0.3;"></i>
                <p class="mt-3 mb-0">Belum ada perbandingan</p>
                <small>Buat perbandingan untuk membandingkan minuman</small>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
