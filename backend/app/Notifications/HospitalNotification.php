<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HospitalNotification extends Notification
{
    use Queueable;

    //Define Variables
    protected $hospital;
    protected $type;
    protected $verificationCode;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($hospital, $type, $verificationCode = null)
    {
        $this->hospital = $hospital;
        $this->type = $type;
        $this->verificationCode = $verificationCode;
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
        switch ($this->type) {
            case 'welcome':
                return $this->welcomeEmail();
            case 'verification':
                return $this->verificationEmail();
            case 'confirmation':
                return $this->confirmationEmail();
            default:
                return $this->defaultEmail();
        }
    }

    protected function welcomeEmail()
    {
        return (new MailMessage)
            ->subject('Welcome to Our Hospital Platform')
            ->greeting('Hello, ' . $this->hospital->name)
            ->line('Congratulations on successfully registering your hospital!')
            ->line('Thank you for choosing our platform.');
    }

    // Method to handle the Verification Email
    protected function verificationEmail()
    {
        return (new MailMessage)
            ->subject('Verify Your Email')
            ->greeting('Hello, ' . $this->hospital->name)
            ->line('Your verification code is: ' . $this->verificationCode)
            ->action('Verify Your Email', url('/verify?code=' . $this->verificationCode));
    }

    protected function confirmationEmail()
    {
        return (new MailMessage)
            ->subject('Hospital Registration Confirmed')
            ->greeting('Hello, ' . $this->hospital->name)
            ->line('Your hospital registration is confirmed.')
            ->line('We are excited to have you on board.');
    }

    // Default Email Fallback
    protected function defaultEmail()
    {
        return (new MailMessage)
            ->subject('Notification')
            ->line('This is a default notification.');
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
