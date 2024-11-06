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
        Schema::create('tb_mahasiswa', function (Blueprint $table) {
            $table->uuid("id_mhs")->primary();
            $table->string('npm');
            $table->uuid('id_prodi');
            $table->foreign('id_prodi')->references('id_prodi')->on('tb_prodi');
            $table->uuid('id_jurusan');
            $table->foreign('id_jurusan')->references('id_jurusan')->on('tb_jurusan');
            $table->string('name_mhs');
            $table->string('email_mhs');
            $table->string('no_hp');
            $table->string('jk_mhs');
            $table->string('tempat_tgl_lahir_mhs');
            $table->string('alamat_mhs');
            $table->boolean('status_mhs');
            $table->string('tahun_masuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_mahasiswa');
    }
};