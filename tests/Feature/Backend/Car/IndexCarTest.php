<?php

namespace Tests\Feature\Backend\Car;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IndexCarTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name' => 'website name', 'description' => 'description', 'logo' => 'images/logo/logo.png']);
        Permission::create(['name' => 'cars']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_has_permission_cars()
    {
        $this->actingAs($this->user)
            ->get('/backend/car')
            ->assertStatus(403);
    }

    public function test_user_has_permission_cars()
    {
        //give the user permission cars
        $this->user->givePermissionTo('cars');

        //login user
        $this->actingAs($this->user)
            ->get('/backend/car')
            ->assertStatus(200);
    }

}
