<?php

use App\Models\Bid;
use App\Models\Lot;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('allows navigation between dashboard tabs', function () {
    $user = User::factory()->create();
    $lot = Lot::factory()->active()->create();
    Bid::factory()->for($user)->for($lot)->create();

    actingAs($user);

    visit(route('dashboard.index'))
        // By default, "My Bids" is visible
        ->assertSee($lot->title)
        ->assertDontSee('Logged in')

        // Click on "Action History" tab
        ->click('Action History')
        ->assertSee($lot->title)
        ->assertSee('Placed a bid');
});
