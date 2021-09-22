<?php

namespace Tests\Feature\Backend\Role;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IndexRoleTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'roles']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_has_permission_roles_can_not_login()
    {
        $response=
        $this->actingAs($this->user)
        ->get('/backend/roles');
        $response->assertStatus(403);
    }

    public function test_user_has_permission_roles_can_login()
    {
        $this->user->givePermissionTo(['roles']);
        $this->actingAs($this->user)
        ->get('/backend/roles')
        ->assertStatus(200);
    }
}
