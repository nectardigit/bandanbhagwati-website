<?php

use App\Models\SiteSetting;
use Illuminate\Support\Str;

if (! function_exists('media')) {
    /**
     * Resolve an image value to a URL.
     * Accepts a full URL (seeded Unsplash links) or a storage path (uploaded files).
     */
    function media(?string $value, ?string $fallback = null): ?string
    {
        if (blank($value)) {
            return $fallback;
        }

        // Already a usable URL: absolute, protocol-relative, root-relative (e.g. unisharp's
        // "/storage/photos/x.jpg"), or a data URI — pass through (encoding spaces only).
        if (Str::startsWith($value, ['http://', 'https://', '//', '/', 'data:'])) {
            return str_replace(' ', '%20', $value);
        }

        return str_replace(' ', '%20', asset('storage/'.ltrim($value, '/')));
    }
}

if (! function_exists('og_url')) {
    /**
     * Absolute Open-Graph image URL (on the production SITE_URL), with a site-wide default.
     */
    function og_url(?string $value): string
    {
        $url = media($value) ?: media(setting('hero_image')) ?: '/storage/photos/1/hero/hero.jpg';

        if (Str::startsWith($url, ['http://', 'https://'])) {
            return $url;
        }

        return rtrim(config('app.site_url'), '/').'/'.ltrim($url, '/');
    }
}

if (! function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        $shared = view()->shared('settings', null);

        if (is_array($shared) && array_key_exists($key, $shared)) {
            return $shared[$key] ?? $default;
        }

        return SiteSetting::get($key, $default);
    }
}
