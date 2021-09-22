<?php

namespace Tests\Feature\Backend\Permission;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IndexPermissionTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'permissions']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_has_permission_permissions_not_see_page()
    {
        //create user not has permissions
        $this->actingAs($this->user)
        ->get('/backend/permissions')
        ->assertStatus(403);
    }

    public function test_user_has_permission_permissions_not_see_page()
    {
        // create user has permissions
        $this->user->givePermissionTo(['permissions']);
        $this->actingAs($this->user)
        ->get('/backend/permissions')
        ->assertStatus(200)
        //check to see permissions in the page
        ->assertSee('permissions')
        //check view name
        ->assertViewIs('backend.permissions.index');
    }
}
