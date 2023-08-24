<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendReminder extends Notification
{
    use Queueable;

    public $reminder;
    

    public function __construct($reminder)
    {
        $this->reminder = $reminder;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Task Reminder')
                    ->greeting('Hello User!')
                    ->line('We wanted to send you a quick reminder about the upcoming task on '.$this->reminder->reminder_time)
                    ->line('You leave a below note for your referrence:')
                    ->line($this->reminder->note)
                    ->action('Click Here to View Lead', url('/lead/view/'.$this->reminder->lead_id))
                    ->line('Thank you! Have a great day ahead.');
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
            //
        ];
    }
}
