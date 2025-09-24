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
            ->subject(sprintf('Your lot "%s" has been sold!', $this->lot->title))
            ->line(sprintf('Good news, %s!', $notifiable->name))
            ->line(sprintf('Your lot, **%s**, has been sold for **$%s**.', $this->lot->title, $this->lot->winnerBid->amount))
            ->line(sprintf('The winning bidder is %s.', $winner->name))
            ->action('View Lot', route('lots.show', $this->lot))
            ->line('The winner has been notified and will be in touch regarding payment and delivery.');
    }
}
