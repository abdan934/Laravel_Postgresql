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
        Schema::create('tb_dosen', function (Blueprint $table) {
            $table->uuid("id_dosen")->primary();
            $table->string('nidn');
            $table->string('nip');
            $table->uuid('id_prodi');
            $table->foreign('id_prodi')->references('id_prodi')->on('tb_prodi');
            $table->uuid('id_jurusan');
            $table->foreign('id_jurusan')->references('id_jurusan')->on('tb_jurusan');
            $table->string('name_dosen');
            $table->string('email_dosen');
            $table->string('no_hp_dosen');
            $table->string('jk_dosen');
            $table->string('alamat_dosen');
            $table->boolean('status_dosen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_dosen');
    }
};