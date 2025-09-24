<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\CategoryController as CategoryAdminController;
use App\Http\Controllers\Admin\DistributorController as DistributorAdminController;
use App\Http\Controllers\Admin\ItemController as ItemAdminController;
use App\Http\Controllers\Admin\ParameterController as ParameterAdminController;
use App\Http\Controllers\Admin\OrderController as OrderAdminController;
use App\Http\Controllers\Admin\UnitController as UnitAdminController;
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
	Route::get('/distributors', [DistributorAdminController::class, 'index'])->name('distributor.admin');
	Route::get('/distributor/0', [DistributorAdminController::class, 'create'])->name('distributor.create');
	Route::get('/distributor/items/{id}', [DistributorAdminController::class, 'show'])->name('distributor.show');
	Route::put('/distributor/items', [DistributorAdminController::class, 'updateItems'])->name('distributor.items');
	Route::put('/distributor/item/state', [DistributorAdminController::class, 'updateItemState'])->name('distributor.updateItemState');
	Route::get('/distributor/{id}', [DistributorAdminController::class, 'edit'])->name('distributor.edit');
	Route::put('/distributor/0', [DistributorAdminController::class, 'store'])->name('distributor.store');
	Route::put('/distributor/{id}', [DistributorAdminController::class, 'update'])->name('distributor.update');
	Route::get('/items', [ItemAdminController::class, 'index'])->name('item.admin');
	Route::get('/item/parameters/{id}', [ItemAdminController::class, 'show'])->name('item.show');
	Route::put('/item/parameters/{id}', [ItemAdminController::class, 'updateParams'])->name('item-param.update');
	Route::get('/item/value/{id}/{pid}', [ItemAdminController::class, 'editValue'])->name('value.edit');
	Route::put('/item/value/', [ItemAdminController::class, 'updateValue'])->name('value.update');
	Route::get('/item/0', [ItemAdminController::class, 'create'])->name('item.create');
	Route::get('/item/{id}', [ItemAdminController::class, 'edit'])->name('item.edit');
	Route::put('/item/0', [ItemAdminController::class, 'store'])->name('item.store');
	Route::put('/item/{id}', [ItemAdminController::class, 'update'])->name('item.update');
	Route::get('/orders', [OrderAdminController::class, 'index'])->name('order.admin');
	Route::get('/order/0', [OrderAdminController::class, 'create'])->name('order.create');
	Route::get('/order/{id}', [OrderAdminController::class, 'edit'])->name('order.edit');
	Route::put('/order/0', [OrderAdminController::class, 'store'])->name('order.store');
	Route::put('/order/{id}', [OrderAdminController::class, 'update'])->name('order.update');
	Route::get('/posts/{id}', [PostController::class, 'index'])->name('post.admin');
	Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');
	Route::get('/comment/{id}', [CommentController::class, 'show'])->name('comment.show');
	Route::get('/parameters', [ParameterAdminController::class, 'index'])->name('parameter.admin');
	Route::get('/parameter/0', [ParameterAdminController::class, 'create'])->name('parameter.create');
	Route::get('/parameter/{id}', [ParameterAdminController::class, 'edit'])->name('parameter.edit');
	Route::put('/parameter/0', [ParameterAdminController::class, 'store'])->name('parameter.store');
	Route::put('/parameter/{id}', [ParameterAdminController::class, 'update'])->name('parameter.update');
	Route::get('/units', [UnitAdminController::class, 'index'])->name('unit.admin');
	Route::get('/unit/0', [UnitAdminController::class, 'create'])->name('unit.create');
	Route::get('/unit/{id}', [UnitAdminController::class, 'edit'])->name('unit.edit');
	Route::put('/unit/0', [UnitAdminController::class, 'store'])->name('unit.store');
	Route::put('/unit/{id}', [UnitAdminController::class, 'update'])->name('unit.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	Route::put('/post/0', [PostController::class, 'store'])->name('post.store');
	Route::put('/post/{id}', [PostController::class, 'update'])->name('post.update');
	Route::put('/comment/0', [CommentController::class, 'store'])->name('comment.store');
	Route::put('/comment/{id}', [CommentController::class, 'update'])->name('comment.update');
});

require __DIR__.'/auth.php';
