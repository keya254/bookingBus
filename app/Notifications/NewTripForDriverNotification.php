<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTripForDriverNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $trip;

    public function __construct($trip)
    {
       $this->trip=$trip;
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
            'content'=>' لقد تم اضافة رحلة جديدة للسيارة '.$this->trip->car->name.' يوم '.$this->trip->day.' الساعة '.$this->trip->start_time.' من '.$this->trip->from->name.' الي '.$this->trip->to->name.' ',
        ];
    }
}
