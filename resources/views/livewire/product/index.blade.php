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
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($products as $product)
                    <flux:table.row>
                        <flux:table.cell>{{ $product->name }}</flux:table.cell>
                        <flux:table.cell>{{ $product->sku }}</flux:table.cell>
                        <flux:table.cell>{{ $product->price }}</flux:table.cell>
                        <flux:table.cell>{{ $product->stock }}</flux:table.cell>
                        <flux:table.cell>{{ $product->unit }}</flux:table.cell>
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
</div>
