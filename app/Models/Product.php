<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Str;

#[Fillable(['name', 'sku', 'category_id', 'price', 'stock', 'unit', 'image', 'is_active', 'barcode', 'description', 'cost_price', 'min_stock'])]
class Product extends Model
{

    protected $table = 'products';

    public static function generateSku(int $categoryId): string
    {
        $category = Category::findOrFail($categoryId);

        // 1. Ambil prefix (pasti 3 karakter uppercase, aman jika nama pendek)
        $prefix = Str::of($category->name)
            ->slug()
            ->upper()
            ->substr(0, 3)
            ->padRight(3, 'X') // Tambahkan 'X' jika kurang dari 3 huruf (cth: "ITX")
            ->toString();

        // 2. Cari produk terakhir berdasarkan ID terbesar
        $lastProduct = self::where('sku', 'like', "{$prefix}-%")
            ->orderByDesc('id')
            ->first();

        // 3. Ambil nomor terakhir secara aman
        $lastNumber = 0;

        if ($lastProduct) {
            $lastSegment = Str::afterLast($lastProduct->sku, '-');

            // Pastikan segmen terakhir benar-benar berupa angka murni
            if (is_numeric($lastSegment)) {
                $lastNumber = (int) $lastSegment;
            }
        }

        // 4. Format nomor urut baru (contoh: 0001, 0002)
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return "{$prefix}-{$newNumber}";
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
