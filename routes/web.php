<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackOrderController;

Route::get('/', function () {
    return view('guest');
});

Route::get('/salveowell-login', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::put('/change-password/{user}', [AuthController::class, 'changePassword'])->name('changePassword');

});

Route::middleware(['auth', 'SuperAdminOnly'])->group(function () {

    Route::prefix('branches')->group(function () {
        Route::get('/', [BranchController::class, 'index'])->name('branch.index');
        Route::get('/{branch}/view', [BranchController::class, 'view'])->name('branch.view');
        Route::post('/add', [BranchController::class, 'addBranch'])->name('branch.addBranch');
        Route::put('/{branch}/update', [BranchController::class, 'updateBranch'])->name('branch.updateBranch');
    });

    Route::prefix('employee-maintenance/roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::get('/{role}/view', [RoleController::class, 'view'])->name('role.view');
        Route::post('/add', [RoleController::class, 'addRole'])->name('role.addRole');
        Route::put('/{role}/update', [RoleController::class, 'updateRole'])->name('role.updateRole');
    });
    
});

Route::middleware(['auth', 'AdminOnly'])->group(function () {

    Route::prefix('employee-maintenance/accounts')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('account.index');
        Route::get('/{user}/view', [AccountController::class, 'view'])->name('account.view');
        Route::post('/add', [AccountController::class, 'addAccount'])->name('account.addAccount');
        Route::put('/{user}/update', [AccountController::class, 'updateAccount'])->name('account.updateAccount');
        Route::put('/{user}/reset-password', [AccountController::class, 'resetPassword'])->name('account.resetPassword');
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        Route::get('/create', [OrderController::class, 'create'])->name('order.create');
        Route::post('/store', [OrderController::class, 'store'])->name('order.store');
        Route::post('/bulk-store', [OrderController::class, 'bulkStore'])->name('order.bulkStore');
        Route::get('/{order}', [OrderController::class, 'view'])->name('order.view');
        Route::put('/{order}/update', [OrderController::class, 'update'])->name('order.update');
        Route::delete('/{order}/delete', [OrderController::class, 'destroy'])->name('order.destroy');
    });
    
});

Route::middleware(['auth', 'RiderOnly'])->group(function () {

    Route::prefix('deliveries')->group(function () {
        Route::get('/', [DeliveryController::class, 'index'])->name('delivery.index');
        Route::get('/{order}', [DeliveryController::class, 'view'])->name('delivery.view');
        Route::put('/{order}/delivered', [DeliveryController::class, 'markDelivered'])->name('order.markDelivered');
        Route::put('/{order}/cancelled', [DeliveryController::class, 'markCancelled'])->name('order.markCancelled');
        Route::put('/delivery/{order}/reschedule', [DeliveryController::class, 'markReschedule'])->name('delivery.reschedule');

    });
    
});

Route::post('/track-order/search', [TrackOrderController::class, 'search'])->name('track.order.search');
Route::post('/track/order/verify', [TrackOrderController::class, 'verifyOrder'])->name('track.order.verify');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
