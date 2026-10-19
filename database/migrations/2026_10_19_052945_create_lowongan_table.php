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
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perusahaan_id')->constrained('perusahaan')->onDelete('cascade');
            $table->string('judul_lowongan');
            $table->string('slug')->unique();
            $table->string('kategori_bidang');
            $table->enum('tipe_pekerjaan', ['Full-time', 'Part-time', 'Internship', 'Contract'])->default('Full-time');
            $table->enum('sistem_kerja', ['On-site', 'Remote', 'Hybrid'])->default('On-site');
            $table->string('lokasi');
            $table->string('rentang_gaji');
            $table->text('deskripsi_pekerjaan');
            $table->text('kualifikasi');
            $table->date('batas_lamaran');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan');
    }
};
