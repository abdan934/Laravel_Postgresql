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
        Schema::create('tb_users', function (Blueprint $table) {
            $table->uuid('id_users')->primary();
            $table->unsignedBigInteger('id_role');
            $table->foreign('id_role')->references('id_role')->on('tb_role');
            $table->string('username');
            $table->string('password');
            $table->string('name_user');
            $table->string('photo_profile');
            $table->string('jk_user');
            $table->boolean('status_user');
            $table->boolean('default_pass');
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
};
