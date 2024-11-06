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
        Schema::create('tb_file_jadwal', function (Blueprint $table) {
            $table->bigIncrements("id_file_jadwal");
            $table->uuid('id_jurusan');
            $table->foreign('id_jurusan')->references('id_jurusan')->on('tb_jurusan');
            $table->string('name_file_jadwal_excel');
            $table->string('name_file_jadwal_pdf');
            $table->integer('semester_file_jadwal');
            $table->string('tahun_file_jadwal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_file_jadwal');
    }
};