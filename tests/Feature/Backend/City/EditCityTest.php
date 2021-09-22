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

class EditCityTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'edit-city']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_has_permission_edit_city_can_not_see_page()
    {
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        //create city
        $city=City::create(['governorate_id'=>$governorate->id,'name'=>'المطرية']);
        //login user not access this page when not has permission 'edit-city'
        $this->actingAs($this->user)
        ->json('put','/backend/city/'.$city->id,['governorate_id'=>$governorate->id,'name'=>'الهرم'])
        ->assertStatus(403);
    }

    public function test_user_has_permission_edit_city_can_edit_city()
    {
        //given permission to this user
        $this->user->givePermissionTo('edit-city');
        //create governorate
        $governorate1=Governorate::create(['name'=>'القاهرة']);
        $governorate2=Governorate::create(['name'=>'بورسعيد']);
        //create city
        $city1=City::create(['governorate_id'=>$governorate1->id,'name'=>'المطرية']);
        $city2=City::create(['governorate_id'=>$governorate1->id,'name'=>'المنزلة']);

        //login user not access this page when not has permission 'edit-city'
        $this->actingAs($this->user)
        ->json('put','/backend/city/'.$city1->id,['governorate_id'=>$governorate1->id,'name'=>'الهرم'])
        ->assertStatus(200);
        //check the record is updated
        $this->assertDatabaseHas('cities',['id'=>$city1->id,'governorate_id'=>$governorate1->id,'name'=>'الهرم']);

        //has  the same city name in different governorate
        //login user not access this page when not has permission 'edit-city'
        $this->actingAs($this->user)
        ->json('put','/backend/city/'.$city2->id,['governorate_id'=>$governorate2->id,'name'=>'الهرم'])
        ->assertStatus(200);
        //check the record is updated
        $this->assertDatabaseHas('cities',['id'=>$city2->id,'governorate_id'=>$governorate2->id,'name'=>'الهرم']);

    }

    public function test_user_has_permission_edit_city_can_see_page_can_not_edit_city_founded_in_different_governorate()
    {
        //given permission to this user
        $this->user->givePermissionTo('edit-city');
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        //create city
        $city1=City::create(['governorate_id'=>$governorate->id,'name'=>'المطرية']);
        $city2=City::create(['governorate_id'=>$governorate->id,'name'=>'الهرم']);
        //login user not access this page when not has permission 'edit-city'

        //edit by name founded in different governorate
        $this->actingAs($this->user)
        ->json('put','/backend/city/'.$city1->id,['governorate_id'=>$governorate->id,'name'=>'الهرم'])
        ->assertJsonValidationErrors(['name'])
        ->assertStatus(422);
        //check the record is not updated
        $this->assertDatabaseHas('cities',['id'=>$city1->id,'governorate_id'=>$governorate->id,'name'=>'المطرية']);
    }

    public function test_user_has_permission_edit_city_can_see_page_can_not_edit_city_governorate_null()
    {
        //given permission to this user
        $this->user->givePermissionTo('edit-city');
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        //create city
        $city1=City::create(['governorate_id'=>$governorate->id,'name'=>'المطرية']);
        $city2=City::create(['governorate_id'=>$governorate->id,'name'=>'الهرم']);
        //login user not access this page when not has permission 'edit-city'
        //edit by  governorate_id =null
        $this->actingAs($this->user)
        ->json('put','/backend/city/'.$city1->id,['governorate_id'=>null,'name'=>'الهرم'])
        ->assertJsonValidationErrors(['governorate_id'])
        ->assertStatus(422);
        //check the record is not updated
        $this->assertDatabaseHas('cities',['id'=>$city1->id,'governorate_id'=>$governorate->id,'name'=>'المطرية']);
    }

    public function test_user_has_permission_edit_city_can_see_page_can_not_edit_city_governorate_string()
    {
        //given permission to this user
        $this->user->givePermissionTo('edit-city');
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        //create city
        $city1=City::create(['governorate_id'=>$governorate->id,'name'=>'المطرية']);
        $city2=City::create(['governorate_id'=>$governorate->id,'name'=>'الهرم']);
        //login user not access this page when not has permission 'edit-city'
        //edit by  governorate_id ="string"
        $this->actingAs($this->user)
        ->json('put','/backend/city/'.$city1->id,['governorate_id'=>'القاهرة','name'=>'الهرم'])
        ->assertJsonValidationErrors(['governorate_id'])
        ->assertStatus(422);
        //check the record is not updated
        $this->assertDatabaseHas('cities',['id'=>$city1->id,'governorate_id'=>$governorate->id,'name'=>'المطرية']);
    }

    public function test_user_has_permission_edit_city_can_see_page_can_not_edit_city_governorate_not_found_in_database()
    {
        //given permission to this user
        $this->user->givePermissionTo('edit-city');
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        //create city
        $city1=City::create(['governorate_id'=>$governorate->id,'name'=>'المطرية']);
        $city2=City::create(['governorate_id'=>$governorate->id,'name'=>'الهرم']);
        //login user not access this page when not has permission 'edit-city'
        //edit by  governorate_id  not found in database
        $this->actingAs($this->user)
        ->json('put','/backend/city/'.$city1->id,['governorate_id'=>$governorate->id+1,'name'=>'الهرم'])
        ->assertJsonValidationErrors(['governorate_id'])
        ->assertStatus(422);
        //check the record is not updated
        $this->assertDatabaseHas('cities',['id'=>$city1->id,'governorate_id'=>$governorate->id,'name'=>'المطرية']);
    }

    public function test_user_has_permission_edit_city_can_see_page_can_not_edit_city_city_name_is_null()
    {
        //given permission to this user
        $this->user->givePermissionTo('edit-city');
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        //create city
        $city1=City::create(['governorate_id'=>$governorate->id,'name'=>'المطرية']);
        $city2=City::create(['governorate_id'=>$governorate->id,'name'=>'الهرم']);
        //login user not access this page when not has permission 'edit-city'
         //edit by name = null
         $this->actingAs($this->user)
         ->json('put','/backend/city/'.$city1->id,['governorate_id'=>$governorate->id,'name'=>null])
         ->assertJsonValidationErrors(['name'])
         ->assertStatus(422);
         //check the record is not updated
         $this->assertDatabaseHas('cities',['id'=>$city1->id,'governorate_id'=>$governorate->id,'name'=>'المطرية']);
    }

    public function test_user_has_permission_edit_city_can_see_page_can_not_edit_city_city_name_is_min_3()
    {
        //given permission to this user
        $this->user->givePermissionTo('edit-city');
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        //create city
        $city1=City::create(['governorate_id'=>$governorate->id,'name'=>'المطرية']);
        $city2=City::create(['governorate_id'=>$governorate->id,'name'=>'الهرم']);
        //login user not access this page when not has permission 'edit-city'
         //edit by name = min:3
         $this->actingAs($this->user)
         ->json('put','/backend/city/'.$city1->id,['governorate_id'=>$governorate->id,'name'=>'h'])
         ->assertJsonValidationErrors(['name'])
         ->assertStatus(422);
         //check the record is not updated
         $this->assertDatabaseHas('cities',['id'=>$city1->id,'governorate_id'=>$governorate->id,'name'=>'المطرية']);
    }

    public function test_user_has_permission_edit_city_can_see_page_can_not_edit_city_city_id_not_found()
    {
        //given permission to this user
        $this->user->givePermissionTo('edit-city');
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        //create city
        $city1=City::create(['governorate_id'=>$governorate->id,'name'=>'المطرية']);
        $city2=City::create(['governorate_id'=>$governorate->id,'name'=>'الهرم']);
        //login user not access this page when not has permission 'edit-city'
        //edit by  cities.id not found in database
        $this->actingAs($this->user)
        ->json('put','/backend/city/'.$city2->id+1,['governorate_id'=>$governorate->id,'name'=>'الهرم'])
        ->assertStatus(404);
    }


}
