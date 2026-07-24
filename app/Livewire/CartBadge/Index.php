<?php

namespace App\Livewire\CartBadge;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\Attributes\On;

class Index extends Component
{
    #[On('cart-updated')]
    public function refresh() {}
    public function render()
    {
        return view('livewire.cart-badge.index', [
            'count' => auth()->check()
                ? Transaction::where('user_id', auth()->id())
                ->where('status', 'cart')
                ->withCount('transactionDetails')
                ->first()?->transaction_details_count ?? 0
                : 0,
        ]);
    }
}
