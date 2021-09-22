<?php

namespace Tests\Feature\Backend\Role;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'create-role']);
        $this->user = User::factory()->create();
    }

    public function test_user_has_permission_create_role_found_not_created()
    {
        //test has permissions create-role
        $this->user->givePermissionTo(['create-role']);
        //create role
        Role::create(['name'=>'Admin']);
        //test create role with the same name
        $this->actingAs($this->user)
        ->json('post','/backend/roles',['name'=>'Admin'])
        ->assertStatus(422);
    }

    public function test_user_has_permission_create_role_not_found_created()
    {
        //user has a permission create role where not found in the database
        $this->user->givePermissionTo(['create-role']);
        //create new role
        $this->actingAs($this->user)
        ->json('post','/backend/roles',['name'=>'User'])
        ->assertStatus(200);
    }
}
