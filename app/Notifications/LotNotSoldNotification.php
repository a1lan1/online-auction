<?php

namespace App\Notifications;

use App\Models\Lot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LotNotSoldNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Lot $lot) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Your lot \"{$this->lot->title}\" was not sold")
            ->line("Hello, {$notifiable->name}.")
            ->line("The auction for your lot, **{$this->lot->title}**, has ended without any bids.")
            ->line('You may want to consider relisting it, perhaps with a lower starting price.')
            ->action('View Lot', route('lots.show', $this->lot));
    }
}
