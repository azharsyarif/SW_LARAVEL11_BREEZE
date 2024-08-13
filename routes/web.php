<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\IzinSakitController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PICController;
use App\Http\Controllers\POController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekananController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/user', [UserController::class, 'userIndex'])->name('user.index');
Route::get('/user-create', [UserController::class, 'viewCreate'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::delete('/user{id}', [UserController::class, 'destroy'])->name('users.delete');

Route::get('/rekanan', [RekananController::class, 'index'])->name('rekanan.index');
Route::get('/rekanan-create', [RekananController::class, 'viewCreate'])->name('rekanan.create');
Route::post('/rekanan-create', [RekananController::class, 'store'])->name('rekanan.store');
Route::get('/rekanans/{rekanan}/edit', [RekananController::class, 'viewEdit'])->name('rekanan.edit');
Route::put('/rekanans/{rekanan}', [RekananController::class, 'update'])->name('rekanan.update');
Route::delete('/rekanans/{rekanan}', [RekananController::class, 'delete'])->name('rekanan.delete');

Route::get('/pic-customer', [PICController::class, 'index'])->name('pic.index');
Route::get('/pic-customer-create', [PICController::class, 'viewCreate'])->name('pic.createView');
Route::post('/pic-customer-create', [PICController::class, 'create'])->name('pic.customer.store');
Route::get('/pic_customer/{id}/edit', [PICController::class, 'viewEdit'])->name('pic.customer.edit');
Route::put('/pic_customer/{id}', [PICController::class, 'update'])->name('pic.customer.update');
Route::delete('/pic/{pic}', [PICController::class, 'delete'])->name('pic.delete');

Route::get('/pengajuan-cuti', [CutiController::class, 'index'])->name('pengajuan.cuti.index');
Route::get('/create-cuti', [CutiController::class, 'viewCreate'])->name('pengajuan.cuti.create');
Route::post('/pengajuan-cuti', [CutiController::class, 'store'])->name('pengajuan-cuti.store');

Route::get('/pengajuan-izin-sakit', [IzinSakitController::class, 'index'])->name('pengajuan.izin-sakit.index');
Route::get('/create-izin-sakit', [IzinSakitController::class, 'createIndex'])->name('pengajuan.izin-sakit.create');
Route::post('/pengajuan-izin-sakit', [IzinSakitController::class, 'store'])->name('pengajuan-izin-sakit.store');

Route::get('/po-customer', [POController::class, 'index'])->name('marketing.po.index');
Route::get('/po-customer-create', [POController::class, 'viewCreate'])->name('marketing.po.create');
Route::post('/po-customer/store', [POController::class, 'store'])->name('marketing.po.store');
Route::get('/po-customer/edit/{id}', [POController::class, 'viewEdit'])->name('marketing.po.viewEdit');
Route::put('/po-customer/edit/{id}', [POController::class, 'update'])->name('marketing.po.update');
Route::delete('/po-customer/{id}', [POController::class, 'destroy'])->name('marketing.po.destroy');


Route::get('/order-management',[OrderController::class, 'index'])->name('marketing.order.index');
Route::get('/order-view-create', [OrderController::class, 'viewCreate'])->name('marketing.order.viewCreate');
Route::post('/order-create', [OrderController::class, 'store'])->name('marketing.order.store');
Route::get('/fetch-term-agrement/{no_po}', [OrderController::class, 'fetchTermAgrement']);
Route::get('/fetch-orders/{noPo}', [OrderController::class, 'fetchOrders']);

Route::get('/cities', [APIController::class, 'getCities'])->name('cities');

require __DIR__.'/auth.php';
