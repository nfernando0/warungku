<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="#">Home</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Transaction</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="mt-4">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Produk</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Amount</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($transactions as $transaction)
                    <flux:table.row>
                        <flux:table.cell>{{ $transaction->user->name }}</flux:table.cell>
                        <flux:table.cell>
                            @if ($transaction->transactionDetails->isNotEmpty())
                                <span>{{ $transaction->transactionDetails->first()->product->name ?? 'Produk tidak ditemukan' }}</span>

                                @if ($transaction->transactionDetails->count() > 1)
                                    <flux:badge size="sm" color="zinc" class="ml-1">
                                        +{{ $transaction->transactionDetails->count() - 1 }} lainnya
                                    </flux:badge>
                                @endif
                            @else
                                <span class="text-zinc-400 italic">-</span>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell class="py-0">
                            <flux:badge color="green" size="sm">Paid</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell variant="strong">$49.00</flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <!-- colspan="2"
                                        karena tabel Anda memiliki 2 kolom (Name & Price) -->
                        <flux:table.cell colspan="4" class="text-center text-zinc-400 py-8">
                            Belum ada data transaction.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </div>
</div>
