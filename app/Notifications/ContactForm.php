<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ContactForm extends Notification
{
    public $name;
    public $email;
    public $phone;
    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->message = $data['message'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Сообщение с сайта Lidz ' . '[' . date('d.m.Y H:i') . ']')
            ->greeting('Сообщение с сайта Lidz')
            ->line('Имя: ' . $this->name)
            ->line('E-mail: ' . $this->email)
            ->line('Телефон: ' . $this->phone)
            ->line('Сообщение: ' . $this->message)
            ->salutation(' ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
