<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $guarded = [];

    public static function values(): array
    {
        $settings = collect(config('stackspring.shell_settings'))
            ->mapWithKeys(fn ($setting, $key) => [$key => $setting['default']])
            ->all();

        foreach (static::query()->pluck('value', 'key') as $key => $value) {
            if (array_key_exists($key, $settings)) $settings[$key] = $value;
        }

        return $settings;
    }
}