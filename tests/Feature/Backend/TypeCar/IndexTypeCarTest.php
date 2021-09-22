<?php

namespace Tests\Feature\Backend\TypeCar;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IndexTypeCarTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'typecars']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_has_permission_typecars()
    {
        //login user do not has permission typecars
        $this->actingAs($this->user)
        ->get('/backend/typecar')
        ->assertStatus(403);
    }

    public function test_user_has_permission_typecars()
    {
        //give user permission
        $this->user->givePermissionTo('typecars');
        //login user has permission typecars
        $this->actingAs($this->user)
        ->get('/backend/typecar')
        ->assertStatus(200)
        ->assertSee(['انواع السيارات']);
    }

}
