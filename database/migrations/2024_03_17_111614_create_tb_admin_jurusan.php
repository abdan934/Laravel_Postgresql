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
        Schema::create('tb_admin_jurusan', function (Blueprint $table) {
            $table->uuid("id_admin_jurusan")->primary();
            $table->string('nip');
            $table->uuid('id_jurusan');
            $table->foreign('id_jurusan')->references('id_jurusan')->on('tb_jurusan');
            $table->string('name_admin_jurusan');
            $table->string('email_admin_jurusan');
            $table->string('no_hp_admin_jurusan');
            $table->string('jk_admin_jurusan');
            $table->string('alamat_admin_jurusan');
            $table->boolean('status_admin_jurusan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_admin_jurusan');
    }
};