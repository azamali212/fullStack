<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class HospitalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $hospital;
    protected $type;
    protected $verificationCode;

    public function __construct($hospital, $type, $verificationCode = null)
    {
        $this->hospital = $hospital;
        $this->type = $type;
        $this->verificationCode = $verificationCode;
    }

    public function failed(\Exception $exception)
    {
        DB::table('hospital_notifications')
            ->where('hospital_id', $this->hospital->id)
            ->update(['status' => 'failed']);
    }

    public function markAsCompleted()
    {
        DB::table('hospital_notifications')
            ->where('hospital_id', $this->hospital->id)
            ->update(['status' => 'completed']);
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

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
            ->subject('Hospital Registration Confirmed')
            ->greeting('Hello, ' . $this->hospital->name)
            ->line('Your hospital registration is confirmed.')
            ->line('We are excited to have you on board.');
    }

    protected function updateEmail()
    {
        return (new MailMessage)
            ->subject('Your Hospital Information Has Been Updated')
            ->greeting('Hello, ' . $this->hospital->name)
            ->line('Your hospital information has been successfully updated.')
            ->line('Thank you for keeping your details up to date.')
            ->line('If you did not make this change, please contact support.');
    }

    protected function defaultEmail()
    {
        return (new MailMessage)
            ->subject('Notification')
            ->line('This is a default notification.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
