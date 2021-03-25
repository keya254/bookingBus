<?php

namespace Tests\Feature\Backend;

use App\Models\Setting;
use App\Models\User;
use Database\Factories\UserFactory;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        // now re-register all the roles and permissions (clears cache and reloads relations)
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'roles']);
        Permission::create(['name'=>'create-role']);
        Permission::create(['name'=>'edit-role']);
        Permission::create(['name'=>'delete-role']);
        $this->user  = User::factory()->create();
    }

    public function test_user_not_have_permission_roles_can_not_login()
    {
        $response=
        $this->actingAs($this->user)
        ->get('/backend/roles');
        $response->assertStatus(403);
    }

    public function test_user_have_permission_roles_can_login()
    {
        $this->user->givePermissionTo(['roles']);
        $this->actingAs($this->user)
        ->get('/backend/roles')
        ->assertStatus(200);
    }

    public function test_user_have_permission_create_role_found_not_created()
    {
        //test have permissions create-role
        $this->user->givePermissionTo(['create-role']);
        //create role
        Role::create(['name'=>'Admin']);
        //test create role with the same name
        $this->actingAs($this->user)
        ->post('/backend/roles',['name'=>'Admin'])
        ->assertStatus(302);
    }

    public function test_user_have_permission_create_role_not_found_created()
    {
        //user have a permission create role where not found in the database
        $this->user->givePermissionTo(['create-role']);
        //create new role
        $this->actingAs($this->user)
        ->post('/backend/roles',['name'=>'User'])
        ->assertStatus(200);
    }

    public function test_user_have_permission_update_role_not_found()
    {
        //user have permissions delete_role
        $this->user->givePermissionTo(['edit-role']);
        //create new role
        $role=Role::create(['name'=>'SAdmin']);
        //update role where not found this name in the database
        $this->actingAs($this->user)
             ->put('/backend/roles/'.$role->id,['name'=>'min'])
             ->assertStatus(200);
    }

    public function test_user_have_permission_update_role_found()
    {
        //user have permissions delete_role
        $this->user->givePermissionTo(['edit-role']);
        //create two roles
        $role=Role::create(['name'=>'2Admin']);
        $role2=Role::create(['name'=>'Admin']);
        //update role by name found it in database chech unique
        $this->actingAs($this->user)
             ->put('/backend/roles/'.$role->id,['name'=>'Admin'])
             ->assertStatus(302);
    }

    public function test_user_have_permission_delete_role_found()
    {
        //user have permissions delete_role
        $this->user->givePermissionTo(['delete-role']);
        //create new role
        $role=Role::create(['name'=>'SAdmin']);
        //login user have permissions and delete role  founded and deleted it
        $this->actingAs($this->user)
             ->delete('/backend/roles/'.$role->id)
             ->assertStatus(200);
    }

    public function test_user_have_permission_delete_role_not_found()
    {
        //user have permissions delete_role
        $this->user->givePermissionTo(['delete-role']);
        //create new role
        $role=Role::create(['name'=>'SAdmin']);
        //login user have permissions and delete role not found
        $this->actingAs($this->user)
             ->delete('/backend/roles/'.$role->id+1)
             ->assertStatus(500);
    }


}
