<?php

namespace App\Notifications;

use App\Models\Lot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LotWonNotification extends Notification implements ShouldQueue
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
            ->subject("Congratulations! You've won a lot!")
            ->line("Congratulations, {$notifiable->name}!")
            ->line("You have won the auction for the lot: **{$this->lot->title}**.")
            ->line("Your winning bid was **\${$this->lot->winnerBid->amount}**.")
            ->action('View Lot', route('lots.show', $this->lot))
            ->line('Thank you for using our auction platform!');
    }
}
