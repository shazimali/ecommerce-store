<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;
use Illuminate\Support\Facades\Schema;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // if (Schema::hasTable('roles')) {
        //     $roles = Role::with('permissions')->get();
        //     $permissionsArray = [];
        //     foreach ($roles as $role) {
        //         foreach ($role->permissions as $permissions) {
        //             $permissionsArray[$permissions->key][] = $role->id;
        //         }
        //     }

        //     // Every permission may have multiple roles assigned
        //     foreach ($permissionsArray as $title => $roles) {
        //         Gate::define($title, function ($user) use ($roles) {
        //             // We check if we have the needed roles among current user's roles
        //             return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0;
        //         });
        //     }
        // }
    }
}
