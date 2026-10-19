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
        Schema::create('lamaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_lamaran')->unique();
            $table->foreignId('lowongan_id')->constrained('lowongan')->onDelete('cascade');
            $table->foreignId('pelamar_id')->constrained('pelamar')->onDelete('cascade');
            $table->string('cv_snapshot');
            $table->string('github_snapshot');
            $table->text('surat_lamaran');
            $table->enum('status_lamaran', ['dilamar', 'dilihat', 'interview', 'diterima', 'ditolak'])->default('dilamar');
            $table->dateTime('jadwal_interview')->nullable();
            $table->enum('metode_interview', ['Online', 'Offline'])->nullable();
            $table->string('link_atau_lokasi_interview')->nullable();
            $table->text('catatan_hrd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lamaran');
    }
};
