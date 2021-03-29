<?php

namespace Tests\Feature\Backend\Car;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActionCarTest extends TestCase
{
    public function test_change_status()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_change_public()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_change_private()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
