<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingSeatNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $tripid;

    public $myseats;

    public $phone_number;

    public function __construct($tripid,$myseats,$phone_number)
    {
       $this->tripid =  $tripid;
       $this->myseats =  $myseats;
       $this->phone_number =  $phone_number;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'content'=>' لقد تم حجز المقاعد رقم  ' .$this->myseats. ' من الرحلة رقم ' .$this->tripid. ' للعميل  ' .$this->phone_number. '' ,
        ];
    }
}
