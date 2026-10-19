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
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_perusahaan');
            $table->string('slug')->unique();
            $table->string('bidang_industri');
            $table->string('website')->nullable();
            $table->string('email_hrd');
            $table->string('no_telp');
            $table->text('alamat');
            $table->string('kota');
            $table->text('deskripsi');
            $table->string('logo')->nullable();
            $table->enum('status_verifikasi', ['pending', 'terverifikasi', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaan');
    }
};
