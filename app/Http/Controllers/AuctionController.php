<?php

namespace App\Http\Controllers;

use App\Contracts\AuctionServiceInterface;
use App\Contracts\LotServiceInterface;
use App\Http\Resources\AuctionResource;
use App\Http\Resources\LotResource;
use App\Models\Auction;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;
use Inertia\Response;

class AuctionController extends Controller
{
    public function __construct(
        private readonly AuctionServiceInterface $auctionService,
        private readonly LotServiceInterface $lotService,
    ) {}

    /**
     * @throws AuthorizationException
     */
    public function index(): Response
    {
        $this->authorize('viewAny', Auction::class);

        return Inertia::render('auction/Index', [
            'auctions' => $this->auctionService->getAuctions(30),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Auction $auction): Response
    {
        $this->authorize('view', $auction);

        $auction = $this->auctionService->getAuction($auction);
        $lots = $this->lotService->getLots($auction->id);

        return Inertia::render('auction/Show', [
            'auction' => AuctionResource::make($auction),
            'lots' => Inertia::scroll(
                LotResource::collection($lots)
            ),
        ]);
    }
}
