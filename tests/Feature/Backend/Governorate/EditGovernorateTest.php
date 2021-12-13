<?php

namespace Tests\Feature\Backend\Governorate;

use App\Models\Governorate;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class EditGovernorateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name' => 'website name', 'description' => 'description', 'logo' => 'images/logo/logo.png']);
        Permission::create(['name' => 'edit-governorate']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_has_permission_edit_governorate_can_not_edit_governorate()
    {
        //create governorate
        $governorate = Governorate::create(['name' => 'الجيزة']);
        //user not has permission
        $this->actingAs($this->user)
        //login user
            ->json('put', '/backend/governorate/' . $governorate->id, ['name' => 'القاهرة'])
            ->assertStatus(403);
    }

    public function test_user_has_permission_edit_governorate_can_edit_governorate()
    {
        //give permission to this user to edit governorate
        $this->user->givePermissionTo('edit-governorate');
        //create governorate
        $governorate = Governorate::create(['name' => 'الجيزة']);
        //user not has permission
        $this->actingAs($this->user)
        //login user
            ->json('put', '/backend/governorate/' . $governorate->id, ['name' => 'القاهرة'])
            ->assertStatus(200);
        //check the governorates updated
        $this->assertDatabaseHas('governorates', ['id' => $governorate->id, 'name' => 'القاهرة']);
    }

    public function test_user_has_permission_edit_governorate_can_not_update_the_same_name_in_database()
    {
        //give permission to this user to edit governorate
        $this->user->givePermissionTo('edit-governorate');
        //create governorate
        $governorate1 = Governorate::create(['name' => 'الجيزة']);
        $governorate2 = Governorate::create(['name' => 'القاهرة']);
        //user not has permission
        $this->actingAs($this->user)
        //login user
            ->json('put', '/backend/governorate/' . $governorate1->id, ['name' => 'القاهرة'])
            ->assertStatus(422);
        //check the governorates not updated
        $this->assertDatabaseHas('governorates', ['id' => $governorate1->id, 'name' => 'الجيزة']);
    }

}
