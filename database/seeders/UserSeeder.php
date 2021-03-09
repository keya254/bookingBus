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
    }
}
