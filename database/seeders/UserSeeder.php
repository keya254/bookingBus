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
        User::factory()->create(['email'=>'superadmin@example.com'])->assignRole('SuperAdmin');
        User::factory()->create(['email'=>'admin@example.com'])->assignRole('Admin');
        for ($i=1; $i <100 ; $i++) {
          User::factory()->create(['email'=>"owner$i@example.com"])->assignRole('Owner');
        }
    }
}
