<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $guarded = [];

    public static function forPage(string $key): object
    {
        $defaults = config("stackspring.seo_pages.$key", []);
        $setting = static::where('page_key', $key)->first();

        return (object) array_merge([
            'meta_title' => $defaults['meta_title'] ?? null,
            'meta_description' => $defaults['meta_description'] ?? null,
            'meta_robots' => 'index',
            'og_image' => null,
        ], array_filter($setting?->only(['meta_title', 'meta_description', 'meta_robots', 'og_image']) ?? [], fn ($value) => $value !== null && $value !== ''));
    }
}