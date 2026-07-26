<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="#">Home</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Product</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="mt-4">
        <flux:button href="{{ route('product.create') }}">Tambah Produk</flux:button>
    </div>

    <div class="mt-4">
        <flux:table :paginate="$products">
            <flux:table.columns>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>SKU</flux:table.column>
                <flux:table.column>Price</flux:table.column>
                <flux:table.column>Stok</flux:table.column>
                <flux:table.column>Unit</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($products as $product)
                    <flux:table.row>
                        <flux:table.cell>{{ $product->name }}</flux:table.cell>
                        <flux:table.cell>{{ $product->sku }}</flux:table.cell>
                        <flux:table.cell>{{ $product->price }}</flux:table.cell>
                        <flux:table.cell>{{ $product->stock }}</flux:table.cell>
                        <flux:table.cell>{{ $product->unit }}</flux:table.cell>
                        <flux:table.cell class="text-center">
                            <div class="flex gap-2">
                                <flux:modal.trigger name="edit-product">
                                    <flux:button wire:click="edit({{ $product->id }})" icon="pencil-square" size="sm"
                                        variant="subtle">
                                    </flux:button>
                                </flux:modal.trigger>
                                <flux:modal.trigger name="delete-product">
                                    <flux:button wire:click="confirmDelete({{ $product->id }})" icon="trash"
                                        size="sm" variant="subtle" aria-label="Hapus produk" />
                                </flux:modal.trigger>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <!-- colspan="2"
                                        karena tabel Anda memiliki 2 kolom (Name & Price) -->
                        <flux:table.cell colspan="4" class="text-center text-zinc-400 py-8">
                            Belum ada data product.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </div>

    {{-- Modal Edit Product --}}
    <flux:modal name="edit-product" class="max-w-2xl" flyout>
        <form wire:submit="update" class="space-y-4">
            <div>
                <flux:heading size="lg">Edit Produk</flux:heading>
                <flux:subheading>Ubah informasi detail produk di bawah ini.</flux:subheading>
            </div>

            <!-- 1. Nama & Kategori -->
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

            <!-- 2. SKU & Barcode -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label badge="Required">SKU</flux:label>
                    <div class="flex gap-2">
                        <flux:input wire:model="sku" class="w-full" placeholder="PRD-001" />
                        <flux:button wire:click="regenerateSku" icon="arrow-path" variant="ghost"
                            tooltip="Generate SKU" />
                    </div>
                    <flux:error name="sku" />
                </flux:field>

                <flux:field>
                    <flux:label>Barcode (Scan / Manual)</flux:label>
                    <flux:input wire:model="barcode" placeholder="Scan barcode kemasan" />
                    <flux:error name="barcode" />
                </flux:field>
            </div>

            <!-- 3. Harga Modal & Harga Jual -->
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

            <!-- 4. Stok, Min Stock & Unit -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <flux:field>
                    <flux:label badge="Required">Stok</flux:label>
                    <flux:input wire:model="stock" type="number" min="0" />
                    <flux:error name="stock" />
                </flux:field>

                <flux:field>
                    <flux:label>Min. Stok</flux:label>
                    <flux:input wire:model="min_stock" type="number" min="0" />
                    <flux:error name="min_stock" />
                </flux:field>

                <flux:field>
                    <flux:label badge="Required">Satuan / Unit</flux:label>
                    <flux:input wire:model="unit" placeholder="pcs, kg, dll" />
                    <flux:error name="unit" />
                </flux:field>
            </div>

            <!-- 5. Foto Produk & Status Aktif -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Foto Produk</flux:label>

                    <!-- Preview Gambar Baru atau Gambar Lama dari Storage -->
                    @if ($image)
                        <div
                            class="mb-2 relative w-20 h-20 rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover"
                                alt="Preview Foto Baru">
                        </div>
                    @elseif ($old_image)
                        <div
                            class="mb-2 relative w-20 h-20 rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
                            <img src="{{ asset('storage/' . $old_image) }}" class="w-full h-full object-cover"
                                alt="Foto Sekarang">
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

            <!-- 6. Deskripsi -->
            <flux:field>
                <flux:label>Deskripsi (Opsional)</flux:label>
                <flux:textarea wire:model="description" rows="2"
                    placeholder="Catatan tambahan mengenai produk..." />
                <flux:error name="description" />
            </flux:field>

            <!-- Form Actions -->
            <div class="flex justify-end gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">Simpan Perubahan</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Modal Notification delete --}}
    <flux:modal name="delete-product" class="max-w-md">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Konfirmasi Hapus</flux:heading>
                <flux:subheading>
                    Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.
                </flux:subheading>
            </div>

            <div class="flex justify-end space-x-2">
                <!-- Tombol Batal -->
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>

                <!-- Tombol Eksekusi Hapus -->
                <flux:button wire:click="delete" variant="danger">
                    Ya, Hapus
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
