<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    /**
     * Get a setting by key with optional default fallback.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("site_setting_{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting && $setting->value !== null ? $setting->value : $default;
        });
    }

    /**
     * Set/update a setting by key.
     */
    public static function set(string $key, mixed $value, string $group = 'general'): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        Cache::forget("site_setting_{$key}");
        Cache::forget('site_settings_all_key_map');

        return $setting;
    }

    /**
     * Get all settings as an associative key => value array.
     */
    public static function allAsKeyMap(): array
    {
        return Cache::rememberForever('site_settings_all_key_map', function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Flush settings cache.
     */
    public static function clearCache(): void
    {
        $keys = static::pluck('key')->all();
        foreach ($keys as $key) {
            Cache::forget("site_setting_{$key}");
        }
        Cache::forget('site_settings_all_key_map');
    }
}
