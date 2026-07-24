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
    <nav class="bg-indigo-600 text-white shadow-sm p-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="/" class="font-bold text-xl">Portal Pelanggan</a>
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Ditampilkan HANYA jika user SUDAH login -->
                    <flux:dropdown align="end">
                        <!-- Trigger Dropdown (Gunakan nama user atau avatar/icon) -->
                        <flux:button variant="ghost" icon-trailing="chevron-down">
                            {{ auth()->user()->name ?? 'Akun Saya' }}
                        </flux:button>

                        <flux:menu>
                            <!-- Profil Saya -->
                            <flux:menu.item href="{{ route('profile.index') }}" icon="user">
                                Profil Saya
                            </flux:menu.item>

                            <!-- Pesanan (+ Cart Badge) -->
                            <flux:menu.item href="{{ route('pesanan.index') }}" icon="shopping-bag">
                                <div class="flex items-center justify-between w-full">
                                    <span>Pesanan</span>
                                    <livewire:cart-badge />
                                </div>
                            </flux:menu.item>

                            <flux:separator />

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                    variant="danger">
                                    Log Out
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                @else
                    <!-- Ditampilkan HANYA jika user BELUM login -->
                    <flux:button href="{{ route('login') }}" variant="primary" size="sm">
                        Login
                    </flux:button>
                @endauth
            </div>
        </div>
    </nav>

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
