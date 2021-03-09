<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=['SuperAdmin','Owner','Driver','User'];
        foreach ($roles as $key => $role) {
            Role::create(['name'=>$role]);
         }

    }
}
