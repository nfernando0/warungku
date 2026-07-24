<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.product.index', [
            'products' => Product::paginate(5),
        ]);
    }
}
