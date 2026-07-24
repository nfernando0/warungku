<div class="max-w-4xl mx-auto py-8 px-4 space-y-6">

    <!-- Header Profil Card -->
    <flux:card class="flex flex-col md:flex-row items-center gap-6 p-6">

        <!-- Avatar & Upload -->
        <div class="relative">
            @if ($img)
                <img src="{{ $img->temporaryUrl() }}"
                    class="w-24 h-24 rounded-full object-cover border border-zinc-200 dark:border-zinc-700 shadow-sm"
                    alt="Avatar Preview">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=0D9488&color=fff"
                    class="w-24 h-24 rounded-full object-cover border border-zinc-200 dark:border-zinc-700 shadow-sm"
                    alt="Avatar">
            @endif

            @if ($isEditing)
                <label
                    class="absolute bottom-0 right-0 p-2 bg-zinc-900 text-white rounded-full hover:bg-zinc-700 transition cursor-pointer shadow-md">
                    <flux:icon.camera class="w-4 h-4" />
                    <input type="file" wire:model="img" class="hidden" accept="image/*">
                </label>
            @endif
        </div>

        <!-- Info Ringkas -->
        <div class="text-center md:text-left space-y-1 grow">
            <flux:heading size="xl" level="1">{{ $name }}</flux:heading>
            <flux:subheading>{{ $email }}</flux:subheading>

            <div class="flex items-center justify-center md:justify-start gap-2 pt-2">
                <flux:badge color="emerald" size="sm" inset="top bottom">Active</flux:badge>
                <span class="text-xs text-zinc-400">• Joined May 2026</span>
            </div>
        </div>

        <!-- Tombol Toggle Mode -->
        <div>
            @if (!$isEditing)
                <flux:button wire:click="toggleEdit" variant="outline" icon="pencil">
                    Edit Profil
                </flux:button>
            @else
                <flux:button wire:click="toggleEdit" variant="ghost" icon="x-mark">
                    Batal Edit
                </flux:button>
            @endif
        </div>
    </flux:card>

    <!-- Detail Form Card -->
    <flux:card class="p-6 space-y-6">
        <div>
            <flux:heading size="lg">Informasi Pribadi</flux:heading>
            <flux:subheading>
                @if ($isEditing)
                    <span class="text-amber-600 dark:text-amber-400 font-medium">Mode edit aktif — Silakan sesuaikan
                        data Anda di bawah ini.</span>
                @else
                    Data pribadi dan detail kontak terdaftar Anda.
                @endif
            </flux:subheading>
        </div>

        <flux:separator />

        <form wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Nama Lengkap</flux:label>
                    <flux:input wire:model="name" :disabled="!$isEditing" />
                    <flux:error name="name" />
                </flux:field>

                <flux:field>
                    <flux:label>Username</flux:label>
                    <flux:input wire:model="username" :disabled="!$isEditing" />
                    <flux:error name="username" />
                </flux:field>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Email</flux:label>
                    <flux:input type="email" wire:model="email" :disabled="!$isEditing" />
                    <flux:error name="email" />
                </flux:field>

                <flux:field>
                    <flux:label>Nomor Telepon</flux:label>
                    <flux:input wire:model="phone" :disabled="!$isEditing" />
                    <flux:error name="phone" />
                </flux:field>
            </div>

            <flux:field>
                <flux:label>Bio / Deskripsi</flux:label>
                <flux:textarea wire:model="bio" rows="3" :disabled="!$isEditing" />
                <flux:error name="bio" />
            </flux:field>

            <!-- Action Buttons (Tampil Hanya Saat Editing) -->
            @if ($isEditing)
                <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <flux:button type="button" wire:click="toggleEdit" variant="ghost">
                        Batal
                    </flux:button>
                    <flux:button type="submit" variant="primary" icon="check">
                        Simpan Perubahan
                    </flux:button>
                </div>
            @endif
        </form>
    </flux:card>

</div>
