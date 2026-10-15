<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// ---- Public site ----
Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
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
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->controller(AdminController::class)->group(function () {
        Route::get('/', 'dashboard')->name('admin');
        Route::get('leads', 'leads')->name('admin.leads');
        Route::put('leads/{lead}', 'leadUpdate')->name('admin.leads.update');
        Route::delete('leads/{lead}', 'leadDelete')->name('admin.leads.delete');

        Route::prefix('{r}')->where(['r' => 'services|packages|posts|pages'])->group(function () {
            Route::get('/', 'index')->name('admin.index');
            Route::get('create', 'create')->name('admin.create');
            Route::post('/', 'store')->name('admin.store');
            Route::get('{id}/edit', 'edit')->name('admin.edit');
            Route::put('{id}', 'update')->name('admin.update');
            Route::delete('{id}', 'destroy')->name('admin.destroy');
        });
    });
});
