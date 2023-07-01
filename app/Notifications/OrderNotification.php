<?php

namespace App\Notifications;

use Ramsey\Uuid\Uuid;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderNotification extends Notification
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

    public function toDatabase(object $notifiable){

        $uuid =  Uuid::uuid4()->toString();
        return [
            "id" => $uuid,
            "user" => $notifiable->name,
            "image" => $notifiable->image,
            "message" => "Congratulations! You've Received an Order!
            Dear " . $this->order->freelancer->name . ",
            We are thrilled to inform you that you have received a new order on our platform. This is a significant milestone in your freelancing journey, and we are excited to see your skills and expertise being recognized by buyers.            
            Order Details: 
            Order ID:" . $this->order->id .
            "Buyer:" . Auth::user()->name . 
            "Order Date:" . $this->order->created_at->diffForHumans() .
            "The buyer has placed their trust in your services, and now it's time to showcase your talents and deliver exceptional results. We encourage you to review the order details carefully and promptly get in touch with the buyer to discuss project requirements, timelines, and any other necessary details"
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
