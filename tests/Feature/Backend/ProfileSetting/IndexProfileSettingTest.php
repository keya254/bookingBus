<?php

namespace Tests\Feature\Backend\ProfileSetting;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IndexProfileSettingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name' => 'website name', 'description' => 'description', 'logo' => 'images/logo/logo.png']);
        Permission::create(['name' => 'profile-setting']);
        $this->user = User::factory()->create();
    }

    public function test_guest_can_not_see_page_profile_setting()
    {
        $this->get('/backend/profile-setting')
            ->assertRedirect('/login');
    }

    public function test_user_not_have_permission_profile_setting_can_not_see_page_profile_setting()
    {
        $this->actingAs($this->user)
            ->get('/backend/profile-setting')
            ->assertForbidden()
            ->assertStatus(403);
    }

    public function test_user_have_permission_profile_setting_can_see_page_profile_setting()
    {
        $this->user->givePermissionTo('profile-setting');
        $this->actingAs($this->user)
            ->get('/backend/profile-setting')
            ->assertSuccessful()
            ->assertSee(['الصورة الشخصية', 'تعديل البيانات الشخصية'])
            ->assertStatus(200);
    }

    public function test_user_not_have_permission_profile_setting_can_not_change_page_profile_setting()
    {
        $this->actingAs($this->user)
            ->json('post', '/backend/profile-setting')
            ->assertForbidden();
    }

    public function test_user_have_permission_profile_setting_can_change_page_profile_setting()
    {
        $this->user->givePermissionTo('profile-setting');
        $this->actingAs($this->user)
            ->post('/backend/profile-setting', ['name' => 'mohamed', 'email' => 'mohamed@gmail.com', 'image' => UploadedFile::fake()->image('3.png', 500, 500)])
            ->assertSessionHas('success')
            ->assertRedirect('/backend/profile-setting');
    }

    public function test_user_have_permission_profile_setting_can_not_change_page_profile_setting_name_required()
    {
        $this->user->givePermissionTo('profile-setting');
        $this->actingAs($this->user)
            ->post('/backend/profile-setting', ['name' => null, 'email' => 'mohamed@gmail.com', 'image' => UploadedFile::fake()->image('3.png', 500, 500)])
            ->assertSessionHasErrors('name');
    }

    public function test_user_have_permission_profile_setting_can_not_change_page_profile_setting_email_required()
    {
        $this->user->givePermissionTo('profile-setting');
        $this->actingAs($this->user)
            ->post('/backend/profile-setting', ['name' => 'mohamed', 'email' => null, 'image' => UploadedFile::fake()->image('3.png', 500, 500)])
            ->assertSessionHasErrors('email');
    }

    public function test_user_have_permission_profile_setting_can_not_change_page_profile_setting_email_unique()
    {
        $this->user->givePermissionTo('profile-setting');
        $user2 = User::factory()->create();
        $this->actingAs($this->user)
            ->post('/backend/profile-setting', ['name' => 'mohamed', 'email' => $user2->email, 'image' => UploadedFile::fake()->image('3.png', 500, 500)])
            ->assertSessionHasErrors('email');
    }

    public function test_user_have_permission_profile_setting_can_not_change_page_profile_setting_image_field_not_image()
    {
        $this->user->givePermissionTo('profile-setting');
        $this->actingAs($this->user)
            ->post('/backend/profile-setting', ['name' => 'mohamed', 'email' => 'mohamed@gmail.com', 'image' => 'string_test'])
            ->assertSessionHasErrors('image');
    }
}
