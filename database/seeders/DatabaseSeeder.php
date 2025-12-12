<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run() {
        // 1. User Admin
        DB::table('users')->insert(['name'=>'Admin','email'=>'admin@spk.com','password'=>Hash::make('123')]);

        // 2. Kriteria
        $criterias = [
            ['id'=>1, 'code'=>'C1', 'name'=>'Gula', 'attribute'=>'cost', 'weight'=>0.35, 'column_ref'=>'sugar'],
            ['id'=>2, 'code'=>'C2', 'name'=>'Energi', 'attribute'=>'cost', 'weight'=>0.20, 'column_ref'=>'calories'],
            ['id'=>3, 'code'=>'C3', 'name'=>'Lemak', 'attribute'=>'cost', 'weight'=>0.15, 'column_ref'=>'fat'],
            ['id'=>4, 'code'=>'C4', 'name'=>'Protein', 'attribute'=>'benefit', 'weight'=>0.20, 'column_ref'=>'protein'],
            ['id'=>5, 'code'=>'C5', 'name'=>'Karbo', 'attribute'=>'cost', 'weight'=>0.10, 'column_ref'=>'carbs'],
        ];
        DB::table('criterias')->insert($criterias);

        // 3. Range Nilai LENGKAP (1-5)
        $subs = [];
        
        // --- PROTEIN (Benefit: Makin Tinggi Makin Bagus) ---
        // Range sengaja dibuat rapat untuk contoh
        $subs[] = ['criteria_id'=>4, 'range_min'=>0, 'range_max'=>1, 'value'=>1]; // Sangat Buruk
        $subs[] = ['criteria_id'=>4, 'range_min'=>1.1, 'range_max'=>3, 'value'=>2]; // Buruk
        $subs[] = ['criteria_id'=>4, 'range_min'=>3.1, 'range_max'=>5, 'value'=>3]; // Cukup
        $subs[] = ['criteria_id'=>4, 'range_min'=>5.1, 'range_max'=>8, 'value'=>4]; // Baik
        $subs[] = ['criteria_id'=>4, 'range_min'=>8.1, 'range_max'=>100, 'value'=>5]; // Sangat Baik

        // --- GULA (Cost: Makin Rendah Makin Bagus) ---
        $subs[] = ['criteria_id'=>1, 'range_min'=>0, 'range_max'=>5, 'value'=>5]; // Sangat Baik
        $subs[] = ['criteria_id'=>1, 'range_min'=>5.1, 'range_max'=>10, 'value'=>4]; // Baik
        $subs[] = ['criteria_id'=>1, 'range_min'=>10.1, 'range_max'=>15, 'value'=>3]; // Cukup
        $subs[] = ['criteria_id'=>1, 'range_min'=>15.1, 'range_max'=>25, 'value'=>2]; // Buruk
        $subs[] = ['criteria_id'=>1, 'range_min'=>25.1, 'range_max'=>500, 'value'=>1]; // Sangat Buruk

        // --- ENERGI (Cost) ---
        $subs[] = ['criteria_id'=>2, 'range_min'=>0, 'range_max'=>50, 'value'=>5];
        $subs[] = ['criteria_id'=>2, 'range_min'=>50.1, 'range_max'=>100, 'value'=>4];
        $subs[] = ['criteria_id'=>2, 'range_min'=>100.1, 'range_max'=>150, 'value'=>3];
        $subs[] = ['criteria_id'=>2, 'range_min'=>150.1, 'range_max'=>200, 'value'=>2];
        $subs[] = ['criteria_id'=>2, 'range_min'=>200.1, 'range_max'=>1000, 'value'=>1];

        // --- LEMAK (Cost) ---
        $subs[] = ['criteria_id'=>3, 'range_min'=>0, 'range_max'=>1, 'value'=>5];
        $subs[] = ['criteria_id'=>3, 'range_min'=>1.1, 'range_max'=>3, 'value'=>4];
        $subs[] = ['criteria_id'=>3, 'range_min'=>3.1, 'range_max'=>5, 'value'=>3];
        $subs[] = ['criteria_id'=>3, 'range_min'=>5.1, 'range_max'=>10, 'value'=>2];
        $subs[] = ['criteria_id'=>3, 'range_min'=>10.1, 'range_max'=>100, 'value'=>1];

        // --- KARBO (Cost) ---
        $subs[] = ['criteria_id'=>5, 'range_min'=>0, 'range_max'=>10, 'value'=>5];
        $subs[] = ['criteria_id'=>5, 'range_min'=>10.1, 'range_max'=>20, 'value'=>4];
        $subs[] = ['criteria_id'=>5, 'range_min'=>20.1, 'range_max'=>30, 'value'=>3];
        $subs[] = ['criteria_id'=>5, 'range_min'=>30.1, 'range_max'=>40, 'value'=>2];
        $subs[] = ['criteria_id'=>5, 'range_min'=>40.1, 'range_max'=>500, 'value'=>1];

        DB::table('sub_criterias')->insert($subs);

        // 4. Minuman (Tetap sama)
        $drinks = [
            ['name'=>'Nescafe Latte', 'sugar'=>18, 'calories'=>130, 'fat'=>3.5, 'protein'=>4, 'carbs'=>22],
            ['name'=>'Sprite Zero', 'sugar'=>0, 'calories'=>0, 'fat'=>0, 'protein'=>0, 'carbs'=>0],
            ['name'=>'Bear Brand', 'sugar'=>9, 'calories'=>120, 'fat'=>7, 'protein'=>6, 'carbs'=>9],
            ['name'=>'Coca Cola', 'sugar'=>39, 'calories'=>140, 'fat'=>0, 'protein'=>0, 'carbs'=>39],
            ['name'=>'Teh Pucuk', 'sugar'=>18, 'calories'=>70, 'fat'=>0, 'protein'=>0, 'carbs'=>18],
            ['name'=>'Ultra Milk', 'sugar'=>18, 'calories'=>160, 'fat'=>4, 'protein'=>8, 'carbs'=>20],
            ['name'=>'Good Day', 'sugar'=>20, 'calories'=>110, 'fat'=>2, 'protein'=>1, 'carbs'=>18],
            ['name'=>'Floridina', 'sugar'=>25, 'calories'=>100, 'fat'=>0, 'protein'=>0, 'carbs'=>25],
            ['name'=>'Mizone', 'sugar'=>10, 'calories'=>40, 'fat'=>0, 'protein'=>0, 'carbs'=>10],
            ['name'=>'Yakult', 'sugar'=>10, 'calories'=>50, 'fat'=>0, 'protein'=>1, 'carbs'=>11],
            ['name'=>'Cimory', 'sugar'=>14, 'calories'=>120, 'fat'=>3, 'protein'=>4, 'carbs'=>16],
            ['name'=>'Teh Kotak', 'sugar'=>19, 'calories'=>80, 'fat'=>0, 'protein'=>0, 'carbs'=>19],
            ['name'=>'Golda', 'sugar'=>18, 'calories'=>100, 'fat'=>2, 'protein'=>1, 'carbs'=>17],
            ['name'=>'Kopiko', 'sugar'=>22, 'calories'=>140, 'fat'=>4, 'protein'=>3, 'carbs'=>24],
            ['name'=>'Aqua Rasa', 'sugar'=>15, 'calories'=>60, 'fat'=>0, 'protein'=>0, 'carbs'=>15],
        ];
        DB::table('drinks')->insert($drinks);
    }
}