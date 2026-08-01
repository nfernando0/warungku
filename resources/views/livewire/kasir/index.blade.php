<div>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

        <!-- ========================================== -->
        <!-- KOLOM KIRI: KATALOG PRODUK (lg:col-span-7)  -->
        <!-- ========================================== -->
        <div class="lg:col-span-7 xl:col-span-8 space-y-4">

            <!-- Header & Search Bar -->
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <flux:heading size="xl">Kasir Warungku</flux:heading>
                    <flux:subheading size="sm">Pilih produk atau scan barcode untuk transaksi</flux:subheading>
                </div>

                <div class="w-full sm:w-72">
                    <flux:input icon="magnifying-glass" placeholder="Scan Barcode / Cari Produk..." autofocus />
                </div>
            </div>

            <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-none">
                <!-- Tombol Semua Kategori -->
                <flux:button wire:click="selectCategory(null)" size="sm"
                    :variant="$selectedCategory === null ? 'primary' : 'subtle'">
                    Semua
                </flux:button>

                <!-- Looping Kategori dari Database -->
                @foreach ($categories as $category)
                    <flux:button wire:key="category-{{ $category->id }}"
                        wire:click="selectCategory({{ $category->id }})" size="sm"
                        :variant="$selectedCategory === $category->id ? 'primary' : 'subtle'">
                        {{ $category->name }}
                    </flux:button>
                @endforeach
            </div>

            <!-- Grid Produk -->
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-4">

                @forelse ($products as $product)
                    <flux:card wire:key="product-{{ $product->id }}" class="flex flex-col justify-between p-3 gap-2">
                        <!-- Badge Kategori -->
                        <div class="flex items-center justify-between">
                            <flux:badge size="sm" color="zinc">
                                {{ $product->category->name ?? 'Umum' }}
                            </flux:badge>
                        </div>

                        <!-- Gambar Produk -->
                        <div
                            class="relative my-1 aspect-square w-full overflow-hidden rounded-md bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover" />
                            @else
                                <flux:icon icon="photo" class="h-8 w-8 text-zinc-400" />
                            @endif
                        </div>

                        <!-- Detail Produk -->
                        <div>
                            <flux:heading size="sm" class="line-clamp-1" title="{{ $product->name }}">
                                {{ $product->name }}
                            </flux:heading>
                            <flux:text size="xs" class="text-zinc-500">
                                SKU: {{ $product->sku ?? '-' }}
                            </flux:text>
                        </div>

                        <!-- Harga & Stok -->
                        <div class="flex items-center justify-between pt-1">
                            <flux:text class="font-bold text-sm">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </flux:text>
                            <flux:text size="xs"
                                class="{{ $product->stock > 0 ? 'text-zinc-500' : 'text-red-500 font-medium' }}">
                                Stok: {{ $product->stock }}
                            </flux:text>
                        </div>

                        <!-- Tombol Tambah ke Keranjang -->
                        <flux:button wire:click="addToCart({{ $product->id }})" variant="primary" size="sm"
                            class="w-full mt-1" :disabled="$product->stock <= 0">
                            {{ $product->stock > 0 ? '+ Tambah' : 'Stok Habis' }}
                        </flux:button>
                    </flux:card>
                @empty
                    <!-- Empty State (Jika produk tidak ditemukan) -->
                    <div class="col-span-full flex flex-col items-center justify-center py-12 text-zinc-400">
                        <flux:icon icon="magnifying-glass" class="w-12 h-12 mb-3 opacity-40" />
                        <flux:heading size="lg" class="text-zinc-600 dark:text-zinc-300">
                            Produk Tidak Ditemukan
                        </flux:heading>
                        <flux:text size="sm" class="text-zinc-400">
                            Coba gunakan kata kunci pencarian lain atau pilih kategori berbeda.
                        </flux:text>
                    </div>
                @endforelse

            </div>
        </div>

        <!-- ========================================== -->
        <!-- KOLOM KANAN: KERANJANG BELANJA (lg:col-span-5) -->
        <!-- ========================================== -->
        @if ($showCart)
            <div class="lg:col-span-5 xl:col-span-4">
                <flux:card class="sticky top-6 flex flex-col h-[calc(100vh-5rem)] justify-between">

                    <!-- Header Keranjang -->
                    <div class="flex items-center justify-between border-b pb-3 border-zinc-200 dark:border-zinc-700">
                        <flux:heading class="flex items-center gap-2 p-2">
                            <flux:icon icon="shopping-bag" /> Keranjang Belanja
                        </flux:heading>

                        @if (count($cart) > 0)
                            <flux:button wire:click="clearCart" variant="ghost" size="sm" color="red">
                                Bersihkan
                            </flux:button>
                        @endif
                    </div>

                    <!-- Daftar Item Belanja (Dinamis) -->
                    <div class="flex-1 overflow-y-auto my-3 space-y-3 pr-1">
                        @forelse ($cart as $index => $item)
                            <div wire:key="cart-item-{{ $item['id'] }}"
                                class="flex items-center justify-between p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                                <div class="flex-1 pr-2">
                                    <flux:heading size="sm" class="line-clamp-1" title="{{ $item['name'] }}">
                                        {{ $item['name'] }}
                                    </flux:heading>
                                    <flux:text size="xs" class="text-zinc-500">
                                        Rp{{ number_format($item['price'], 0, ',', '.') }} x {{ $item['qty'] }}
                                    </flux:text>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="number" min="1" max="{{ $item['stock'] }}"
                                        value="{{ $item['qty'] }}"
                                        wire:change="updateQty({{ $index }}, $event.target.value)"
                                        class="w-14 text-center text-sm border rounded p-1 dark:bg-zinc-900 dark:border-zinc-700 focus:outline-none focus:ring-1 focus:ring-emerald-500" />
                                    <flux:button wire:click="removeItem({{ $index }})" variant="subtle"
                                        size="sm" icon="trash" />
                                </div>
                            </div>
                        @empty
                            <!-- Display saat keranjang kosong -->
                            <div class="flex flex-col items-center justify-center h-full text-zinc-400 py-10">
                                <flux:icon icon="shopping-bag" class="w-12 h-12 mb-2 opacity-40" />
                                <flux:text class="text-sm">Keranjang masih kosong</flux:text>
                            </div>
                        @endforelse
                    </div>

                    <!-- Ringkasan & Form Pembayaran Dinamis -->
                    <div class="border-t pt-3 space-y-3 border-zinc-200 dark:border-zinc-700">

                        <!-- Subtotal & Total -->
                        <div class="space-y-1">
                            <div class="flex justify-between items-center text-sm text-zinc-500">
                                <flux:text>Subtotal Item ({{ $this->totalQty }} pcs):</flux:text>
                                <flux:text class="font-medium">
                                    Rp{{ number_format($this->totalPrice, 0, ',', '.') }}
                                </flux:text>
                            </div>
                            <div class="flex justify-between items-center text-lg font-bold">
                                <flux:text>Total Tagihan:</flux:text>
                                <flux:text size="xl" class="text-emerald-600 dark:text-emerald-400">
                                    Rp{{ number_format($this->totalPrice, 0, ',', '.') }}
                                </flux:text>
                            </div>
                        </div>

                        <!-- Input Nominal Uang Bayar -->
                        <div>
                            <flux:input type="number" label="Nominal Uang Diterima"
                                wire:model.live.debounce.300ms="paymentAmount" />
                        </div>

                        <!-- Shortcut Nominal Uang Cepat -->
                        <div class="grid grid-cols-3 gap-1">
                            <flux:button wire:click="setPayment({{ $this->totalPrice }})" size="xs"
                                variant="subtle">
                                Pas
                            </flux:button>
                            <flux:button wire:click="setPayment(50000)" size="xs" variant="subtle">
                                50.000
                            </flux:button>
                            <flux:button wire:click="setPayment(100000)" size="xs" variant="subtle">
                                100.000
                            </flux:button>
                        </div>

                        <!-- Display Kembalian -->
                        <div class="flex justify-between items-center text-sm pt-1">
                            <flux:text>Kembalian:</flux:text>
                            <flux:text class="font-bold text-base text-zinc-800 dark:text-zinc-100">
                                Rp{{ number_format($this->change, 0, ',', '.') }}
                            </flux:text>
                        </div>

                        <!-- Tombol Bayar -->
                        <flux:button variant="primary" class="w-full"
                            :disabled="count($cart) === 0 || $paymentAmount < $this->totalPrice">
                            Bayar Sekarang (F2)
                        </flux:button>
                    </div>

                </flux:card>
            </div>
        @endif

    </div>
</div>
