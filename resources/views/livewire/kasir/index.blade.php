<div>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

        <!-- ========================================== -->
        <!-- KOLOM KIRI: KATALOG PRODUK (lg:col-span-7)  -->
        <!-- ========================================== -->
        <div class="lg:col-span-7 xl:col-span-8 space-y-4">

            <!-- Header & Search Bar -->
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <flux:heading size="xl">Kasir Warungku</flux:heading>
                    <flux:subheading size="sm">Pilih produk atau scan barcode untuk transaksi</flux:subheading>
                </div>

                <div class="w-full sm:w-72">
                    <flux:input icon="magnifying-glass" placeholder="Scan Barcode / Cari Produk..." autofocus />
                </div>
            </div>

            <!-- Filter Kategori (Dummy) -->
            <div class="flex gap-2 overflow-x-auto pb-2">
                <flux:button size="sm" variant="primary">Semua</flux:button>
                <flux:button size="sm" variant="subtle">Makanan</flux:button>
                <flux:button size="sm" variant="subtle">Minuman</flux:button>
                <flux:button size="sm" variant="subtle">Sembako</flux:button>
                <flux:button size="sm" variant="subtle">Snack</flux:button>
            </div>

            <!-- Grid Produk (Data Dummy) -->
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-4">

                <!-- Item Dummy 1 -->
                <flux:card class="flex flex-col justify-between p-3 gap-2">
                    <div class="flex items-center justify-between">
                        <flux:badge size="sm" color="zinc">Minuman</flux:badge>
                    </div>
                    <div
                        class="relative my-1 aspect-square w-full overflow-hidden rounded-md bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                        <flux:icon icon="photo" class="h-8 w-8 text-zinc-400" />
                    </div>
                    <div>
                        <flux:heading size="sm" class="line-clamp-1">Teh Pucuk Harum 350ml</flux:heading>
                        <flux:text size="xs" class="text-zinc-500">SKU: MIN-0001</flux:text>
                    </div>
                    <div class="flex items-center justify-between pt-1">
                        <flux:text class="font-bold text-sm">Rp5.000</flux:text>
                        <flux:text size="xs" class="text-zinc-500">Stok: 45</flux:text>
                    </div>
                    <flux:button variant="primary" size="sm" class="w-full mt-1">+ Tambah</flux:button>
                </flux:card>

                <!-- Item Dummy 2 -->
                <flux:card class="flex flex-col justify-between p-3 gap-2">
                    <div class="flex items-center justify-between">
                        <flux:badge size="sm" color="zinc">Makanan</flux:badge>
                    </div>
                    <div
                        class="relative my-1 aspect-square w-full overflow-hidden rounded-md bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                        <flux:icon icon="photo" class="h-8 w-8 text-zinc-400" />
                    </div>
                    <div>
                        <flux:heading size="sm" class="line-clamp-1">Indomie Goreng Spesial</flux:heading>
                        <flux:text size="xs" class="text-zinc-500">SKU: MAK-0002</flux:text>
                    </div>
                    <div class="flex items-center justify-between pt-1">
                        <flux:text class="font-bold text-sm">Rp3.500</flux:text>
                        <flux:text size="xs" class="text-zinc-500">Stok: 120</flux:text>
                    </div>
                    <flux:button variant="primary" size="sm" class="w-full mt-1">+ Tambah</flux:button>
                </flux:card>

                <!-- Item Dummy 3 -->
                <flux:card class="flex flex-col justify-between p-3 gap-2">
                    <div class="flex items-center justify-between">
                        <flux:badge size="sm" color="zinc">Sembako</flux:badge>
                    </div>
                    <div
                        class="relative my-1 aspect-square w-full overflow-hidden rounded-md bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                        <flux:icon icon="photo" class="h-8 w-8 text-zinc-400" />
                    </div>
                    <div>
                        <flux:heading size="sm" class="line-clamp-1">Minyak Goreng Sania 1L</flux:heading>
                        <flux:text size="xs" class="text-zinc-500">SKU: SMB-0003</flux:text>
                    </div>
                    <div class="flex items-center justify-between pt-1">
                        <flux:text class="font-bold text-sm">Rp18.500</flux:text>
                        <flux:text size="xs" class="text-zinc-500">Stok: 15</flux:text>
                    </div>
                    <flux:button variant="primary" size="sm" class="w-full mt-1">+ Tambah</flux:button>
                </flux:card>

                <!-- Item Dummy 4 (Stok Habis) -->
                <flux:card class="flex flex-col justify-between p-3 gap-2 opacity-75">
                    <div class="flex items-center justify-between">
                        <flux:badge size="sm" color="zinc">Snack</flux:badge>
                        <flux:badge size="sm" color="red">Habis</flux:badge>
                    </div>
                    <div
                        class="relative my-1 aspect-square w-full overflow-hidden rounded-md bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                        <flux:icon icon="photo" class="h-8 w-8 text-zinc-400" />
                    </div>
                    <div>
                        <flux:heading size="sm" class="line-clamp-1">Chitato Sapi Panggang 68g</flux:heading>
                        <flux:text size="xs" class="text-zinc-500">SKU: SNK-0004</flux:text>
                    </div>
                    <div class="flex items-center justify-between pt-1">
                        <flux:text class="font-bold text-sm">Rp11.000</flux:text>
                        <flux:text size="xs" class="text-red-500 font-medium">Stok: 0</flux:text>
                    </div>
                    <flux:button variant="primary" size="sm" class="w-full mt-1" disabled>+ Tambah</flux:button>
                </flux:card>

            </div>
        </div>

        <!-- ========================================== -->
        <!-- KOLOM KANAN: KERANJANG BELANJA (lg:col-span-5) -->
        <!-- ========================================== -->
        <div class="lg:col-span-5 xl:col-span-4">
            <flux:card class="sticky top-6 flex flex-col h-[calc(100vh-5rem)] justify-between">

                <!-- Header Keranjang -->
                <div class="flex items-center justify-between border-b pb-3 border-zinc-200 dark:border-zinc-700">
                    <flux:heading class="flex items-center gap-2 p-6">
                        <flux:icon icon="shopping-bag" /> Keranjang Belanja
                    </flux:heading>
                    <flux:button variant="ghost" size="sm" color="red">
                        Bersihkan
                    </flux:button>
                </div>

                <!-- Daftar Item Belanja (Dummy Cart Items) -->
                <div class="flex-1 overflow-y-auto my-3 space-y-3 pr-1">

                    <!-- Item Cart Dummy 1 -->
                    <div class="flex items-center justify-between p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                        <div class="flex-1">
                            <flux:heading size="sm" class="line-clamp-1">Teh Pucuk Harum 350ml</flux:heading>
                            <flux:text size="xs" class="text-zinc-500">Rp5.000 x 2</flux:text>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="number" value="2"
                                class="w-12 text-center text-sm border rounded p-1 dark:bg-zinc-900 dark:border-zinc-700" />
                            <flux:button variant="subtle" size="sm" icon="trash" />
                        </div>
                    </div>

                    <!-- Item Cart Dummy 2 -->
                    <div class="flex items-center justify-between p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                        <div class="flex-1">
                            <flux:heading size="sm" class="line-clamp-1">Minyak Goreng Sania 1L</flux:heading>
                            <flux:text size="xs" class="text-zinc-500">Rp18.500 x 1</flux:text>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="number" value="1"
                                class="w-12 text-center text-sm border rounded p-1 dark:bg-zinc-900 dark:border-zinc-700" />
                            <flux:button variant="subtle" size="sm" icon="trash" />
                        </div>
                    </div>

                </div>

                <!-- Ringkasan & Form Pembayaran Dummy -->
                <div class="border-t pt-3 space-y-3 border-zinc-200 dark:border-zinc-700">
                    <!-- Subtotal & Total -->
                    <div class="space-y-1">
                        <div class="flex justify-between items-center text-sm text-zinc-500">
                            <flux:text>Subtotal Item (3 pcs):</flux:text>
                            <flux:text class="font-medium">Rp28.500</flux:text>
                        </div>
                        <div class="flex justify-between items-center text-lg font-bold">
                            <flux:text>Total Tagihan:</flux:text>
                            <flux:text size="xl" class="text-emerald-600 dark:text-emerald-400">
                                Rp28.500
                            </flux:text>
                        </div>
                    </div>

                    <!-- Input Nominal Uang Bayar -->
                    <div>
                        <flux:input type="number" label="Nominal Uang Diterima" value="50000" />
                    </div>

                    <!-- Shortcut Nominal Uang Cepat (Opsional Kasir) -->
                    <div class="grid grid-cols-3 gap-1">
                        <flux:button size="xs" variant="subtle">Pas</flux:button>
                        <flux:button size="xs" variant="subtle">50.000</flux:button>
                        <flux:button size="xs" variant="subtle">100.000</flux:button>
                    </div>

                    <!-- Display Kembalian -->
                    <div class="flex justify-between items-center text-sm pt-1">
                        <flux:text>Kembalian:</flux:text>
                        <flux:text class="font-bold text-base text-zinc-800 dark:text-zinc-100">
                            Rp21.500
                        </flux:text>
                    </div>

                    <!-- Tombol Bayar -->
                    <flux:button variant="primary" class="w-full">
                        Bayar Sekarang (F2)
                    </flux:button>
                </div>

            </flux:card>
        </div>

    </div>
</div>
