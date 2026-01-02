@extends('layouts.main')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Hasil Analisa SAW</h3>
        <p class="text-muted small mb-0">Laporan lengkap perhitungan metode Simple Additive Weighting</p>
    </div>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#saveResultModal">
        <i class="fas fa-save me-2"></i>Simpan Hasil Ini
    </button>
</div>

{{-- Saved Results Section --}}
@if($savedResults->count() > 0)
<div class="card mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0 fw-bold"><i class="fas fa-history me-2"></i>Hasil Tersimpan ({{ $savedResults->count() }})</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Catatan</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($savedResults as $saved)
                    <tr>
                        <td><strong>{{ $saved->name }}</strong></td>
                        <td>{{ $saved->notes ? Str::limit($saved->notes, 50) : '-' }}</td>
                        <td><small>{{ $saved->created_at->format('d M Y H:i') }}</small></td>
                        <td class="text-center">
                            <a href="{{ route('spk.show', $saved->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('spk.edit', $saved->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('spk.destroy', $saved->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Hapus hasil tersimpan?')">
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
@endif


<ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active rounded-pill px-4 fw-bold" id="pills-rank-tab" data-bs-toggle="pill" data-bs-target="#pills-rank" type="button">
            <i class="fas fa-trophy me-2"></i>Dashboard Juara
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill px-4 fw-bold" id="pills-math-tab" data-bs-toggle="pill" data-bs-target="#pills-math" type="button">
            <i class="fas fa-calculator me-2"></i>Detail Rumus (Step-by-Step)
        </button>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    
    <div class="tab-pane fade show active" id="pills-rank" role="tabpanel">
        <div class="row mb-4">
            @foreach($hasilAkhir as $idx => $row)
                @if($idx < 3)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center p-4 h-100" 
                         >
                        <h1 class="mb-2" style="font-size: 3rem;">{{ $idx==0 ? '🥇' : ($idx==1 ? '🥈' : '🥉') }}</h1>
                        <h5 class="fw-bold">{{ $row['name'] }}</h5>
                        <h2 class="fw-bold my-2">{{ number_format($row['score'], 4) }}</h2>
                        <small class="opacity-75">Skor Akhir</small>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3"><h6 class="fw-bold m-0">Tabel Peringkat Lengkap</h6></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Rank</th>
                            <th>Minuman</th>
                            <th>Nilai V</th>
                            <th class="text-end pe-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hasilAkhir as $idx => $row)
                        <tr>
                            <td class="ps-4 fw-bold">#{{ $idx + 1 }}</td>
                            <td>{{ $row['name'] }}</td>
                            <td class="fw-bold text-primary">{{ number_format($row['score'], 4) }}</td>
                            <td class="text-end pe-4">
                                @if($idx == 0) <span class="badge bg-success">Rekomendasi Utama</span>
                                @else <span class="badge bg-light text-dark border">Alternatif</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="pills-math" role="tabpanel">
        
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="m-0 fw-bold text-primary">Langkah 1: Matriks Keputusan (X)</h6>
                <small class="text-muted">Mengubah data asli menjadi nilai skala (1-5) berdasarkan range.</small>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered mb-0 text-center table-sm">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-start ps-3">Alternatif</th>
                            @foreach($criterias as $c)
                            <th>{{ $c->code }}<br><small class="text-muted">{{ $c->name }}</small></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataAwal as $row)
                        <tr>
                            <td class="text-start ps-3 fw-bold">{{ $row['name'] }}</td>
                            @foreach($criterias as $c)
                            <td>
                                <span class="badge bg-light text-dark border">{{ $row['values'][$c->id] }}</span>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="m-0 fw-bold text-info">Langkah 2: Matriks Normalisasi (R)</h6>
                <small class="text-muted">Membagi nilai skala dengan Max (Benefit) atau Min (Cost).</small>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered mb-0 text-center table-sm">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-start ps-3">Alternatif</th>
                            @foreach($criterias as $c)
                            <th>
                                {{ $c->code }} <span class="badge {{ $c->attribute == 'benefit' ? 'bg-success' : 'bg-danger' }}">{{ $c->attribute == 'benefit' ? 'Max' : 'Min' }}</span>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($normalisasi as $row)
                        <tr>
                            <td class="text-start ps-3 fw-bold">{{ $row['name'] }}</td>
                            @foreach($criterias as $c)
                            <td>{{ number_format($row['values'][$c->id], 3) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="m-0 fw-bold text-success">Langkah 3: Nilai Preferensi (V)</h6>
                <small class="text-muted">Penjumlahan dari (Nilai Normalisasi x Bobot).</small>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered mb-0 text-center table-sm">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-start ps-3">Alternatif</th>
                            <th>Total Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hasilAkhir as $row)
                        <tr>
                            <td class="text-start ps-3 fw-bold">{{ $row['name'] }}</td>
                            <td class="fw-bold text-success">{{ number_format($row['score'], 4) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- Save Result Modal --}}
<div class="modal fade" id="saveResultModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('spk.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-save me-2"></i>Simpan Hasil SPK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Hasil <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Misal: Hasil SPK Januari 2026">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Tambahkan catatan untuk hasil ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection