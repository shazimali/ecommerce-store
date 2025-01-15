<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RolesTest extends TestCase
{

    // public function test_get_all_roles()
    // {
    //     Artisan::call('migrate');
    //     $this->seed();
    //     $user= User::first();
    //     Sanctum::actingAs($user);
    //     Gate::define('role_access', function ($user) {
    //         return true;
    //     });
    //     $this->withoutExceptionHandling();
    //     $this->getJson('/api/admin/roles')
    //     ->assertOk();
    // }
}
