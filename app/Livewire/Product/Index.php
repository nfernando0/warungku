<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use Livewire\WithFileUploads;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Support\Str;

class Index extends Component
{

    use WithFileUploads;

    public $productId;
    public $category_id, $sku, $barcode, $name, $cost_price, $price, $stock, $min_stock, $unit, $description;
    public $is_active = true;

    // 🔴 TAMBAHKAN DUA PROPERTI INI:
    public $image;     // Untuk menampung file upload baru
    public $old_image;
    public $productToDeleteId = null;

    public function editProduct($id)
    {
        $this->edit($id); // Mengisi field form

        // Buka modal Flux 'edit-product' dari server side
        // $this->dispatch('modal-show', name: 'edit-product');
        // Atau jika menggunakan Flux UI versi baru:
        Flux::modal('edit-product')->show();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $this->productId   = $product->id;
        $this->category_id = $product->category_id;
        $this->sku         = $product->sku;
        $this->barcode     = $product->barcode;
        $this->name        = $product->name;
        $this->cost_price  = $product->cost_price;
        $this->price       = $product->price;
        $this->stock       = $product->stock;
        $this->min_stock   = $product->min_stock;
        $this->unit        = $product->unit;
        $this->description = $product->description;
        $this->is_active   = $product->is_active;

        // Set gambar lama dan reset input file baru
        $this->old_image   = $product->image;
        $this->image       = null;
    }

    public function regenerateSku()
    {
        $this->sku = 'PRD-' . strtoupper(Str::random(8));
    }

    public function update()
    {
        // 1. Validasi Input (Pastikan SKU & Barcode Unik KECUALI untuk Produk Ini Sendiri)
        $validated = $this->validate([
            'category_id' => 'required|exists:categories,id',
            'sku'         => ['required', 'string', Rule::unique('products', 'sku')->ignore($this->productId)],
            'barcode'     => ['nullable', 'string', Rule::unique('products', 'barcode')->ignore($this->productId)],
            'name'        => 'required|string|max:255',
            'image'       => 'nullable|image|max:2048', // File upload baru (opsional)
            'description' => 'nullable|string',
            'cost_price'  => 'nullable|numeric|min:0',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'nullable|integer|min:0',
            'unit'        => 'required|string',
            'is_active'   => 'boolean',
        ]);

        $product = Product::findOrFail($this->productId);

        // 2. Auto-fill barcode jika ditiadakan/kosong
        if (empty($validated['barcode'])) {
            $validated['barcode'] = $validated['sku'];
        }

        // 3. Handle Update Gambar
        if ($this->image) {
            // Hapus gambar lama dari storage public jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan gambar baru
            $validated['image'] = $this->image->store('products', 'public');
        } else {
            // Jika tidak upload gambar baru, tetap gunakan path gambar lama
            $validated['image'] = $product->image;
        }

        // 4. Update data di database
        $product->update($validated);

        // 5. Reset input state & Tutup Modal Flux
        $this->reset(['image', 'old_image']);
        Flux::modals()->close(); // Menutup modal Flux setelah berhasil simpan

        // 6. Toast Notification
        Flux::toast(
            text: 'Produk berhasil diperbarui.',
            variant: 'success',
            heading: 'Sukses'
        );
    }

    public function confirmDelete($id)
    {
        $this->productToDeleteId = $id;
    }

    // Eksekusi Hapus & Kirim Notifikasi
    public function delete()
    {
        if ($this->productToDeleteId) {
            $product = Product::find($this->productToDeleteId);

            if ($product) {
                $product->delete();

                // 1. Kirim notifikasi / toast Flux
                Flux::toast(
                    text: 'Produk berhasil dihapus.',
                    heading: 'Sukses',
                    variant: 'success'
                );
            }
        }

        // 2. Tutup modal secara otomatis
        Flux::modals()->close('delete-product');

        // Reset ID
        $this->productToDeleteId = null;
    }

    public function render()
    {
        return view('livewire.product.index', [
            'products' => Product::paginate(5),
            'categories' => Category::all(),
        ]);
    }
}
