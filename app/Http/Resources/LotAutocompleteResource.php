<?php

namespace App\Http\Resources;

use App\Models\Lot;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin Lot
 */
class LotAutocompleteResource extends JsonResource
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
            'current_price' => $this->current_price,
            'status' => $this->status->value,
            'url' => route('lots.show', $this->id),
        ];
    }
}
