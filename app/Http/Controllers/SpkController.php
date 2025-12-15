<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Services\SpkService;
use Illuminate\Http\Request;

/**
 * SPK Controller - Displays decision support system results
 */
class SpkController extends Controller
{
    protected $spkService;

    public function __construct(SpkService $spkService)
    {
        $this->spkService = $spkService;
    }

    /**
     * Display SPK calculation results
     */
    public function index()
    {
        try {
            // Check if we have the minimum required data
            $criteriaCount = Criteria::count();
            $drinkCount = Drink::count();
            
            if ($criteriaCount === 0 || $drinkCount === 0) {
                return redirect()->route('drinks.index')
                    ->with('error', 'Data belum lengkap. Silakan tambahkan kriteria dan minuman terlebih dahulu.');
            }
            
            // Calculate using SPK Service
            $result = $this->spkService->calculate();
            
            $hasilAkhir = $result['hasil_akhir'];
            $normalisasi = $result['normalisasi'];
            $dataAwal = $result['data_awal'];
            $criterias = Criteria::all();

            return view('spk.index', compact('hasil_akhir', 'normalisasi', 'data_awal', 'criterias'));
        } catch (\Exception $e) {
            \Log::error('SPK Calculation Error: ' . $e->getMessage());
            
            return redirect()->route('drinks.index')
                ->with('error', 'Terjadi kesalahan saat menghitung SPK: ' . $e->getMessage());
        }
    }
}