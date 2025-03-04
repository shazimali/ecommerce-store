<?php

use App\Models\Website;

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
