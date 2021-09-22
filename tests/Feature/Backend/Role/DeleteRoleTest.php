<?php

namespace Tests\Feature\Backend\Role;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DeleteRoleTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'delete-role']);
        $this->user = User::factory()->create();
    }

    public function test_user_has_permission_delete_role_found()
    {
        //user has permissions delete_role
        $this->user->givePermissionTo(['delete-role']);
        //create new role
        $role=Role::create(['name'=>'SAdmin']);
        //login user has permissions and delete role  founded and deleted it
        $this->actingAs($this->user)
             ->json('delete','/backend/roles/'.$role->id)
             ->assertStatus(200);
    }

    public function test_user_has_permission_delete_role_not_found()
    {
        //user has permissions delete_role
        $this->user->givePermissionTo(['delete-role']);
        //create new role
        $role=Role::create(['name'=>'SAdmin']);
        //login user has permissions and delete role not found
        $this->actingAs($this->user)
             ->json('delete','/backend/roles/'.$role->id+1)
             ->assertStatus(500);
    }
}
