<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');
    }

    /**
     * Configure the Horizon authorization services.
     */
    protected function authorization(): void
    {
        $this->gate();

        Horizon::auth(function ($request) {
            $secretToken = env('HORIZON_TOKEN', env('HORIZON_SECRET_TOKEN'));

            // 1. Allow via ?token=... query parameter, header, or session
            if (!empty($secretToken)) {
                $providedToken = $request->query('token') ?? $request->header('X-Horizon-Token');

                if ($providedToken && hash_equals($secretToken, $providedToken)) {
                    session(['horizon_token' => $secretToken]);
                    return true;
                }

                if (session('horizon_token') && hash_equals($secretToken, session('horizon_token'))) {
                    return true;
                }
            }

            // 2. Always allow in local environment
            if (app()->environment('local')) {
                return true;
            }

            // 3. Fallback to Gate (logged-in admin users)
            return Gate::check('viewHorizon', [$request->user()]);
        });
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewHorizon', function ($user = null) {
            if (!$user) {
                return false;
            }

            $allowedEmails = array_filter([
                env('OWNER_EMAIL_ADDRESS'),
            ]);

            if (in_array($user->email, $allowedEmails)) {
                return true;
            }

            if ($user->type === 'admin' || $user->type === 'owner') {
                return true;
            }

            return $user->roles()->whereIn('name', ['admin', 'super-admin', 'owner'])->exists();
        });
    }
}
