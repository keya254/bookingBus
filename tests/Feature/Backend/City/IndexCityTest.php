<?php

namespace Tests\Feature\Backend\City;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IndexCityTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'citys']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_has_permission_citys_can_not_see_page()
    {
        //login user not access this page when not has permission 'citys'
        $this->actingAs($this->user)
        ->get('/backend/city')
        ->assertStatus(403);
    }

    public function test_user_has_permission_citys_can_see_page_see_all_cities()
    {
        //given permission to this user
        $this->user->givePermissionTo('citys');
        //login user access this page when has permission 'citys'
        $this->actingAs($this->user)
        ->get('/backend/city')
        ->assertStatus(200)
        //check the page has this titles
        ->assertSee(['اسم المحافظة','اسم المدينة']);
    }

}
