<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="#">Home</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('category.index') }}">Category</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Create</flux:breadcrumbs.item>
    </flux:breadcrumbs>


    <div class="mt-4">
        <form wire:submit="save">
            <flux:field>
                <flux:label>Name</flux:label>
                <flux:input wire:model="name" />
                <flux:error name="name" />
            </flux:field>

            <flux:button type="submit" variant="primary" class="mt-4">Save</flux:button>
        </form>
    </div>
</div>
