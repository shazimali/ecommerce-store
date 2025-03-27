<?php

use App\Models\Country;
use App\Models\ProductHead;
use App\Models\Website;
use Stevebauman\Location\Facades\Location;

function website()
{

    $domain =  request()->headers->get('host');

    if ($domain) {
        return  Website::active()->where('domain', $domain)
            ->with('categories', 'banners')
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
    $loc = Location::get('154.192.161.138');
    return Country::where('iso', $loc->countryCode)->first();
}

function facilities()
{
    $loc = Location::get('154.192.161.138');
    $country = Country::where('iso', $loc->countryCode)->first();
    return $country->facilities()->get();
}

function new_products() {}
