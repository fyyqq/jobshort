<?php

namespace App\Notifications;

use Ramsey\Uuid\Uuid;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CompleteOrderNotification extends Notification
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
            "title" => "Congratulations! Your Order Has Been Completed by " . $this->order->user->name,
            "message" => "We are happy to inform you that the order you made has been completed by the buyer. This is a happy moment because you have completed a job well.
            Buyers have seen your work and are satisfied with what you provide. This is proof of your skill and dedication in working on this project.
            We thank you for your hard work and efforts to provide the best results for buyers. Hopefully this collaboration will bring satisfaction and success for both parties.
            If you have further questions or need to communicate with buyers, do not hesitate to use our platform to interact.
            Continue to provide the best quality in every job you do. We wish you continued success in your freelancing career.
            Thank you for your dedication!
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
