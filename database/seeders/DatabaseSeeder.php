<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Setting::create(['name'=>'name of website','description'=>'description','logo'=>'/images/logo/1.png']);
        $roles=['SuperAdmin','Owner','Driver','User'];
        $permissions=['role','permission','typecar','car','trip'];
        foreach ($roles as $key => $role) {
           Role::create(['name'=>$role]);
        }
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
        User::create(['name'=>'SuperAdmin','email'=>'superadmin@example.com','password'=>bcrypt('12345678')])->assignRole('SuperAdmin');

         for ($i=1; $i <100 ; $i++) {
           User::create(['name'=>"Owner$i",'email'=>"owner$i@example.com",'password'=>bcrypt('12345678')])->assignRole('Owner');
         }
         for ($i=1; $i <100 ; $i++) {
            User::create(['name'=>"Driver$i",'email'=>"driver$i@example.com",'password'=>bcrypt('12345678')])->assignRole('Driver');
         }
         for ($i=1; $i <100 ; $i++) {
            User::create(['name'=>"OD$i",'email'=>"od$i@example.com",'password'=>bcrypt('12345678')])->assignRole(['Owner','Driver']);
         }
         for ($i=1; $i <100 ; $i++) {
            User::create(['name'=>"User$i",'email'=>"user$i@example.com",'password'=>bcrypt('12345678')])->assignRole('User');
         }
        \App\Models\TypeCar::factory(20)->create();
        \App\Models\Car::factory(300)->create();
        \App\Models\Trip::factory(300)->create();
    }
}
