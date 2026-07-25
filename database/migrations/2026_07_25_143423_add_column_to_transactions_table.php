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
        Schema::table('transactions', function (Blueprint $table) {
            // 1. Rincian Biaya & Laba (POS)
            $table->decimal('subtotal', 12, 2)->after('transaction_code');
            $table->decimal('discount', 12, 2)->default(0)->after('subtotal');
            $table->decimal('profit', 12, 2)->default(0)->after('total'); // Hitung Laba Bersih

            // 2. Integrasi Midtrans Payment Gateway
            $table->string('snap_token')->nullable()->after('profit');
            $table->string('payment_type')->nullable()->after('payment_method'); // e.g., gopay, qris, bank_transfer, cstore
            $table->string('payment_status')->default('pending')->after('payment_type'); // pending, settlement, expire, cancel
            $table->string('pdf_url')->nullable()->after('payment_status');

            // 3. Status & Informasi Pelanggan
            $table->string('customer_name')->nullable()->after('status');
            $table->text('notes')->nullable()->after('customer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'subtotal',
                'discount',
                'profit',
                'snap_token',
                'payment_type',
                'payment_status',
                'pdf_url',
                'status',
                'customer_name',
                'notes',
            ]);
        });
    }
};
