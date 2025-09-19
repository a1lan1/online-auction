<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Inertia\Inertia;
use Inertia\Response;

class AuctionController extends Controller
{
    public function index(): Response
    {
        $auctions = Auction::with('lots')->get();

        return Inertia::render('auction/Index', [
            'auctions' => $auctions,
        ]);
    }

    public function show(Auction $auction): Response
    {
        $auction->load('lots');

        return Inertia::render('auction/Show', [
            'auction' => $auction,
        ]);
    }
}
