<?php

namespace App\Notifications;

use Ramsey\Uuid\Uuid;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterNotification extends Notification
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

    public function toDatabase(object $notifiable)
    {
        $uuid = Uuid::uuid4()->toString();

        return [
            "id" => $uuid,
            "user" => "admin",
            "image" => "js-logo.jpg",
            "message" => "Welcome to Jobshort!
            We are very happy to have you as a new member of our freelancer community. Jobshort is the perfect place to explore new opportunities, connect with interesting clients, and build an impressive portfolio.
            Join thousands of talented and professional freelancers who have found success through Jobshort. With our user-friendly platform, you can easily find jobs that suit your skills, expand your professional network, and increase your exposure in the freelance world.
            Now, let's get started! Explore exciting projects, create an engaging profile, and showcase your unique talents and skills to our diverse clientele. We are ready to help you achieve success in your freelance career.
            Feel free to contact our support team if you have any questions or need assistance. We are ready to help you every step of your freelance journey at Jobshort.
            Thank you for joining Jobshort! We wish you much success and valuable experience on our platform.
            Good luck,
            Team Jobshort"
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
