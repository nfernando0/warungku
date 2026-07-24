<div>
    <flux:heading size="xl" class="mb-6">Pesanan Saya</flux:heading>

    @if (session('message'))
        <flux:callout variant="success" class="mb-4">{{ session('message') }}</flux:callout>
    @endif

    @error('cart')
        <flux:callout variant="danger" class="mb-4">{{ $message }}</flux:callout>
    @enderror

    <div class="mb-6 flex gap-2">
        <flux:button wire:click="$set('activeTab', 'cart')" variant="{{ $activeTab === 'cart' ? 'primary' : 'ghost' }}"
            size="sm">
            Keranjang
        </flux:button>
        <flux:button wire:click="$set('activeTab', 'history')"
            variant="{{ $activeTab === 'history' ? 'primary' : 'ghost' }}" size="sm">
            Riwayat
        </flux:button>
    </div>

    {{-- Tab: Keranjang --}}
    @if ($activeTab === 'cart')
        @if (!$cart || $cart->transactionDetails->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <flux:icon name="shopping-cart" class="mb-3 size-10 text-zinc-400" />
                <flux:heading size="lg">Keranjang kosong</flux:heading>
                <flux:subheading>Yuk pilih produk dulu di halaman utama</flux:subheading>
            </div>
        @else
            <div class="flex flex-col gap-3">
                @foreach ($cart->transactionDetails as $detail)
                    <flux:card class="flex items-center justify-between gap-4">
                        <div>
                            <flux:heading size="sm">{{ $detail->product_name }}</flux:heading>
                            <flux:text size="sm" class="text-zinc-500">
                                Rp{{ number_format($detail->price, 0, ',', '.') }} / {{ $detail->product->unit ?? '' }}
                            </flux:text>
                        </div>

                        <div class="flex items-center gap-2">
                            <flux:button wire:click="updateQuantity({{ $detail->id }}, {{ $detail->quantity - 1 }})"
                                variant="ghost" size="sm" icon="minus" />
                            <flux:text>{{ $detail->quantity }}</flux:text>
                            <flux:button wire:click="updateQuantity({{ $detail->id }}, {{ $detail->quantity + 1 }})"
                                variant="ghost" size="sm" icon="plus" />
                        </div>

                        <flux:text class="w-28 text-right font-semibold">
                            Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                        </flux:text>

                        <flux:button wire:click="removeItem({{ $detail->id }})" variant="ghost" size="sm"
                            icon="trash" class="text-red-500" />
                    </flux:card>
                @endforeach
            </div>

            <div class="mt-6 flex items-center justify-between border-t pt-4">
                <flux:heading size="lg">Total: Rp{{ number_format($cart->total, 0, ',', '.') }}</flux:heading>
                <flux:button wire:click="checkout" variant="primary">Checkout</flux:button>
            </div>
        @endif
    @endif

    {{-- Tab: Riwayat --}}
    @if ($activeTab === 'history')
        @if ($history->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <flux:icon name="clock" class="mb-3 size-10 text-zinc-400" />
                <flux:heading size="lg">Belum ada riwayat pesanan</flux:heading>
            </div>
        @else
            <div class="flex flex-col gap-3">
                @foreach ($history as $order)
                    <flux:card class="flex items-center justify-between">
                        <div>
                            <flux:heading size="sm">{{ $order->transaction_code }}</flux:heading>
                            <flux:text size="sm" class="text-zinc-500">
                                {{ $order->transactionDetails->count() }} item &middot;
                                {{ $order->transaction_date->translatedFormat('d M Y, H:i') }}
                            </flux:text>
                        </div>

                        <div class="flex items-center gap-3">
                            <flux:badge
                                color="{{ match ($order->status) {
                                    'pending' => 'yellow',
                                    'paid' => 'blue',
                                    'completed' => 'green',
                                    'cancelled' => 'red',
                                    default => 'zinc',
                                } }}">
                                {{ ucfirst($order->status) }}
                            </flux:badge>
                            <flux:text class="font-semibold">
                                Rp{{ number_format($order->total, 0, ',', '.') }}
                            </flux:text>
                        </div>
                    </flux:card>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $history->links() }}
            </div>
        @endif
    @endif
</div>
