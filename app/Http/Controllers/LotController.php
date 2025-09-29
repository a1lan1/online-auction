<?php

namespace App\Http\Controllers;

use App\Actions\PlaceBidAction;
use App\Contracts\LotServiceInterface;
use App\DTOs\BidData;
use App\Http\Requests\AutocompleteLotRequest;
use App\Http\Requests\PlaceBidRequest;
use App\Http\Resources\LotAutocompleteResource;
use App\Models\Bid;
use App\Models\Lot;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class LotController extends Controller
{
    public function __construct(private readonly LotServiceInterface $lotService) {}

    /**
     * @throws AuthorizationException
     */
    public function show(Lot $lot): Response
    {
        $this->authorize('view', $lot);

        return Inertia::render('lot/Show', [
            'lot' => $this->lotService->getLot($lot),
        ]);
    }

    public function autocomplete(AutocompleteLotRequest $request): JsonResponse
    {
        $lots = $this->lotService->autocompleteSearch($request->validated('query'));

        return LotAutocompleteResource::collection($lots)->response();
    }

    /**
     * @throws AuthorizationException
     */
    public function placeBid(PlaceBidRequest $request, Lot $lot, PlaceBidAction $action): RedirectResponse
    {
        $this->authorize('create', [Bid::class, $lot]);

        try {
            $action->execute(
                new BidData(
                    lot_id: $lot->id,
                    user_id: $request->user()->id,
                    amount: $request->validated('amount'),
                )
            );
        } catch (Throwable $throwable) {
            return back()->withErrors(['amount' => $throwable->getMessage()]);
        }

        return back()->with('message', 'Your bid was placed successfully!');
    }
}
