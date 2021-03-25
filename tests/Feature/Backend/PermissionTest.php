<?php

namespace Tests\Feature\Backend;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'permissions']);
        Permission::create(['name'=>'create-permission']);
        Permission::create(['name'=>'edit-permission']);
        Permission::create(['name'=>'delete-permission']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_have_permission_permissions_not_see_page()
    {
        //create user not have permissions
        $this->actingAs($this->user)
        ->get('/backend/permissions')
        ->assertStatus(403);
    }

    public function test_user_have_permission_permissions_not_see_page()
    {
        // create user have permissions
        $this->user->givePermissionTo(['permissions']);
        $this->actingAs($this->user)
        ->get('/backend/permissions')
        ->assertStatus(200)
        //check to see permissions in the page
        ->assertSee('permissions')
        //check view name
        ->assertViewIs('backend.permissions.index');
    }

    public function test_user_not_have_permission_create_permission()
    {
        //create user not have permissions to create permissions
        //login user
        $this->actingAs($this->user)
        //create permissions
        ->post('/backend/permissions',['name'=>'permission_test'])
        ->assertStatus(403);
    }

    public function test_user_have_permission_create_permission()
    {
        //create user have permissions to create permissions
        $this->user->givePermissionTo(['create-permission']);
        //login user
        $this->actingAs($this->user)
        //create permissions
        ->post('/backend/permissions',['name'=>'permission_test'])
        ->assertStatus(200)
        ->assertSee('success created');
    }

    public function test_user_have_permission_create_permission_same_name()
    {
        //create user have permissions to create permissions
        $this->user->givePermissionTo(['create-permission']);
        //create new permission
        $permission=Permission::create(['name'=>'test_create_permission']);
        //login user
        $this->actingAs($this->user)
        //create permission using the same name
        ->post('/backend/permissions',['name'=>'test_create_permission'])
        ->assertStatus(302);
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
        ->put('/backend/permissions/'.$permission1->id,['name'=>'test_permissions_2'])
        ->assertStatus(302);
    }

    public function test_user_not_have_permission_delete_permission()
    {
        $permission1=Permission::create(['name'=>'test_permissions']);
        //login user
        $this->actingAs($this->user)
        //create permissions
        ->delete('/backend/permissions/'.$permission1->id)
        ->assertStatus(403);
    }

    public function test_user_have_permission_delete_permission()
    {
        //create user have permissions to delete permissions
        $this->user->givePermissionTo(['delete-permission']);
        //create permissions
        $permission1=Permission::create(['name'=>'test_permissions']);
        //login user
        $this->actingAs($this->user)
        //create permissions
        ->delete('/backend/permissions/'.$permission1->id)
        ->assertStatus(200);
    }

    public function test_user_have_permission_delete_permission_but_permission_not_found()
    {
        //create user have permissions to delete permissions
        $this->user->givePermissionTo(['delete-permission']);
        //create permissions
        $permission1=Permission::create(['name'=>'test_permissions']);
        //login user
        $this->actingAs($this->user)
        //create permissions
        ->delete('/backend/permissions/'.$permission1->id+1)
        ->assertStatus(500);
    }
}
