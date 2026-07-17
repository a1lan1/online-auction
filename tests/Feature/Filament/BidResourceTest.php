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
    $lot = Lot::factory()->pending()->create();
    $bids = Bid::factory()->for($lot)->count(3)->create();

    livewire(ListBids::class)
        ->assertOk()
        ->assertCanSeeTableRecords($bids);
});

it('can search bids by lot title', function () {
    $lot = Lot::factory()->pending()->create(['title' => 'Test Lot']);
    $bid = Bid::factory()->for($lot)->create();
    Bid::factory()->count(2)->create();

    livewire(ListBids::class)
        ->searchTable('Test Lot')
        ->assertCanSeeTableRecords(collect([$bid]));
});

it('can search bids by user name', function () {
    $user = User::factory()->create(['name' => 'John Doe']);
    $lot = Lot::factory()->pending()->create();
    $bid = Bid::factory()->for($lot)->for($user)->create();
    Bid::factory()->count(2)->create();

    livewire(ListBids::class)
        ->searchTable('John Doe')
        ->assertCanSeeTableRecords(collect([$bid]));
});

it('can load the bid view page', function () {
    $lot = Lot::factory()->pending()->create();
    $bid = Bid::factory()->for($lot)->create();

    livewire(ViewBid::class, [
        'record' => $bid->id,
    ])
        ->assertOk();
});

it('can see bid details in view page', function () {
    $lot = Lot::factory()->pending()->create();
    $bid = Bid::factory()->for($lot)->create();

    livewire(ViewBid::class, [
        'record' => $bid->id,
    ])
        ->assertOk();
});

it('cannot create bids', function () {
    livewire(ListBids::class)
        ->assertActionDoesNotExist(CreateAction::class);
});
