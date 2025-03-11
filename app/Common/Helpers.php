<?php

use App\Models\Country;
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


function facilities()
{
    $loc = Location::get('154.192.161.138');
    $country = Country::where('iso', $loc->countryCode)->first();
    return $country->facilities()->get();
}

function new_products() {}
