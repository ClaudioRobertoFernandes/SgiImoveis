<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\{Dashboard\DashboardComponent,
    RealState\RealStateComponent,
    Register\RegisterComponent,
    registerUnit\RegisterUnitComponent,
    Unit\UnitComponent,
    WelcomeComponent};
use Illuminate\Support\Facades\Route;

Route::get('/welcome', WelcomeComponent::class)->name('welcome');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardComponent::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/register-participants', RegisterComponent::class)->name('register-participants');
    Route::get('/teste', RegisterComponent::class)->name('teste');
    Route::get('register-units', RegisterUnitComponent::class)->name('register-units');
    Route::get('units',UnitComponent::class)->name('units');
    Route::get('real-states',RealStateComponent::class)->name('Imobiliarias');
});

require __DIR__.'/auth.php';
