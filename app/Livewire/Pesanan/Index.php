<?php

namespace App\Livewire\Pesanan;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;

#[Layout('layouts.user')]
class Index extends Component
{

    public string $activeTab = 'cart';

    #[On('cart-updated')]
    public function refresh()
    {
        // cukup trigger re-render, data diambil ulang di render()
    }

    public function updateQuantity($detailId, $quantity)
    {
        if ($quantity < 1) {
            return $this->removeItem($detailId);
        }

        $cart = $this->getCart();
        $detail = $cart->transactionDetails()->findOrFail($detailId);
        $detail->update([
            'quantity' => $quantity,
            'subtotal' => $quantity * $detail->price,
        ]);

        $cart->update(['total' => $cart->transactionDetails()->sum('subtotal')]);
    }

    public function removeItem($detailId)
    {
        $cart = $this->getCart();
        $cart->transactionDetails()->where('id', $detailId)->delete();
        $cart->update(['total' => $cart->transactionDetails()->sum('subtotal')]);
    }

    public function checkout()
    {
        $cart = $this->getCart();

        if (! $cart || $cart->transactionDetails->isEmpty()) {
            $this->addError('cart', 'Keranjang masih kosong.');
            return;
        }

        foreach ($cart->transactionDetails as $detail) {
            if ($detail->product && $detail->product->stock < $detail->quantity) {
                $this->addError('cart', "Stok {$detail->product_name} tidak cukup.");
                return;
            }
        }

        foreach ($cart->transactionDetails as $detail) {
            $detail->product?->decrement('stock', $detail->quantity);
        }

        $cart->update([
            'status' => 'pending',
            'transaction_code' => 'TRX-' . strtoupper(uniqid()),
            'paid_amount' => 0,
        ]);

        $this->activeTab = 'history';
        session()->flash('message', 'Pesanan berhasil dibuat, menunggu konfirmasi.');
    }

    protected function getCart(): ?Transaction
    {
        return Transaction::with('transactionDetails.product')
            ->where('user_id', auth()->id())
            ->where('status', 'cart')
            ->first();
    }

    public function render()
    {
        return view('livewire.pesanan.index', [
            'cart' => $this->getCart(),
            'history' => Transaction::with('transactionDetails')
                ->where('user_id', auth()->id())
                ->where('status', '!=', 'cart')
                ->latest()
                ->paginate(10),
        ]);
    }
}
