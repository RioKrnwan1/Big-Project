<?php

namespace App\Services;

use App\Models\Drink;
use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Support\Collection;

class SpkService
{
    /// Menjalankan seluruh proses SPK dengan metode SAW
    public function calculate(): array
    {
        $minuman = Drink::all();
        $kriteria = Criteria::all();

        //Matriks X
        $dataAwal = $this->konversiKeSkala($minuman, $kriteria);

        // min max
        $minMax = $this->cariMinMax($dataAwal, $kriteria);

        // normalisasi (Matriks R) dan skor akhir (V)
        [$normalisasi, $hasilAkhir] = $this->hitungSkor($dataAwal, $kriteria, $minMax);

        usort($hasilAkhir, fn($a, $b) => $b['score'] <=> $a['score']);

        $hasilAkhir = array_slice($hasilAkhir, 0, 5);

        return [
            'data_awal' => $dataAwal,
            'normalisasi' => $normalisasi,
            'hasil_akhir' => $hasilAkhir,
        ];
    }

    //Hitung SPK dengan filter kriteria tertentu
    public function calculateWithFilter(array $criteriaIds): array
    {
        $minuman = Drink::all();
        $kriteria = Criteria::whereIn('id', $criteriaIds)->get();

        //Matriks X (hanya dengan kriteria terpilih)
        $dataAwal = $this->konversiKeSkala($minuman, $kriteria);

        //min max
        $minMax = $this->cariMinMax($dataAwal, $kriteria);

        //normalisasi (Matriks R) dan skor akhir (V)
        [$normalisasi, $hasilAkhir] = $this->hitungSkor($dataAwal, $kriteria, $minMax);

        usort($hasilAkhir, fn($a, $b) => $b['score'] <=> $a['score']);

        $hasilAkhir = array_slice($hasilAkhir, 0, 5);

        return [
            'data_awal' => $dataAwal,
            'normalisasi' => $normalisasi,
            'hasil_akhir' => $hasilAkhir,
        ];
    }

    // konversi nilai mentah ke skala 1-5 berdasarkan range subkriteria
    protected function konversiKeSkala(Collection $minuman, Collection $kriteria): array
    {
        $hasil = [];

        foreach ($minuman as $item) {
            $skorPerKriteria = [];

            foreach ($kriteria as $k) {
                $nilaiAsli = $item->{$k->column_ref};

                // Cari subkriteria yang range-nya cocok
                $subKriteria = SubCriteria::where('criteria_id', $k->id)
                    ->where('range_min', '<=', $nilaiAsli)
                    ->where('range_max', '>=', $nilaiAsli)
                    ->first();

                // Skor default 1 jika tidak ada range yang cocok
                $skorPerKriteria[$k->id] = $subKriteria ? $subKriteria->value : 1;
            }

            $hasil[] = [
                'name' => $item->name,
                'values' => $skorPerKriteria,
            ];
        }

        return $hasil;
    }

    // cari nilai min atau max sebagai patokan normalisasi
    protected function cariMinMax(array $dataAwal, Collection $kriteria): array
    {
        $hasil = [];

        foreach ($kriteria as $k) {
            $semuaNilai = array_column(array_column($dataAwal, 'values'), $k->id);

            if (empty($semuaNilai)) {
                $hasil[$k->id] = 0;
                continue;
            }

            // Benefit gunakan max, Cost gunakan min
            $hasil[$k->id] = ($k->attribute === 'benefit') 
                ? max($semuaNilai) 
                : min($semuaNilai);
        }

        return $hasil;
    }

    //normalisasi dan menghitung skor akhir
    protected function hitungSkor(array $dataAwal, Collection $kriteria, array $minMax): array
    {
        $normalisasi = [];
        $hasilAkhir = [];

        foreach ($dataAwal as $item) {
            $totalSkor = 0;
            $nilaiNormalisasi = [];

            foreach ($kriteria as $k) {
                $skor = $item['values'][$k->id];
                $pembagi = $minMax[$k->id];

                // Hitung nilai ternormalisasi
                if ($k->attribute === 'benefit') {
                    $r = ($pembagi == 0) ? 0 : ($skor / $pembagi); //Semakin besar skor → semakin bagus
                } else {
                    $r = ($skor == 0) ? 0 : ($pembagi / $skor); //Semakin kecil skor → semakin bagus
                }

                $nilaiNormalisasi[$k->id] = $r;
                $totalSkor += $r * $k->weight;
            }

            $normalisasi[] = [
                'name' => $item['name'],
                'values' => $nilaiNormalisasi,
            ];

            $hasilAkhir[] = [
                'name' => $item['name'],
                'score' => $totalSkor,
            ];
        }

        return [$normalisasi, $hasilAkhir];
    }
}
