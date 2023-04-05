<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class DashboardComponent extends Component
{

    public function render(): View|Application|Factory
    {
        return view('livewire.dashboard.dashboard-component');
    }
}
