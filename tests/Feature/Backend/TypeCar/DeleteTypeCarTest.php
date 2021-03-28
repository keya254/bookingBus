<?php

namespace Tests\Feature\Backend\TypeCar;

use App\Models\Setting;
use App\Models\TypeCar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class DeleteTypeCarTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'delete-typecar']);
        $this->user = User::factory()->create();
    }

    public function test_user_not_have_permission_delete_typecar()
    {
        //create typecar
        $typecar=TypeCar::create(['name'=>'car128','number_seats'=>7,'status'=>1]);
        //login user not have permission delete-typecar
        $this->actingAs($this->user)
        ->json('delete','/backend/typecar/'.$typecar->id)
        ->assertStatus(403);
    }

    public function test_user_have_permission_delete_typecar()
    {
        //give permission to user
        $this->user->givePermissionTo('delete-typecar');
        //create typecar
        $typecar=TypeCar::create(['name'=>'car128','number_seats'=>7,'status'=>1]);
        //login user not have permission delete-typecar
        $this->actingAs($this->user)
        ->json('delete','/backend/typecar/'.$typecar->id)
        ->assertStatus(200);
        //check the record does not exist in the database.
        $this->assertDatabaseMissing('type_cars',['id'=>$typecar->id,'name'=>'car128','number_seats'=>7,'status'=>1]);
    }

    public function test_user_have_permission_delete_typecar_and_fail()
    {
        //give permission to user
        $this->user->givePermissionTo('delete-typecar');
        //create typecar
        $typecar=TypeCar::create(['name'=>'car128','number_seats'=>7,'status'=>1]);
        //login user not have permission delete-typecar
        $this->actingAs($this->user)
        ->json('delete','/backend/typecar/'.$typecar->id+1)
        ->assertStatus(404);
        //check the record exist in the database. not deleted
        $this->assertDatabaseHas('type_cars',['id'=>$typecar->id,'name'=>'car128','number_seats'=>7,'status'=>1]);
    }

}
