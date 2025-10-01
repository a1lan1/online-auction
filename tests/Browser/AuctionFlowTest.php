<?php

use App\Models\Auction;
use App\Models\Lot;
use App\Models\User;
use App\Events\NewBidPlaced;
use Illuminate\Support\Facades\Event;

use function Pest\Laravel\actingAs;

it('displays a list of auctions and allows navigation to an auction', function () {
    $user = User::factory()->create();
    $auctions = Auction::factory(2)->create();
    $targetAuction = $auctions->first();

    actingAs($user);

    visit(route('auctions.index'))
        ->assertSee($targetAuction->name)
        ->assertSee($auctions->last()->name)
        ->click($targetAuction->name)
        ->assertPathIs('/auctions/'.$targetAuction->id)
        ->assertSee($targetAuction->name);
});

it('displays lots within an auction and allows navigation to a lot', function () {
    $user = User::factory()->create();
    $auction = Auction::factory()->create();
    $activeLot = Lot::factory()->active()->for($auction)->create();
    $finishedLot = Lot::factory()->finished()->for($auction)->create();

    actingAs($user);

    visit(route('auctions.show', $auction))
        ->assertSee($auction->name)
        ->assertSee($activeLot->title)
        ->assertSee($finishedLot->title)
        ->click($activeLot->title)
        ->assertPathIs('/lots/'.$activeLot->id)
        ->assertSee($activeLot->title);
});

it('allows a user to place a bid on an active lot', function () {
    Event::fake([
        NewBidPlaced::class,
    ]);

    $user = User::factory()->create();
    $lot = Lot::factory()->active()->create(['starting_price' => 100]);

    actingAs($user);

    visit(route('lots.show', $lot))
        ->assertSee('Starting Price: $ 100.00')
        ->assertSee('Current Price: $ 0')
        ->fill('#amount input.p-inputnumber-input', '110')
        ->press('Place Bid')
        ->assertSee('Bid placed successfully!')
        ->refresh()
        ->assertSee('Current Price: $ 110.00'); // Assuming bid increment is $10

    Event::assertDispatched(
        NewBidPlaced::class,
        fn (NewBidPlaced $event) => $event->bid->lot_id === $lot->id
    );
});

it('does not allow a user to bid on a finished lot', function () {
    $user = User::factory()->create();
    $lot = Lot::factory()->finished()->create();

    actingAs($user);

    visit(route('lots.show', $lot))
        ->assertDontSee('Place Bid');
});
