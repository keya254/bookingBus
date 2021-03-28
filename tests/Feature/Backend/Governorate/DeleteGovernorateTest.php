<?php

namespace Tests\Feature\Backend\Governorate;

use App\Models\Governorate;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class DeleteGovernorateTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'delete-governorate']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_have_permission_delete_governorate_can_not_delete()
    {
        //create governorate
        $governorate=Governorate::create(['name'=>'الجيزة']);
        //user not have permission
        $this->actingAs($this->user)
           //login user
           ->json('delete','/backend/governorate/'.$governorate->id)
           ->assertForbidden();
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
           ->json('delete','/backend/governorate/'.$governorate->id)
           ->assertSuccessful();
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
           ->json('delete','/backend/governorate/'.$governorate->id+1)
           ->assertNotFound();
    }
}
