<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\Criteria;
use App\Services\SpkService;

/**
 * Dashboard Controller - Displays analytics and statistics
 * Includes calculations for drink distribution and scoring metrics
 */
class DashboardController extends Controller
{
    protected $spkService;

    public function __construct(SpkService $spkService)
    {
        $this->spkService = $spkService;
    }

    /**
     * Display dashboard with statistical calculations
     */
    public function index()
    {
        try {
            // Get basic counts
            $totalMinuman = Drink::count();
            $totalKriteria = Criteria::count();
            
            // Calculate statistics only if we have data
            if ($totalMinuman > 0 && $totalKriteria > 0) {
                $result = $this->spkService->calculate();
                $hasilAkhir = $result['hasil_akhir'];
                
                // Calculate average score
                $rataRataSkor = $this->hitungRataRata($hasilAkhir);
                
                // Calculate score distribution
                $distribusi = $this->hitungDistribusi($hasilAkhir);
                
                // Get top 5 drinks
                $top5Minuman = array_slice($hasilAkhir, 0, 5);
                
                // Calculate percentage for each category
                $persentaseDistribusi = $this->hitungPersentase($distribusi, $totalMinuman);
                
                return view('dashboard.index', compact(
                    'totalMinuman',
                    'totalKriteria',
                    'rataRataSkor',
                    'distribusi',
                    'top5Minuman',
                    'persentaseDistribusi'
                ));
            }
            
            // Return dashboard with basic counts only
            return view('dashboard.index', compact('totalMinuman', 'totalKriteria'));
            
        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            
            return view('dashboard.index', [
                'totalMinuman' => 0,
                'totalKriteria' => 0,
                'error' => 'Terjadi kesalahan saat memuat dashboard'
            ]);
        }
    }
    
    /**
     * Calculate average score from results
     * 
     * @param array $hasilAkhir
     * @return float
     */
    protected function hitungRataRata(array $hasilAkhir): float
    {
        if (empty($hasilAkhir)) {
            return 0;
        }
        
        $totalSkor = array_sum(array_column($hasilAkhir, 'score'));
        $jumlahMinuman = count($hasilAkhir);
        
        return round($totalSkor / $jumlahMinuman, 2);
    }
    
    /**
     * Calculate score distribution by category
     * Categories: Excellent (>0.8), Good (0.6-0.8), Fair (0.4-0.6), Poor (<0.4)
     * 
     * @param array $hasilAkhir
     * @return array
     */
    protected function hitungDistribusi(array $hasilAkhir): array
    {
        $distribusi = [
            'excellent' => 0,
            'good' => 0,
            'fair' => 0,
            'poor' => 0
        ];
        
        foreach ($hasilAkhir as $item) {
            $skor = $item['score'];
            
            if ($skor > 0.8) {
                $distribusi['excellent']++;
            } elseif ($skor >= 0.6) {
                $distribusi['good']++;
            } elseif ($skor >= 0.4) {
                $distribusi['fair']++;
            } else {
                $distribusi['poor']++;
            }
        }
        
        return $distribusi;
    }
    
    /**
     * Calculate percentage for each distribution category
     * 
     * @param array $distribusi
     * @param int $total
     * @return array
     */
    protected function hitungPersentase(array $distribusi, int $total): array
    {
        if ($total == 0) {
            return [
                'excellent' => 0,
                'good' => 0,
                'fair' => 0,
                'poor' => 0
            ];
        }
        
        return [
            'excellent' => round(($distribusi['excellent'] / $total) * 100, 1),
            'good' => round(($distribusi['good'] / $total) * 100, 1),
            'fair' => round(($distribusi['fair'] / $total) * 100, 1),
            'poor' => round(($distribusi['poor'] / $total) * 100, 1)
        ];
    }
}
