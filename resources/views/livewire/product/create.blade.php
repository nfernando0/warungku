<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="#">Home</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('product.index') }}">Product</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Create</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form wire:submit="save" class="space-y-4 mt-4">

        <!-- 1. Name & Category -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:field>
                <flux:label badge="Required">Nama Produk</flux:label>
                <flux:input wire:model="name" placeholder="Contoh: Kopi Kapal Api 20g" />
                <flux:error name="name" />
            </flux:field>

            <flux:select wire:model="category_id" label="Kategori" badge="Required">
                <flux:select.option value="">Pilih kategori</flux:select.option>
                @foreach ($categories as $category)
                    <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <!-- 2. Code & Barcode -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:field>
                <flux:label badge="Required">SKU</flux:label>
                <div class="flex gap-2">
                    <flux:input wire:model="sku" class="w-full" placeholder="PRD-001" />
                    <flux:button wire:click="regenerateSku" icon="arrow-path" variant="ghost" tooltip="Generate SKU" />
                </div>
                <flux:error name="sku" />
            </flux:field>

            <flux:field>
                <flux:label>Barcode (Scan / Manual)</flux:label>
                <flux:input wire:model="barcode" placeholder="Scan barcode kemasan atau kosongkan" />
                <flux:error name="barcode" />
            </flux:field>
        </div>

        <!-- 3. Prices (Modal & Jual) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:field>
                <flux:label>Harga Modal (HPP)</flux:label>
                <flux:input wire:model="cost_price" type="number" prefix="Rp" placeholder="0" />
                <flux:error name="cost_price" />
            </flux:field>

            <flux:field>
                <flux:label badge="Required">Harga Jual</flux:label>
                <flux:input wire:model="price" type="number" prefix="Rp" placeholder="0" />
                <flux:error name="price" />
            </flux:field>
        </div>

        <!-- 4. Stock, Min Stock & Unit -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <flux:field>
                <flux:label badge="Required">Stok Awal</flux:label>
                <flux:input wire:model="stock" type="number" min="0" placeholder="0" />
                <flux:error name="stock" />
            </flux:field>

            <flux:field>
                <flux:label>Min. Stok (Alert)</flux:label>
                <flux:input wire:model="min_stock" type="number" min="0" placeholder="5" />
                <flux:error name="min_stock" />
            </flux:field>

            <flux:field>
                <flux:label badge="Required">Satuan / Unit</flux:label>
                <flux:input wire:model="unit" placeholder="pcs, kg, renteng, dll" />
                <flux:error name="unit" />
            </flux:field>
        </div>

        <!-- 5. Upload Image & Description (Opsional) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:field>
                <flux:label>Foto Produk</flux:label>

                <!-- Preview Gambar jika ada yang dipilih -->
                @if ($image)
                    <div class="mb-2">
                        <!-- Trigger Tombol Preview (Menggunakan Modal) -->
                        <flux:modal.trigger name="zoom-image">
                            <div
                                class="relative w-24 h-24 rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 cursor-pointer group">
                                <img src="{{ $image->temporaryUrl() }}"
                                    class="w-full h-full object-cover transition-transform duration-200 group-hover:scale-105"
                                    alt="Preview Foto">

                                <!-- Overlay Hover (Ikon Kaca Pembesar) -->
                                <div
                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                    <flux:icon icon="magnifying-glass-plus" class="w-6 h-6" />
                                </div>
                            </div>
                        </flux:modal.trigger>

                        <!-- Modal Tampilan Gambar Perbesar (Zoom) -->
                        <flux:modal name="zoom-image" class="max-w-2xl p-2">
                            <div
                                class="relative flex items-center justify-center bg-zinc-950 rounded-lg overflow-hidden">
                                <img src="{{ $image->temporaryUrl() }}"
                                    class="max-h-[80vh] w-auto object-contain rounded-lg" alt="Preview Foto Zoom">
                            </div>
                        </flux:modal>
                    </div>
                @endif

                <flux:input wire:model="image" type="file" accept="image/*" />
                <flux:error name="image" />
            </flux:field>

            <flux:field>
                <flux:label>Status Produk</flux:label>
                <div class="pt-2">
                    <flux:switch wire:model="is_active" label="Aktifkan Produk (Tampilkan di Kasir)" />
                </div>
                <flux:error name="is_active" />
            </flux:field>
        </div>

        <flux:field>
            <flux:label>Deskripsi (Opsional)</flux:label>
            <flux:textarea wire:model="description" rows="2" placeholder="Catatan tambahan mengenai produk..." />
            <flux:error name="description" />
        </flux:field>

        <!-- Form Actions -->
        <div class="flex justify-end gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-800">
            <flux:button href="{{ route('product.index') }}" variant="ghost">Batal</flux:button>
            <flux:button type="submit" variant="primary">Simpan Produk</flux:button>
        </div>

    </form>
</div>
