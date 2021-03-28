<?php

namespace Tests\Feature\Backend\Owner;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DeleteOwnerTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Role::create(['name'=>'Owner']);
        $this->user = User::factory()->create();
        $this->owner=User::create(['name'=>'mohamed','email'=>'mohamed@example.com','password'=>bcrypt('12345678')])->assignRole('Owner');
        Permission::create(['name'=>'delete-owner']);
    }

    public function test_guest_can_not_delete_owner()
    {
        $this->json('DELETE','/backend/owner/'.$this->owner->id)
             ->assertUnauthorized()
             ->assertStatus(401);
    }

    public function test_user_not_have_permission_delete_owner_can_not_delete_owner()
    {
        $this->actingAs($this->user)
             ->json('DELETE','/backend/owner/'.$this->owner->id)
             ->assertForbidden();
    }

    public function test_user_have_permission_delete_owner_can_not_delete_owner_where_id_not_found()
    {
        //give user permission delete-owner
        $this->user->givePermissionTo('delete-owner');
        $this->actingAs($this->user)
             ->json('DELETE','/backend/owner/'.$this->owner->id+1)
             ->assertNotFound();
    }

    public function test_user_have_permission_delete_owner_can_delete_owner_and_success_deleted()
    {
        //give user permission delete-owner
        $this->user->givePermissionTo('delete-owner');
        $this->actingAs($this->user)
             ->json('DELETE','/backend/owner/'.$this->owner->id)
             ->assertSuccessful()
             ->assertStatus(200);
        $this->assertDatabaseCount('model_has_roles',0);
        $this->assertDatabaseCount('users',1);
    }
}
