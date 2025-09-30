<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Override;

class DashboardLotCollection extends ResourceCollection
{
    #[Override]
    public function toArray(Request $request): array
    {
        return DashboardLotResource::collection($this->collection)->toArray($request);
    }

    #[Override]
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'bids_sort_by' => $request->query('bids_sort_by'),
                'bids_sort_order' => $request->query('bids_sort_order'),
            ],
        ];
    }
}
