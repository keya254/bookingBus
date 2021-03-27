<?php

namespace Tests\Feature\Backend\Car;

use App\Models\Car;
use App\Models\Setting;
use App\Models\TypeCar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class EditCarTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

         $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'edit-car']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_have_permission_edit_car()
    {
        // $this->withoutExceptionHandling();
        $typecar=TypeCar::factory()->create();
        $car=Car::factory()->create();
        $this->actingAs($this->user)
        ->json('PUT','/backend/car/'.$car->id,['name'=>'car12','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertStatus(403);
    }

    public function test_user_have_permission_edit_car()
    {
        $this->user->givePermissionTo('edit-car');
        $typecar=TypeCar::factory()->create();
        $car=Car::factory()->create();
        $this->actingAs($this->user)
        ->json('PUT','/backend/car/'.$car->id,['name'=>'car12','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertStatus(200);
    }

    public function test_user_have_permission_edit_car_and_fail()
    {
        $this->user->givePermissionTo('edit-car');
        $typecar=TypeCar::factory()->create();
        $car=Car::factory()->create();

         //! Image => image  try string
         $this->actingAs($this->user)
         ->json('PUT','/backend/car/'.$car->id,['name'=>'car12','image'=>'hh','phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
         ->assertJsonValidationErrors('image')
         ->assertStatus(422);

         //! Image => image  try integer
         $this->actingAs($this->user)
         ->json('PUT','/backend/car/'.$car->id,['name'=>'car12','image'=>1,'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
         ->assertJsonValidationErrors('image')
         ->assertStatus(422);

         //! name => required
         $this->actingAs($this->user)
         ->json('PUT','/backend/car/'.$car->id,['name'=>null,'image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
         ->assertJsonValidationErrors('name')
         ->assertStatus(422);

         //! name => min:3
         $this->actingAs($this->user)
         ->json('PUT','/backend/car/'.$car->id,['name'=>'ca','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
         ->assertJsonValidationErrors('name')
         ->assertStatus(422);

         //! phone_number => size:11
         $this->actingAs($this->user)
         ->json('PUT','/backend/car/'.$car->id,['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'0123447554','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
         ->assertJsonValidationErrors('phone_number')
         ->assertStatus(422);

         //! public => in:0,1
         $this->actingAs($this->user)
         ->json('PUT','/backend/car/'.$car->id,['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475548','status'=>1,'private'=>1,'public'=>2,'typecar_id'=>$typecar->id])
         ->assertJsonValidationErrors('public')
         ->assertStatus(422);

         //! type_cars => exist in the database id
         $this->actingAs($this->user)
         ->json('PUT','/backend/car/'.$car->id,['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475548','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id+2])
         ->assertJsonValidationErrors('typecar_id')
         ->assertStatus(422);

        //! car.id => not exist in the database id
        $this->actingAs($this->user)
        ->json('PUT','/backend/car/'.$car->id+1,['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475548','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id+1])
        ->assertStatus(404);
    }

}
