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
        Schema::table('pemesanan', function (Blueprint $table) {
            // Kolom untuk menyimpan path bukti pelunasan
            $table->string('bukti_pelunasan_path')->nullable()->after('remaining_payment');
            // Kolom untuk menandai apakah pelunasan sudah dikonfirmasi admin
            $table->boolean('is_pelunasan_confirmed')->default(false)->after('bukti_pelunasan_path');

            // Opsional: Jika Anda ingin menambahkan kolom untuk tanggal pelunasan
            $table->timestamp('tanggal_pelunasan')->nullable()->after('is_pelunasan_confirmed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn('bukti_pelunasan_path');
            $table->dropColumn('is_pelunasan_confirmed');
            $table->dropColumn('tanggal_pelunasan'); // Jika Anda menambahkannya
        });
    }
};
