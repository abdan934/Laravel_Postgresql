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
        Schema::create('tb_prodi', function (Blueprint $table) {
            $table->uuid("id_prodi")->primary();
            $table->uuid('id_jurusan');
            $table->foreign('id_jurusan')->references('id_jurusan')->on('tb_jurusan');
            $table->string("jenjang_prodi");
            $table->string("name_prodi");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_prodi');
    }
};