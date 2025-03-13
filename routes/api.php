<?php

use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/holidays', [UserController::class, 'getHolidays'])->name('api.holidays');
