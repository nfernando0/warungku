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
        Schema::table('products', function (Blueprint $table) {
            $table->string('barcode')->nullable()->unique()->after('sku');
            $table->string('image')->nullable()->after('name');
            $table->text('description')->nullable()->after('image');
            $table->decimal('cost_price', 12, 2)->default(0)->after('description'); // Harga Modal
            $table->integer('min_stock')->default(5)->after('stock');                 // Alert stok minimal
            $table->boolean('is_active')->default(true)->after('unit');               // Status aktif/sembunyi
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'barcode',
                'image',
                'description',
                'cost_price',
                'min_stock',
                'is_active',
            ]);

            $table->dropSoftDeletes();
        });
    }
};
