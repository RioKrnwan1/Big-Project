<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Drink;
use App\Services\SpkService;
use Illuminate\Http\Request;

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

            return view('spk.index', compact('hasilAkhir', 'normalisasi', 'dataAwal', 'criterias'));
        } catch (\Exception $e) {
            \Log::error('SPK Calculation Error: ' . $e->getMessage());
            
            return redirect()->route('drinks.index')
                ->with('error', 'Terjadi kesalahan saat menghitung SPK: ' . $e->getMessage());
        }
    }

    //Export hasil SPK ke PDF
    public function exportPDF()
    {
        try {
            //Ambil perhitungan saat ini
            $result = $this->spkService->calculate();
            
            $hasilAkhir = $result['hasil_akhir'];
            $normalisasi = $result['normalisasi'];
            $dataAwal = $result['data_awal'];
            $criterias = Criteria::all();

            //Generate PDF
            $pdf = \PDF::loadView('spk.pdf', compact('hasilAkhir', 'normalisasi', 'dataAwal', 'criterias'));
            
            //Filename dengan timestamp
            $filename = 'SPK_Laporan_' . date('Y-m-d_His') . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('Error exporting SPK to PDF: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat mengekspor ke PDF: ' . $e->getMessage());
        }
    }

    //Hitung ulang SPK dengan filter kriteria tertentu
    public function recalculate(Request $request)
    {
        try {
            //Ambil kriteria yang dipilih dari request
            $selectedCriteriaIds = $request->input('criteria_ids', []);
            
            //Jika tidak ada yang dipilih, gunakan semua kriteria
            if (empty($selectedCriteriaIds)) {
                return redirect()->route('spk.index');
            }

            //Hitung dengan kriteria terpilih saja
            $result = $this->spkService->calculateWithFilter($selectedCriteriaIds);
            
            $hasilAkhir = $result['hasil_akhir'];
            $normalisasi = $result['normalisasi'];
            $dataAwal = $result['data_awal'];
            $criterias = Criteria::whereIn('id', $selectedCriteriaIds)->get();
            $allCriterias = Criteria::all();

            return view('spk.index', compact('hasilAkhir', 'normalisasi', 'dataAwal', 'criterias', 'allCriterias'))
                ->with('filtered', true);

        } catch (\Exception $e) {
            \Log::error('Error recalculating SPK: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat menghitung ulang: ' . $e->getMessage());
        }
    }

    //Export hasil SPK ke Excel
    public function exportExcel()
    {
        try {
            //Ambil perhitungan saat ini
            $result = $this->spkService->calculate();
            
            $hasilAkhir = $result['hasil_akhir'];
            $normalisasi = $result['normalisasi'];
            $dataAwal = $result['data_awal'];
            $criterias = Criteria::all();

            //Data untuk export
            $data = [
                'hasil_akhir' => $hasilAkhir,
                'normalisasi' => $normalisasi,
                'data_awal' => $dataAwal,
                'criterias' => $criterias,
            ];

            //Generate filename dengan timestamp
            $filename = 'SPK_Hasil_' . date('Y-m-d_His') . '.xlsx';

            //Download Excel
            return \Excel::download(new \App\Exports\SpkExport($data), $filename);

        } catch (\Exception $e) {
            \Log::error('Error exporting SPK to Excel: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat mengekspor ke Excel: ' . $e->getMessage());
        }
    }
}