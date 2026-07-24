<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="#">Home</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('product.index') }}">Product</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Create</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form wire:submit="save">

        <flux:field class="mt-4">
            <flux:label badge="Required">Name</flux:label>
            <flux:input wire:model="name" />
            <flux:error name="name" />
        </flux:field>

        <flux:field class="mt-4">
            <flux:label badge="Required">Harga</flux:label>
            <flux:input wire:model="price" type="number" />
            <flux:error name="price" />
        </flux:field>

        <div class="flex gap-4">
            <flux:field class="mt-4">
                <flux:label badge="Required">Stok</flux:label>
                <flux:input wire:model="stock" type="number" />
                <flux:error name="stock" />
            </flux:field>
            <flux:field class="mt-4">
                <flux:label badge="Required">Unit</flux:label>
                <flux:input wire:model="unit" />
                <flux:error name="unit" />
            </flux:field>
        </div>

        <div class="mt-4">
            <flux:select wire:model.live="category_id" label="Kategori">
                <flux:select.option value="">Pilih kategori</flux:select.option>
                @foreach ($categories as $category)
                    <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <div class="flex gap-2 items-end mt-4">
            <flux:input wire:model="sku" label="SKU" />
            <flux:button wire:click="regenerateSku" icon="arrow-path" variant="ghost" />
        </div>

        <flux:button type="submit" variant="primary" class="mt-4">Save</flux:button>
    </form>
</div>
