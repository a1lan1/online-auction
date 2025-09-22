<?php

namespace Tests\Feature\Policies;

use App\Enums\LotStatus;
use App\Models\Auction;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

test('guest cannot place a bid', function () {
    // 1. Arrange: Create an active lot.
    $lot = Lot::factory()->create([
        'starts_at' => now()->subDay(),
        'ends_at' => now()->addDay(),
    ]);

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
    $lot = Lot::factory()->for($auction)->create();

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
    $lot = Lot::factory()->active()->for($auction)->create([
        'starts_at' => now()->subDay(),
        'ends_at' => now()->addDay(),
        'starting_price' => 1000,
    ]);

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

test('user cannot place a bid on an inactive lot', function (callable $lotState) {
    // 1. Arrange: Create a bidder and an inactive lot using the data provider.
    $bidder = User::factory()->create();
    $lot = Lot::factory()->create($lotState());

    // 2. Act: The bidder attempts to place a bid.
    $response = actingAs($bidder)->post(route('lots.bids.store', $lot), [
        'amount' => $lot->starting_price + 100,
    ]);

    // 3. Assert: Ensure the action is forbidden.
    $response->assertForbidden();
})->with([
    'lot has not started' => [fn () => ['starts_at' => now()->addDay(), 'ends_at' => now()->addDays(2)]],
    'lot has finished' => [fn () => ['starts_at' => now()->subDays(2), 'ends_at' => now()->subDay()]],
    'lot is canceled' => [fn () => ['status' => LotStatus::CANCELED]],
]);
