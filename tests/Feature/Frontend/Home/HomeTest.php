<?php

namespace Tests\Feature\Frontend\Home;

use App\Models\Governorate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function test_home_page_load_without_error()
    {
        $governorate=Governorate::factory()->create();
        $this->get('/')
        ->assertSee('ابحث عن المكان والمعاد')
        ->assertDontSee('بورسعيد')
        ->assertSee($governorate->name)
        ->assertViewHas('governorates');
    }
}
