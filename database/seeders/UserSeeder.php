<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name'=>'SuperAdmin','email'=>'superadmin@example.com','password'=>bcrypt('12345678')])->assignRole('SuperAdmin');
        User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>bcrypt('12345678')])->assignRole('Admin');
        for ($i=1; $i <100 ; $i++) {
          User::create(['name'=>"Owner$i",'email'=>"owner$i@example.com",'password'=>bcrypt('12345678')])->assignRole('Owner');
        }
    }
}
