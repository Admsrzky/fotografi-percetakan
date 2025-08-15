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
        Schema::create('paket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jasa_id')->constrained('jasa')->onDelete('cascade'); // Terhubung ke tabel 'jasa'
            $table->string('nama_paket'); // Nama Paket (e.g., "Paket Romantis", "Paket Harmoni")
            $table->text('deskripsi_paket')->nullable();
            $table->unsignedBigInteger('harga_paket'); // Harga paket (dalam satuan terkecil, misal IDR)
            $table->json('fitur_paket')->nullable(); // Fitur-fitur paket (e.g., ["Durasi 6 jam", "1 Fotografer"])
            $table->string('info_durasi')->nullable(); // Misal: "Full Day", "2-3 Jam"
            $table->string('info_output')->nullable(); // Misal: "Album Fisik, USB Drive, Galeri Online"
            $table->integer('urutan_tampil')->default(0); // Untuk mengurutkan paket
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket');
    }
};
