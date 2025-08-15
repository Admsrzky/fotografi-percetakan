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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jasa_id')->nullable()->constrained('jasa')->onDelete('set null'); // Opsional: Ketersediaan bisa per jasa
            $table->date('tanggal_mulai_blokir'); // Tanggal mulai pemblokiran
            $table->date('tanggal_akhir_blokir')->nullable(); // Tanggal akhir pemblokiran (jika rentang)
            $table->string('alasan_blokir')->nullable(); // Alasan pemblokiran (misal: "Sudah Dibooking", "Libur")
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
