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
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard'); // Ensure this exists
    Route::get('/user/applyleave', [UserController::class, 'applyleave'])->name('user.applyleave');
    Route::get('/user/leavehistory', [UserController::class, 'leavehistory'])->name('user.leavehistory');
    Route::post('/user/storeleave', [UserController::class, 'storeleave'])->name('user.storeleave');
    Route::get('/user/editleave/{id}', [UserController::class, 'editLeave'])->name('user.editleave'); // Add this
    Route::patch('/user/updateleave/{id}', [UserController::class, 'updateLeave'])->name('user.updateleave');
    Route::delete('/user/deleteleave/{id}', [UserController::class, 'deleteLeave'])->name('user.deleteleave');
});

// admin routes
Route::middleware(['auth', 'adminMiddleware'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/manageleave', [AdminController::class, 'manageleave'])->name('admin.manageleave');
    Route::get('/admin/manageuser', [AdminController::class, 'manageuser'])->name('admin.manageuser');
    Route::delete('/admin/deleteuser/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteuser');
    Route::patch('/admin/approveleave/{id}', [AdminController::class, 'approveLeave'])->name('admin.approveleave');
    Route::patch('/admin/rejectleave/{id}', [AdminController::class, 'rejectLeave'])->name('admin.rejectleave');

});

require __DIR__.'/auth.php';
