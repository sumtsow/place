<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Admin\CategoryController as CategoryAdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [CategoryController::class, 'index'])->name('home');

Route::get('/cat/{id}', [CategoryController::class, 'show'])->name('category');

Route::get('/item/{id}', [ItemController::class, 'show'])->name('item');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'can:admin, App\Models\User'])->name('dashboard');

Route::prefix('admin')->group(function () {
	Route::get('/category', [CategoryAdminController::class, 'index'])->name('categoryAdmin');
	Route::get('/category/{id}', [CategoryAdminController::class, 'show'])->name('categoryShow');
})->middleware(['can:admin, App\Models\User']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
