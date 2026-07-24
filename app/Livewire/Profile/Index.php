<?php

namespace App\Livewire\Profile;

use Flux\Flux;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.user')]
class Index extends Component
{
    use WithFileUploads;

    public bool $isEditing = false;

    // Form fields
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $phone = '';
    public string $bio = '';
    public $img;

    public function mount(): void
    {
        $user = auth()->user();

        $this->name = $user->name ?? 'Alex Developer';
        $this->username = $user->username ?? 'alexdev';
        $this->email = $user->email ?? 'alex.developer@example.com';
        $this->phone = $user->phone ?? '+62 812 3456 7890';
        $this->bio = $user->bio ?? 'Full-stack web developer yang berfokus pada ekosistem Laravel dan Flux UI.';
    }

    public function toggleEdit(): void
    {
        $this->isEditing = !$this->isEditing;
    }

    public function save(): void
    {
        if (!$this->isEditing) return;

        $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'img' => 'nullable|image|max:2048', // Max 2MB
        ]);

        // Logika simpan user
        $user = auth()->user();
        if ($user) {
            $user->update([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'phone' => $this->phone,
                'bio' => $this->bio,
            ]);

            if ($this->img) {
                $path = $this->img->store('avatars', 'public');
                $user->update(['avatar' => $path]);
            }
        }

        $this->isEditing = false;

        // Memunculkan Toast Notifikasi Bawaan Flux
        Flux::toast(
            text: 'Profil berhasil diperbarui.',
            heading: 'Sukses',
            variant: 'success'
        );
    }

    public function render()
    {
        return view('livewire.profile.index');
    }
}
