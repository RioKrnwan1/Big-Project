<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SpkExport implements WithMultipleSheets
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new RankingSheet($this->data['hasil_akhir']),
            new MatriksKeputusanSheet($this->data['data_awal'], $this->data['criterias']),
            new MatriksNormalisasiSheet($this->data['normalisasi'], $this->data['criterias']),
            new DetailKriteriaSheet($this->data['criterias']),
        ];
    }
}

//Sheet 1: Ranking Top 5
class RankingSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $hasilAkhir;

    public function __construct($hasilAkhir)
    {
        $this->hasilAkhir = $hasilAkhir;
    }

    public function collection()
    {
        return collect($this->hasilAkhir)->map(function($item, $index) {
            return [
                'ranking' => $index + 1,
                'nama_minuman' => $item['name'],
                'skor' => round($item['score'], 4),
            ];
        });
    }

    public function headings(): array
    {
        return ['Ranking', 'Nama Minuman', 'Skor Akhir'];
    }

    public function title(): string
    {
        return 'Top 5 Minuman Terbaik';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}

//Sheet 2: Matriks Keputusan [X]
class MatriksKeputusanSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $dataAwal;
    protected $criterias;

    public function __construct($dataAwal, $criterias)
    {
        $this->dataAwal = $dataAwal;
        $this->criterias = $criterias;
    }

    public function collection()
    {
        return collect($this->dataAwal)->map(function($item) {
            $row = ['nama_minuman' => $item['name']];
            foreach ($this->criterias as $kriteria) {
                $row[$kriteria->code] = $item['values'][$kriteria->id] ?? '-';
            }
            return $row;
        });
    }

    public function headings(): array
    {
        $headers = ['Nama Minuman'];
        foreach ($this->criterias as $kriteria) {
            $headers[] = $kriteria->code . ' (' . $kriteria->name . ')';
        }
        return $headers;
    }

    public function title(): string
    {
        return 'Matriks Keputusan [X]';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}

//Sheet 3: Matriks Normalisasi [R]
class MatriksNormalisasiSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $normalisasi;
    protected $criterias;

    public function __construct($normalisasi, $criterias)
    {
        $this->normalisasi = $normalisasi;
        $this->criterias = $criterias;
    }

    public function collection()
    {
        return collect($this->normalisasi)->map(function($item) {
            $row = ['nama_minuman' => $item['name']];
            foreach ($this->criterias as $kriteria) {
                $row[$kriteria->code] = round($item['values'][$kriteria->id] ?? 0, 4);
            }
            return $row;
        });
    }

    public function headings(): array
    {
        $headers = ['Nama Minuman'];
        foreach ($this->criterias as $kriteria) {
            $headers[] = $kriteria->code . ' (' . $kriteria->name . ')';
        }
        return $headers;
    }

    public function title(): string
    {
        return 'Matriks Normalisasi [R]';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}

//Sheet 4: Detail Kriteria
class DetailKriteriaSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $criterias;

    public function __construct($criterias)
    {
        $this->criterias = $criterias;
    }

    public function collection()
    {
        return $this->criterias->map(function($kriteria) {
            return [
                'kode' => $kriteria->code,
                'nama' => $kriteria->name,
                'atribut' => strtoupper($kriteria->attribute),
                'bobot' => $kriteria->weight,
                'kolom_referensi' => $kriteria->column_ref,
            ];
        });
    }

    public function headings(): array
    {
        return ['Kode', 'Nama Kriteria', 'Atribut', 'Bobot', 'Kolom Referensi'];
    }

    public function title(): string
    {
        return 'Detail Kriteria';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
