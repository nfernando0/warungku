<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use Flux\Flux;
use Livewire\Component;

class Create extends Component
{
    public $category_id;
    public $sku;
    public $name;
    public $stock;
    public $unit;
    public $price;

    public function updatedCategoryId($value)
    {
        if ($value && empty($this->sku)) {
            $this->sku = Product::generateSku($value);
        }
    }

    public function regenerateSku()
    {
        if ($this->category_id) {
            $this->sku = Product::generateSku($this->category_id);
        }
    }

    public function save()
    {
        $this->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|unique:products,sku',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'unit' => 'required',
        ]);

        Product::create($this->only(['category_id', 'sku', 'name', 'price', 'stock', 'unit']));

        $this->reset();
        session()->flash('message', 'Produk berhasil ditambahkan.');
        Flux::toast(
            text: 'Product berhasil dibuat.',
            variant: 'success',
            heading: 'Sukses'
        );

        return $this->redirect(route('product.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.product.create', [
            'categories' => Category::get(),
        ]);
    }
}
