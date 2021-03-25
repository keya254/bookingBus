<?php

namespace Tests\Feature\Backend;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CarTest extends TestCase
{

    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'cars']);
        Permission::create(['name'=>'create-car']);
        Permission::create(['name'=>'edit-car']);
        Permission::create(['name'=>'delete-car']);
        $this->user = User::factory()->create();
    }

    public function test_car()
    {
        $this->assertTrue(1==1);
    }
}
