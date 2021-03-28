<?php

namespace Tests\Feature\Backend\Passenger;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexPassenger extends TestCase
{

    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
