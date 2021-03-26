<?php

namespace Tests\Feature\Backend;

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

class CarTest extends TestCase
{

    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'cars']);
        Permission::create(['name'=>'create-car']);
        Permission::create(['name'=>'edit-car']);
        Permission::create(['name'=>'delete-car']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_have_permission_cars()
    {
        $this->actingAs($this->user)
        ->get('/backend/car')
        ->assertStatus(403);
    }

    public function test_user_have_permission_cars()
    {
        //give the user permission cars
        $this->user->givePermissionTo('cars');

        //login user
        $this->actingAs($this->user)
        ->get('/backend/car')
        ->assertStatus(200);
    }

    public function test_user_not_have_permission_create_car()
    {
        $this->actingAs($this->user)
        ->post('/backend/car',['name'=>'car12','image'=>'/image/car/1.png','phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>1])
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
        ->post('/backend/car',['name'=>'car12','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertStatus(200);
    }

    public function test_user_have_permission_create_car_and_fail()
    {
        //give this user permission create-car
        $this->user->givePermissionTo('create-car');
        //make default path public
        Storage::fake('public');
        //typecar
        $typecar=TypeCar::create(['name'=>'car127','number_seats'=>7,'status'=>1]);

        //! Image => image  try string
        $this->actingAs($this->user)
        ->post('/backend/car',['name'=>'car12','image'=>'hh','phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertSessionHasErrors('image')
        ->assertStatus(302);

        //! Image => image  try integer
        $this->actingAs($this->user)
        ->post('/backend/car',['name'=>'car12','image'=>1,'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertSessionHasErrors('image')
        ->assertStatus(302);

        //! name => required
        $this->actingAs($this->user)
        ->post('/backend/car',['name'=>null,'image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertSessionHasErrors('name')
        ->assertStatus(302);

        //! name => min:3
        $this->actingAs($this->user)
        ->post('/backend/car',['name'=>'ca','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertSessionHasErrors('name')
        ->assertStatus(302);

        //! phone_number => size:11
        $this->actingAs($this->user)
        ->post('/backend/car',['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'0123447554','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertSessionHasErrors('phone_number')
        ->assertStatus(302);

        //! public => in:0,1
        $this->actingAs($this->user)
        ->post('/backend/car',['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475548','status'=>1,'private'=>1,'public'=>2,'typecar_id'=>$typecar->id])
        ->assertSessionHasErrors('public')
        ->assertStatus(302);

        //! type_cars => exist in the database id
        $this->actingAs($this->user)
        ->post('/backend/car',['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475548','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id+1])
        ->assertSessionHasErrors('typecar_id')
        ->assertStatus(302);
    }

    public function test_user_not_have_permission_edit_car()
    {
        // $this->withoutExceptionHandling();
        $typecar=TypeCar::factory()->create();
        $car=Car::factory()->create();
        $this->actingAs($this->user)
        ->put('/backend/car/'.$car->id,['name'=>'car12','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertStatus(403);
    }

    public function test_user_have_permission_edit_car()
    {
        $this->user->givePermissionTo('edit-car');
        $typecar=TypeCar::factory()->create();
        $car=Car::factory()->create();
        $this->actingAs($this->user)
        ->put('/backend/car/'.$car->id,['name'=>'car12','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
        ->assertStatus(200);
    }

    public function test_user_have_permission_edit_car_and_fail()
    {
        $this->user->givePermissionTo('edit-car');
        $typecar=TypeCar::factory()->create();
        $car=Car::factory()->create();

         //! Image => image  try string
         $this->actingAs($this->user)
         ->put('/backend/car/'.$car->id,['name'=>'car12','image'=>'hh','phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
         ->assertSessionHasErrors('image')
         ->assertStatus(302);

         //! Image => image  try integer
         $this->actingAs($this->user)
         ->put('/backend/car/'.$car->id,['name'=>'car12','image'=>1,'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
         ->assertSessionHasErrors('image')
         ->assertStatus(302);

         //! name => required
         $this->actingAs($this->user)
         ->put('/backend/car/'.$car->id,['name'=>null,'image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
         ->assertSessionHasErrors('name')
         ->assertStatus(302);

         //! name => min:3
         $this->actingAs($this->user)
         ->put('/backend/car/'.$car->id,['name'=>'ca','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475544','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
         ->assertSessionHasErrors('name')
         ->assertStatus(302);

         //! phone_number => size:11
         $this->actingAs($this->user)
         ->put('/backend/car/'.$car->id,['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'0123447554','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id])
         ->assertSessionHasErrors('phone_number')
         ->assertStatus(302);

         //! public => in:0,1
         $this->actingAs($this->user)
         ->put('/backend/car/'.$car->id,['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475548','status'=>1,'private'=>1,'public'=>2,'typecar_id'=>$typecar->id])
         ->assertSessionHasErrors('public')
         ->assertStatus(302);

         //! type_cars => exist in the database id
         $this->actingAs($this->user)
         ->put('/backend/car/'.$car->id,['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475548','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id+1])
         ->assertSessionHasErrors('typecar_id')
         ->assertStatus(302);

        //! car.id => not exist in the database id
        $this->actingAs($this->user)
        ->put('/backend/car/'.$car->id+1,['name'=>'ca23','image'=>UploadedFile::fake()->image('1.png',500,500),'phone_number'=>'01234475548','status'=>1,'private'=>1,'public'=>1,'typecar_id'=>$typecar->id+1])
        ->assertStatus(404);
    }


    public function test_user_not_have_permission_delete_car()
    {
        $typecar=TypeCar::factory()->create();
        $car=Car::factory()->create();
        $this->actingAs($this->user)
        ->delete('/backend/car/'.$car->id)
        ->assertStatus(403);
    }

    public function test_user_have_permission_delete_car()
    {
        $this->user->givePermissionTo('delete-car');
        $typecar=TypeCar::factory()->create();
        $car=Car::factory()->create();
        $this->actingAs($this->user)
        ->delete('/backend/car/'.$car->id)
        ->assertStatus(200);
        $this->assertDatabaseMissing('cars',$car->toArray());
    }

    public function test_user_have_permission_delete_car_fail()
    {
        $this->user->givePermissionTo('delete-car');
        $typecar=TypeCar::factory()->create();
        $car=Car::factory()->create();
        $this->actingAs($this->user)
        ->delete('/backend/car/'.$car->id+1)
        ->assertStatus(404);
        $this->assertDatabaseHas('cars',['id'=>$car->id]);
    }

}
