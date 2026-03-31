<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\newsGalleryController;
use App\Http\Controllers\Admin\NewsspecialitycategoryController;
use App\Http\Controllers\Admin\NewsSubcategoryController;
use App\Http\Controllers\Admin\NewsvideogalleryController;
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

//  News Speciality List Routes ──────────────────────────────────────────
Route::resource('speciality', NewsspecialitycategoryController::class)->only(['index', 'store', 'update', 'destroy']);
// Bulk delete route
Route::delete('speciality-bulk-destroy', [NewsspecialitycategoryController::class, 'bulkDestroy']) ->name('speciality.bulkDestroy');
// End  News Speciality List Routes ──────────────────────────────────────────

//  News Gallery List Routes ──────────────────────────────────────────
Route::resource('newsgallery', newsGalleryController::class);
// Toggle publish status (AJAX)
Route::post('newsgallery/{id}/toggle-status', [newsGalleryController::class, 'toggleStatus']) ->name('newsgallery.toggleStatus');
// Bulk delete
Route::delete('newsgallery-bulk-destroy', [newsGalleryController::class, 'bulkDestroy'])->name('newsgallery.bulkDestroy');
//  News Gallery List Routes End ──────────────────────────────────────────

// ── News Video Gallery Routes ──────────────────────────────────────────────────
// Toggle publish status (AJAX)
Route::post('newsvideogallery/{id}/toggle-status', [NewsvideogalleryController::class, 'toggleStatus'])->name('newsvideogallery.toggleStatus');

// Bulk delete (AJAX)
Route::delete('newsvideogallery-bulk-destroy', [NewsvideogalleryController::class, 'bulkDestroy']) ->name('newsvideogallery.bulkDestroy');

// Resource routes — সবার শেষে
Route::resource('newsvideogallery', NewsvideogalleryController::class);

// ── End News Video Gallery Routes ──────────────────────────────────────────────

