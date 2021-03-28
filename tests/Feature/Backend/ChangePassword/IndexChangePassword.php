<?php

namespace Tests\Feature\Backend\ChangePassword;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IndexChangePassword extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'change-password']);
        $this->user = User::factory()->create();
    }

    public function test_guest_can_not_see_page_change_password()
    {
        $this->get('/backend/change-password')
             ->assertRedirect('/login');
    }

    public function test_user_not_have_permission_change_password_can_not_see_page_change_password()
    {
        $this->actingAs($this->user)
             ->get('/backend/change-password')
             ->assertForbidden()
             ->assertStatus(403);
    }

    public function test_user_have_permission_change_password_can_see_page_change_password()
    {
        $this->user->givePermissionTo('change-password');
        $this->actingAs($this->user)
             ->get('/backend/change-password')
             ->assertSuccessful()
             ->assertSee(['كلمة السر القديمة','كلمة السر الجديدة'])
             ->assertStatus(200);
    }

    public function test_user_not_have_permission_change_password_can_not_change_password()
    {
        $this->actingAs($this->user)
             ->json('post','/backend/change-password',['old_password'=>'12345678','password'=>'123456789','password_confirmation'=>'123456789'])
             ->assertStatus(401);
    }

    public function test_user_have_permission_change_password_can_not_change_password_and_old_password_required()
    {
        $this->user->givePermissionTo('change-password');
        $this->actingAs($this->user)
             ->json('post','/backend/change-password',['old_password'=>null,'password'=>'123456789','password_confirmation'=>'123456789'])
             ->assertJsonValidationErrors(['old_password'])
             ->assertStatus(422);
    }

    public function test_user_have_permission_change_password_can_not_change_password_and_password_required()
    {
        $this->user->givePermissionTo('change-password');
        $this->actingAs($this->user)
             ->json('post','/backend/change-password',['old_password'=>'12345678','password'=>null,'password_confirmation'=>'123456789'])
             ->assertJsonValidationErrors(['password'])
             ->assertStatus(422);
    }

    public function test_user_have_permission_change_password_can_not_change_password_and_password_min_8()
    {
        $this->user->givePermissionTo('change-password');
        $this->actingAs($this->user)
             ->json('post','/backend/change-password',['old_password'=>'12345678','password'=>'123456','password_confirmation'=>'123456789'])
             ->assertJsonValidationErrors(['password'])
             ->assertStatus(422);
    }

    public function test_user_have_permission_change_password_can_not_change_password_and_old_password_min_8()
    {
        $this->user->givePermissionTo('change-password');
        $this->actingAs($this->user)
             ->json('post','/backend/change-password',['old_password'=>'123456','password'=>'123456789','password_confirmation'=>'123456789'])
             ->assertJsonValidationErrors(['old_password'])
             ->assertStatus(422);
    }

    public function test_user_have_permission_change_password_can_not_change_password_and_old_password_not_correct()
    {
        $this->user->givePermissionTo('change-password');
        $this->actingAs($this->user)
             ->json('post','/backend/change-password',['old_password'=>'12345687','password'=>'123456789','password_confirmation'=>'123456789'])
             ->assertJsonValidationErrors(['old_password'])
             ->assertStatus(422);
    }

    public function test_user_have_permission_change_password_can_not_change_password_and_password_confirmation_not_correct()
    {
        $this->user->givePermissionTo('change-password');
        $this->actingAs($this->user)
             ->json('post','/backend/change-password',['old_password'=>'12345687','password'=>'123456798','password_confirmation'=>'123456789'])
             ->assertJsonValidationErrors(['password'])
             ->assertStatus(422);
    }
}
