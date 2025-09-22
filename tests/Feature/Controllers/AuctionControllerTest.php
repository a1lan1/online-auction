<?php

use App\Models\Auction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

uses(RefreshDatabase::class);

test('guests can view auctions', function () {
    Auction::factory(3)->create();

    $this->get(route('auctions.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('auction/Index')
            ->has('auctions', 3)
        );
});

test('authenticated users can view auctions', function () {
    $user = User::factory()->create();
    Auction::factory(3)->create();

    $this->actingAs($user)
        ->get(route('auctions.index'))
        ->assertOk();
});

test('guests can view a single auction', function () {
    $auction = Auction::factory()->create();

    $this->get(route('auctions.show', $auction))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('auction/Show')
            ->has('auction', fn (AssertableInertia $page) => $page
                ->where('id', $auction->id)
                ->etc()
            )
        );
});

test('authenticated users can view a single auction', function () {
    $user = User::factory()->create();
    $auction = Auction::factory()->create();

    $this->actingAs($user)
        ->get(route('auctions.show', $auction))
        ->assertOk();
});

test('it returns a 404 if auction is not found', function () {
    $this->get(route('auctions.show', 999))
        ->assertNotFound();
});
