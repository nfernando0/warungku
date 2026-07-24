<?php

namespace App\Livewire\Category;

use App\Models\Category;
use \Livewire\WithPagination;
use Livewire\Component;

class Index extends Component
{

    use WithPagination;

    public $categoryId;
    public $name = '';
    public $categoryIdToDelete;

    // Edit
    public function edit($id)
    {
        $category = \App\Models\Category::findOrFail($id);

        $this->categoryId = $category->id;
        $this->name = $category->name;

        // Perintah Flux untuk membuka modal bernama 'edit-category' dari backend
        $this->js("Flux.modal('edit-category').show()");
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = \App\Models\Category::findOrFail($this->categoryId);
        $category->update([
            'name' => $this->name,
        ]);

        // Tutup modal setelah sukses
        $this->js("Flux.modal('edit-category').close()");

        // Beri notifikasi toast
        \Flux\Flux::toast(
            text: 'Kategori berhasil diperbarui.',
            variant: 'success'
        );

        // Reset input form
        $this->reset(['name', 'categoryId']);
    }

    // Delete
    public function confirmDelete($id)
    {
        $this->categoryIdToDelete = $id;
    }

    public function delete()
    {
        if ($this->categoryIdToDelete) {
            $category = \App\Models\Category::findOrFail($this->categoryIdToDelete);
            $category->delete();

            // Tutup modal secara terprogram setelah sukses hapus
            $this->js("Flux.modal('delete-category').close()");

            // Tampilkan toast notifikasi sukses
            \Flux\Flux::toast(
                text: 'Kategori berhasil dihapus.',
                variant: 'success'
            );

            // Reset ID penampung
            $this->reset(['categoryIdToDelete']);
        }
    }

    public function render()
    {
        return view('livewire.category.index', [
            'categories' => Category::paginate(5),
        ]);
    }
}
