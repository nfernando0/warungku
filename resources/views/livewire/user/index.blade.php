<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="#">Home</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>User</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="mt-4">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Username</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column>Role</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($users as $user)
                    <flux:table.row>
                        <flux:table.cell>{{ $user->name }}</flux:table.cell>
                        <flux:table.cell>{{ $user->username }}</flux:table.cell>
                        <flux:table.cell>{{ $user->email }}</flux:table.cell>
                        <flux:table.cell class="py-0">
                            <flux:badge color="green" size="sm">{{ $user->role }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>$49.00</flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <!-- colspan="2"
                                        karena tabel Anda memiliki 2 kolom (Name & Price) -->
                        <flux:table.cell colspan="4" class="text-center text-zinc-400 py-8">
                            Belum ada data user.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </div>
</div>
