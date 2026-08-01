<?php

namespace App\Livewire\Kasir;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

use Livewire\Attributes\Layout;

#[Layout('layouts.kasir')]
class Index extends Component
{
    public int $paymentAmount = 0;
    public bool $showCart = true;
    public array $cart = [];
    public ?int $selectedCategory = null;

    // Method untuk menambahkan produk ke keranjang berdasarkan Eloquent ID
    public function addToCart(int $productId): void
    {
        $product = Product::find($productId);

        if (! $product || $product->stock <= 0) {
            return;
        }

        $this->showCart = true;

        // Cek apakah item sudah ada di dalam keranjang
        $existingIndex = collect($this->cart)->search(fn($item) => $item['id'] === $productId);

        if ($existingIndex !== false) {
            // Batasi penambahan agar tidak melebihi stok yang ada
            if ($this->cart[$existingIndex]['qty'] < $product->stock) {
                $this->cart[$existingIndex]['qty']++;
            }
        } else {
            // Tambahkan sebagai item baru
            $this->cart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => 1,
                'stock' => $product->stock,
            ];
        }

        // Set default nilai pembayaran jika masih kosong
        if ($this->paymentAmount === 0) {
            $this->paymentAmount = $this->totalPrice;
        }
    }

    // Mengubah jumlah item di input qty
    public function updateQty(int $index, $qty): void
    {
        $qty = (int) $qty;

        if ($qty > 0) {
            // Validasi batasan stok
            $maxStock = $this->cart[$index]['stock'] ?? 999;
            $this->cart[$index]['qty'] = min($qty, $maxStock);
        } else {
            $this->removeItem($index);
        }
    }

    // Hapus satu item dari keranjang
    public function removeItem(int $index): void
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart); // Re-index array
    }

    // Kosongkan seluruh keranjang
    public function clearCart(): void
    {
        $this->cart = [];
        $this->paymentAmount = 0;
    }

    // Shortcut untuk mengisi angka pembayaran cepat
    public function setPayment(int $amount): void
    {
        $this->paymentAmount = $amount;
    }

    // Computed Property: Menghitung total jumlah pcs item
    public function getTotalQtyProperty(): int
    {
        return array_sum(array_column($this->cart, 'qty'));
    }

    // Computed Property: Menghitung subtotal & total harga
    public function getTotalPriceProperty(): int
    {
        return array_reduce($this->cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['qty']);
        }, 0);
    }

    // Computed Property: Menghitung kembalian otomatis
    public function getChangeProperty(): int
    {
        $change = $this->paymentAmount - $this->totalPrice;
        return $change > 0 ? $change : 0;
    }

    public function selectCategory(?int $categoryId = null): void
    {
        $this->selectedCategory = $categoryId;
    }

    public function render()
    {
        $products = Product::with('category')
            ->when($this->selectedCategory, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->get();

        return view('livewire.kasir.index', [
            'products' => $products,
            'categories' => Category::get(),
        ]);
    }
}
