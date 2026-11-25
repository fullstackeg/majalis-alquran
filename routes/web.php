<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// User Livewire components
use App\Livewire\MajlisShow;
use App\Livewire\MajalisIndex;
use App\Livewire\MyContributions;
// Admin Livewire components
use App\Livewire\Admin\TadabburModeration;
use App\Livewire\Admin\MajlisManager;
use App\Livewire\Admin\AyahManager;
use App\Livewire\Admin\Dashboard as AdminDashboard;

// 1. الصفحة الرئيسية أصبحت تعرض المجalis لجميع الزوار (بدون auth)
Route::get('/', MajalisIndex::class)->name('majalis.index');

// 2. تصفح تفاصيل مجلس معين متاح للجميع أيضاً (بدون auth)
Route::get('/majalis/{majlis}', MajlisShow::class)->name('majalis.show');

// 3. لوحة التحكم والمسارات الخاصة بالأعضاء والمشرفين
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', MajalisIndex::class)->name('dashboard'); // للإحالة المتوافقة
    Route::get('/my-contributions', MyContributions::class)->name('my-contributions');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/tadabburat/pending', TadabburModeration::class)->name('tadabburat.pending');
    Route::get('/majalis', MajlisManager::class)->name('majalis.index');
    Route::get('/majalis/{majlis}/ayat', AyahManager::class)->name('majalis.ayat');
});

require __DIR__ . '/auth.php';