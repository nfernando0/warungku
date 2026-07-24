<div>
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
</div>
