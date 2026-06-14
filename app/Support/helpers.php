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

if (! function_exists('video_embed')) {
    /**
     * Resolve a video URL (YouTube, Vimeo, or direct file) to embed/thumbnail data.
     *
     * @return array{type:string, embed:?string, thumb:?string}
     */
    function video_embed(?string $url): array
    {
        $url = trim((string) $url);

        if ($url !== '' && preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/|live/)|youtu\.be/)([A-Za-z0-9_-]{6,})~', $url, $m)) {
            return ['type' => 'youtube', 'embed' => 'https://www.youtube.com/embed/'.$m[1].'?rel=0&autoplay=1', 'thumb' => 'https://img.youtube.com/vi/'.$m[1].'/hqdefault.jpg'];
        }

        if ($url !== '' && preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
            return ['type' => 'vimeo', 'embed' => 'https://player.vimeo.com/video/'.$m[1].'?autoplay=1', 'thumb' => null];
        }

        return ['type' => 'file', 'embed' => media($url), 'thumb' => null];
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
