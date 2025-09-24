<?php

namespace App\Http\Controllers;

use App\Actions\PlaceBidAction;
use App\Contracts\LotServiceInterface;
use App\DTOs\BidData;
use App\Http\Requests\PlaceBidRequest;
use App\Models\Bid;
use App\Models\Lot;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class LotController extends Controller
{
    public function __construct(private readonly LotServiceInterface $lotService) {}

    /**
     * @throws AuthorizationException
     */
    public function show(Lot $lot): Response
    {
        $this->authorize('view', $lot);

        return Inertia::render('auction/ShowLot', [
            'lot' => $this->lotService->getLot($lot),
        ]);
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
        } catch (Exception $exception) {
            return back()->withErrors(['amount' => $exception->getMessage()]);
        }

        return back()->with('message', 'Your bid was placed successfully!');
    }
}
