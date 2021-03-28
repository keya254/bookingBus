<?php

namespace Tests\Feature\Backend\WebsiteSetting;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexWebsiteSettingTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function test_website_setting()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
