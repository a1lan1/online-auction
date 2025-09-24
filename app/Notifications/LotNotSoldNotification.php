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
            ->subject(sprintf('Your lot "%s" was not sold', $this->lot->title))
            ->line(sprintf('Hello, %s.', $notifiable->name))
            ->line(sprintf('The auction for your lot, **%s**, has ended without any bids.', $this->lot->title))
            ->line('You may want to consider relisting it, perhaps with a lower starting price.')
            ->action('View Lot', route('lots.show', $this->lot));
    }
}
