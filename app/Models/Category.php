<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name'])]
class Category extends Model
{
    protected $table = 'categories';

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
