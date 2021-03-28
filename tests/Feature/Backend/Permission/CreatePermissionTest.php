<?php

namespace Tests\Feature\Backend\Permission;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CreatePermissionTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'create-permission']);
        $this->user = User::factory()->create();
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
         //create permission using the same name
        $this->actingAs($this->user)
        ->json('post','/backend/permissions',['name'=>'test_create_permission'])
        ->assertJsonValidationErrors(['name'])
        ->assertStatus(422);
    }

    public function test_user_have_permission_create_permission_name_required()
    {
        //create user have permissions to create permissions
        $this->user->givePermissionTo(['create-permission']);
        //create new permission
        $permission=Permission::create(['name'=>'test_create_permission']);
        //login user
         //create permission using the same name
        $this->actingAs($this->user)
        ->json('post','/backend/permissions',['name'=>'test_create_permission'])
        ->assertJsonValidationErrors(['name'])
        ->assertStatus(422);
    }
}
