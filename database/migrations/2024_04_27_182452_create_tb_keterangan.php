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
        Schema::create('tb_keterangan', function (Blueprint $table) {
            $table->uuid("id_keterangan")->primary();
            $table->string("alpha");
            $table->string("izin");
            $table->string("sakit");
            $table->string("catatan");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_keterangan');
    }
};