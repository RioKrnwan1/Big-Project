@extends('layouts.main')

@section('content')
<div class="container-fluid">
    {{-- Statistics Cards Row --}}
    <div class="row mb-4">
        {{-- Total Minuman --}}
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Minuman</p>
                            <h3 class="fw-bold mb-0">{{ $totalMinuman ?? 0 }}</h3>
                        </div>
                        <div class="p-3 rounded-circle" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-wine-bottle text-white" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Kriteria --}}
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Kriteria</p>
                            <h3 class="fw-bold mb-0">{{ $totalKriteria ?? 0 }}</h3>
                        </div>
                        <div class="p-3 rounded-circle" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                            <i class="fas fa-sliders-h text-white" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rata-rata Skor --}}
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Rata-rata Skor</p>
                            <h3 class="fw-bold mb-0">{{ isset($rataRataSkor) ? number_format($rataRataSkor, 2) : '0.00' }}</h3>
                        </div>
                        <div class="p-3 rounded-circle" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-chart-line text-white" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Best Drink --}}
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Minuman Terbaik</p>
                            <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">
                                {{ isset($top5Minuman) && count($top5Minuman) > 0 ? $top5Minuman[0]['name'] : '-' }}
                            </h6>
                        </div>
                        <div class="p-3 rounded-circle" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                            <i class="fas fa-trophy text-white" style="font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Distribution Chart --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-2"></i> Distribusi Kategori Skor
                </div>
                <div class="card-body">
                    @if(isset($distribusi))
                    <canvas id="distributionChart"></canvas>
                    @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-chart-pie" style="font-size: 48px; opacity: 0.3;"></i>
                        <p class="mt-3">Belum ada data untuk ditampilkan</p>
                        <small>Silakan tambahkan kriteria dan minuman terlebih dahulu</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Top 5 Drinks --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-medal me-2"></i> Top 5 Minuman Terbaik
                </div>
                <div class="card-body">
                    @if(isset($top5Minuman) && count($top5Minuman) > 0)
                    <div class="list-group list-group-flush">
                        @foreach($top5Minuman as $index => $drink)
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="badge me-3" style="
                                        width: 32px; 
                                        height: 32px; 
                                        display: flex; 
                                        align-items: center; 
                                        justify-content: center;
                                        background: {{ $index == 0 ? 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)' : ($index == 1 ? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' : 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)') }};
                                        font-size: 14px;
                                        font-weight: bold;">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <h6 class="mb-0">{{ $drink['name'] }}</h6>
                                        <small class="text-muted">Skor: {{ number_format($drink['score'], 4) }}</small>
                                    </div>
                                </div>
                                @if($index == 0)
                                <i class="fas fa-crown text-warning" style="font-size: 20px;"></i>
                                @elseif($index == 1)
                                <i class="fas fa-medal" style="color: #c0c0c0; font-size: 20px;"></i>
                                @elseif($index == 2)
                                <i class="fas fa-medal" style="color: #cd7f32; font-size: 20px;"></i>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-trophy" style="font-size: 48px; opacity: 0.3;"></i>
                        <p class="mt-3">Belum ada data untuk ditampilkan</p>
                        <small>Silakan tambahkan kriteria dan minuman terlebih dahulu</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Percentage Distribution Cards --}}
    @if(isset($persentaseDistribusi))
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card border-0" style="border-left: 4px solid #10b981 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Excellent (>0.8)</p>
                            <h4 class="fw-bold mb-0">{{ $persentaseDistribusi['excellent'] }}%</h4>
                            <small class="text-muted">{{ $distribusi['excellent'] ?? 0 }} minuman</small>
                        </div>
                        <i class="fas fa-check-circle" style="font-size: 32px; color: #10b981;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0" style="border-left: 4px solid #3b82f6 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Good (0.6-0.8)</p>
                            <h4 class="fw-bold mb-0">{{ $persentaseDistribusi['good'] }}%</h4>
                            <small class="text-muted">{{ $distribusi['good'] ?? 0 }} minuman</small>
                        </div>
                        <i class="fas fa-thumbs-up" style="font-size: 32px; color: #3b82f6;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0" style="border-left: 4px solid #f59e0b !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Fair (0.4-0.6)</p>
                            <h4 class="fw-bold mb-0">{{ $persentaseDistribusi['fair'] }}%</h4>
                            <small class="text-muted">{{ $distribusi['fair'] ?? 0 }} minuman</small>
                        </div>
                        <i class="fas fa-meh" style="font-size: 32px; color: #f59e0b;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0" style="border-left: 4px solid #ef4444 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Poor (<0.4)</p>
                            <h4 class="fw-bold mb-0">{{ $persentaseDistribusi['poor'] }}%</h4>
                            <small class="text-muted">{{ $distribusi['poor'] ?? 0 }} minuman</small>
                        </div>
                        <i class="fas fa-times-circle" style="font-size: 32px; color: #ef4444;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@if(isset($distribusi))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('distributionChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Excellent (>0.8)', 'Good (0.6-0.8)', 'Fair (0.4-0.6)', 'Poor (<0.4)'],
            datasets: [{
                data: [
                    {{ $distribusi['excellent'] ?? 0 }},
                    {{ $distribusi['good'] ?? 0 }},
                    {{ $distribusi['fair'] ?? 0 }},
                    {{ $distribusi['poor'] ?? 0 }}
                ],
                backgroundColor: [
                    '#10b981',
                    '#3b82f6',
                    '#f59e0b',
                    '#ef4444'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
});
</script>
@endif
@endsection
