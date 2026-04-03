<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlognewsaddController;
use App\Http\Controllers\Admin\CompanyinfoController;
use App\Http\Controllers\Admin\NewblogController;
use App\Http\Controllers\Admin\NewsblogcategoryController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\newsGalleryController;
use App\Http\Controllers\Admin\NewsspecialitycategoryController;
use App\Http\Controllers\Admin\NewsSubcategoryController;
use App\Http\Controllers\Admin\NewsvideogalleryController;
use App\Http\Controllers\Admin\NewsblogsubcategoryController;
use App\Http\Controllers\Admin\SitesettingController;
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

// ── News Blog Category Routes ──────────────────────────────────────────────────
Route::post('newsblogcategory/{id}/toggle-status', [NewsblogcategoryController::class, 'toggleStatus'])->name('newsblogcategory.toggleStatus');
// Bulk delete (AJAX)
Route::delete('newsblogcategory-bulk-destroy', [NewsblogcategoryController::class, 'bulkDestroy']) ->name('newsblogcategory.bulkDestroy');

// Resource routes — সবার শেষে
Route::resource('newsblogcategory', NewsblogcategoryController::class);
// ── News Blog Category Routes ──────────────────────────────────────────────────



// ── News Blog SubCategory Routes ──────────────────────────────────────────────
Route::post('newsblogsubcategory/{id}/toggle-status', [NewsblogsubcategoryController::class, 'toggleStatus'])->name('newsblogsubcategory.toggleStatus');
Route::delete('newsblogsubcategory-bulk-destroy',[NewsblogsubcategoryController::class, 'bulkDestroy'])->name('newsblogsubcategory.bulkDestroy');
Route::resource('newsblogsubcategory', NewsblogsubcategoryController::class);
// ── End News Blog SubCategory Routes ──────────────────────────────────────────


// ── News Blog  Routes ──────────────────────────────────────────────
Route::post('newblog/{id}/toggle-status', [NewblogController::class, 'toggleStatus'])->name('newblog.toggleStatus');
Route::delete('newblog-bulk-destroy', [NewblogController::class, 'bulkDestroy'])->name('newblog.bulkDestroy');
Route::get('newblog/subcategories', [NewblogController::class, 'getSubcategories'])->name('newblog.subcategories');
Route::resource('newblog', NewblogController::class);
// ── End News Blog  Routes ──────────────────────────────────────────


// ── News Routes ──────────────────────────────────────────────────
// AJAX helpers
    Route::get('blognewsadd/subcategories', [BlognewsaddController::class, 'getSubcategories'])->name('blognewsadd.subcategories');
    // Toggle endpoints
    Route::post('blognewsadd/{id}/toggle-status', [BlognewsaddController::class, 'toggleStatus']) ->name('blognewsadd.toggleStatus');
    Route::post('blognewsadd/{id}/toggle-breaking',[BlognewsaddController::class, 'toggleBreaking']) ->name('blognewsadd.toggleBreaking');
    // Bulk delete
    Route::delete('blognewsadd-bulk-destroy', [BlognewsaddController::class, 'bulkDestroy']) ->name('blognewsadd.bulkDestroy');
    // Standard resource (index, create, store, show, edit, update, destroy)
    Route::resource('blognewsadd', BlognewsaddController::class);
// ── End News Routes ──────────────────────────────────────────────]



// ── Site setting Routes ──────────────────────────────────────────────────
// AJAX helpers
    Route::get('sitesetting/subcategories', [SitesettingController::class, 'getSubcategories'])->name('sitesetting.subcategories');
    // Toggle endpoints
    Route::post('sitesetting/{id}/toggle-status', [SitesettingController::class, 'toggleStatus']) ->name('sitesetting.toggleStatus');
    Route::post('sitesetting/{id}/toggle-breaking',[SitesettingController::class, 'toggleBreaking']) ->name('sitesetting.toggleBreaking');
    // Bulk delete
    Route::delete('sitesetting-bulk-destroy', [SitesettingController::class, 'bulkDestroy']) ->name('sitesetting.bulkDestroy');
    // Standard resource (index, create, store, show, edit, update, destroy)
    Route::resource('sitesetting', SitesettingController::class);
// ── End Site setting Routes ──────────────────────────────────────────────

// ── Company Info Routes ──────────────────────────────────────────────────────
Route::post('companyinfo/{id}/toggle-status', [CompanyinfoController::class, 'toggleStatus'])->name('companyinfo.toggleStatus');
Route::delete('companyinfo-bulk-destroy', [CompanyinfoController::class, 'bulkDestroy'])->name('companyinfo.bulkDestroy');
Route::resource('companyinfo', CompanyinfoController::class);
// ── End Company Info Routes ──────────────────────────────────────────────────

