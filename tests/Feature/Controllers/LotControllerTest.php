<?php

use App\Actions\PlaceBidAction;
use App\Models\Auction;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

uses(RefreshDatabase::class);

test('unauthenticated users cannot place a bid', function () {
    $lot = Lot::factory()->active()->create();

    $response = $this->post(route('lots.bids.store', $lot->id), [
        'amount' => 100,
    ]);

    $response->assertRedirect(route('login'));
});

test('authenticated users cannot place a bid on an inactive lot', function () {
    $user = User::factory()->create();
    $auction = Auction::factory()->create();
    $lot = Lot::factory()->finished()->create([
        'auction_id' => $auction->id,
    ]);

    $response = $this->actingAs($user)->post(route('lots.bids.store', $lot->id), [
        'amount' => $lot->starting_price + 100,
    ]);

    $response->assertForbidden();
});

test('it requires a valid amount to place a bid', function (mixed $amount, ?string $expectedError) {
    $user = User::factory()->create();
    $auction = Auction::factory()->create();
    $lot = Lot::factory()->active()->create([
        'auction_id' => $auction->id,
        'starting_price' => 1000,
    ]);

    $response = $this->actingAs($user)->post(route('lots.bids.store', $lot->id), [
        'amount' => $amount,
    ]);

    $response->assertInvalid($expectedError);
})->with([
    'amount is null' => [null, 'amount'],
    'amount is not numeric' => ['not-a-number', 'amount'],
    'amount is less than current price' => [999, 'amount'],
]);

test('it successfully places a valid bid', function () {
    $user = User::factory()->create();
    $auction = Auction::factory()->create();
    $lot = Lot::factory()->active()->create([
        'auction_id' => $auction->id,
        'starting_price' => 1000,
    ]);

    $response = $this->actingAs($user)->post(route('lots.bids.store', $lot->id), [
        'amount' => 1500,
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('message', 'Your bid was placed successfully!');
    $this->assertDatabaseHas('bids', [
        'lot_id' => $lot->id,
        'user_id' => $user->id,
        'amount' => 1500,
    ]);
});

test('it handles errors when placing a bid', function () {
    $user = User::factory()->create();
    $auction = Auction::factory()->create();
    $lot = Lot::factory()->active()->create([
        'auction_id' => $auction->id,
        'starting_price' => 1000,
    ]);

    $this->mock(PlaceBidAction::class)
        ->shouldReceive('execute')
        ->andThrow(new \Exception('Your bid is too low.'));

    $response = $this->actingAs($user)->post(route('lots.bids.store', $lot->id), [
        'amount' => 1100, // Valid amount, but action will fail
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors(['amount' => 'Your bid is too low.']);
});

test('it is throttled', function () {
    $user = User::factory()->create();
    $auction = Auction::factory()->create();
    $lot = Lot::factory()->active()->create([
        'auction_id' => $auction->id,
        'starting_price' => 1000,
    ]);

    $responses = collect();
    for ($i = 0; $i < 13; $i++) {
        $responses->push($this->actingAs($user)->post(route('lots.bids.store', $lot->id), [
            'amount' => 1500 + $i,
        ]));
    }

    $responses->last()->assertStatus(429);
});

test('guests can view a lot', function () {
    $lot = Lot::factory()->active()->create();

    $this->get(route('lots.show', $lot))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('lot/Show')
            ->has('lot', fn (AssertableInertia $page) => $page
                ->where('id', $lot->id)
                ->etc()
            )
        );
});

test('authenticated users can view a lot', function () {
    $user = User::factory()->create();
    $lot = Lot::factory()->active()->create();

    $this->actingAs($user)
        ->get(route('lots.show', $lot))
        ->assertOk();
});

test('it returns a 404 if lot is not found', function () {
    $this->get(route('lots.show', 999))
        ->assertNotFound();
});
