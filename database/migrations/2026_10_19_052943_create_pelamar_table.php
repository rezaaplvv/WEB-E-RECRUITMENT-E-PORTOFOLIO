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
        Schema::create('pelamar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nim')->unique();
            $table->string('angkatan');
            $table->decimal('ipk', 3, 2);
            $table->string('no_telp');
            $table->text('alamat');
            $table->string('headline');
            $table->text('ringkasan_profil');
            $table->text('keahlian');
            $table->string('link_github');
            $table->string('link_linkedin')->nullable();
            $table->string('link_portofolio_web')->nullable();
            $table->string('file_cv')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelamar');
    }
};
