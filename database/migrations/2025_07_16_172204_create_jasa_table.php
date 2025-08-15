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
        Schema::create('jasa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jasa')->unique(); // Nama Jasa (e.g., "Fotografi Pre-wedding", "Jasa Percetakan")
            $table->string('slug')->unique(); // Untuk URL ramah SEO (misal: "fotografi-pre-wedding")
            $table->text('deskripsi_jasa')->nullable();
            $table->string('tipe_jasa')->default('fotografi'); // 'fotografi', 'percetakan', 'lainnya'
            $table->string('gambar_jasa')->nullable(); // Path ke gambar hero untuk halaman jasa
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jasa');
    }
};
