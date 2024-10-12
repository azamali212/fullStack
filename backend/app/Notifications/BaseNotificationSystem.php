<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class BaseNotificationSystem extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $type;
    protected $verificationCode;
    protected $ambulance;
    protected $shift;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $type, $verificationCode = null, $ambulance = null, $shift = null)
    {
        $this->user = $user;
        $this->type = $type;
        $this->verificationCode = $verificationCode;
        $this->ambulance = $ambulance;
        $this->shift = $shift;
        //$this->nurses = $nurses;

        //dd($this->type);
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
            case 'update':
                return $this->updateEmail();
            case 'shift_assignment':
                return $this->shiftAssignmentEmail();
            case 'ambulance_assignment':
                return $this->ambulanceAssignmentEmail();
            default:
                return $this->defaultEmail();
        }
    }

    protected function welcomeEmail()
    {
        return (new MailMessage)
            ->subject('Welcome to Our Platform')
            ->greeting('Hello, ' . $this->user->name)
            ->line('Welcome to our platform!')
            ->line('Thank you for registering.');
    }

    protected function verificationEmail()
    {
        return (new MailMessage)
            ->subject('Email Verification')
            ->line('Your verification code is: ' . $this->verificationCode)
            ->action('Verify Email', url('/verify-email?code=' . $this->verificationCode))
            ->line('Thank you for using our application!');
    }

    protected function confirmationEmail()
    {
        return (new MailMessage)
            ->subject('Registration Confirmed')
            ->greeting('Hello, ' . $this->user->name)
            ->line('Your registration is confirmed.')
            ->line('We are excited to have you onboard.');
    }

    protected function updateEmail()
    {
        return (new MailMessage)
            ->subject('Information Updated')
            ->greeting('Hello, ' . $this->user->name)
            ->line('Your information has been updated.')
            ->line('Thank you for keeping your details up to date.');
    }

    protected function shiftAssignmentEmail()
    {
        return (new MailMessage)
            ->subject('New Shift Assignment')
            ->greeting('Hello ' . $this->user->name)
            ->line('You have been assigned a new shift.')
            ->line('Shift Date: ' . $this->shift->shift_date)
            ->line('Shift Time: ' . $this->shift->start_time . ' - ' . $this->shift->end_time)
            ->line('Thank you for your service!');
    }

    protected function ambulanceAssignmentEmail()
    {
        return (new MailMessage)
            ->subject('New Ambulance Assignment')
            ->greeting('Hello ' . $this->user->name)
            ->line('You have been assigned a new ambulance.')
            ->line('Ambulance: ' . $this->ambulance->license_plate)
            ->line('Thank you for your service!');
    }

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
            // Add any array data if needed
        ];
    }
}
