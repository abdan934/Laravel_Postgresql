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
        Schema::create('tb_kaprodi', function (Blueprint $table) {
            $table->uuid('id_kaprodi')->primary();
            $table->string('nidn');
            $table->uuid('id_prodi');
            $table->foreign('id_prodi')->references('id_prodi')->on('tb_prodi');
            $table->boolean('status_kaprodi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kaprodi');
    }
};