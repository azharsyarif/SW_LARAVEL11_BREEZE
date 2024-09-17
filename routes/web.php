<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\IzinSakitController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PICController;
use App\Http\Controllers\POController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekananController;
use App\Http\Controllers\UserController;
use App\Models\PengajuanCuti;
use App\Models\PengajuanIzinSakit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    $jumlahPengajuanCuti = PengajuanCuti::where('karyawan_id', $user->id)->count();
    $jumlahPengajuanIzinSakit = PengajuanIzinSakit::where('karyawan_id', $user->id)->count();
    $cutiTersisa = $user->jatah_cuti;

    return view('dashboard', compact('jumlahPengajuanCuti', 'jumlahPengajuanIzinSakit', 'cutiTersisa'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/user', [UserController::class, 'userIndex'])->name('user.index');
Route::get('/user-create', [UserController::class, 'viewCreate'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user{id}', [UserController::class, 'destroy'])->name('users.delete');
Route::get('/profile', [UserController::class, 'viewProfile'])->name('profile.index');


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

Route::get('/invoice-management',[InvoiceController::class, 'index'])->name('marketing.invoice.index');
Route::get('/invoice-management-create', [InvoiceController::class, 'viewCreate'])->name('marketing.invoice.create');
Route::get('marketing/invoice/{id}/edit', [InvoiceController::class, 'viewEdit'])->name('marketing.invoice.edit');
Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('marketing.invoice.show');
Route::put('marketing/invoice/{id}', [InvoiceController::class, 'update'])->name('marketing.invoice.update');
Route::post('/invoice-management-create', [InvoiceController::class, 'store'])->name('invoices.store');

Route::get('/api/get-orders', [InvoiceController::class, 'getOrders'])->name('api.get-orders');

Route::get('/finance/approval-payment', [FinanceController::class, 'indexApprovalPayment'])->name('approvalPayment-index');
Route::get('/approval-payment/create/{invoice}', [FinanceController::class, 'createApprovalPayment'])->name('approval_payment.create');
Route::post('/approval-payment/store', [FinanceController::class, 'storeApprovalPayment'])->name('approval_payment.store');
Route::get('/overdue-invoices', [FinanceController::class, 'overdueInvoices'])->name('overdue.invoices');

// Routes for Attendance management
Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
Route::get('/absensi/create', [AttendanceController::class, 'create'])->name('absensi.create');
Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');

// Example route for fetching user department (adjust as needed)
Route::get('/api/get-user-department', [AttendanceController::class, 'getUserDepartment'])->name('api.get-user-department');

Route::get('/approval-cuti', [ApprovalController::class, 'index'])->name('approval.index');
Route::post('/cuti/{id}/approve', [ApprovalController::class, 'approveCuti'])->name('cuti.approve');
Route::post('/cuti/{id}/reject', [ApprovalController::class, 'rejectCuti'])->name('cuti.reject');

Route::post('/izin-sakit/{id}/approve', [ApprovalController::class, 'approveIzinSakit'])->name('izin-sakit.approve');
Route::post('/izin-sakit/{id}/reject', [ApprovalController::class, 'rejectIzinSakit'])->name('izin-sakit.reject');
require __DIR__.'/auth.php';
