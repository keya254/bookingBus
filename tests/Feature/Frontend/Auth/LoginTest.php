<?php

namespace Tests\Feature\Frontend\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
   use RefreshDatabase,WithFaker;

   protected function setUp(): void
   {
       parent::setUp();

       // code
   }

   public function test_user_login_redirect_to_dashboard()
   {
       $user=User::factory()->create();
       $this->actingAs($user)
            ->get('/login')
            ->assertRedirect('/backend/dashboard');
   }

   public function test_user_visit_page_login()
   {
       $this->get('/login')
            ->assertSee('كلمة المرور')
            ->assertSuccessful();
   }

   public function test_user_can_login_success()
   {
       $user=User::factory()->create();
       $this->post('/login',['email'=>$user->email,'password'=>'12345678'])
            ->assertRedirect('/backend/dashboard');
   }

   public function test_user_can_login_error_password_required()
   {
       $user=User::factory()->create();
       $this->post('/login',['email'=>$user->email,'password'=>''])
            ->assertSessionHasErrors('password');
   }

   public function test_user_can_login_error_email_required()
   {
       $this->post('/login',['email'=>'','password'=>'12345678'])
            ->assertSessionHasErrors('email');
   }

   public function test_user_can_login_error_email_input_not_email()
   {
       $this->post('/login',['email'=>'mfr','password'=>'12345678'])
            ->assertSessionHasErrors('email');
   }

   public function test_user_can_login_not_found()
   {
       $user=User::factory()->create();
       $this->post('/login',['email'=>$user->email,'password'=>'123456'])
            ->assertSessionHasErrors('email');
   }


}
