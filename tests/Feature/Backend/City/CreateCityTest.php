<?php

namespace Tests\Feature\Backend\City;

use App\Models\City;
use App\Models\Governorate;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CreateCityTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name' => 'website name', 'description' => 'description', 'logo' => 'images/logo/logo.png']);
        Permission::create(['name' => 'create-city']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_has_permission_create_city_can_not_create_city()
    {
        //create governorate
        $governorate = Governorate::create(['name' => 'القاهرة']);
        //login user not access this page when not has permission 'create-city'
        $this->actingAs($this->user)
            ->json('post', '/backend/city', ['governorate_id' => $governorate->id, 'name' => 'المطرية'])
            ->assertStatus(403);
    }

    public function test_user_has_permission_create_city_can_create_city()
    {
        //create governorate
        $governorate = Governorate::create(['name' => 'القاهرة']);
        //given permission to this user
        $this->user->givePermissionTo('create-city');
        //login user access this page when has permission 'citys'
        $this->actingAs($this->user)
            ->json('post', '/backend/city', ['governorate_id' => $governorate->id, 'name' => 'المطرية'])
            ->assertStatus(201);
        //check is created in database
        $this->assertDatabaseHas('cities', ['governorate_id' => $governorate->id, 'name' => 'المطرية']);
    }

    public function test_user_has_permission_create_city_can_not_create_unique_name_city()
    {
        //create governorate
        $governorate = Governorate::create(['name' => 'القاهرة']);
        $city = City::create(['governorate_id' => $governorate->id, 'name' => 'المطرية']);
        //given permission to this user
        $this->user->givePermissionTo('create-city');
        //login user access this page when has permission 'citys'
        $this->actingAs($this->user)
            ->json('post', '/backend/city', ['governorate_id' => $governorate->id, 'name' => 'المطرية'])
        //check if has error validation name
            ->assertJsonValidationErrors(['name'])
            ->assertStatus(422);
    }

    public function test_user_has_permission_create_city_can_not_create_city_governorate_id_is_string()
    {
        //given permission to this user
        $this->user->givePermissionTo('create-city');
        //login user access this page when has permission 'citys'
        //check  governorate_id is not string
        $this->actingAs($this->user)
            ->json('post', '/backend/city', ['governorate_id' => 'nom', 'name' => 'المطرية'])
        //check if has error validation governorate_id
            ->assertJsonValidationErrors(['governorate_id'])
            ->assertStatus(422);

    }

    public function test_user_has_permission_create_city_can_not_create_city_governorate_id_is_null()
    {
        //given permission to this user
        $this->user->givePermissionTo('create-city');
        //check where  governorate_id not null
        $this->actingAs($this->user)
            ->json('post', '/backend/city', ['governorate_id' => null, 'name' => 'المطرية'])
        //check if has error validation governorate_id
            ->assertJsonValidationErrors(['governorate_id'])
            ->assertStatus(422);
    }

    public function test_user_has_permission_create_city_can_not_create_city_governorate_id_is_not_exist_in_the_database()
    {
        //given permission to this user
        $this->user->givePermissionTo('create-city');
        //check where  governorate_id not found
        $this->actingAs($this->user)
            ->json('post', '/backend/city', ['governorate_id' => 1, 'name' => 'المطرية'])
        //check if has error validation governorate_id
            ->assertJsonValidationErrors(['governorate_id'])
            ->assertStatus(422);
    }

    public function test_user_has_permission_create_city_can_not_create_city_name_is_null()
    {
        //given permission to this user
        $this->user->givePermissionTo('create-city');
        //edit by name = null
        $governorate = Governorate::create(['name' => 'القاهرة']);
        $this->actingAs($this->user)
            ->json('post', '/backend/city', ['governorate_id' => $governorate->id, 'name' => null])
            ->assertJsonValidationErrors(['name'])
            ->assertStatus(422);
    }
}
