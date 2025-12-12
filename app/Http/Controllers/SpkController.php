<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Http\Request;

class SpkController extends Controller
{
    public function index()
    {
        $drinks = Drink::all();
        $criterias = Criteria::all();

        // Variabel Penampung
        $data_awal = [];      // MATRIKS X (Skala 1-5) -> INI YANG KITA TAMBAHKAN
        $normalisasi = [];    // MATRIKS R (0-1)
        $hasil_akhir = [];    // NILAI V (Skor)

        // --- STEP 1: KONVERSI DATA ASLI KE SKALA 1-5 (MATRIKS X) ---
        foreach ($drinks as $d) {
            $row_skala = []; // Baris untuk Matriks X
            
            foreach ($criterias as $c) {
                $col = $c->column_ref;
                $val_asli = $d->$col;

                // Cari di database Range
                $sub = SubCriteria::where('criteria_id', $c->id)
                        ->where('range_min', '<=', $val_asli)
                        ->where('range_max', '>=', $val_asli)
                        ->first();
                
                $nilai_skala = $sub ? $sub->value : 1;
                $row_skala[$c->id] = $nilai_skala;
            }

            // Simpan ke array Data Awal (Matrix X)
            $data_awal[] = [
                'name' => $d->name,
                'values' => $row_skala
            ];
        }

        // --- STEP 2: CARI MAX/MIN UTK RUMUS ---
        $min_max = [];
        foreach ($criterias as $c) {
            // Ambil semua angka di kolom kriteria ini dari data_awal
            $col_values = array_column(array_column($data_awal, 'values'), $c->id);
            
            if ($c->attribute == 'benefit') {
                $min_max[$c->id] = max($col_values);
            } else {
                $min_max[$c->id] = min($col_values);
            }
        }

        // --- STEP 3: HITUNG NORMALISASI (MATRIKS R) & SKOR AKHIR (V) ---
        foreach ($data_awal as $idx => $item) {
            $total_score = 0;
            $row_norm = [];

            foreach ($criterias as $c) {
                $nilai_skala = $item['values'][$c->id];
                $pembagi = $min_max[$c->id];

                // Rumus SAW
                if ($c->attribute == 'benefit') {
                    $r = ($pembagi == 0) ? 0 : ($nilai_skala / $pembagi);
                } else {
                    $r = ($nilai_skala == 0) ? 0 : ($pembagi / $nilai_skala);
                }

                $row_norm[$c->id] = $r; 
                $total_score += $r * $c->weight;
            }

            // Simpan ke array Normalisasi (Matrix R)
            $normalisasi[] = [
                'name' => $item['name'],
                'values' => $row_norm
            ];

            // Simpan Hasil Akhir
            $hasil_akhir[] = [
                'name' => $item['name'],
                'score' => $total_score
            ];
        }

        // Sorting Juara
        usort($hasil_akhir, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // Kirim $data_awal, $normalisasi, $hasil_akhir ke View
        return view('spk.index', compact('hasil_akhir', 'normalisasi', 'data_awal', 'criterias'));
    }
}