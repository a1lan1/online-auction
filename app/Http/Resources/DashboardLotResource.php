<?php

namespace App\Http\Resources;

use App\Enums\LotStatus;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin Lot
 */
class DashboardLotResource extends JsonResource
{
    #[Override]
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $request->user();
        $userBidStatus = 'outbid';

        if ($this->status === LotStatus::FINISHED) {
            $userBidStatus = $this->winner_id === $user->id ? 'won' : 'lost';
        } elseif ($this->bids->isNotEmpty()) {
            $highestBid = $this->bids->sortByDesc('amount')->first();

            if ($highestBid->user_id === $user->id) {
                $userBidStatus = 'winning';
            }
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'user_bid_status' => $userBidStatus,
            'current_price' => $this->current_price,
            'ends_at' => $this->ends_at->diffForHumans(),
            'url' => route('lots.show', $this->id),
            'auction_name' => $this->whenLoaded('auction', fn () => $this->auction->name),
        ];
    }
}
