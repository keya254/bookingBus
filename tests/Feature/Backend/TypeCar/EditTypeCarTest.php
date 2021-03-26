<?php

namespace Tests\Feature\Backend\TypeCar;

use App\Models\Setting;
use App\Models\TypeCar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class EditTypeCarTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'edit-typecar']);
        $this->user = User::factory()->create();
    }

    public function test_user_have_permission_edit_typecar()
    {
         //give user permission
         $this->user->givePermissionTo('edit-typecar');
         $typecar=TypeCar::create(['name'=>'car128','number_seats'=>7,'status'=>1]);
         //login user have permission edit-type
         $this->actingAs($this->user)
         ->put('/backend/typecar/'.$typecar->id,['name'=>'car128_127','number_seats'=>9,'status'=>0])
         ->assertStatus(200);
         // check the record before update not found in the database
         $this->assertDatabaseMissing('type_cars',['id'=> $typecar->id,'name'=>'car128','number_seats'=>7,'status'=>1]);
         // check the record is updated
         $this->assertDatabaseHas('type_cars',['id'=> $typecar->id,'name'=>'car128_127','number_seats'=>9,'status'=>0]);

        //! status=>null
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->put('/backend/typecar/'.$typecar->id,['name'=>'car128','number_seats'=>7])
        ->assertStatus(200);
    }

    public function test_user_not_have_permission_edit_typecar()
    {
         $typecar=TypeCar::create(['name'=>'car128','number_seats'=>7,'status'=>1]);
         //login user have permission edit-type
         $this->actingAs($this->user)
         ->put('/backend/typecar/'.$typecar->id,['name'=>'car128','number_seats'=>9,'status'=>1])
         ->assertStatus(403);
         $this->assertDatabaseHas('type_cars',['id'=> $typecar->id,'name'=>'car128','number_seats'=>7,'status'=>1]);
    }

    public function test_user_have_permission_edit_typecar_and_fail()
    {
        //give user permission
        $this->user->givePermissionTo('edit-typecar');

        $typecar=TypeCar::create(['name'=>'car128','number_seats'=>10,'status'=>1]);
        //!all errors  'name'=>'required|min:4|max:50','number_seats'=>'required|integer','status'=>'nullable|boolean|in:0,1'

        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->put('/backend/typecar/'.$typecar->id,['name'=>'c','number_seats'=>'','status'=>6])
        ->assertSessionHasErrors(['name','number_seats','status'])
        ->assertStatus(302);

        //! name=>required
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->put('/backend/typecar/'.$typecar->id,['name'=>null,'number_seats'=>7,'status'=>1])
        ->assertSessionHasErrors(['name'])
        ->assertStatus(302);

         //! name=>min:4
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->put('/backend/typecar/'.$typecar->id,['name'=>'car','number_seats'=>7,'status'=>1])
        ->assertSessionHasErrors(['name'])
        ->assertStatus(302);

          //! name=>max:50
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->put('/backend/typecar/'.$typecar->id,['name'=>'carcarcarcarcarcarcarcarcarcarcarcarcarcar carcarcarcarcarcarcarcarcarcarcarcarcarcar','number_seats'=>7,'status'=>1])
        ->assertSessionHasErrors(['name'])
        ->assertStatus(302);

          //! number_seats=>required
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->put('/backend/typecar/'.$typecar->id,['name'=>'car1234','number_seats'=>null,'status'=>1])
        ->assertSessionHasErrors(['number_seats'])
        ->assertStatus(302);

         //! number_seats=>string
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->put('/backend/typecar/'.$typecar->id,['name'=>'car127','number_seats'=>'test_string','status'=>1])
        ->assertSessionHasErrors(['number_seats'])
        ->assertStatus(302);

        //! status=>between 1,2
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->put('/backend/typecar/'.$typecar->id,['name'=>'car128','number_seats'=>7,'status'=>6])
        ->assertSessionHasErrors(['status'])
        ->assertStatus(302);
    }

}