<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [];
        
        //Users
        $permissions[0]['name'] = 'User Management';
        $permissions[0]['key'] = 'user_management';
        $permissions[1]['name'] = 'User Create';
        $permissions[1]['key'] = 'user_create';
        $permissions[2]['name'] = 'User Edit';
        $permissions[2]['key'] = 'user_edit';
        $permissions[3]['name'] = 'User Delete';
        $permissions[3]['key'] = 'user_delete';

        //roles
        $permissions[4]['name'] = 'Role Access';
        $permissions[4]['key'] = 'role_access';
        $permissions[5]['name'] = 'Role Create';
        $permissions[5]['key'] = 'role_create';
        $permissions[6]['name'] = 'Role Edit';
        $permissions[6]['key'] = 'role_edit';
        $permissions[7]['name'] = 'Role Delete';
        $permissions[7]['key'] = 'role_delete';


        foreach ($permissions as $key => $permission) {

            Permission::create([
                'name' => $permission['name'],
                'key' => $permission['key']
            ]);
            
        }
    }
}
