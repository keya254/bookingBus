<?php

namespace Tests\Feature\Backend\TypeCar;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CreateTypeCarTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name' => 'website name', 'description' => 'description', 'logo' => 'images/logo/logo.png']);
        Permission::create(['name' => 'create-typecar']);
        $this->user = User::factory()->create();
    }

    public function test_user_has_permission_create_typecar()
    {
        //give user permission
        $this->user->givePermissionTo('create-typecar');
        //login user has permission create-typecar
        $this->actingAs($this->user)
            ->json('post', '/backend/typecar', ['name' => 'car128', 'number_seats' => 7, 'status' => 1])
            ->assertSee('Success Created')
            ->assertStatus(201);
        //check if the record created
        $this->assertDatabaseHas('type_cars', ['name' => 'car128', 'number_seats' => 7, 'status' => 1]);
    }

    public function test_user_not_has_permission_to_create_typecar()
    {
        //login user has permission create-typecar
        $this->actingAs($this->user)
            ->json('post', '/backend/typecar', ['name' => 'car128', 'number_seats' => 7, 'status' => 1])
            ->assertStatus(403);
    }

    public function test_user_has_permission_to_create_typecar_and_all_error()
    {
        //give user permission
        $this->user->givePermissionTo('create-typecar');
        //!all errors  'name'=>'required|min:4|max:50','number_seats'=>'required|integer','status'=>'nullable|boolean|in:0,1'
        //login user has permission create-typecar
        $this->actingAs($this->user)
            ->json('post', '/backend/typecar', ['name' => 'car', 'number_seats' => '', 'status' => 3])
            ->assertJsonValidationErrors(['name', 'number_seats', 'status'])
            ->assertStatus(422);
    }

    public function test_user_has_permission_to_create_typecar_and_name_min_4()
    {
        //give user permission
        $this->user->givePermissionTo('create-typecar');
        //! name=> min=4
        //login user has permission create-typecar
        $this->actingAs($this->user)
            ->json('post', '/backend/typecar', ['name' => 'car', 'number_seats' => 1, 'status' => 1])
            ->assertJsonValidationErrors(['name'])
            ->assertStatus(422);
    }

    public function test_user_has_permission_to_create_typecar_name_required()
    {
        //give user permission
        $this->user->givePermissionTo('create-typecar');
        //! name=> required
        //login user has permission create-typecar
        $this->actingAs($this->user)
            ->json('post', '/backend/typecar', ['name' => '', 'number_seats' => 1, 'status' => 1])
            ->assertJsonValidationErrors(['name'])
            ->assertStatus(422);
    }

    public function test_user_has_permission_to_create_typecar_and_name_max_50()
    {
        //give user permission
        $this->user->givePermissionTo('create-typecar');
        //! name=> max=50
        //login user has permission create-typecar
        $this->actingAs($this->user)
            ->json('post', '/backend/typecar', ['name' => 'login user has permission create-typecar create-typecar create-typecar create-typecar', 'number_seats' => 1, 'status' => 1])
            ->assertJsonValidationErrors(['name'])
            ->assertStatus(422);

    }

    public function test_user_has_permission_to_create_typecar_and_number_seats_required()
    {
        //give user permission
        $this->user->givePermissionTo('create-typecar');
        //! number_seats=> required
        //login user has permission create-typecar
        $this->actingAs($this->user)
            ->json('post', '/backend/typecar', ['name' => 'car128', 'number_seats' => null, 'status' => 1])
            ->assertJsonValidationErrors(['number_seats'])
            ->assertStatus(422);
    }

    public function test_user_has_permission_to_create_typecar_and_number_seats_not_integer()
    {
        //give user permission
        $this->user->givePermissionTo('create-typecar');
        //! number_seats=> not integer
        //login user has permission create-typecar
        $this->actingAs($this->user)
            ->json('post', '/backend/typecar', ['name' => 'car128', 'number_seats' => 'mo', 'status' => 1])
            ->assertJsonValidationErrors(['number_seats'])
            ->assertStatus(422);
    }

    public function test_user_has_permission_to_create_typecar_and_status_in_0_1()
    {
        //give user permission
        $this->user->givePermissionTo('create-typecar');
        //! status=> between [0,1]
        //login user has permission create-typecar
        $this->actingAs($this->user)
            ->json('post', '/backend/typecar', ['name' => 'car128', 'number_seats' => 7, 'status' => 2])
            ->assertJsonValidationErrors(['status'])
            ->assertStatus(422);
    }
}
