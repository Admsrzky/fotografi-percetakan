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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            // Tabel 'users' tetap menggunakan nama default Laravel 'users'
            $table->foreignId('pengguna_id')->nullable()->constrained('users')->onDelete('set null'); // Terhubung ke user (jika login), nullable jika tamu
            $table->foreignId('jasa_id')->constrained('jasa'); // Jasa yang dipesan
            $table->foreignId('paket_id')->nullable()->constrained('paket')->onDelete('set null'); // Paket yang dipesan (opsional)

            // Informasi pemesan
            $table->string('nama_pelanggan');
            $table->string('email_pelanggan');
            $table->string('telepon_pelanggan')->nullable();

            // Detail pemesanan jasa
            $table->date('tanggal_acara')->nullable(); // Tanggal acara/target selesai
            $table->string('lokasi_acara')->nullable(); // Lokasi acara/alamat kirim
            $table->text('catatan_tambahan')->nullable(); // Catatan tambahan dari pemesan

            // Status pesanan: 'menunggu', 'dikonfirmasi', 'selesai', 'dibatalkan', 'ditolak', 'dalam_proses'
            $table->string('status_pemesanan')->default('menunggu');
            $table->text('catatan_admin')->nullable(); // Catatan dari admin

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
