<?php

namespace App\Http\Livewire;

use Livewire\Component;

class WelcomeComponent extends Component
{
    public function render()
    {
        return view('livewire.welcome-component')->layout('livewire.welcome-component');
    }
}
