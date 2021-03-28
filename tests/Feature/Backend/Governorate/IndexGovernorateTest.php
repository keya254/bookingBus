<?php

namespace Tests\Feature\Backend\Governorate;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IndexGovernorateTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'governorates']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_have_permission_governorates_can_not_see_page()
    {
        //user not have permission
        $this->actingAs($this->user)
           //login user
           ->get('/backend/governorate')
           ->assertStatus(403);
    }

    public function test_user_have_permission_governorates_can_see_page()
    {
        $this->user->givePermissionTo('governorates');
        //check the permission founded
        $this->assertDatabaseHas('permissions',['name'=>'governorates']);
        //user not have permission
        $this->actingAs($this->user)
           //login user
           ->get('/backend/governorate')
           ->assertStatus(200)
           ->assertSee(['اسم المحافظة']);
    }
}
