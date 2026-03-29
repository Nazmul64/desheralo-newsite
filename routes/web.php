<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;



Route::get('/', [FrontendController::class, 'frontend'])->name('frontend');
Route::get('admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
