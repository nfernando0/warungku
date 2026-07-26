<div>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <flux:heading size="xl">Daftar Produk</flux:heading>
            <flux:subheading>Cari dan pilih produk yang tersedia</flux:subheading>
        </div>

        <flux:input wire:model.live.debounce.400ms="search" placeholder="Cari produk..." icon="magnifying-glass"
            class="sm:w-64" />
    </div>

    {{-- Filter kategori --}}
    <div x-data="{ showEmpty: false }" class="mb-6 space-y-3">
        <div class="flex flex-wrap items-center gap-2">
            <!-- Tombol Semua -->
            <flux:button wire:click="$set('category_id', null)"
                variant="{{ is_null($category_id) ? 'primary' : 'ghost' }}" size="sm">
                Semua
            </flux:button>

            <!-- Kategori Aktif (Ada Produk) -->
            @foreach ($activeCategories as $category)
                <flux:button wire:click="$set('category_id', {{ $category->id }})"
                    variant="{{ $category_id === $category->id ? 'primary' : 'ghost' }}" size="sm">
                    {{ $category->name }}
                </flux:button>
            @endforeach

            <!-- Tombol Pemicu Tampilkan/Sembunyikan -->
            @if ($emptyCategories->isNotEmpty())
                <flux:button @click="showEmpty = !showEmpty" variant="subtle" size="sm" icon="squares-plus">
                    <span
                        x-text="showEmpty ? 'Sembunyikan' : '+ Kategori Lainnya ({{ $emptyCategories->count() }})'"></span>
                </flux:button>
            @endif
        </div>

        <!-- Area Kategori Kosong (Tampil jika showEmpty = true) -->
        <div x-show="showEmpty" x-collapse
            class="p-3 bg-zinc-50 dark:bg-zinc-900/50 rounded-lg border border-dashed border-zinc-200 dark:border-zinc-800 space-y-2">
            <p class="text-xs text-zinc-400 font-medium">Kategori belum memiliki produk:</p>
            <div class="flex flex-wrap gap-2">
                @foreach ($emptyCategories as $category)
                    <flux:button wire:click="$set('category_id', {{ $category->id }})"
                        variant="{{ $category_id === $category->id ? 'primary' : 'ghost' }}" size="sm"
                        class="opacity-60 hover:opacity-100">
                        {{ $category->name }}
                    </flux:button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Grid produk --}}
    @if ($products->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <flux:icon name="cube" class="mb-3 size-10 text-zinc-400" />
            <flux:heading size="lg">Produk tidak ditemukan</flux:heading>
            <flux:subheading>Coba ubah kata kunci atau kategori pencarian</flux:subheading>
        </div>
    @else
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($products as $product)
                <flux:card class="flex flex-col gap-2">
                    <!-- Header Badge (Kategori & Status Stok) -->
                    <div class="flex items-start justify-between">
                        <flux:badge size="sm" color="zinc">{{ $product->category->name }}</flux:badge>
                        @if ($product->stock <= 0)
                            <flux:badge size="sm" color="red">Habis</flux:badge>
                        @endif
                    </div>

                    <!-- Gambar Produk -->
                    <div
                        class="relative my-2 aspect-square w-full overflow-hidden rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="h-full w-full object-cover" />
                        @else
                            <!-- Fallback jika produk belum memiliki gambar -->
                            <flux:icon icon="photo" class="h-10 w-10 text-zinc-400" />
                        @endif
                    </div>

                    <!-- Informasi Produk -->
                    <flux:heading size="sm" class="line-clamp-1">{{ $product->name }}</flux:heading>
                    <flux:text size="sm" class="text-zinc-500">SKU: {{ $product->sku }}</flux:text>

                    <div class="mt-auto flex items-center justify-between pt-2">
                        <flux:text class="font-semibold">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </flux:text>
                        <flux:text size="sm" class="text-zinc-500">
                            {{ $product->stock }} {{ $product->unit ?? 'pcs' }}
                        </flux:text>
                    </div>

                    <!-- Tombol Tambah ke Keranjang -->
                    <flux:button wire:click="addToCart({{ $product->id }})" variant="primary" size="sm"
                        :disabled="$product->stock <= 0" class="mt-2 w-full">
                        Tambah
                    </flux:button>
                </flux:card>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @endif
</div>
