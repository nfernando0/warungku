<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use Livewire\WithFileUploads;
use Flux\Flux;
use Livewire\Component;

class Create extends Component
{

    use WithFileUploads;

    public $category_id, $sku, $barcode, $name, $price, $cost_price, $stock, $min_stock, $unit, $description;
    public $image; // Properti untuk menampung file upload
    public $is_active = true;

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
        $validated = $this->validate([
            // Identitas & Relasi
            'category_id' => 'required|exists:categories,id',
            'sku'         => 'required|string|unique:products,sku',
            'barcode'     => 'nullable|string|unique:products,barcode',
            'name'        => 'required|string|max:255',
            'image'       => 'nullable|image|max:2048', // Max 2MB (opsional)
            'description' => 'nullable|string',

            // Harga & Stok
            'cost_price'  => 'nullable|numeric|min:0',  // Harga modal/HPP
            'price'       => 'required|numeric|min:0',  // Harga jual
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'nullable|integer|min:0',  // Batas peringatan stok
            'unit'        => 'required|string|max:20',  // pcs, kg, renteng, dll.

            // Status
            'is_active'   => 'boolean',
        ]);

        if (empty($validated['barcode'])) {
            // Contoh Opsi A: Samakan barcode dengan SKU
            $validated['barcode'] = $validated['sku'];

            // Contoh Opsi B: Buat Barcode Angka Unik (Misal: 899 + 10 digit acak khas produk Indonesia)
            // $validated['barcode'] = '899' . mt_rand(100000000, 999999999);
        }

        if ($this->image) {
            // Menyimpan ke 'storage/app/public/products' dan mengembalikan path-nya
            $validated['image'] = $this->image->store('products', 'public');
        }

        Product::create($validated);

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
