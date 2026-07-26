<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kasir - Warungku</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @fluxStyles --}}
</head>

<body class="min-h-screen bg-zinc-100 dark:bg-zinc-900 antialiased">

    <!-- Header Minimalis Khusus Kasir -->
    <header
        class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-3 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <flux:heading size="lg" class="font-bold text-emerald-600">WARUNGKU <span
                    class="text-xs text-zinc-500 font-normal">POS System</span></flux:heading>
        </div>

        <!-- Info Kasir Bertugas -->
        <div class="flex items-center gap-4 text-sm">
            <span class="text-zinc-500">Kasir: <strong
                    class="text-zinc-800 dark:text-zinc-200">{{ auth()->user()->name ?? 'Kasir' }}</strong></span>

            <!-- Tombol Kembali ke Dashboard Admin (Jika role admin) -->
            @if (auth()->user()?->role === 'admin')
                <flux:button :href="route('dashboard')" variant="subtle" size="sm" icon="arrow-left" wire:navigate>
                    Dashboard
                </flux:button>
            @endif
        </div>
    </header>

    <!-- Content Halaman Kasir (Tanpa Sidebar) -->
    <main class="p-4 sm:p-6">
        {{ $slot }}
    </main>

    @fluxScripts
</body>

</html>
