<?php

namespace Tests\Feature\Backend\Driver;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IndexDriverTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'drivers']);
        $this->user = User::factory()->create();
    }

    public function test_guest_can_not_see_page_driver()
    {
        $this->get('/backend/driver')
             ->assertRedirect('/login');
    }

    public function test_user_not_have_permission_drivers_can_not_see_page_driver()
    {
        $this->actingAs($this->user)
        ->get('/backend/driver')
        ->assertStatus(403);
    }

    public function test_user_have_permission_drivers_can_see_page_driver()
    {
        //give the user permission drivers to see driver page
        $this->user->givePermissionTo('drivers');
        $this->actingAs($this->user)
        ->get('/backend/driver')
        ->assertViewIs('backend.driver.index')
        ->assertSee(['السائقين'])
        ->assertStatus(200);
    }
}
