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
            // Menambahkan kolom 'quantity'
            // Default 1 jika tidak ada kuantitas spesifik (misal: untuk fotografi)
            $table->integer('quantity')->default(1)->after('paket_id');

            // Menambahkan kolom untuk perhitungan harga
            $table->decimal('subtotal', 15, 2)->default(0.00)->after('quantity');
            $table->decimal('total_harga', 15, 2)->default(0.00)->after('subtotal');
            $table->decimal('dp_amount', 15, 2)->default(0.00)->after('total_harga');
            $table->decimal('remaining_payment', 15, 2)->default(0.00)->after('dp_amount');

            // Menambahkan kolom 'payment_type' untuk menandai jenis pembayaran awal
            // 'dp' jika ada sisa pembayaran, 'full_payment' jika lunas di awal
            $table->string('payment_type')->nullable()->after('remaining_payment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            // Menghapus semua kolom yang ditambahkan jika migrasi di-rollback
            $table->dropColumn([
                'quantity',
                'subtotal',
                'total_harga',
                'dp_amount',
                'remaining_payment',
                'payment_type',
            ]);
        });
    }
};
