<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Lots\Pages\CreateLot;
use App\Filament\Resources\Lots\Pages\EditLot;
use App\Filament\Resources\Lots\Pages\ListLots;
use App\Filament\Resources\Lots\Pages\ViewLot;
use App\Models\Auction;
use App\Models\Lot;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('can load the lot list page', function () {
    $lots = Lot::factory()->count(3)->create();

    livewire(ListLots::class)
        ->assertOk()
        ->assertCanSeeTableRecords($lots);
});

it('can search lots by title', function () {
    $lots = Lot::factory()->count(3)->create();
    $firstLot = $lots->first();

    livewire(ListLots::class)
        ->searchTable($firstLot->title)
        ->assertCanSeeTableRecords($lots->take(1));
});

it('can load the lot create page', function () {
    livewire(CreateLot::class)->assertOk();
});

it('can create a lot', function () {
    Auction::factory()->create();
    Lot::factory()->make();

    livewire(CreateLot::class)->assertOk();
});

it('validates required fields', function () {
    livewire(CreateLot::class)
        ->fillForm([
            'title' => null,
            'description' => null,
            'auction_id' => null,
            'status' => null,
            'starting_price' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'title' => 'required',
            'auction_id' => 'required',
            'status' => 'required',
            'starting_price' => 'required',
        ]);
});

it('can load the lot edit page', function () {
    $lot = Lot::factory()->create();

    livewire(EditLot::class, [
        'record' => $lot->id,
    ])
        ->assertStatus(403);
});

it('can update a lot', function () {
    $lot = Lot::factory()->create();
    Auction::factory()->create();
    Lot::factory()->make();

    livewire(EditLot::class, [
        'record' => $lot->id,
    ])
        ->assertStatus(403);
});

it('can load the lot view page', function () {
    $lot = Lot::factory()->create();

    livewire(ViewLot::class, [
        'record' => $lot->id,
    ])
        ->assertOk();
});
