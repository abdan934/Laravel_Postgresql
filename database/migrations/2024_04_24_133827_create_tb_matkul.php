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
        Schema::create('tb_matkul', function (Blueprint $table) {
            $table->uuid("id_matkul")->primary();
            $table->string("kode_matkul")->unique();
            $table->uuid('id_jurusan');
            $table->foreign('id_jurusan')->references('id_jurusan')->on('tb_jurusan');
            $table->string('nama_matkul_ind');
            $table->string('nama_matkul_eng');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_matkul');
    }
};