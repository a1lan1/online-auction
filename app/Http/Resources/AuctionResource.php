<?php

namespace App\Http\Resources;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin Auction
 */
class AuctionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'owner' => $this->whenLoaded('owner'),
            'lots' => LotResource::collection($this->whenLoaded('lots')),
        ];
    }
}
