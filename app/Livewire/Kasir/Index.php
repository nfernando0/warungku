<?php

namespace App\Livewire\Kasir;

use Livewire\Component;

use Livewire\Attributes\Layout;

#[Layout('layouts.kasir')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.kasir.index');
    }
}
