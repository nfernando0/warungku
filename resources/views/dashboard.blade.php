<x-layouts::app :title="__('Dashboard')">
    <div class="flex flex-col gap-4">
        <!-- Grid 3 Stat Cards (Baris Atas) -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">

            <!-- Card 1: Total Omset/Penjualan -->
            <div
                class="relative flex flex-col justify-between p-5 rounded-xl border border-neutral-200 bg-white dark:bg-neutral-900 dark:border-neutral-800 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Penjualan Hari
                        Ini</span>
                    <div
                        class="p-2 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400">
                        <flux:icon icon="banknotes" class="size-5" />
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                        Rp{{ number_format($todayEarnings ?? 0, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1 flex items-center gap-1 font-medium">
                        <flux:icon icon="arrow-trending-up" class="size-3" />
                        +12% dibanding kemarin
                    </p>
                </div>
            </div>

            <!-- Card 2: Jumlah Transaksi -->
            <div
                class="relative flex flex-col justify-between p-5 rounded-xl border border-neutral-200 bg-white dark:bg-neutral-900 dark:border-neutral-800 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Transaksi Hari Ini</span>
                    <div class="p-2 rounded-lg bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400">
                        <flux:icon icon="shopping-cart" class="size-5" />
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                        {{ $todayTransactionsCount ?? 0 }} Transaksi
                    </h3>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                        Transaksi berhasil diproses
                    </p>
                </div>
            </div>

            <!-- Card 3: Total Produk -->
            <div
                class="relative flex flex-col justify-between p-5 rounded-xl border border-neutral-200 bg-white dark:bg-neutral-900 dark:border-neutral-800 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Produk Aktif</span>
                    <div class="p-2 rounded-lg bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400">
                        <flux:icon icon="cube" class="size-5" />
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                        {{ $totalProductsCount ?? 0 }} Produk
                    </h3>
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-1 font-medium">
                        {{ $lowStockProductsCount ?? 0 }} produk stok menipis
                    </p>
                </div>
            </div>

        </div>

        <!-- Area Konten Utama (Baris Bawah: Tabel Transaksi Terakhir / Grafik) -->
        <div
            class="relative flex-1 min-h-[400px] p-5 rounded-xl border border-neutral-200 bg-white dark:bg-neutral-900 dark:border-neutral-800 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-neutral-100">Transaksi Terakhir</h2>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">Daftar transaksi penjualan terbaru hari
                        ini</p>
                </div>
                <flux:button href="/kasir" size="sm" variant="primary" icon="plus">
                    Transaksi Baru
                </flux:button>
            </div>

            <!-- Tabel Transaksi -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-neutral-600 dark:text-neutral-300">
                    <thead
                        class="border-b border-neutral-200 dark:border-neutral-800 text-xs font-semibold uppercase text-neutral-400">
                        <tr>
                            <th class="py-3 px-2">Kode TRX</th>
                            <th class="py-3 px-2">Pelanggan</th>
                            <th class="py-3 px-2">Total</th>
                            <th class="py-3 px-2">Metode</th>
                            <th class="py-3 px-2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                        @forelse ($recentTransactions ?? [] as $trx)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                                <td
                                    class="py-3 px-2 font-mono text-xs font-medium text-neutral-900 dark:text-neutral-100">
                                    {{ $trx->transaction_code }}
                                </td>
                                <td class="py-3 px-2">{{ $trx->customer_name }}</td>
                                <td class="py-3 px-2 font-semibold text-neutral-900 dark:text-neutral-100">
                                    Rp{{ number_format($trx->total, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-2 uppercase text-xs">{{ $trx->payment_method }}</td>
                                <td class="py-3 px-2">
                                    <flux:badge size="sm" color="emerald">Selesai</flux:badge>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-neutral-400">
                                    Belum ada transaksi hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
