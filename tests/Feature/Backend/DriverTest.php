<?php

namespace Tests\Feature\Backend;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class DriverTest extends TestCase
{

    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'drivers']);
        Permission::create(['name'=>'create-driver']);
        Permission::create(['name'=>'delete-driver']);
        $this->user = User::factory()->create();
    }

    public function test_driver()
    {
        $this->assertTrue(1==1);
    }
}
