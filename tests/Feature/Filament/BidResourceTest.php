<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Bids\Pages\ListBids;
use App\Filament\Resources\Bids\Pages\ViewBid;
use App\Models\Bid;
use App\Models\Lot;
use App\Models\User;
use Filament\Actions\CreateAction;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('can load the bid list page', function () {
    $bids = Bid::factory()->count(3)->create();

    livewire(ListBids::class)
        ->assertOk()
        ->assertCanSeeTableRecords($bids);
});

it('can search bids by lot title', function () {
    $lot = Lot::factory()->create(['title' => 'Test Lot']);
    $bid = Bid::factory()->for($lot)->create();
    Bid::factory()->count(2)->create();

    livewire(ListBids::class)
        ->searchTable('Test Lot')
        ->assertCanSeeTableRecords(collect([$bid]));
});

it('can search bids by user name', function () {
    $user = User::factory()->create(['name' => 'John Doe']);
    $bid = Bid::factory()->for($user)->create();
    Bid::factory()->count(2)->create();

    livewire(ListBids::class)
        ->searchTable('John Doe')
        ->assertCanSeeTableRecords(collect([$bid]));
});

it('can load the bid view page', function () {
    $bid = Bid::factory()->create();

    livewire(ViewBid::class, [
        'record' => $bid->id,
    ])
        ->assertOk();
});

it('can see bid details in view page', function () {
    $bid = Bid::factory()->create();

    livewire(ViewBid::class, [
        'record' => $bid->id,
    ])
        ->assertOk();
});

it('cannot create bids', function () {
    livewire(ListBids::class)
        ->assertActionDoesNotExist(CreateAction::class);
});
