<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Drink;
use App\Models\SpkResult;
use App\Services\SpkService;
use App\Http\Requests\SpkResultRequest;

/**
 * SPK Controller - Displays decision support system results and manages saved results
 */
class SpkController extends Controller
{
    protected $spkService;

    public function __construct(SpkService $spkService)
    {
        $this->spkService = $spkService;
    }

    /**
     * Display SPK calculation results and saved results list
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
            
            // Get saved results
            $savedResults = SpkResult::latest()->get();

            return view('spk.index', compact('hasilAkhir', 'normalisasi', 'dataAwal', 'criterias', 'savedResults'));
        } catch (\Exception $e) {
            \Log::error('SPK Calculation Error: ' . $e->getMessage());
            
            return redirect()->route('drinks.index')
                ->with('error', 'Terjadi kesalahan saat menghitung SPK: ' . $e->getMessage());
        }
    }
    
    /**
     * Store current SPK calculation result
     */
    public function store(SpkResultRequest $request)
    {
        try {
            // Get current calculation
            $result = $this->spkService->calculate();
            
            // Save result
            SpkResult::create([
                'name' => $request->name,
                'notes' => $request->notes,
                'result_data' => $result
            ]);

            return redirect()->route('spk.index')
                ->with('success', 'Hasil SPK berhasil disimpan');
        } catch (\Exception $e) {
            \Log::error('Error saving SPK result: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan hasil');
        }
    }

    /**
     * Display the specified saved result
     */
    public function show($id)
    {
        try {
            $savedResult = SpkResult::findOrFail($id);
            $result = $savedResult->result_data;
            
            $hasilAkhir = $result['hasil_akhir'];
            $normalisasi = $result['normalisasi'];
            $dataAwal = $result['data_awal'];
            $criterias = Criteria::all();

            return view('spk.show', compact('savedResult', 'hasilAkhir', 'normalisasi', 'dataAwal', 'criterias'));
        } catch (\Exception $e) {
            return redirect()->route('spk.index')
                ->with('error', 'Hasil tersimpan tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified saved result
     */
    public function edit($id)
    {
        try {
            $savedResult = SpkResult::findOrFail($id);
            return view('spk.edit', compact('savedResult'));
        } catch (\Exception $e) {
            return redirect()->route('spk.index')
                ->with('error', 'Hasil tersimpan tidak ditemukan');
        }
    }

    /**
     * Update the specified saved result
     */
    public function update(SpkResultRequest $request, $id)
    {
        try {
            $savedResult = SpkResult::findOrFail($id);
            $savedResult->update([
                'name' => $request->name,
                'notes' => $request->notes
            ]);

            return redirect()->route('spk.index')
                ->with('success', 'Hasil SPK berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Error updating SPK result: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui hasil');
        }
    }

    /**
     * Remove the specified saved result
     */
    public function destroy($id)
    {
        try {
            $savedResult = SpkResult::findOrFail($id);
            $savedResult->delete();

            return redirect()->back()
                ->with('success', 'Hasil tersimpan berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting SPK result: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus hasil');
        }
    }
}