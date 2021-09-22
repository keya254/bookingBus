<?php

namespace Tests\Feature\Backend\Car;

use App\Models\Setting;
use App\Models\TypeCar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CreateCarTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

         $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'create-car']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_have_permission_create_car()
    {
        $this->actingAs($this->user)
        ->json('POST','/backend/car',['name'=>'car12','image'=>'/image/car/1.png','phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>1])
        ->assertStatus(403);
    }

    public function test_user_have_permission_create_car()
    {
        //give this user permission create-car
        $this->user->givePermissionTo('create-car');
        //make default path public
        Storage::fake('public');
        //typecar
        $typecar=TypeCar::create(['name'=>'car127','number_seats'=>7,'status'=>1]);
        //login user
        $this->actingAs($this->user)
        ->json('POST','/backend/car',['name'=>'car12','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertStatus(200);
    }

    public function test_user_have_permission_create_car_and_image_string()
    {
        //give this user permission create-car
        $this->user->givePermissionTo('create-car');
        $typecar=TypeCar::create(['name'=>'car127','number_seats'=>7,'status'=>1]);

        //! Image => image  try string
        $this->actingAs($this->user)
        ->json('POST','/backend/car',['name'=>'car12','image'=>'hh','phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertJsonValidationErrors('image')
        ->assertStatus(422);
    }

    public function test_user_have_permission_create_car_and_image_integer()
    {
        //give this user permission create-car
        $this->user->givePermissionTo('create-car');
        $typecar=TypeCar::create(['name'=>'car127','number_seats'=>7,'status'=>1]);
        //! Image => image  try integer
        $this->actingAs($this->user)
        ->json('POST','/backend/car',['name'=>'car12','image'=>1,'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertJsonValidationErrors('image')
        ->assertStatus(422);

    }

    public function test_user_have_permission_create_car_and_name_required()
    {
        //give this user permission create-car
        $this->user->givePermissionTo('create-car');
        $typecar=TypeCar::create(['name'=>'car127','number_seats'=>7,'status'=>1]);
        //! name => required
        $this->actingAs($this->user)
        ->json('POST','/backend/car',['name'=>null,'image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertJsonValidationErrors('name')
        ->assertStatus(422);
    }

    public function test_user_have_permission_create_car_and_name_min_3()
    {
        //give this user permission create-car
        $this->user->givePermissionTo('create-car');
        $typecar=TypeCar::create(['name'=>'car127','number_seats'=>7,'status'=>1]);
        //! name => min:3
        $this->actingAs($this->user)
        ->json('POST','/backend/car',['name'=>'ca','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertJsonValidationErrors('name')
        ->assertStatus(422);
    }

    public function test_user_have_permission_create_car_and_phone_number_size_11()
    {
        //give this user permission create-car
        $this->user->givePermissionTo('create-car');
        $typecar=TypeCar::create(['name'=>'car127','number_seats'=>7,'status'=>1]);
        //! phone_number => size:11
        $this->actingAs($this->user)
        ->json('POST','/backend/car',['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'0123447554','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertJsonValidationErrors('phone_number')
        ->assertStatus(422);
    }

    public function test_user_have_permission_create_car_and_public_in_0_1()
    {
        //give this user permission create-car
        $this->user->givePermissionTo('create-car');
        $typecar=TypeCar::create(['name'=>'car127','number_seats'=>7,'status'=>1]);
        //! public => in:0,1
        $this->actingAs($this->user)
        ->json('POST','/backend/car',['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475548','status'=>1,'private'=>1,'public'=>2,'typecar_id'=>$typecar->id])
        ->assertJsonValidationErrors('public')
        ->assertStatus(422);
    }

    public function test_user_have_permission_create_car_and_typecar_not_exist_in_database()
    {
        //give this user permission create-car
        $this->user->givePermissionTo('create-car');
        $typecar=TypeCar::create(['name'=>'car127','number_seats'=>7,'status'=>1]);
        //! type_cars => exist in the database id
        $this->actingAs($this->user)
        ->json('POST','/backend/car',['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475548','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id+1])
        ->assertJsonValidationErrors('typecar_id')
        ->assertStatus(422);
    }

}
