<?php

namespace Tests\Feature\Backend\Governorate;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CreateGovernorateTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'create-governorate']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_has_permission_create_governorate_can_not_see_page()
    {
        //user not has permission
        $this->actingAs($this->user)
           //login user
           ->json('post','/backend/governorate',['name'=>'القاهرة'])
           ->assertForbidden(403);
    }

    public function test_user_has_permission_create_governorate_can_see_page()
    {
        //give permission to this user to create governorate
        $this->user->givePermissionTo('create-governorate');
        //user not has permission
        $this->actingAs($this->user)
           //login user
           ->json('post','/backend/governorate',['name'=>'القاهرة'])
           ->assertSuccessful(200);
        //check the governorates founded
        $this->assertDatabaseHas('governorates',['name'=>'القاهرة']);
    }


}
