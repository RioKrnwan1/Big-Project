<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spk_results', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama/judul hasil
            $table->text('notes')->nullable(); // Catatan
            $table->json('result_data'); // Snapshot hasil perhitungan (JSON)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spk_results');
    }
};
