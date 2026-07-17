<?php

namespace Tests\Feature\Policies;

use App\Models\Auction;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

test('guest cannot place a bid', function () {
    // 1. Arrange: Create an active lot.
    $lot = Lot::factory()->active()->create();

    // 2. Act: Make a POST request as a guest.
    $response = post(route('lots.bids.store', $lot), [
        'amount' => $lot->starting_price + 100,
    ]);

    // 3. Assert: Ensure the guest is redirected to the login page.
    $response->assertRedirect(route('login'));
});

test('lot owner cannot place a bid on their own lot', function () {
    // 1. Arrange: Create a user who owns a lot.
    $owner = User::factory()->create();
    $auction = Auction::factory()->for($owner, 'owner')->create();
    $lot = Lot::factory()->for($auction)->active()->create();

    // 2. Act: Make a POST request as the owner.
    $response = actingAs($owner)->post(route('lots.bids.store', $lot), [
        'amount' => $lot->starting_price + 100,
    ]);

    // 3. Assert: Ensure the action is forbidden.
    $response->assertForbidden();
});

test('user can place a bid on an active lot', function () {
    // 1. Arrange: Create a bidder, an owner, and an active lot.
    $bidder = User::factory()->create();
    $owner = User::factory()->create();
    $auction = Auction::factory()->for($owner, 'owner')->create();
    $lot = Lot::factory()->for($auction)->active()->create(['starting_price' => 1000]);

    // 2. Act: The bidder places a valid bid.
    $response = actingAs($bidder)->post(route('lots.bids.store', $lot), [
        'amount' => 1100,
    ]);

    // 3. Assert: Ensure the request was valid, redirected, and the bid was created.
    $response->assertValid()->assertRedirect();
    $this->assertDatabaseHas('bids', [
        'lot_id' => $lot->id,
        'user_id' => $bidder->id,
        'amount' => 1100,
    ]);
});

test('user cannot place a bid on an inactive lot', function (Lot $lot) {
    // 1. Arrange: Create a bidder and an inactive lot using the data provider.
    $bidder = User::factory()->create();

    // 2. Act: The bidder attempts to place a bid.
    $response = actingAs($bidder)->post(route('lots.bids.store', $lot), [
        'amount' => $lot->starting_price + 100,
    ]);

    // 3. Assert: Ensure the action is forbidden.
    $response->assertForbidden();
})->with([
    'lot has not started' => fn () => Lot::factory()->active()->hasNotStarted()->create(),
    'lot has finished' => fn () => Lot::factory()->active()->hasFinished()->create(),
    'lot is pending' => fn () => Lot::factory()->pending()->create(),
    'lot is sold' => fn () => Lot::factory()->sold()->create(),
    'lot is not sold' => fn () => Lot::factory()->notSold()->create(),
]);
