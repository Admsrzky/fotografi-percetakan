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
                // Mengubah tipe kolom yang sudah ada menjadi DECIMAL(15, 2)
                // Ini akan memungkinkan penyimpanan angka hingga 15 digit total dengan 2 digit di belakang koma
                $table->decimal('subtotal', 15, 2)->default(0.00)->change();
                $table->decimal('total_harga', 15, 2)->default(0.00)->change();
                $table->decimal('dp_amount', 15, 2)->default(0.00)->change();
                $table->decimal('remaining_payment', 15, 2)->default(0.00)->change();

                // Kolom payment_type sudah string, pastikan nullable jika Anda ingin defaultnya NULL
                // Jika Anda ingin memastikan nilai default non-NULL, bisa tambahkan ->default('dp') atau sejenisnya
                // $table->string('payment_type')->nullable()->change(); // Contoh jika ingin diubah
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('pemesanan', function (Blueprint $table) {
                // Mengembalikan tipe kolom ke BIGINT jika migrasi di-rollback
                // Penting: Jika ada data desimal, mereka akan terpotong saat rollback ke BIGINT
                $table->bigInteger('subtotal')->default(0)->change();
                $table->bigInteger('total_harga')->default(0)->change();
                $table->bigInteger('dp_amount')->default(0)->change();
                $table->bigInteger('remaining_payment')->default(0)->change();

                // $table->string('payment_type')->nullable(false)->change(); // Contoh jika ingin mengembalikan
            });
        }
    };
