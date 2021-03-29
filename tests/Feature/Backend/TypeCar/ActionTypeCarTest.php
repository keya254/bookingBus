<?php

namespace Tests\Feature\Backend\TypeCar;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActionTypeCarTest extends TestCase
{
  use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();


    }

    public function test_change_status()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
