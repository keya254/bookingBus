<?php

namespace Tests\Feature\Backend\Owner;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IndexOwnerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name' => 'website name', 'description' => 'description', 'logo' => 'images/logo/logo.png']);
        Permission::create(['name' => 'owners']);
        $this->user = User::factory()->create();
    }

    public function test_guest_can_not_see_page()
    {
        $this->get('/backend/owner')
            ->assertRedirect('/login');
    }

    public function test_user_not_has_permission_owners_can_not_see_page()
    {
        $this->actingAs($this->user)
            ->get('/backend/owner')
            ->assertForbidden();
    }

    public function test_user_has_permission_owners_can_see_page()
    {
        //give the user permission owners to see owner page
        $this->user->givePermissionTo('owners');
        $this->actingAs($this->user)
            ->get('/backend/owner')
            ->assertViewIs('backend.owner.index')
            ->assertSee(['اصحاب السيارات'])
            ->assertSuccessful();
    }
}
