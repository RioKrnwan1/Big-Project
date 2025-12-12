<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tabel User (Admin)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // Tabel Minuman (Alternatif)
        Schema::create('drinks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('sugar');    // C1
            $table->float('calories'); // C2
            $table->float('fat');      // C3
            $table->float('protein');  // C4
            $table->float('carbs');    // C5
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // Tabel Kriteria
        Schema::create('criterias', function (Blueprint $table) {
            $table->id();
            $table->string('code');       // C1
            $table->string('name');       // Gula
            $table->string('attribute');  // cost/benefit
            $table->float('weight');      // Bobot
            $table->string('column_ref'); // Nama kolom di tabel drinks
            $table->timestamps();
        });

        // Tabel Sub Kriteria (Range Nilai)
        Schema::create('sub_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')->constrained('criterias')->onDelete('cascade');
            $table->float('range_min');
            $table->float('range_max');
            $table->integer('value');   // Nilai Skala 1-5
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_criterias');
        Schema::dropIfExists('criterias');
        Schema::dropIfExists('drinks');
        Schema::dropIfExists('users');
    }
};