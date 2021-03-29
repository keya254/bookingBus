<?php

namespace Tests\Feature\Backend\Trip;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActionTripTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_change_status()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
