<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;
use Inertia\Response;

class AuctionController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): Response
    {
        $this->authorize('viewAny', Auction::class);

        $auctions = Auction::with('lots')->get();

        return Inertia::render('auction/Index', [
            'auctions' => $auctions,
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Auction $auction): Response
    {
        $this->authorize('view', $auction);

        $auction->load('lots');

        return Inertia::render('auction/Show', [
            'auction' => $auction,
        ]);
    }
}
