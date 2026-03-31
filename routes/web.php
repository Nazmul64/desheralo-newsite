<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsSubcategoryController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;



Route::get('/', [FrontendController::class, 'frontend'])->name('frontend');
Route::get('admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
// News Category
Route::delete('newscategories/bulk-destroy', [NewsCategoryController::class, 'bulkDestroy'])->name('newscategories.bulkDestroy');
Route::resource('newscategories', NewsCategoryController::class);
Route::post('newscategories/{id}/toggle-publish', [NewsCategoryController::class, 'togglePublish'])->name('newscategories.togglePublish');
//End News Category
// ── News Subcategory Routes ──────────────────────────────────────────
Route::delete('newssubcategories/bulk-destroy', [NewsSubcategoryController::class, 'bulkDestroy']) ->name('newssubcategories.bulkDestroy');
Route::post('newssubcategories/{id}/toggle-publish', [NewsSubcategoryController::class, 'togglePublish'])->name('newssubcategories.togglePublish');
Route::resource('newssubcategories', NewsSubcategoryController::class);
// ──End News Subcategory Routes ──────────────────────────────────────────



