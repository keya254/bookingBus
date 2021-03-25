<?php

namespace Tests\Feature\Backend;

use App\Models\Governorate;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class GovernorateTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'governorates']);
        Permission::create(['name'=>'create-governorate']);
        Permission::create(['name'=>'edit-governorate']);
        Permission::create(['name'=>'delete-governorate']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_have_permission_governorates_can_not_see_page()
    {
        //user not have permission
        $this->actingAs($this->user)
           //login user
           ->get('/backend/governorate')
           ->assertStatus(403);
    }

    public function test_user_have_permission_governorates_can_see_page()
    {
        $this->user->givePermissionTo('governorates');
        //check the permission founded
        $this->assertDatabaseHas('permissions',['name'=>'governorates']);
        //user not have permission
        $this->actingAs($this->user)
           //login user
           ->get('/backend/governorate')
           ->assertStatus(200)
           ->assertSee(['اسم المحافظة']);
    }

    public function test_user_not_have_permission_create_governorate_can_not_see_page()
    {
        //user not have permission
        $this->actingAs($this->user)
           //login user
           ->post('/backend/governorate',['name'=>'القاهرة'])
           ->assertStatus(403);
    }

    public function test_user_have_permission_create_governorate_can_see_page()
    {
        //give permission to this user to create governorate
        $this->user->givePermissionTo('create-governorate');
        //user not have permission
        $this->actingAs($this->user)
           //login user
           ->post('/backend/governorate',['name'=>'القاهرة'])
           ->assertStatus(200);
        //check the governorates founded
        $this->assertDatabaseHas('governorates',['name'=>'القاهرة']);
    }

    public function test_user_not_have_permission_edit_governorate_can_not_see_page()
    {
        //create governorate
        $governorate=Governorate::create(['name'=>'الجيزة']);
        //user not have permission
        $this->actingAs($this->user)
           //login user
           ->put('/backend/governorate/'.$governorate->id,['name'=>'القاهرة'])
           ->assertStatus(403);
    }

    public function test_user_have_permission_edit_governorate_can_see_page()
    {
        //give permission to this user to edit governorate
        $this->user->givePermissionTo('edit-governorate');
        //create governorate
        $governorate=Governorate::create(['name'=>'الجيزة']);
        //user not have permission
        $this->actingAs($this->user)
           //login user
           ->put('/backend/governorate/'.$governorate->id,['name'=>'القاهرة'])
           ->assertStatus(200);
        //check the governorates updated
        $this->assertDatabaseHas('governorates',['id'=>$governorate->id,'name'=>'القاهرة']);
    }

    public function test_user_have_permission_edit_governorate_can_not_update_the_same_name_in_database()
    {
        //give permission to this user to edit governorate
        $this->user->givePermissionTo('edit-governorate');
        //create governorate
        $governorate1=Governorate::create(['name'=>'الجيزة']);
        $governorate2=Governorate::create(['name'=>'القاهرة']);
        //user not have permission
        $this->actingAs($this->user)
           //login user
           ->put('/backend/governorate/'.$governorate1->id,['name'=>'القاهرة'])
           ->assertStatus(302);
        //check the governorates not updated
        $this->assertDatabaseHas('governorates',['id'=>$governorate1->id,'name'=>'الجيزة']);
    }

    public function test_user_not_have_permission_delete_governorate_can_not_delete()
    {
        //create governorate
        $governorate=Governorate::create(['name'=>'الجيزة']);
        //user not have permission
        $this->actingAs($this->user)
           //login user
           ->delete('/backend/governorate/'.$governorate->id)
           ->assertStatus(403);
        //check the governorates not deleted
        $this->assertDatabaseHas('governorates',['id'=>$governorate->id,'name'=>'الجيزة']);
    }

    public function test_user_not_have_permission_delete_governorate_can_delete()
    {
        //give permission to this user to delete governorate
        $this->user->givePermissionTo('delete-governorate');
        //create governorate
        $governorate=Governorate::create(['name'=>'الجيزة']);
        //user not have permission
        $this->actingAs($this->user)
           //login user
           ->delete('/backend/governorate/'.$governorate->id)
           ->assertStatus(200);
        //check the governorates deleted
        $this->assertDeleted('governorates',['id'=>$governorate->id,'name'=>'الجيزة']);
    }

    public function test_user_not_have_permission_delete_governorate_delete_record_not_found()
    {
        //give permission to this user to delete governorate
        $this->user->givePermissionTo('delete-governorate');
        //create governorate
        $governorate=Governorate::create(['name'=>'الجيزة']);
        //user not have permission
        $this->actingAs($this->user)
           //login user
           ->delete('/backend/governorate/'.$governorate->id+1)
           ->assertStatus(404);
    }

}
