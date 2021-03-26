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
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'create-typecar']);
        $this->user = User::factory()->create();
    }

    public function test_user_have_permission_create_typecar()
    {
        //give user permission
        $this->user->givePermissionTo('create-typecar');
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->post('/backend/typecar',['name'=>'car128','number_seats'=>7,'status'=>1])
        ->assertSee('success created')
        ->assertStatus(200);
        //check if the record created
        $this->assertDatabaseHas('type_cars',['name'=>'car128','number_seats'=>7,'status'=>1]);
    }

    public function test_user_not_have_permission_to_create_typecar()
    {
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->post('/backend/typecar',['name'=>'car128','number_seats'=>7,'status'=>1])
        ->assertStatus(403);
    }

    public function test_user_have_permission_to_create_typecar_and_fail()
    {
        //give user permission
        $this->user->givePermissionTo('create-typecar');
        //!all errors  'name'=>'required|min:4|max:50','number_seats'=>'required|integer','status'=>'nullable|boolean|in:0,1'
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->post('/backend/typecar',['name'=>'car','number_seats'=>'','status'=>3])
        ->assertSessionHasErrors(['name','number_seats','status'])
        ->assertStatus(302);

        //! name=> min=4
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->post('/backend/typecar',['name'=>'car','number_seats'=>1,'status'=>1])
        ->assertSessionHasErrors(['name'])
        ->assertStatus(302);

        //! name=> required
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->post('/backend/typecar',['name'=>'','number_seats'=>1,'status'=>1])
        ->assertSessionHasErrors(['name'])
        ->assertStatus(302);

        //! name=> max=50
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->post('/backend/typecar',['name'=>'login user have permission create-typecar create-typecar create-typecar create-typecar','number_seats'=>1,'status'=>1])
        ->assertSessionHasErrors(['name'])
        ->assertStatus(302);

        //! number_seats=> required
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->post('/backend/typecar',['name'=>'car128','number_seats'=>null,'status'=>1])
        ->assertSessionHasErrors(['number_seats'])
        ->assertStatus(302);

        //! number_seats=> not integer
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->post('/backend/typecar',['name'=>'car128','number_seats'=>'mo','status'=>1])
        ->assertSessionHasErrors(['number_seats'])
        ->assertStatus(302);

        //! status=> between [0,1]
        //login user have permission create-typecar
        $this->actingAs($this->user)
        ->post('/backend/typecar',['name'=>'car128','number_seats'=>7,'status'=>2])
        ->assertSessionHasErrors(['status'])
        ->assertStatus(302);
    }
}
