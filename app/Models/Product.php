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
        $prefix = strtoupper(Str::substr(Str::slug($category->name), 0, 3));

        $lastProduct = self::where('sku', 'like', "{$prefix}-%")
            ->orderByDesc('id')
            ->first();

        $lastNumber = $lastProduct
            ? (int) Str::afterLast($lastProduct->sku, '-')
            : 0;

        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return "{$prefix}-{$newNumber}";
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
