<?php

namespace Tests\Feature\Backend\Permission;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class EditPermissionTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'edit-permission']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_have_permission_update_permission()
    {
        //create new permission
        $permission=Permission::create(['name'=>'test_permissions']);
        //login user
        $this->actingAs($this->user)
        //create permissions
        ->put('/backend/permissions/'.$permission->id,['name'=>'test_permissions_2'])
        ->assertStatus(403);
    }

    public function test_user_have_permission_update_permission()
    {
        //create user have permissions to edit permissions
        $this->user->givePermissionTo(['edit-permission']);
        //create new permission
        $permission=Permission::create(['name'=>'test_permissions']);
        //login user
        $this->actingAs($this->user)
        //create permissions
        ->put('/backend/permissions/'.$permission->id,['name'=>'test_permissions_2'])
        ->assertStatus(200);
        //check the data updated
        $this->assertTrue($permission->fresh()->name=='test_permissions_2');
    }

    public function test_user_have_permission_update_permission_using_name_in_database()
    {
        //create user have permissions to edit permissions
        $this->user->givePermissionTo(['edit-permission']);
        //create new permission
        $permission1=Permission::create(['name'=>'test_permissions']);
        $permission2=Permission::create(['name'=>'test_permissions_2']);
        //login user
        $this->actingAs($this->user)
        //create permissions
        ->json('put','/backend/permissions/'.$permission1->id,['name'=>'test_permissions_2'])
        ->assertStatus(422);
    }

    public function test_user_have_permission_update_permission_using_name_required()
    {
        //create user have permissions to edit permissions
        $this->user->givePermissionTo(['edit-permission']);
        //create new permission
        $permission1=Permission::create(['name'=>'test_permissions']);
        $permission2=Permission::create(['name'=>'test_permissions_2']);
        //login user
        $this->actingAs($this->user)
        //create permissions
        ->json('put','/backend/permissions/'.$permission1->id,['name'=>null])
        ->assertStatus(422);
    }
}
