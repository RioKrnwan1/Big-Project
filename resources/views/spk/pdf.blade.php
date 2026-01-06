<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan SPK - Sistem Pendukung Keputusan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 24px;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 14px;
            color: #666;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            background: #667eea;
            color: white;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table th {
            background: #f4f4f4;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
        }
        
        table td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: center;
            font-size: 11px;
        }
        
        table td:first-child {
            text-align: left;
            font-weight: bold;
        }
        
        .ranking-card {
            display: inline-block;
            width: 30%;
            margin: 5px 1.5%;
            padding: 15px;
            border: 2px solid #667eea;
            border-radius: 8px;
            text-align: center;
        }
        
        .ranking-card .medal {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .ranking-card .name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .ranking-card .score {
            font-size: 20px;
            font-weight: bold;
            color: #667eea;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .badge-success {
            background: #28a745;
            color: white;
        }
        
        .badge-danger {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN SISTEM PENDUKUNG KEPUTUSAN</h1>
        <p>Metode Simple Additive Weighting (SAW)</p>
        <p style="font-size: 11px; margin-top: 5px;">Tanggal: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <!-- TOP 3 RANKING -->
    <div class="section">
        <div class="section-title">TOP 3 MINUMAN TERBAIK</div>
        <div style="text-align: center; margin: 20px 0;">
            @foreach($hasilAkhir as $idx => $row)
                @if($idx < 3)
                <div class="ranking-card">
                    <div class="medal">{{ $idx==0 ? '#1' : ($idx==1 ? '#2' : '#3') }}</div>
                    <div class="name">{{ $row['name'] }}</div>
                    <div class="score">{{ number_format($row['score'], 4) }}</div>
                    <div style="font-size: 10px; color: #666; margin-top: 5px;">Skor Akhir</div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- TABEL PERINGKAT LENGKAP -->
    <div class="section">
        <div class="section-title">TABEL PERINGKAT LENGKAP</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">Rank</th>
                    <th style="width: 50%;">Nama Minuman</th>
                    <th style="width: 25%;">Nilai Preferensi (V)</th>
                    <th style="width: 15%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasilAkhir as $idx => $row)
                <tr>
                    <td style="text-align: center; font-weight: bold;">#{{ $idx + 1 }}</td>
                    <td>{{ $row['name'] }}</td>
                    <td style="font-weight: bold; color: #667eea;">{{ number_format($row['score'], 4) }}</td>
                    <td>
                        @if($idx == 0)
                        <span class="badge badge-success">Rekomendasi</span>
                        @else
                        <span style="font-size: 10px; color: #999;">Alternatif</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- LANGKAH 1: MATRIKS KEPUTUSAN [X] -->
    <div class="section" style="page-break-before: always;">
        <div class="section-title">LANGKAH 1: MATRIKS KEPUTUSAN [X]</div>
        <p style="margin-bottom: 10px; font-size: 11px;">Mengubah data asli menjadi nilai skala (1-5) berdasarkan range sub-kriteria.</p>
        <table>
            <thead>
                <tr>
                    <th>Alternatif</th>
                    @foreach($criterias as $c)
                    <th>{{ $c->code }}<br><small style="font-weight: normal;">{{ $c->name }}</small></th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($dataAwal as $row)
                <tr>
                    <td>{{ $row['name'] }}</td>
                    @foreach($criterias as $c)
                    <td>{{ $row['values'][$c->id] }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- LANGKAH 2: MATRIKS NORMALISASI [R] -->
    <div class="section">
        <div class="section-title">LANGKAH 2: MATRIKS NORMALISASI [R]</div>
        <p style="margin-bottom: 10px; font-size: 11px;">Membagi nilai skala dengan Max (Benefit) atau Min (Cost).</p>
        <table>
            <thead>
                <tr>
                    <th>Alternatif</th>
                    @foreach($criterias as $c)
                    <th>
                        {{ $c->code }}
                        <span class="badge {{ $c->attribute == 'benefit' ? 'badge-success' : 'badge-danger' }}">
                            {{ $c->attribute == 'benefit' ? 'Max' : 'Min' }}
                        </span>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($normalisasi as $row)
                <tr>
                    <td>{{ $row['name'] }}</td>
                    @foreach($criterias as $c)
                    <td>{{ number_format($row['values'][$c->id], 4) }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- DETAIL KRITERIA -->
    <div class="section">
        <div class="section-title">DETAIL KRITERIA &amp; BOBOT</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">Kode</th>
                    <th style="width: 35%;">Nama Kriteria</th>
                    <th style="width: 15%;">Atribut</th>
                    <th style="width: 15%;">Bobot</th>
                    <th style="width: 25%;">Kolom Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($criterias as $c)
                <tr>
                    <td style="font-weight: bold;">{{ $c->code }}</td>
                    <td>{{ $c->name }}</td>
                    <td>
                        <span class="badge {{ $c->attribute == 'benefit' ? 'badge-success' : 'badge-danger' }}">
                            {{ strtoupper($c->attribute) }}
                        </span>
                    </td>
                    <td style="font-weight: bold;">{{ $c->weight }}</td>
                    <td>{{ $c->column_ref }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} HealthyLife SPK - Sistem Pendukung Keputusan Minuman Sehat</p>
        <p>Laporan ini dibuat secara otomatis menggunakan metode SAW (Simple Additive Weighting)</p>
    </div>
</body>
</html>
