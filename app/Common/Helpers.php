<?php

use App\Models\Country;
use App\Models\ProductHead;
use App\Models\Setting;
use App\Models\Website;
use Illuminate\Support\Facades\Cache;
use Stevebauman\Location\Facades\Location;

function website()
{

    $domain =  request()->headers->get('host');

    $website =  Website::active()->where('domain', $domain)
        ->with('categories', 'banners', 'social_medias', 'collections')
        ->first();

    if ($website) {
        return $website;
    }

    return  Website::active()->with('categories', 'banners')
        ->where('id', 1)
        ->first();
}

function newArrivals()
{
    return ProductHead::new()->active()->with('price_detail', 'stocks')->orderBy('order', 'ASC')->get()->take(4);
}


function getWebsiteUrl()
{
    return  Env('HTTP') . website()->domain;
}
function getLocation()
{
<<<<<<< HEAD
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
=======
    $country = Country::where('iso', 'PK')->first(); // default country


    
    // if (Cache::has('countryCode')) {
    //     $country = Country::where('iso', Cache::get('countryCode'))->first();
    // } else {
    //     $loc =   Location::get(request()->ip());
    //     if ($loc) {
    //         Cache::put('countryCode', $loc->countryCode);
    //         $country = Country::where('iso', $loc->countryCode)->first();
    //     }
    // }
    return $country;
>>>>>>> e903174 (update)
}

function facilities()
{
    $location = getLocation();
    if (!$location) return collect();
    
    return $location->facilities()->get();
}

function header_pages()
{
    $location = getLocation();
    if (!$location) return collect();

    return $location->pages()->active()->header()->get();
}

function footer_pages()
{
    $location = getLocation();
    if (!$location) return collect();

    return $location->pages()->active()->footer()->get();
}

function getSettingVal($key)
{
    $location = getLocation();
    if (!$location) return 0;

    $setting = Setting::where('country_id', $location->id)->where('key', $key)->first();
    
    return $setting ? $setting->value : 0;
}

function new_products() {}
