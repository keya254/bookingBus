<?php

namespace Tests\Feature\Backend\Dashboard;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IndexDashboardTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'dashboard']);
        $this->user = User::factory()->create();
    }

    public function test_guest_can_not_see_page()
    {
        $this->get('/backend/dashboard')
             ->assertRedirect('/login');
    }

    public function test_user_not_have_permission_dashboard_can_not_see_page()
    {
        $this->actingAs($this->user)
             ->get('/backend/dashboard')
             ->assertForbidden()
             ->assertStatus(403);
    }

    public function test_user_have_permission_dashboard_can_see_page()
    {
        $this->user->givePermissionTo('dashboard');
        $this->actingAs($this->user)
             ->get('/backend/dashboard')
             ->assertViewIs('backend.dashboard.index')
             ->assertViewHas('data')
             ->assertStatus(200);
    }
}
