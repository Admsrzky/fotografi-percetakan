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
        Schema::create('pengaturan_situs', function (Blueprint $table) {
            $table->id();
            $table->string('kunci')->unique(); // (e.g., 'telepon_kontak', 'email_kontak', 'alamat_studio')
            $table->text('nilai')->nullable();
            $table->string('tipe_data')->default('teks'); // 'teks', 'textarea', 'gambar', 'json'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_situs');
    }
};
