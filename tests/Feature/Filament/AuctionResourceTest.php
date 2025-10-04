<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Auctions\Pages\CreateAuction;
use App\Filament\Resources\Auctions\Pages\EditAuction;
use App\Filament\Resources\Auctions\Pages\ListAuctions;
use App\Filament\Resources\Auctions\Pages\ViewAuction;
use App\Models\Auction;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('can load the auction list page', function () {
    $auctions = Auction::factory()->count(3)->create();

    livewire(ListAuctions::class)
        ->assertOk()
        ->assertCanSeeTableRecords($auctions);
});

it('can search auctions by name', function () {
    $auctions = Auction::factory()->count(3)->create();
    $firstAuction = $auctions->first();

    livewire(ListAuctions::class)
        ->searchTable($firstAuction->name)
        ->assertCanSeeTableRecords($auctions->take(1));
});

it('can load the auction create page', function () {
    livewire(CreateAuction::class)->assertOk();
});

it('can create an auction', function () {
    $user = User::factory()->create();
    $auctionData = Auction::factory()->make();

    livewire(CreateAuction::class)
        ->fillForm([
            'name' => $auctionData->name,
            'user_id' => $user->id,
        ])
        ->call('create')
        ->assertNotified();

    assertDatabaseHas('auctions', [
        'name' => $auctionData->name,
        'user_id' => $user->id,
    ]);
});

it('validates required fields', function () {
    livewire(CreateAuction::class)
        ->fillForm([
            'name' => null,
            'user_id' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name' => 'required',
            'user_id' => 'required',
        ]);
});

it('can load the auction edit page', function () {
    $auction = Auction::factory()->create();

    livewire(EditAuction::class, [
        'record' => $auction->id,
    ])
        ->assertStatus(403);
});

it('can load the auction view page', function () {
    $auction = Auction::factory()->create();

    livewire(ViewAuction::class, [
        'record' => $auction->id,
    ])
        ->assertOk();
});
