<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (! function_exists('media_url')) {
    /**
     * Resolve an image value that may be a remote URL or a stored path.
     */
    function media_url(?string $value, ?string $fallback = null): ?string
    {
        if (blank($value)) {
            return $fallback;
        }

        if (Str::startsWith($value, ['http://', 'https://', '//', '/'])) {
            return $value;
        }

        return Storage::disk('public')->url($value);
    }
}

if (! function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }
}
