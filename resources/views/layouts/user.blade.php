<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Portal User' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 antialiased">

    <!-- Navbar Khusus User Biasa / Publik -->
    <livewire:navbar />

    <!-- Konten halaman dipasang di sini -->
    <main class="max-w-6xl mx-auto p-4 mt-6">
        {{ $slot }}
    </main>

    <!-- Footer Khusus -->
    <footer class="text-center text-slate-400 text-sm mt-12 py-6 border-t border-slate-200">
        &copy; {{ date('Y') }} Portal Pelanggan.
    </footer>

    @fluxScripts

    <!-- Wajib di bawah jika menggunakan Flux UI agar Toast/Modal jalan -->
    <flux:toast />
</body>

</html>
