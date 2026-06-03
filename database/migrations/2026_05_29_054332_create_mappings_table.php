<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mappings', function (Blueprint $blueprint) {
            $blueprint->id();
            
            // Menggunakan foreignId agar tipe data otomatis BigInteger (Sinkron dengan tabel induk)
            $blueprint->foreignId('cpl_id')
                      ->constrained('cpls')
                      ->onDelete('cascade'); // Jika CPL dihapus, data mapping otomatis dibersihkan
            
            $blueprint->foreignId('cpmk_id')
                      ->constrained('cpmks')
                      ->onDelete('cascade'); // Jika CPMK dihapus, data mapping otomatis dibersihkan

            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mappings');
    }
};