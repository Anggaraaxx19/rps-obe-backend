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
    Schema::create('revisis', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('rps_id');
        $table->string('nama_matkul');
        $table->string('aktivitas');
        $table->string('aktor');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revisis');
    }
};
