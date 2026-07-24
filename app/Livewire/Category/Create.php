<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Flux\Flux;
use Livewire\Component;

class Create extends Component
{
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $this->name
        ]);

        $this->reset(['name']);

        Flux::toast(
            text: 'Kategori berhasil dibuat.',
            variant: 'success',
            heading: 'Sukses'
        );

        return $this->redirect(route('category.index'), navigate: true);
    }
    public function render()
    {
        return view('livewire.category.create');
    }
}
