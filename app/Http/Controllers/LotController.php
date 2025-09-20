<?php

namespace App\Http\Controllers;

use App\Actions\PlaceBidAction;
use App\DTOs\BidData;
use App\Http\Requests\PlaceBidRequest;
use App\Models\Bid;
use App\Models\Lot;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class LotController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function show(Lot $lot): Response
    {
        $this->authorize('view', $lot);

        $lot->load(['bids.user', 'auction']);

        return Inertia::render('auction/ShowLot', [
            'lot' => $lot,
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function placeBid(PlaceBidRequest $request, PlaceBidAction $action): RedirectResponse
    {
        $lot = Lot::findOrFail($request->validated('lot_id'));

        $this->authorize('create', [Bid::class, $lot]);

        try {
            $action->execute(
                new BidData(
                    lot_id: $lot->id,
                    user_id: $request->user()->id,
                    amount: $request->validated('amount'),
                )
            );
        } catch (\Exception $e) {
            return back()->withErrors(['amount' => $e->getMessage()]);
        }

        return back()->with('success', 'Your bid was placed successfully!');
    }
}
