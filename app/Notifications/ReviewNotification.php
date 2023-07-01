<?php

namespace App\Notifications;

use Ramsey\Uuid\Uuid;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReviewNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    public function toDatabase(object $notifiable) {
        $uuid =  Uuid::uuid4()->toString();
        return [
            "id" => $uuid,
            "user" => $this->order->freelancer->name,
            "image" => $this->order->freelancer->image,
            "message" => "Congratulations! Your Order Has Been Approved by " . $this->order->freelancer->name .
            ". We are happy to inform you that your order has been approved by your chosen freelancer. This is an important stage in your collaboration process.
            Our freelancer has seen the details of your order and is ready to start work. They have the skills and experience needed to deliver exceptional results.            
            We appreciate your trust in this freelancer and hope this cooperation goes smoothly. If you have any questions or need to communicate further, do not hesitate to contact the freelancer through our platform.
            We hope you enjoy this collaborative experience and get satisfactory results from our freelancers. Thank you for choosing our platform to meet your needs.
            Warm greetings,
            JobShort Support Team"
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
