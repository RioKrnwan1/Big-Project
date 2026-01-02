<?php

namespace App\Http\Controllers;

use App\Models\Comparison;
use App\Models\Drink;
use App\Http\Requests\ComparisonRequest;
use App\Services\SpkService;

/**
 * Comparison Controller - Manages drink comparisons with CRUD operations
 * Includes calculations for score differences and percentage comparisons
 */
class ComparisonController extends Controller
{
    protected $spkService;

    public function __construct(SpkService $spkService)
    {
        $this->spkService = $spkService;
    }

    /**
     * Display a listing of comparisons with calculations
     */
    public function index()
    {
        try {
            $comparisons = Comparison::latest()->get();
            
            // Calculate results for each comparison
            $comparisonResults = [];
            
            if ($comparisons->count() > 0) {
                $result = $this->spkService->calculate();
                $allScores = collect($result['hasil_akhir']);
                
                foreach ($comparisons as $comparison) {
                    $drinks = Drink::whereIn('id', $comparison->drink_ids)->get();
                    
                    if ($drinks->count() >= 2) {
                        $scores = $allScores->filter(function($item) use ($drinks) {
                            return $drinks->pluck('name')->contains($item['name']);
                        })->values();
                        
                        $comparisonResults[$comparison->id] = [
                            'drinks' => $drinks,
                            'scores' => $scores,
                            'data' => $this->calculateComparison($drinks, $scores)
                        ];
                    }
                }
            }
            
            return view('comparisons.index', compact('comparisons', 'comparisonResults'));
            
        } catch (\Exception $e) {
            \Log::error('Comparison index error: ' . $e->getMessage());
            return view('comparisons.index', [
                'comparisons' => collect(),
                'comparisonResults' => []
            ]);
        }
    }

    /**
     * Show the form for creating a new comparison
     */
    public function create()
    {
        $drinks = Drink::all();
        return view('comparisons.create', compact('drinks'));
    }

    /**
     * Store a newly created comparison
     */
    public function store(ComparisonRequest $request)
    {
        try {
            Comparison::create($request->validated());

            return redirect()->route('comparisons.index')
                ->with('success', 'Perbandingan berhasil dibuat');
        } catch (\Exception $e) {
            \Log::error('Error creating comparison: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat perbandingan');
        }
    }

    /**
     * Show the form for editing the specified comparison
     */
    public function edit($id)
    {
        try {
            $comparison = Comparison::findOrFail($id);
            $drinks = Drink::all();
            
            return view('comparisons.edit', compact('comparison', 'drinks'));
        } catch (\Exception $e) {
            return redirect()->route('comparisons.index')
                ->with('error', 'Perbandingan tidak ditemukan');
        }
    }

    /**
     * Update the specified comparison
     */
    public function update(ComparisonRequest $request, $id)
    {
        try {
            $comparison = Comparison::findOrFail($id);
            $comparison->update($request->validated());

            return redirect()->route('comparisons.index')
                ->with('success', 'Perbandingan berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Error updating comparison: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui perbandingan');
        }
    }

    /**
     * Remove the specified comparison
     */
    public function destroy($id)
    {
        try {
            $comparison = Comparison::findOrFail($id);
            $comparison->delete();

            return redirect()->back()
                ->with('success', 'Perbandingan berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting comparison: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus perbandingan');
        }
    }

    /**
     * Calculate comparison metrics between drinks
     * 
     * @param Collection $drinks
     * @param Collection $scores
     * @return array
     */
    protected function calculateComparison($drinks, $scores): array
    {
        $scoresArray = $scores->pluck('score', 'name')->toArray();
        
        // Calculate score differences
        $differences = $this->getScoreDifferences($scoresArray);
        
        // Calculate percentage differences
        $percentages = $this->getPercentageDifferences($scoresArray);
        
        // Find best and worst
        $best = $scores->sortByDesc('score')->first();
        $worst = $scores->sortBy('score')->first();
        
        return [
            'differences' => $differences,
            'percentages' => $percentages,
            'best' => $best,
            'worst' => $worst,
            'average' => round($scores->avg('score'), 4)
        ];
    }

    /**
     * Calculate absolute score differences between drinks
     * 
     * @param array $scores
     * @return array
     */
    protected function getScoreDifferences(array $scores): array
    {
        $differences = [];
        $names = array_keys($scores);
        
        for ($i = 0; $i < count($names); $i++) {
            for ($j = $i + 1; $j < count($names); $j++) {
                $name1 = $names[$i];
                $name2 = $names[$j];
                $diff = abs($scores[$name1] - $scores[$name2]);
                
                $differences[] = [
                    'drink1' => $name1,
                    'drink2' => $name2,
                    'difference' => round($diff, 4)
                ];
            }
        }
        
        return $differences;
    }

    /**
     * Calculate percentage differences from highest score
     * 
     * @param array $scores
     * @return array
     */
    protected function getPercentageDifferences(array $scores): array
    {
        $maxScore = max($scores);
        $percentages = [];
        
        if ($maxScore == 0) {
            return $percentages;
        }
        
        foreach ($scores as $name => $score) {
            $percentage = ($score / $maxScore) * 100;
            $percentages[$name] = round($percentage, 2);
        }
        
        return $percentages;
    }
}
