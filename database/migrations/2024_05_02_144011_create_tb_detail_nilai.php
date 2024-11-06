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
       Schema::create('tb_detail_nilai', function (Blueprint $table) {
            $table->uuid("id_detail_nilai");
            $table->uuid('id_nilai');
            $table->foreign('id_nilai')->references('id_nilai')->on('tb_nilai');
            $table->string('lain_detail');
            $table->string('lain_prosentase_detail');
            $table->string('uts_detail');
            $table->string('uts_prosentase_detail');
            $table->string('uas_detail');
            $table->string('uas_prosentase_detail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_detail_nilai');
    }
};
