<?php

namespace Tests\Feature\Backend\Car;

use App\Models\Car;
use App\Models\Setting;
use App\Models\TypeCar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class EditCarTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name' => 'website name', 'description' => 'description', 'logo' => 'images/logo/logo.png']);
        Permission::create(['name' => 'edit-car']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_has_permission_edit_car()
    {
        $typecar = TypeCar::factory()->create();
        $car = Car::factory()->create();
        $this->actingAs($this->user)
            ->json('PUT', '/backend/car/' . $car->id, ['name' => 'car12', 'image' => UploadedFile::fake()->image('1.png', 500, 500), 'phone_number' => '01234475544', 'status' => 1, 'private' => 1, 'public' => 1, 'typecar_id' => $typecar->id])
            ->assertStatus(403);
    }

    public function test_user_has_permission_edit_car()
    {
        $this->user->givePermissionTo('edit-car');
        Storage::fake('public');
        $typecar = TypeCar::factory()->create();
        $car = Car::factory()->create();
        $this->actingAs($this->user)
            ->json('PUT', '/backend/car/' . $car->id, ['name' => 'car12', 'image' => UploadedFile::fake()->image('1.png', 500, 500), 'phone_number' => '01234475544', 'status' => 1, 'private' => 1, 'public' => 1, 'typecar_id' => $typecar->id])
            ->assertStatus(200);
    }

    public function test_user_has_permission_edit_car_and_image_not_string()
    {
        $this->user->givePermissionTo('edit-car');
        $typecar = TypeCar::factory()->create();
        $car = Car::factory()->create();

        //! Image => image  try string
        $this->actingAs($this->user)
            ->json('PUT', '/backend/car/' . $car->id, ['name' => 'car12', 'image' => 'hh', 'phone_number' => '01234475544', 'status' => 1, 'private' => 1, 'public' => 1, 'typecar_id' => $typecar->id])
            ->assertJsonValidationErrors('image')
            ->assertStatus(422);
    }

    public function test_user_has_permission_edit_car_and_image_not_integer()
    {
        $this->user->givePermissionTo('edit-car');
        $typecar = TypeCar::factory()->create();
        $car = Car::factory()->create();
        //! Image => image  try integer
        $this->actingAs($this->user)
            ->json('PUT', '/backend/car/' . $car->id, ['name' => 'car12', 'image' => 1, 'phone_number' => '01234475544', 'status' => 1, 'private' => 1, 'public' => 1, 'typecar_id' => $typecar->id])
            ->assertJsonValidationErrors('image')
            ->assertStatus(422);
    }

    public function test_user_has_permission_edit_car_and_name_required()
    {
        $this->user->givePermissionTo('edit-car');
        $typecar = TypeCar::factory()->create();
        $car = Car::factory()->create();
        //! name => required
        $this->actingAs($this->user)
            ->json('PUT', '/backend/car/' . $car->id, ['name' => null, 'image' => UploadedFile::fake()->image('1.png', 500, 500), 'phone_number' => '01234475544', 'status' => 1, 'private' => 1, 'public' => 1, 'typecar_id' => $typecar->id])
            ->assertJsonValidationErrors('name')
            ->assertStatus(422);
    }

    public function test_user_has_permission_edit_car_and_name_min_3()
    {
        $this->user->givePermissionTo('edit-car');
        $typecar = TypeCar::factory()->create();
        $car = Car::factory()->create();
        //! name => min:3
        $this->actingAs($this->user)
            ->json('PUT', '/backend/car/' . $car->id, ['name' => 'ca', 'image' => UploadedFile::fake()->image('1.png', 500, 500), 'phone_number' => '01234475544', 'status' => 1, 'private' => 1, 'public' => 1, 'typecar_id' => $typecar->id])
            ->assertJsonValidationErrors('name')
            ->assertStatus(422);
    }

    public function test_user_has_permission_edit_car_and_phone_number_size_11()
    {
        $this->user->givePermissionTo('edit-car');
        $typecar = TypeCar::factory()->create();
        $car = Car::factory()->create();
        //! phone_number => size:11
        $this->actingAs($this->user)
            ->json('PUT', '/backend/car/' . $car->id, ['name' => 'ca23', 'image' => UploadedFile::fake()->image('1.png', 500, 500), 'phone_number' => '0123447554', 'status' => 1, 'private' => 1, 'public' => 1, 'typecar_id' => $typecar->id])
            ->assertJsonValidationErrors('phone_number')
            ->assertStatus(422);
    }

    public function test_user_has_permission_edit_car_and_public_in_0_1()
    {
        $this->user->givePermissionTo('edit-car');
        $typecar = TypeCar::factory()->create();
        $car = Car::factory()->create();
        //! public => in:0,1
        $this->actingAs($this->user)
            ->json('PUT', '/backend/car/' . $car->id, ['name' => 'ca23', 'image' => UploadedFile::fake()->image('1.png', 500, 500), 'phone_number' => '01234475548', 'status' => 1, 'private' => 1, 'public' => 2, 'typecar_id' => $typecar->id])
            ->assertJsonValidationErrors('public')
            ->assertStatus(422);
    }

    public function test_user_has_permission_edit_car_and_typecar_not_exist_in_database()
    {
        $this->user->givePermissionTo('edit-car');
        $typecar = TypeCar::factory()->create();
        $car = Car::factory()->create();
        //! type_cars => exist in the database id
        $this->actingAs($this->user)
            ->json('PUT', '/backend/car/' . $car->id, ['name' => 'ca23', 'image' => UploadedFile::fake()->image('1.png', 500, 500), 'phone_number' => '01234475548', 'status' => 1, 'private' => 1, 'public' => 1, 'typecar_id' => $typecar->id + 2])
            ->assertJsonValidationErrors('typecar_id')
            ->assertStatus(422);
    }

    public function test_user_has_permission_edit_car_and_car_id_not_found_in_database()
    {
        $this->user->givePermissionTo('edit-car');
        $typecar = TypeCar::factory()->create();
        $car = Car::factory()->create();
        //! car.id => not exist in the database id
        $this->actingAs($this->user)
            ->json('PUT', '/backend/car/' . $car->id + 1, ['name' => 'ca23', 'image' => UploadedFile::fake()->image('1.png', 500, 500), 'phone_number' => '01234475548', 'status' => 1, 'private' => 1, 'public' => 1, 'typecar_id' => $typecar->id + 1])
            ->assertStatus(404);
    }

}
