<?php

use App\Models\Country;
use App\Models\ProductHead;
use App\Models\Setting;
use App\Models\Website;
use Illuminate\Support\Facades\Cache;
use Stevebauman\Location\Facades\Location;

function website()
{
    $domain = request()->headers->get('host');
    $cacheKey = 'website_' . md5($domain);

    return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($domain) {
        $website = Website::active()
            ->where('domain', $domain)
            ->with('categories', 'banners', 'social_medias', 'collections')
            ->first();

        return $website ?? Website::active()
            ->with('categories', 'banners')
            ->where('id', 1)
            ->first();
    });
}

function newArrivals()
{
    return Cache::remember('new_arrivals', now()->addMinutes(15), function () {
        return ProductHead::new()->active()->with('price_detail')->orderBy('order', 'ASC')->limit(4)->get();
    });
}


function getWebsiteUrl()
{
    return  Env('HTTP') . website()->domain;
}
function getLocation()
{
    static $currentCountry = null;

    if ($currentCountry) {
        return $currentCountry;
    }

    // 1. Check for immediate sources (Headers & Sessions) - 0 latency
    $countryCode = request()->header('CF-IPCountry') // Cloudflare
                ?? request()->header('X-Appengine-Country') // Google App Engine
                ?? request()->header('CloudFront-Viewer-Country') // CloudFront
                ?? session('country_code');

    if ($countryCode) {
        $currentCountry = Country::where('iso', $countryCode)->first();
        if ($currentCountry) return $currentCountry;
    }

    // 2. Check for Cookie - ~0.05ms
    $cookieCode = request()->cookie('country_code');
    if ($cookieCode) {
        $currentCountry = Country::where('iso', $cookieCode)->first();
        if ($currentCountry) {
            session(['country_code' => $cookieCode]);
            return $currentCountry;
        }
    }

    // 3. One-time Detection per IP with Cache - Extremely fast after 1st lookup
    $ip = request()->ip();
    $cacheKey = 'country_code_' . $ip;
    
    $countryCode = Cache::remember($cacheKey, now()->addDays(30), function () use ($ip) {
        $loc = Location::get($ip);
        return $loc ? $loc->countryCode : 'PK';
    });

    session(['country_code' => $countryCode]);
    
    $currentCountry = Country::where('iso', $countryCode)->first() 
                   ?? Country::where('iso', 'PK')->first() 
                   ?? Country::first();

    return $currentCountry;
}

function facilities()
{
    $location = getLocation();
    if (!$location) return collect();

    return Cache::remember('facilities_' . $location->id, now()->addMinutes(30), function () use ($location) {
        return $location->facilities()->get();
    });
}

function header_pages()
{
    $location = getLocation();
    if (!$location) return collect();

    return Cache::remember('header_pages_' . $location->id, now()->addMinutes(30), function () use ($location) {
        return $location->pages()->active()->header()->get();
    });
}

function footer_pages()
{
    $location = getLocation();
    if (!$location) return collect();

    return Cache::remember('footer_pages_' . $location->id, now()->addMinutes(30), function () use ($location) {
        return $location->pages()->active()->footer()->get();
    });
}

function getSettingVal($key)
{
    $location = getLocation();
    if (!$location) return 0;

    // Load ALL settings for this country in one query, then cache the entire map
    $settings = Cache::remember('settings_country_' . $location->id, now()->addMinutes(30), function () use ($location) {
        return Setting::where('country_id', $location->id)
            ->pluck('value', 'key')
            ->toArray();
    });

    return $settings[$key] ?? 0;
}

function new_products() {}
