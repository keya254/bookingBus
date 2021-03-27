<?php

namespace Tests\Feature\Backend\Owner;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateOwnerTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'create-owner']);
        $this->user = User::factory()->create();
        $this->email = ['name'=>'mohamed','email'=>'mohamed@example.com','password'=>'12345678','password_confirmation'=>'12345678'];
    }

    public function test_gust_can_not_create_owner()
    {
          $this
           ->json('POST','/backend/owner',$this->email)
           ->assertUnauthorized()
           ->assertStatus(401);
    }

    public function test_user_not_have_permission_create_owner_can_not_create_owner()
    {
          $this->actingAs($this->user)
           ->json('POST','/backend/owner',$this->email)
           ->assertForbidden()
           ->assertStatus(403);
    }

    public function test_user_have_permission_create_owner_can_create_owner()
    {
          //create Role owner
          Role::create(['name'=>'Owner']);
          //give user permission create-owner
          $this->user->givePermissionTo('create-owner');
          //login user
          $this->actingAs($this->user)
           ->json('POST','/backend/owner',$this->email)
           ->assertSee(['success created'])
           ->assertStatus(200);
          $this->assertDatabaseCount('users',2);
          $this->assertDatabaseCount('model_has_roles',1);
          $this->assertDatabaseHas('model_has_roles',['role_id'=>1,'model_id'=>2]);
          $this->assertDatabaseHas('notifications',["type" => "App\\Notifications\\NewOwnerNotification",'notifiable_id'=>2]);
    }
}
