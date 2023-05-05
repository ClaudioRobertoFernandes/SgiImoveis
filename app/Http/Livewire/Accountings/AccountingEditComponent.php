<?php

namespace App\Http\Livewire\Accountings;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class AccountingEditComponent extends Component
{
    public $userId;
    public function mount($userId): void
    {
        ds($this->userId)->warning();
    }
    public function render(): View|Application|Factory
    {
        return view('livewire.accountings.accounting-edit-component');
    }
}
