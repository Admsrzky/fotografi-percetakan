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
        Schema::create('portofolio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jasa_id')->nullable()->constrained('jasa')->onDelete('set null'); // Opsional: terkait dengan jasa tertentu
            $table->string('judul'); // Judul portofolio (e.g., "Pre-wedding Indah di Bali")
            $table->text('deskripsi')->nullable();
            $table->string('kategori')->nullable(); // Kategori portofolio (e.g., "Pre-wedding", "Wedding", "Album")
            $table->string('gambar_utama'); // Path ke gambar utama portofolio
            $table->json('gambar_galeri')->nullable(); // Array path gambar untuk galeri portofolio detail
            $table->integer('tahun')->nullable(); // Tahun proyek
            $table->boolean('unggulan')->default(false); // Untuk ditampilkan di homepage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolio');
    }
};
