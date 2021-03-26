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
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'create-city']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_have_permission_create_city_can_not_see_page()
    {
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        //login user not access this page when not have permission 'create-city'
        $this->actingAs($this->user)
        ->post('/backend/city',['governorate_id'=>$governorate->id,'name'=>'المطرية'])
        ->assertStatus(403);
    }

    public function test_user_have_permission_create_city_can_create()
    {
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        //given permission to this user
        $this->user->givePermissionTo('create-city');
        //login user access this page when have permission 'citys'
        $this->actingAs($this->user)
        ->post('/backend/city',['governorate_id'=>$governorate->id,'name'=>'المطرية'])
        ->assertStatus(200);
        //check is created in database
        $this->assertDatabaseHas('cities',['governorate_id'=>$governorate->id,'name'=>'المطرية']);
    }

    public function test_user_have_permission_create_city_can_not_create_unique_name_city()
    {
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        $city=City::create(['governorate_id'=>$governorate->id,'name'=>'المطرية']);
        //given permission to this user
        $this->user->givePermissionTo('create-city');
        //login user access this page when have permission 'citys'
        $this->actingAs($this->user)
        ->post('/backend/city',['governorate_id'=>$governorate->id,'name'=>'المطرية'])
        //check if have error validation name
        ->assertSessionHasErrors(['name'])
        ->assertStatus(302);
    }

    public function test_user_have_permission_create_city_can_not_create_city_governorate_id_is_null_or_string_id_not_found()
    {
        //given permission to this user
        $this->user->givePermissionTo('create-city');
        //login user access this page when have permission 'citys'
        //check  governorate_id is not string
        $this->actingAs($this->user)
        ->post('/backend/city',['governorate_id'=>'nom','name'=>'المطرية'])
        //check if have error validation governorate_id
        ->assertSessionHasErrors(['governorate_id'])
        ->assertStatus(302);

        //check where  governorate_id not null
        $this->actingAs($this->user)
        ->post('/backend/city',['governorate_id'=>null,'name'=>'المطرية'])
        //check if have error validation governorate_id
        ->assertSessionHasErrors(['governorate_id'])
        ->assertStatus(302);

        //check where  governorate_id not found
        $this->actingAs($this->user)
        ->post('/backend/city',['governorate_id'=>1,'name'=>'المطرية'])
        //check if have error validation governorate_id
        ->assertSessionHasErrors(['governorate_id'])
        ->assertStatus(302);

        //edit by name = null
        $governorate=Governorate::create(['name'=>'القاهرة']);
        $this->actingAs($this->user)
        ->post('/backend/city',['governorate_id'=>$governorate->id,'name'=>''])
        ->assertSessionHasErrors(['name'])
        ->assertStatus(302);
    }
}
