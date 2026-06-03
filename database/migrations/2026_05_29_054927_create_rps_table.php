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
    Schema::create('rps', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('mata_kuliah_id');
        $table->string('dosen_pengembang');
        $table->string('tahun_akademik');
        $table->string('status')->default('Draft'); // Draft, Review, Disetujui
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rps');
    }
};
