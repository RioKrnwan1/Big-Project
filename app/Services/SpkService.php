<?php

namespace App\Services;

use App\Models\Drink;
use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Support\Collection;

/**
 * SPK Service - Handles SAW (Simple Additive Weighting) Algorithm
 * 
 * This service implements the SAW method for decision support system:
 * 1. Convert raw values to scale (1-5)
 * 2. Normalize values (0-1)
 * 3. Calculate weighted scores
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
        $drinks = Drink::all();
        $criterias = Criteria::all();

        // Step 1: Convert to scale (Matrix X)
        $dataAwal = $this->convertToScale($drinks, $criterias);

        // Step 2: Find min/max for normalization
        $minMax = $this->findMinMax($dataAwal, $criterias);

        // Step 3: Calculate normalization (Matrix R) and final scores (V)
        [$normalisasi, $hasilAkhir] = $this->calculateScores($dataAwal, $criterias, $minMax);

        // Sort by score descending
        usort($hasilAkhir, fn($a, $b) => $b['score'] <=> $a['score']);

        return [
            'data_awal' => $dataAwal,
            'normalisasi' => $normalisasi,
            'hasil_akhir' => $hasilAkhir,
        ];
    }

    /**
     * Convert raw drink values to 1-5 scale based on sub-criteria ranges
     *
     * @param Collection $drinks
     * @param Collection $criterias
     * @return array
     */
    protected function convertToScale(Collection $drinks, Collection $criterias): array
    {
        $dataAwal = [];

        foreach ($drinks as $drink) {
            $rowSkala = [];

            foreach ($criterias as $criteria) {
                $columnRef = $criteria->column_ref;
                $rawValue = $drink->$columnRef;

                // Find matching sub-criteria range
                $subCriteria = SubCriteria::where('criteria_id', $criteria->id)
                    ->where('range_min', '<=', $rawValue)
                    ->where('range_max', '>=', $rawValue)
                    ->first();

                // Default to 1 if no range found
                $nilaiSkala = $subCriteria ? $subCriteria->value : 1;
                $rowSkala[$criteria->id] = $nilaiSkala;
            }

            $dataAwal[] = [
                'name' => $drink->name,
                'values' => $rowSkala,
            ];
        }

        return $dataAwal;
    }

    /**
     * Find min/max values for each criteria for normalization
     *
     * @param array $dataAwal
     * @param Collection $criterias
     * @return array
     */
    protected function findMinMax(array $dataAwal, Collection $criterias): array
    {
        $minMax = [];

        foreach ($criterias as $criteria) {
            $columnValues = array_column(array_column($dataAwal, 'values'), $criteria->id);

            if (empty($columnValues)) {
                $minMax[$criteria->id] = 0;
                continue;
            }

            // For benefit: use max; for cost: use min
            if ($criteria->attribute === Criteria::ATTRIBUTE_BENEFIT) {
                $minMax[$criteria->id] = max($columnValues);
            } else {
                $minMax[$criteria->id] = min($columnValues);
            }
        }

        return $minMax;
    }

    /**
     * Calculate normalization matrix (R) and final scores (V)
     *
     * @param array $dataAwal
     * @param Collection $criterias
     * @param array $minMax
     * @return array [normalisasi, hasilAkhir]
     */
    protected function calculateScores(array $dataAwal, Collection $criterias, array $minMax): array
    {
        $normalisasi = [];
        $hasilAkhir = [];

        foreach ($dataAwal as $item) {
            $totalScore = 0;
            $rowNorm = [];

            foreach ($criterias as $criteria) {
                $nilaiSkala = $item['values'][$criteria->id];
                $pembagi = $minMax[$criteria->id];

                // SAW normalization formula
                if ($criteria->attribute === Criteria::ATTRIBUTE_BENEFIT) {
                    // For benefit: r = x / max
                    $r = ($pembagi == 0) ? 0 : ($nilaiSkala / $pembagi);
                } else {
                    // For cost: r = min / x
                    $r = ($nilaiSkala == 0) ? 0 : ($pembagi / $nilaiSkala);
                }

                $rowNorm[$criteria->id] = $r;
                
                // Calculate weighted score
                $totalScore += $r * $criteria->weight;
            }

            // Store normalization matrix
            $normalisasi[] = [
                'name' => $item['name'],
                'values' => $rowNorm,
            ];

            // Store final scores
            $hasilAkhir[] = [
                'name' => $item['name'],
                'score' => $totalScore,
            ];
        }

        return [$normalisasi, $hasilAkhir];
    }
}
