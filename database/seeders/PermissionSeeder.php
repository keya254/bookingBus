<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions=['role','permission','typecar','car','trip'];

        foreach ($permissions as $key => $permission) {
            Permission::create(['name'=>$permission.'s']);
            Permission::create(['name'=>'create-'.$permission]);
            Permission::create(['name'=>'edit-'.$permission]);
            Permission::create(['name'=>'delete-'.$permission]);
            if (in_array($permission,['typecar','car','trip'])) {
                Permission::create(['name'=>'status-'.$permission]);
            }
            if ($permission=='car') {
                Permission::create(['name'=>'public-'.$permission]);
                Permission::create(['name'=>'private-'.$permission]);
            }
         }
         $permissions2=['dashboard','website-setting','notifications','change-password','profile-setting'];
         foreach ($permissions2 as $key => $permission) {
            Permission::create(['name'=>$permission]);
         }
    }
}
