<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\{
    Dashboard\DashboardComponent,
    Register\RegisterComponent,
    WelcomeComponent
};
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomeComponent::class)->name('welcome');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardComponent::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/register-participants', RegisterComponent::class)->name('register-participants');
    Route::get('/teste', RegisterComponent::class)->name('teste');
});

require __DIR__.'/auth.php';
