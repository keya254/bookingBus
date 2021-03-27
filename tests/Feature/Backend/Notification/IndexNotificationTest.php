<?php

namespace Tests\Feature\Backend\Notification;

use App\Models\Setting;
use App\Models\User;
use App\Notifications\TestNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IndexNotificationTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        Setting::create(['name'=>'website name','description'=>'description','logo'=>'images/logo/logo.png']);
        Permission::create(['name'=>'notifications']);
        $this->user1 = User::factory()->create();
        $this->user2 = User::factory()->create();

        //send notification to user1 and user2
        Notification::Send( $this->user1 ,new TestNotification());
        Notification::Send( $this->user2 ,new TestNotification());

        //check the database has notifications for user1 and user2
        $this->assertDatabaseHas('notifications',['notifiable_id'=>1,'read_at'=>null]);
        $this->assertDatabaseHas('notifications',['notifiable_id'=>2,'read_at'=>null]);
    }

    public function test_guest_can_not_see_page()
    {
        $this->get('/backend/notifications')
             ->assertRedirect('/login');
    }

    public function test_user_not_have_permission_notifications_can_not_see_page()
    {
        $this->actingAs($this->user1)
             ->get('/backend/notifications')
             ->assertForbidden()
             ->assertStatus(403);
    }

    public function test_user_have_permission_notifications_can_see_page()
    {
        $this->user1->givePermissionTo('notifications');
        $this->actingAs($this->user1)
             ->get('/backend/notifications')
             ->assertViewIs('backend.notification.index')
             ->assertSee('الاشعارات')
             ->assertStatus(200);
    }

    public function test_user_have_permission_notifications_can_make_read_notification()
    {
        // id notification for user1
        $id=$this->user1->notifications()->first()->id;

        $this->user1->givePermissionTo('notifications');

        $this->actingAs($this->user1)
             ->json('POST','/backend/notifications',['id'=>$id])
             ->assertStatus(200);

        $this->assertDatabaseHas('notifications',['notifiable_id'=>1,'read_at'=>now()]);
        $this->assertDatabaseHas('notifications',['notifiable_id'=>2,'read_at'=>null]);
    }

    public function test_user_have_permission_notifications_can_make_read_notification_and_fail_unauthorized()
    {
        // id notification for user1
        $id=$this->user1->notifications()->first()->id;

        //give to user 2
        $this->user2->givePermissionTo('notifications');

        //login user 2 can not  make read notification
        $this->actingAs($this->user2)
             ->json('POST','/backend/notifications',['id'=>$id])
             ->assertUnauthorized()
             ->assertStatus(401);

        $this->assertDatabaseHas('notifications',['notifiable_id'=>1,'read_at'=>null]);
        $this->assertDatabaseHas('notifications',['notifiable_id'=>2,'read_at'=>null]);
    }

    public function test_user_have_permission_notifications_can_make_delete()
    {
         // id notification for user1
         $id=$this->user1->notifications()->first()->id;

         $this->user1->givePermissionTo('notifications');

         $this->actingAs($this->user1)
              ->json('DELETE','/backend/notifications/'.$id)
              ->assertStatus(200);

         $this->assertDatabaseCount('notifications',1);
         $this->assertDatabaseMissing('notifications',['id'=>$id,'notifiable_id'=>1]);
         $this->assertDatabaseHas('notifications',['notifiable_id'=>2,'read_at'=>null]);
    }

    public function test_user_have_permission_notifications_can_make_delete_and_fail_unauthorized()
    {
         // id notification for user1
         $id=$this->user1->notifications()->first()->id;

         $this->user2->givePermissionTo('notifications');

         $this->actingAs($this->user2)
              ->json('DELETE','/backend/notifications/'.$id)
              ->assertStatus(401);

         $this->assertDatabaseCount('notifications',2);
         $this->assertDatabaseHas('notifications',['id'=>$id,'notifiable_id'=>1]);
         $this->assertDatabaseHas('notifications',['notifiable_id'=>2,'read_at'=>null]);
    }
}
