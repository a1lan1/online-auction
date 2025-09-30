<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Override;

class ActionHistoryCollection extends ResourceCollection
{
    #[Override]
    public function toArray(Request $request): array
    {
        return ActionHistoryResource::collection($this->collection)->toArray($request);
    }

    #[Override]
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'history_sort_by' => $request->query('history_sort_by'),
                'history_sort_order' => $request->query('history_sort_order'),
            ],
        ];
    }
}
