<?php

namespace App\Http\Controllers;

use App\Actions\PlaceBidAction;
use App\DTOs\BidData;
use App\Http\Requests\PlaceBidRequest;
use App\Models\Lot;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class LotController extends Controller
{
    public function show(Lot $lot): Response
    {
        $lot->load(['bids.user', 'auction']);

        return Inertia::render('auction/ShowLot', [
            'lot' => $lot,
        ]);
    }

    public function placeBid(PlaceBidRequest $request, PlaceBidAction $action): RedirectResponse
    {
        try {
            $action->execute(
                new BidData(
                    lot_id: $request->validated('lot_id'),
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
