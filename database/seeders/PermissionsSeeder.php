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
        $permissions[0]['name'] = 'User Access';
        $permissions[0]['key'] = 'user_access';
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

        //permissions
        $permissions[8]['name'] = 'Permission Access';
        $permissions[8]['key'] = 'permission_access';
        $permissions[9]['name'] = 'Permission Create';
        $permissions[9]['key'] = 'permission_create';
        $permissions[10]['name'] = 'Permission Edit';
        $permissions[10]['key'] = 'permission_edit';
        $permissions[11]['name'] = 'Permission Delete';
        $permissions[11]['key'] = 'permission_delete';

        //Websites
        $permissions[12]['name'] = 'Website Access';
        $permissions[12]['key'] = 'website_access';
        $permissions[13]['name'] = 'Website Create';
        $permissions[13]['key'] = 'website_create';
        $permissions[14]['name'] = 'Website Edit';
        $permissions[14]['key'] = 'website_edit';
        $permissions[15]['name'] = 'Website Delete';
        $permissions[15]['key'] = 'website_delete';

        //Categories
        $permissions[16]['name'] = 'Category Access';
        $permissions[16]['key'] = 'category_access';
        $permissions[17]['name'] = 'Category Create';
        $permissions[17]['key'] = 'category_create';
        $permissions[18]['name'] = 'Category Edit';
        $permissions[18]['key'] = 'category_edit';
        $permissions[19]['name'] = 'Category Delete';
        $permissions[19]['key'] = 'category_delete';

        //SubCategories
        $permissions[20]['name'] = 'SubCategory Access';
        $permissions[20]['key'] = 'subcategory_access';
        $permissions[21]['name'] = 'SubCategory  Create';
        $permissions[21]['key'] = 'subcategory_create';
        $permissions[22]['name'] = 'SubCategory  Edit';
        $permissions[22]['key'] = 'subcategory_edit';
        $permissions[23]['name'] = 'SubCategory  Delete';
        $permissions[23]['key'] = 'subcategory_delete';

        //Products
        $permissions[24]['name'] = 'Product Access';
        $permissions[24]['key'] = 'product_access';
        $permissions[25]['name'] = 'Product  Create';
        $permissions[25]['key'] = 'product_create';
        $permissions[26]['name'] = 'Product  Edit';
        $permissions[26]['key'] = 'product_edit';
        $permissions[27]['name'] = 'Product  Delete';
        $permissions[27]['key'] = 'product_delete';


        foreach ($permissions as $key => $permission) {

            Permission::create([
                'name' => $permission['name'],
                'key' => $permission['key']
            ]);
        }
    }
}
