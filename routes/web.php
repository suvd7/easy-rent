<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Properties + Apartments (owner + admin only)
    Route::middleware('role:owner,admin')->group(function () {
        Route::resource('properties', PropertyController::class);
        Route::resource('properties.apartments', ApartmentController::class);
    });

    // Leases (owner + admin only)
    Route::middleware('role:owner,admin')->group(function () {
        Route::resource('leases', LeaseController::class);
        Route::post('leases/{lease}/end', [LeaseController::class, 'end'])->name('leases.end');
    });

    // Maintenance (all roles can access)
    Route::resource('maintenance', MaintenanceRequestController::class);

    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
        Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');
    });

    Route::get('/my-apartment', [\App\Http\Controllers\TenantController::class, 'apartment'])->name('tenant.apartment');
    // Tenant apartment browsing + lease request
    Route::middleware('role:tenant')->group(function () {
    Route::get('/browse', [\App\Http\Controllers\BrowseController::class, 'index'])->name('browse.index');
    Route::get('/browse/{apartment}', [\App\Http\Controllers\BrowseController::class, 'show'])->name('browse.show');
    Route::post('/browse/{apartment}/request', [\App\Http\Controllers\BrowseController::class, 'requestLease'])->name('browse.request');
});
Route::post('/leases/{lease}/approve', [LeaseController::class, 'approve']);
Route::post('/leases/{lease}/reject', [LeaseController::class, 'reject']);

});

require __DIR__.'/auth.php';