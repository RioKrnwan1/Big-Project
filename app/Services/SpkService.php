<?php

namespace App\Services;

use App\Models\Drink;
use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Support\Collection;

/**
 * SPK Service - Simple Additive Weighting (SAW) Implementation
 * 
 * Implements SAW algorithm for multi-criteria decision making:
 * 1. Convert raw values to scaled scores (1-5)
 * 2. Normalize scores (0-1)
 * 3. Calculate weighted sum
 */
class SpkService
{
    /**
     * Calculate SPK results using SAW method
     *
     * @return array{data_awal: array, normalisasi: array, hasil_akhir: array}
     */
    public function calculate(): array
    {
        $minuman = Drink::all();
        $kriteria = Criteria::all();

        // Step 1: Convert to scale (Matrix X)
        $dataAwal = $this->konversiKeSkala($minuman, $kriteria);

        // Step 2: Find min/max for normalization
        $minMax = $this->cariMinMax($dataAwal, $kriteria);

        // Step 3: Calculate normalization (Matrix R) and final scores (V)
        [$normalisasi, $hasilAkhir] = $this->hitungSkor($dataAwal, $kriteria, $minMax);

        // Sort by score descending
        usort($hasilAkhir, fn($a, $b) => $b['score'] <=> $a['score']);

        // Limit hasil akhir to top 5 only (as requested by lecturer)
        $hasilAkhir = array_slice($hasilAkhir, 0, 5);

        return [
            'data_awal' => $dataAwal,
            'normalisasi' => $normalisasi,
            'hasil_akhir' => $hasilAkhir,
        ];
    }

    /**
     * Convert raw values to scale 1-5 based on subcriteria ranges
     */
    protected function konversiKeSkala(Collection $minuman, Collection $kriteria): array
    {
        $hasil = [];

        foreach ($minuman as $item) {
            $skorPerKriteria = [];

            foreach ($kriteria as $k) {
                $nilaiAsli = $item->{$k->column_ref};

                // Find matching subcriteria range
                $subKriteria = SubCriteria::where('criteria_id', $k->id)
                    ->where('range_min', '<=', $nilaiAsli)
                    ->where('range_max', '>=', $nilaiAsli)
                    ->first();

                // Default score is 1 if no range matches
                $skorPerKriteria[$k->id] = $subKriteria ? $subKriteria->value : 1;
            }

            $hasil[] = [
                'name' => $item->name,
                'values' => $skorPerKriteria,
            ];
        }

        return $hasil;
    }

    /**
     * Find min/max values for each criteria
     */
    protected function cariMinMax(array $dataAwal, Collection $kriteria): array
    {
        $hasil = [];

        foreach ($kriteria as $k) {
            $semuaNilai = array_column(array_column($dataAwal, 'values'), $k->id);

            if (empty($semuaNilai)) {
                $hasil[$k->id] = 0;
                continue;
            }

            // Benefit uses max, Cost uses min
            $hasil[$k->id] = ($k->attribute === 'benefit') 
                ? max($semuaNilai) 
                : min($semuaNilai);
        }

        return $hasil;
    }

    /**
     * Calculate normalization and final scores
     * 
     * SAW normalization formulas:
     * - Benefit: r = x / max
     * - Cost: r = min / x
     */
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

                // Calculate normalized value
                if ($k->attribute === 'benefit') {
                    $r = ($pembagi == 0) ? 0 : ($skor / $pembagi);
                } else {
                    $r = ($skor == 0) ? 0 : ($pembagi / $skor);
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
