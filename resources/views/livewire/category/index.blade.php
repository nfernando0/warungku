<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="#">Home</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Category</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="mt-4">
        <flux:button href="{{ route('category.create') }}">Tambah Category</flux:button>
    </div>

    <div class="mt-4 rounded-md p-3 bg-white dark:bg-neutral-900 shadow">
        <flux:table :paginate="$categories">
            <flux:table.columns>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($categories as $category)
                    <flux:table.row>
                        <flux:table.cell>{{ $category->name }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-4">
                                <flux:modal.trigger name="edit-category">
                                    <flux:button wire:click="edit({{ $category->id }})" icon="pencil" size="xs">Edit
                                    </flux:button>
                                </flux:modal.trigger>
                                <flux:modal.trigger name="delete-category">
                                    <flux:button wire:click="confirmDelete({{ $category->id }})" icon="trash"
                                        size="xs" variant="danger">
                                        Delete
                                    </flux:button>
                                </flux:modal.trigger>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <!-- colspan="2"
                                        karena tabel Anda memiliki 2 kolom (Name & Price) -->
                        <flux:table.cell colspan="1" class="text-center text-zinc-400 py-8">
                            Belum ada data kategori.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </div>

    {{-- Modal Edit Category --}}
    <flux:modal name="edit-category" class="md:w-96" flyout>
        <form wire:submit="update">
            <div>
                <flux:heading size="lg">Edit Kategori</flux:heading>
                <flux:subheading>Ubah nama kategori yang Anda pilih.</flux:subheading>
            </div>

            <div class="space-y-6 mt-6">
                <flux:field>
                    <flux:label>Nama Kategori</flux:label>
                    <flux:input wire:model="name" />
                    <flux:error name="name" />
                </flux:field>
            </div>

            <div class="flex space-x-2 mt-6">
                <flux:spacer />
                <!-- Tombol batal otomatis menutup modal -->
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">Simpan Perubahan</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Modal Notifikasi Delete --}}
    <flux:modal name="delete-category" class="md:w-96">
        <form wire:submit.prevent="delete">
            <div class="space-y-2">
                <flux:heading size="lg">Hapus Kategori?</flux:heading>
                <flux:subheading>
                    Apakah Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.
                </flux:subheading>
            </div>

            <div class="flex space-x-2 mt-6">
                <flux:spacer />

                <!-- Tombol Batal -->
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>

                <!-- Tombol Konfirmasi Hapus -->
                <flux:button type="submit" variant="danger">
                    Ya, Hapus
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
