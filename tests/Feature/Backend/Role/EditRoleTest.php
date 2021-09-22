<?php

namespace Tests\Feature\Backend\Role;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EditRoleTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'edit-role']);
        $this->user = User::factory()->create();
    }

    public function test_user_has_permission_update_role_not_found()
    {
        //user has permissions delete_role
        $this->user->givePermissionTo(['edit-role']);
        //create new role
        $role=Role::create(['name'=>'SAdmin']);
        //update role where not found this name in the database
        $this->actingAs($this->user)
             ->json('put','/backend/roles/'.$role->id,['name'=>'min'])
             ->assertStatus(200);
    }

    public function test_user_has_permission_update_role_found()
    {
        //user has permissions delete_role
        $this->user->givePermissionTo(['edit-role']);
        //create two roles
        $role=Role::create(['name'=>'2Admin']);
        $role2=Role::create(['name'=>'Admin']);
        //update role by name found it in database chech unique
        $this->actingAs($this->user)
             ->json('put','/backend/roles/'.$role->id,['name'=>'Admin'])
             ->assertStatus(422);
    }
}
