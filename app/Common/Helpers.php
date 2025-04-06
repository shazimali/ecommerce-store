<?php

use App\Models\Country;
use App\Models\ProductHead;
use App\Models\Setting;
use App\Models\Website;
use Stevebauman\Location\Facades\Location;

function website()
{

    $domain =  request()->headers->get('host');

    if ($domain) {
        return  Website::active()->where('domain', $domain)
            ->with('categories', 'banners', 'social_medias')
            ->first();
    }

    return  Website::active()->with('categories', 'banners')
        ->where('id', 1)
        ->first();
}

function newArrivals()
{
    return ProductHead::new()->active()->with('price_detail', 'stocks')->orderBy('order', 'ASC')->get()->take(4);
}

function getLocation()
{
    $loc = Location::get(request()->ip());
    if ($loc) {
        return Country::where('iso', $loc->countryCode)->first();
    }
    return Country::whereId(167)->first(); // default country
}

function facilities()
{
    $loc = Location::get(request()->ip());
    if ($loc) {
        $country = Country::where('iso', $loc->countryCode)->first();
    }
    $country = Country::whereId(167)->first(); // default country
    return $country->facilities()->get();
}

function getSettingVal($key)
{

    return Setting::where('country_id', getLocation()->id)->where('key', $key)->first()->value;
}

function new_products() {}
