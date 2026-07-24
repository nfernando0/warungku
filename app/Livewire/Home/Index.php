<?php

namespace App\Livewire\Home;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.user')]
class Index extends Component
{

    use WithPagination;

    public $category_id = null;
    public $search = '';

    public function addToCart($productId)  // <-- harus sejajar di sini
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $product = Product::findOrFail($productId);

        // Cari cart aktif user, atau buat baru kalau belum ada
        $cart = Transaction::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 'cart'],
            [
                'transaction_code' => 'TRX-' . strtoupper(uniqid()),
                'total' => 0,
                'payment_method' => 'cash',
                'paid_amount' => 0,
            ]
        );

        // Kalau produk sudah ada di cart, tambah qty. Kalau belum, buat baru.
        $detail = $cart->transactionDetails()->where('product_id', $productId)->first();

        if ($detail) {
            $detail->increment('quantity');
            $detail->update(['subtotal' => $detail->quantity * $detail->price]);
        } else {
            $cart->transactionDetails()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price,
            ]);
        }

        $cart->update(['total' => $cart->transactionDetails()->sum('subtotal')]);

        $this->dispatch('cart-updated');
        session()->flash('message', 'Produk ditambahkan ke keranjang.');
    }

    public function render()
    {
        return view('livewire.home.index', [
            'products' => Product::with('category')
                ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->when($this->category_id, fn($q) => $q->where('category_id', $this->category_id))
                ->paginate(12),
            'activeCategories' => Category::has('products')->get(),

            // Kategori yang belum memiliki produk
            'emptyCategories'  => Category::doesntHave('products')->get(),
        ]);
    }
}
