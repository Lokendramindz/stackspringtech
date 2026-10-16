<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('site.*', function ($view) {
            static $pageCopy = null;
            if ($pageCopy === null) {
                $defaults = [];
                foreach (config('page_content', []) as $page => $section) foreach ($section['fields'] as $field => $definition) $defaults["content.$page.$field"] = $definition['default'];
                $stored = SiteSetting::whereIn('key', array_keys($defaults))->pluck('value', 'key')->all();
                $pageCopy = array_merge($defaults, $stored);
            }
            $view->with('pageCopy', $pageCopy);
        });
    }
}
