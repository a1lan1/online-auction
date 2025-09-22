<?php

namespace App\Notifications;

use App\Models\Lot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LotSoldNotification extends Notification implements ShouldQueue
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
        $winner = $this->lot->winner;

        return (new MailMessage)
            ->subject("Your lot \"{$this->lot->title}\" has been sold!")
            ->line("Good news, {$notifiable->name}!")
            ->line("Your lot, **{$this->lot->title}**, has been sold for **\${$this->lot->winnerBid->amount}**.")
            ->line("The winning bidder is {$winner->name}.")
            ->action('View Lot', route('lots.show', $this->lot))
            ->line('The winner has been notified and will be in touch regarding payment and delivery.');
    }
}
