<?php

namespace Tests\Feature\Backend\TypeCar;

use App\Models\Setting;
use App\Models\TypeCar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class StatusTypeCarTest extends TestCase
{
  use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'status-typecar']);

        $this->user=User::factory()->create();
    }

    public function test_guest_can_not_change_status()
    {
        $this->json('post','/backend/typecar/changestatus')
             ->assertUnauthorized();
    }

    public function test_user_not_have_permission_status_typecar_can_not_change_status()
    {
        $this->actingAs($this->user);
        $this->json('post','/backend/typecar/changestatus')
             ->assertForbidden();
    }

    public function test_user_have_permission_status_typecar_can_change_status()
    {
        $this->user->givePermissionTo('status-typecar');
        $typecar=TypeCar::factory()->create();
        $this->actingAs($this->user);
        $this->json('post','/backend/typecar/changestatus',['id'=>$typecar->id])
             ->assertSuccessful();
        $this->assertNotEquals($typecar->status,$typecar->fresh()->status);
    }
}
