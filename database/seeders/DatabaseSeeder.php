<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Setting;
use App\Models\Trip;
use App\Models\TypeCar;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Setting::create(['name' => 'name of website', 'description' => 'description', 'logo' => '/images/logo/1.png']);
        $this->call([
            GovernorateSeeder::class,
            CitySeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
        ]);
        TypeCar::factory(20)->create();
        Car::factory(300)->create();
        Trip::factory(300)->create();
    }
}
