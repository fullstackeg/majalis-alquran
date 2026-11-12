<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\MajlisShow;
use App\Livewire\MajalisIndex;

Route::get('/majalis/{majlis}', MajlisShow::class)->middleware(['auth'])->name('majalis.show');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', MajalisIndex::class)->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
