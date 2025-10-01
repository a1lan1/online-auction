<?php

namespace App\Http\Resources;

use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin Bid
 */
class ActionHistoryResource extends JsonResource
{
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'created_at' => $this->created_at->diffForHumans(),
            'lot_title' => $this->whenLoaded('lot', fn () => $this->lot->title),
            'lot_url' => $this->whenLoaded('lot', fn (): string => route('lots.show', $this->lot->id)),
        ];
    }
}
