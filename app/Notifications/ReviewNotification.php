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
    public function __construct($order)
    {
        $this->order = $order;
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
            "user" => $this->order->user->name,
            "image" => $this->order->user->image,
            "message" => "Congratulations! You Receive Positive Reviews and Ratings from Buyers
            We are happy to inform you that the buyer has given a positive review and evaluation of the service you provided. This is a remarkable achievement and shows your quality and professionalism in working on this project.
            Positive reviews and ratings are not only an appreciation for your hard work, but also improve your reputation on our platform. This can attract the attention of potential buyers and help you get more job opportunities in the future.
            We would like to thank you for your dedication in providing quality service to buyers. Keep innovating and delivering the best results in every project you work on.
            You can see those reviews and ratings on your profile. Use this feedback as motivation to continue to improve and provide the best experience to buyers in the future.
            Thank you for your hard work and may success continue to accompany your steps in your freelancing career.
            Good luck and keep up the great work!
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
