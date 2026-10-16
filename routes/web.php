<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// ---- Public site ----
Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/ai-solutions', 'aiSolutions')->name('ai-solutions');
    Route::get('/services', 'services')->name('services');
    Route::get('/services/{slug}', 'service')->name('service');
    Route::get('/packages', 'packages')->name('packages');
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/blog/{slug}', 'post')->name('post');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/sitemap.xml', 'sitemap')->name('sitemap');
    Route::post('/contact', 'send')->middleware('throttle:5,1')->name('contact.send');
});

// ---- Admin ----
Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'form'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->middleware('throttle:3,1')->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:5,1')->name('password.update');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->controller(AdminController::class)->group(function () {
        Route::get('/', 'dashboard')->name('admin');
        Route::get('leads', 'leads')->name('admin.leads');
        Route::put('leads/{lead}', 'leadUpdate')->name('admin.leads.update');
        Route::delete('leads/{lead}', 'leadDelete')->name('admin.leads.delete');
        Route::get('site-settings', 'siteSettings')->name('admin.site-settings');
        Route::post('site-settings', 'siteSettingsUpdate')->name('admin.site-settings.update');
        Route::get('page-content', 'pageContent')->name('admin.page-content');
        Route::get('page-content/{pageKey}/edit', 'pageContentEdit')->where('pageKey', 'home|about|services|packages|blog|contact|ai')->name('admin.page-content.edit');
        Route::put('page-content/{pageKey}', 'pageContentUpdate')->where('pageKey', 'home|about|services|packages|blog|contact|ai')->name('admin.page-content.update');
        Route::delete('page-content/{pageKey}', 'deleteBuiltInPage')->where('pageKey', 'home|about|services|packages|blog|contact|ai')->name('admin.page-content.delete');
        Route::post('page-content/{pageKey}/restore', 'restoreBuiltInPage')->where('pageKey', 'home|about|services|packages|blog|contact|ai')->name('admin.page-content.restore');
        Route::post('page-content/{pageKey}/revisions/{revisionId}/restore', 'restoreSitePageRevision')->where(['pageKey' => 'home|about|services|packages|blog|contact|ai', 'revisionId' => '[0-9]+'])->name('admin.site-page-revisions.restore');

        Route::prefix('{r}')->where(['r' => 'services|packages|posts|pages'])->group(function () {
            Route::get('trash', 'trash')->name('admin.trash');
            Route::post('{id}/restore', 'restore')->name('admin.restore');
            Route::post('{id}/revisions/{revisionId}/restore', 'restoreRevision')->name('admin.revisions.restore');
            Route::get('/', 'index')->name('admin.index');
            Route::get('create', 'create')->name('admin.create');
            Route::post('/', 'store')->name('admin.store');
            Route::get('{id}/edit', 'edit')->name('admin.edit');
            Route::put('{id}', 'update')->name('admin.update');
            Route::delete('{id}', 'destroy')->name('admin.destroy');
        });
    });
});

// Custom CMS pages use root-level slugs and are registered after fixed routes.
Route::get('/{slug}', [SiteController::class, 'customPage'])
    ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*')
    ->name('custom-page');
