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
    Schema::create('pertemuan_kuliahs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('rps_id');
        $table->integer('minggu_ke');
        $table->string('materi');
        $table->string('metode');
        $table->string('tugas')->nullable();
        $table->integer('bobot_penilaian'); // Persentase bobot nilai per minggu
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertemuan_kuliahs');
    }
};
