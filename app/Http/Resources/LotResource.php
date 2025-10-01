<?php

namespace App\Http\Resources;

use App\Models\Lot;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Override;

/**
 * @mixin Lot
 */
class LotResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->whenNotNull(
                $request->routeIs('auctions.show')
                    ? Str::words($this->description, 10)
                    : $this->description
            ),
            'starting_price' => $this->starting_price,
            'current_price' => $this->current_price,
            'status' => $this->status,
            'auction_id' => $this->auction_id,
            'starts_at' => $this->starts_at->format('d M Y H:i'),
            'ends_at' => $this->ends_at->format('d M Y H:i'),
            'image_url' => $this->image_url,
            'gallery_files' => $this->gallery_files,
        ];
    }
}
