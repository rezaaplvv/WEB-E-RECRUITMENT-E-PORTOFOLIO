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
        Schema::create('portofolio_proyek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelamar_id')->constrained('pelamar')->onDelete('cascade');
            $table->string('judul_proyek');
            $table->enum('kategori', [
                'Web Application',
                'Mobile Application',
                'UI/UX Design',
                'Data & AI',
                'Networking & IoT',
            ]);
            $table->string('tech_stack');
            $table->text('deskripsi');
            $table->string('link_github');
            $table->string('link_demo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolio_proyek');
    }
};
