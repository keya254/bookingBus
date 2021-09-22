<?php

namespace Tests\Feature\Backend\Driver;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateDriverTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'create-driver']);
        $this->user = User::factory()->create();
        $this->email = ['name'=>'mohamed','email'=>'mohamed@example.com','password'=>'12345678','password_confirmation'=>'12345678'];
    }

    public function test_gust_can_not_create_driver()
    {
          $this
           ->json('POST','/backend/driver',$this->email)
           ->assertUnauthorized()
           ->assertStatus(401);
    }

    public function test_user_not_has_permission_create_driver_can_not_create_driver()
    {
          $this->actingAs($this->user)
           ->json('POST','/backend/driver',$this->email)
           ->assertForbidden()
           ->assertStatus(403);
    }

    public function test_user_has_permission_create_driver_can_create_driver()
    {
          //create Role Driver
          Role::create(['name'=>'Driver']);
          //give user permission create-driver
          $this->user->givePermissionTo('create-driver');
          //login user
          $this->actingAs($this->user)
           ->json('POST','/backend/driver',$this->email)
           ->assertSee(['success created'])
           ->assertStatus(200);
          $this->assertDatabaseCount('users',2);
          $this->assertDatabaseCount('model_has_roles',1);
          $this->assertDatabaseHas('model_has_roles',['role_id'=>1,'model_id'=>2]);
          $this->assertDatabaseHas('owner_driver',['driver_id'=>2]);
          $this->assertDatabaseHas('notifications',["type" => "App\\Notifications\\NewDriverNotification",'notifiable_id'=>2]);
    }
}
