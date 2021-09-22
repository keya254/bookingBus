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

class DeleteCityTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'delete-city']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_has_permission_delete_city_can_not_delete_city()
    {
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        //create city
        $city=City::create(['governorate_id'=>$governorate->id,'name'=>'المطرية']);
        //login user not access this page when not has permission 'delete-city'
        $this->actingAs($this->user)
        ->json('delete','/backend/city/'.$city->id,['governorate_id'=>$governorate->id,'name'=>'الهرم'])
        ->assertStatus(403);
    }

    public function test_user_has_permission_delete_city_can_see_page_and_deleted()
    {
        //give permission deleted
        $this->user->givePermissionTo('delete-city');
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        //create city
        $city=City::create(['governorate_id'=>$governorate->id,'name'=>'المطرية']);
        //login user not access this page when not has permission 'delete-city'
        $this->actingAs($this->user)
        ->json('delete','/backend/city/'.$city->id,['governorate_id'=>$governorate->id,'name'=>'الهرم'])
        ->assertStatus(200);
    }

    public function test_user_has_permission_delete_city_can_see_page_and_not_deleted_not_found()
    {
        //give permission deleted
        $this->user->givePermissionTo('delete-city');
        //create governorate
        $governorate=Governorate::create(['name'=>'القاهرة']);
        //create city
        $city=City::create(['governorate_id'=>$governorate->id,'name'=>'المطرية']);
        //login user not access this page when not has permission 'delete-city'
        $this->actingAs($this->user)
        ->json('delete','/backend/city/'.$city->id+1,['governorate_id'=>$governorate->id,'name'=>'الهرم'])
        ->assertStatus(404);
    }

}
