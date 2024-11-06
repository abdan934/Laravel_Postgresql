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
        Schema::create('tb_nilai', function (Blueprint $table) {
            $table->uuid('id_nilai')->primary();
            $table->string('kode_mengajar');
            $table->foreign('kode_mengajar')->references('kode_mengajar')->on('tb_mengajar');
            $table->uuid('id_keterangan');
            $table->foreign('id_keterangan')->references('id_keterangan')->on('tb_keterangan');
            $table->string('npm');
            $table->string('kelas_nilai');
            $table->string('tahun_ajar_awal_nilai');
            $table->string('tahun_ajar_akhir_nilai');
            $table->string('semester_nilai');
            $table->string('sks');
            $table->string('angka_nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_nilai');
    }
};
