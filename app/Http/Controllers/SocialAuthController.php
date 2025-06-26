<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function loginSocial(Request $request, string $provider): RedirectResponse
    {
        // $this->validateProvider($request);

        return Socialite::driver($provider)->redirect();
    }

    public function callbackSocial(Request $request, string $provider)
    {
        // $this->validateProvider($request);

        // $response = Socialite::driver($provider)->user();

        $user = User::firstOrCreate(
            ['email' => $request->email],
            ['password' => Str::password()]
        );
        $data = [];
        if ($user->wasRecentlyCreated) {
            $data['name'] = $request->name;
            $data['facebook_id'] = $request->id;
            event(new Registered($user));
        }

        $user->update($data);

        Auth::login($user, remember: true);
        return response()->json(['message' => 'success'], 200);
    }
}
