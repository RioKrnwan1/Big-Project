<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Drink;
use App\Models\SpkResult;
use App\Services\SpkService;
use App\Http\Requests\SpkResultRequest;

//SPK Controller - Menampilkan hasil sistem pendukung keputusan dan mengelola hasil tersimpan
class SpkController extends Controller
{
    protected $spkService;

    public function __construct(SpkService $spkService)
    {
        $this->spkService = $spkService;
    }

    //Tampilkan hasil perhitungan SPK dan daftar hasil tersimpan
    public function index()
    {
        try {
            // Cek apakah sudah ada data minimum yang dibutuhkan
            $criteriaCount = Criteria::count();
            $drinkCount = Drink::count();
            
            if ($criteriaCount === 0 || $drinkCount === 0) {
                return redirect()->route('drinks.index')
                    ->with('error', 'Data belum lengkap. Silakan tambahkan kriteria dan minuman terlebih dahulu.');
            }
            
            // Hitung menggunakan SPK Service
            $result = $this->spkService->calculate();
            
            $hasilAkhir = $result['hasil_akhir'];
            $normalisasi = $result['normalisasi'];
            $dataAwal = $result['data_awal'];
            $criterias = Criteria::all();
            
            // Ambil daftar hasil tersimpan
            $savedResults = SpkResult::latest()->get();

            return view('spk.index', compact('hasilAkhir', 'normalisasi', 'dataAwal', 'criterias', 'savedResults'));
        } catch (\Exception $e) {
            \Log::error('SPK Calculation Error: ' . $e->getMessage());
            
            return redirect()->route('drinks.index')
                ->with('error', 'Terjadi kesalahan saat menghitung SPK: ' . $e->getMessage());
        }
    }
    
    //Simpan hasil perhitungan SPK saat ini
    public function store(SpkResultRequest $request)
    {
        try {
            // Ambil perhitungan saat ini
            $result = $this->spkService->calculate();
            
            // Simpan hasil
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

    //Tampilkan detail hasil tersimpan yang dipilih
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

    //Tampilkan form untuk edit hasil tersimpan yang dipilih
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

    //Update hasil tersimpan yang dipilih
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

    //Hapus hasil tersimpan yang dipilih
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