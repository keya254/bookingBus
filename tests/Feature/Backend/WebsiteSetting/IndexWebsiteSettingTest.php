<?php

namespace Tests\Feature\Backend\WebsiteSetting;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IndexWebsiteSettingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name' => 'website name', 'description' => 'description', 'logo' => 'images/logo/logo.png']);
        Permission::create(['name' => 'website-setting']);
        $this->user = User::factory()->create();
    }

    public function test_guest_can_not_see_website_setting_page()
    {
        $this->get('/backend/setting')
            ->assertRedirect('/login');
    }

    public function test_user_not_has_permission_website_setting_can_not_see_website_setting_page()
    {
        $this->actingAs($this->user)
            ->get('/backend/setting')
            ->assertForbidden();
    }

    public function test_user_has_permission_website_setting_can_see_website_setting_page()
    {
        $this->user->givePermissionTo('website-setting');
        $this->actingAs($this->user)
            ->get('/backend/setting')
            ->assertViewIs('backend.setting.index')
            ->assertSuccessful();
    }

    public function test_user_has_not_permission_website_setting_to_change_website_setting()
    {
        $this->actingAs($this->user)
            ->post('/backend/setting')
            ->assertForbidden();
    }

    public function test_user_has_permission_website_setting_to_change_website_setting()
    {
        $this->user->givePermissionTo('website-setting');
        $this->actingAs($this->user)
            ->post('/backend/setting', ['facebook' => 'https://www.facebook.com/', 'twitter' => 'https://www.twitter.com/'
                , 'youtube' => 'https://www.youtube.com/', 'instagram' => 'https://www.instagram.com/',
                'name' => 'name website', 'description' => 'description website', 'logo' => UploadedFile::fake()->image('1.png', 500, 500)])
            ->assertRedirect('backend/setting');
        $this->assertDatabaseCount('settings', 1);
        $this->assertDatabaseHas('settings',
            ['facebook' => 'https://www.facebook.com/', 'twitter' => 'https://www.twitter.com/'
                , 'youtube' => 'https://www.youtube.com/', 'instagram' => 'https://www.instagram.com/',
                'name' => 'name website', 'description' => 'description website']);
    }

    public function test_user_has_permission_website_setting_to_change_website_setting_error_name_required()
    {
        $this->user->givePermissionTo('website-setting');
        $this->actingAs($this->user)
            ->post('/backend/setting', ['name' => null, 'description' => 'description website', 'logo' => UploadedFile::fake()->image('1.png', 500, 500)])
            ->assertSessionHasErrors(['name']);
    }

    public function test_user_has_permission_website_setting_to_change_website_setting_error_name_min_3()
    {
        $this->user->givePermissionTo('website-setting');
        $this->actingAs($this->user)
            ->post('/backend/setting', ['name' => '23', 'description' => 'description website', 'logo' => UploadedFile::fake()->image('1.png', 500, 500)])
            ->assertSessionHasErrors(['name']);
    }

    public function test_user_has_permission_website_setting_to_change_website_setting_error_description_required()
    {
        $this->user->givePermissionTo('website-setting');
        $this->actingAs($this->user)
            ->post('/backend/setting', ['name' => 'name web', 'description' => null, 'logo' => UploadedFile::fake()->image('1.png', 500, 500)])
            ->assertSessionHasErrors(['description']);
    }

    public function test_user_has_permission_website_setting_to_change_website_setting_error_description_min_3()
    {
        $this->user->givePermissionTo('website-setting');
        $this->actingAs($this->user)
            ->post('/backend/setting', ['name' => 'moha', 'description' => 'de', 'logo' => UploadedFile::fake()->image('1.png', 500, 500)])
            ->assertSessionHasErrors(['description']);
    }

    public function test_user_has_permission_website_setting_to_change_website_setting_error_description_max_100()
    {
        $this->user->givePermissionTo('website-setting');
        $this->actingAs($this->user)
            ->post('/backend/setting', ['name' => 'moha', 'description' => 'descriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescription', 'logo' => UploadedFile::fake()->image('1.png', 500, 500)])
            ->assertSessionHasErrors(['description']);
    }

    public function test_user_has_permission_website_setting_to_change_website_setting_error_image_not_image()
    {
        $this->user->givePermissionTo('website-setting');
        $this->actingAs($this->user)
            ->post('/backend/setting', ['name' => 'moha', 'description' => 'description', 'logo' => 'jjkjk'])
            ->assertSessionHasErrors(['logo']);
    }

    public function test_user_has_permission_website_setting_to_change_website_setting_error_facebook_not_url()
    {
        $this->user->givePermissionTo('website-setting');
        $this->actingAs($this->user)
            ->post('/backend/setting', ['facebook' => 'face', 'name' => 'name', 'description' => 'description', 'logo' => UploadedFile::fake()->image('1.png', 500, 500)])
            ->assertSessionHasErrors(['facebook']);
    }

    public function test_user_has_permission_website_setting_to_change_website_setting_error_twitter_not_url()
    {
        $this->user->givePermissionTo('website-setting');
        $this->actingAs($this->user)
            ->post('/backend/setting', ['twitter' => 'twit', 'name' => 'name', 'description' => 'description', 'logo' => UploadedFile::fake()->image('1.png', 500, 500)])
            ->assertSessionHasErrors(['twitter']);
    }

    public function test_user_has_permission_website_setting_to_change_website_setting_error_instagram_not_url()
    {
        $this->user->givePermissionTo('website-setting');
        $this->actingAs($this->user)
            ->post('/backend/setting', ['instagram' => 'twit', 'name' => 'name', 'description' => 'description', 'logo' => UploadedFile::fake()->image('1.png', 500, 500)])
            ->assertSessionHasErrors(['instagram']);
    }

    public function test_user_has_permission_website_setting_to_change_website_setting_error_youtube_not_url()
    {
        $this->user->givePermissionTo('website-setting');
        $this->actingAs($this->user)
            ->post('/backend/setting', ['youtube' => 'twit', 'name' => 'name', 'description' => 'description', 'logo' => UploadedFile::fake()->image('1.png', 500, 500)])
            ->assertSessionHasErrors(['youtube']);
    }
}
