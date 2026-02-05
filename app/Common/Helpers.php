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
    $country = Country::where('iso', 'PK')->first(); // default country
    
    // Fallback if PK not found
    if (!$country) {
        $country = Country::first();
    }
    
    return $country;
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
