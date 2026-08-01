<?php

namespace App\Livewire\Home;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.user')]
class Index extends Component
{

    use WithPagination;

    public $category_id = null;
    public $search = '';

    public function addToCart($productId)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $product = Product::findOrFail($productId);

        // 1. Cek ketersediaan stok
        if ($product->stock <= 0) {
            session()->flash('error', 'Stok produk ini sedang habis.');
            return;
        }

        FacadesDB::transaction(function () use ($product, $productId) {
            // 2. Cari cart aktif user, atau buat baru kalau belum ada
            $cart = Transaction::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'status'  => 'cart',
                ],
                [
                    'transaction_code' => 'TRX-' . now()->format('YmdHis') . '-' . Str::random(4),
                    'total'            => 0,
                    'payment_method'   => 'cash',
                    'paid_amount'      => 0,
                    'subtotal' => 0,
                    'customer_name' => auth()->user()->name,
                ]
            );

            // 3. Cek item di detail keranjang
            $detail = $cart->transactionDetails()->where('product_id', $productId)->first();

            if ($detail) {
                // Pastikan penambahan qty tidak melebihi stok yang tersedia
                if ($detail->quantity < $product->stock) {
                    $detail->increment('quantity');
                    $detail->update(['subtotal' => $detail->quantity * $detail->price]);
                } else {
                    session()->flash('error', 'Jumlah melebihi stok yang tersedia.');
                    return;
                }
            } else {
                $cart->transactionDetails()->create([
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'price'        => $product->price,
                    'quantity'     => 1,
                    'subtotal'     => $product->price,
                ]);
            }

            // 4. Update total tagihan di tabel transaksi utama
            $cart->update([
                'total' => $cart->transactionDetails()->sum('subtotal'),
            ]);
        });

        // Fire event ke komponen lain (jika ada header cart counter)
        $this->dispatch('cart-updated');
        session()->flash('message', 'Produk berhasil ditambahkan ke keranjang.');
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
