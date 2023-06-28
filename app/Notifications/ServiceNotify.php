<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ServiceNotify extends Notification
{
    use Queueable;

    protected $service;

    /**
     * Create a new notification instance.
     */
    public function __construct($service)
    {
        $this->service = $service;
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
        return [
            "message" => "Congratulations! You've Got a New Freelancer Service
            Hello" . Auth::user()->name . ",
            We are happy to let you know that you have successfully secured the services of a talented freelancer on our platform. We want to let you know that the freelancer you choose is ready to meet your needs and deliver exceptional results.
            With this new freelancer service, you can expect:
            High Quality: Our freelancers are experienced and skilled professionals in their field. They will work hard to deliver results that meet or even exceed your expectations.
            Effective Collaboration: Good communication with freelancers is very important. They are ready to collaborate with you, listen to your needs, and provide the right solution for your project.
            On Time Delivery: Our freelancers value your time and will commit to completing the project according to the agreed schedule.
            We hope that this freelancer service will help you achieve your goals and provide satisfactory results. If you have any questions or need additional assistance, do not hesitate to contact our support team who are ready to help you.
            Thank you for using our platform. We hope you have an amazing experience with the freelancer you choose. Please feel free to provide feedback about your experience, as it means a lot to us.
            Thank you and happy using freelancer services!
            Greetings,
            Team Jobshort",
            "user" => $this->service->freelancer->name,
            "image" => $this->service->freelancer->image
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
