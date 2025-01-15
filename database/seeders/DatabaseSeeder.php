<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Psy\CodeCleaner\AssignThisVariablePass;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(1)->create();
         $this->call(RoleSeeder::class);
         $this->call(PermissionsSeeder::class);
         $this->call(AssignPermissionsToRoleSeeder::class);
         $this->call(UserRoleSeeder::class);
    }
}
