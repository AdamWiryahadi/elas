<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// user routes
Route::middleware(['auth', 'userMiddleware'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard'); // Ensure this exists
    Route::get('/applyleave', [UserController::class, 'applyleave'])->name('user.applyleave');
    Route::get('/leavehistory', [UserController::class, 'leavehistory'])->name('user.leavehistory');
    Route::post('/storeleave', [UserController::class, 'storeleave'])->name('user.storeleave');
    Route::get('/editleave/{id}', [UserController::class, 'editLeave'])->name('user.editleave'); // Add this
    Route::patch('/updateleave/{id}', [UserController::class, 'updateLeave'])->name('user.updateleave');
    Route::delete('/deleteleave/{id}', [UserController::class, 'deleteLeave'])->name('user.deleteleave');
    Route::get('/holidays', [UserController::class, 'getHolidays'])->name('api.holidays');
});

// admin routes
Route::middleware(['auth', 'adminMiddleware'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::put('/admin/settings/update', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    // Holiday Management within Settings
    Route::post('/admin/settings/holidays', [AdminController::class, 'storeHoliday'])->name('admin.holidays.store'); // Add Holiday
    Route::put('/admin/settings/holidays/{id}', [AdminController::class, 'updateHoliday'])->name('admin.holidays.update'); // Edit Holiday
    Route::delete('/admin/settings/holidays/{id}', [AdminController::class, 'deleteHoliday'])->name('admin.holidays.delete'); // Delete Holiday
    
    Route::get('/admin/manageleave', [AdminController::class, 'manageleave'])->name('admin.manageleave');
    Route::patch('/admin/approveleave/{id}', [AdminController::class, 'approveLeave'])->name('admin.approveleave');
    Route::patch('/admin/rejectleave/{id}', [AdminController::class, 'rejectLeave'])->name('admin.rejectleave');
    Route::get('/admin/loghistory', [AdminController::class, 'logHistory'])->name('admin.loghistory');

    Route::get('/admin/manageuser', [AdminController::class, 'manageuser'])->name('admin.manageuser');
    Route::get('/admin/createuser', [AdminController::class, 'createUser'])->name('admin.createuser');
    Route::get('/admin/users/{id}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.resetpassword');
    Route::delete('/admin/deleteuser/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteuser');
    Route::get('/admin/createuser', [AdminController::class, 'createUser'])->name('admin.createuser');
    Route::post('/admin/storeuser', [AdminController::class, 'storeUser'])->name('admin.storeuser');
    Route::patch('/admin/manageuser/{id}/quota', [AdminController::class, 'updateQuota'])->name('admin.updatequota');


});

require __DIR__.'/auth.php';
