<?php

namespace Tests\Feature\Backend\Role;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolePermissionsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function SetUp(): void
    {
        parent::SetUp();

        $this->role = Role::create(['name' => 'Owner']);
        $this->permission = Permission::create(['name' => 'role-permission']);
        $this->user = User::factory()->create();
        $this->user2 = User::factory()->create();
        $this->user->givePermissionTo('role-permission');
        $this->user->assignRole('Owner');
    }

    public function test_guest_visit_role_permission()
    {
        $this->get(route('getrolepermissions', $this->role->id), array('HTTP_X-Requested-With' => 'XMLHttpRequest'))
            ->assertRedirect('/login');
    }

    public function test_not_has_permission_role_permission_get_permissions_to_role()
    {
        $this->actingAs($this->user2)
            ->get(route('getrolepermissions', $this->role->id), array('HTTP_X-Requested-With' => 'XMLHttpRequest'))
            ->assertForbidden();
    }

    public function test_has_permission_role_permission_get_permissions_to_role()
    {
        $this->actingAs($this->user)
            ->get(route('getrolepermissions', $this->role->id), array('HTTP_X-Requested-With' => 'XMLHttpRequest'))
            ->assertSuccessful();
    }

    public function test_has_permission_role_permission_get_permissions_to_role_id_is_wrong()
    {
        $this->actingAs($this->user)
            ->get(route('getrolepermissions', $this->role->id + 23), array('HTTP_X-Requested-With' => 'XMLHttpRequest'))
            ->assertStatus(500);
    }

    public function test_has_permission_role_permission_set_permissions_to_role_success()
    {
        $this->actingAs($this->user)
            ->json('post', route('role_permissions'), ['role_id' => 1, 'permissions' => [1]])
            ->assertSuccessful();
    }

    public function test_guest_set_permissions_to_role()
    {
        $this->json('post', route('role_permissions'), ['role_id' => 1, 'permissions' => [1]])
            ->assertUnauthorized();
    }

    public function test_has_permission_role_permission_set_permissions_to_role_not_found()
    {
        $this->actingAs($this->user)
            ->json('post', route('role_permissions'), ['role_id' => 2, 'permissions' => [1]])
            ->assertStatus(500);
    }

    public function test_has_permission_role_permission_set_permissions_to_role_permissions_not_found()
    {
        $this->actingAs($this->user)
            ->json('post', route('role_permissions'), ['role_id' => 2, 'permissions' => [1, 2]])
            ->assertStatus(500);
    }

    public function test_user_not_has_permission_role_permission_set_permissions_to_role()
    {
        $this->actingAs($this->user2)
            ->json('post', route('role_permissions'), ['role_id' => 1, 'permissions' => [1]])
            ->assertForbidden();
    }

    public function test_user_has_permission_role_permission_set_permissions_to_role_role_id_required()
    {
        $this->actingAs($this->user)
            ->json('post', route('role_permissions'), ['role_id' => '', 'permissions' => [1]])
            ->assertJsonValidationErrors('role_id')
            ->assertStatus(422);
    }

    public function test_user_has_permission_role_permission_set_permissions_to_role_permissions_required()
    {
        $this->actingAs($this->user)
            ->json('post', route('role_permissions'), ['role_id' => 1, 'permissions' => ''])
            ->assertJsonValidationErrors('permissions')
            ->assertStatus(422);
    }

    public function test_user_has_permission_role_permission_set_permissions_to_role_permissions_not_array()
    {
        $this->actingAs($this->user)
            ->json('post', route('role_permissions'), ['role_id' => 1, 'permissions' => 'moh'])
            ->assertJsonValidationErrors('permissions')
            ->assertStatus(422);
    }

    public function test_user_has_permission_role_permission_set_permissions_to_role_permissions_content_integer()
    {
        $this->actingAs($this->user)
            ->json('post', route('role_permissions'), ['role_id' => 1, 'permissions' => ['mi', 'htgty', 1]])
            ->assertJsonValidationErrors('permissions.0')
            ->assertStatus(422);
    }
}
