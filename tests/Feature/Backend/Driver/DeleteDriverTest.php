<?php

namespace Tests\Feature\Backend\Driver;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DeleteDriverTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'delete-driver']);
        Role::create(['name'=>'Driver']);
        $this->user = User::factory()->create();
        $this->user2 = User::factory()->create();
        $this->driver=User::create(['name'=>'mohamed','email'=>'mohamed@example.com','password'=>bcrypt('12345678')])->assignRole('Driver');
        $this->user->drivers()->create(['driver_id'=>$this->driver->id]);
    }

    public function test_guest_can_not_delete_driver()
    {
        $this->json('DELETE','/backend/driver/'.$this->driver->id)
             ->assertUnauthorized()
             ->assertStatus(401);
    }

    public function test_user_not_have_permission_delete_driver_can_not_delete_driver()
    {
        $this->actingAs($this->user)
             ->json('DELETE','/backend/driver/'.$this->driver->id)
             ->assertForbidden()
             ->assertStatus(403);
    }

    public function test_user_have_permission_delete_driver_can_not_delete_driver_where_id_not_found()
    {
        //give user permission delete-driver
        $this->user->givePermissionTo('delete-driver');
        $this->actingAs($this->user)
             ->json('DELETE','/backend/driver/'.$this->driver->id+1)
             ->assertNotFound()
             ->assertStatus(404);
    }

    public function test_user_have_permission_delete_driver_can_delete_driver_and_success_deleted()
    {
        //give user permission delete-driver
        $this->user->givePermissionTo('delete-driver');
        $this->actingAs($this->user)
             ->json('DELETE','/backend/driver/'.$this->driver->id)
             ->assertSuccessful()
             ->assertStatus(200);
        $this->assertDatabaseCount('model_has_roles',0);
        $this->assertDatabaseCount('owner_driver',0);
        $this->assertDatabaseCount('users',2);
        $this->assertDatabaseMissing('owner_driver',$this->driver->toArray());
    }

    public function test_user_have_permission_delete_driver_can_not_delete_driver_not_belong_to_this_user()
    {
        //give user permission delete-driver
        $this->withoutExceptionHandling();
        $this->user2->givePermissionTo('delete-driver');
        $this->actingAs($this->user2)
             ->json('DELETE','/backend/driver/'.$this->driver->id)
             ->assertUnauthorized()
             ->assertStatus(401);
    }
}
