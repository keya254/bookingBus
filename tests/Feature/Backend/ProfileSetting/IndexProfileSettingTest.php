<?php

namespace Tests\Feature\Backend\ProfileSetting;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexProfileSettingTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function test_profile_setting()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
