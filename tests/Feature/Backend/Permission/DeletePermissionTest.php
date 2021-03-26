<?php

namespace Tests\Feature\Backend\Permission;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class DeletePermissionTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'delete-permission']);
        $this->user = User::factory()->create();
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
