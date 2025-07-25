<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Admin\CategoryController as CategoryAdminController;
use App\Http\Controllers\Admin\ItemController as ItemAdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [CategoryController::class, 'index'])->name('home');

Route::get('/cat/{id}', [CategoryController::class, 'show'])->name('category');

Route::get('/item/{id}', [ItemController::class, 'show'])->name('item');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'can:admin, App\Models\User'])->name('dashboard');

Route::middleware('auth')->prefix('admin')->group(function () {
	Route::get('/categories', [CategoryAdminController::class, 'index'])->name('category.admin');
	Route::get('/category/0', [CategoryAdminController::class, 'create'])->name('category.create');
	Route::get('/category/{id}', [CategoryAdminController::class, 'edit'])->name('category.edit');
	Route::put('/category/0', [CategoryAdminController::class, 'store'])->name('category.store');
	Route::put('/category/{id}', [CategoryAdminController::class, 'update'])->name('category.update');
	Route::get('/items', [ItemAdminController::class, 'index'])->name('item.admin');
	Route::get('/item/0', [ItemAdminController::class, 'create'])->name('item.create');
	Route::get('/item/{id}', [ItemAdminController::class, 'edit'])->name('item.edit');
	Route::put('/item/0', [ItemAdminController::class, 'store'])->name('item.store');
	Route::put('/item/{id}', [ItemAdminController::class, 'update'])->name('item.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
