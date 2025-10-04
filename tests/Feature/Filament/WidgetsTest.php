<?php

namespace Tests\Feature\Filament;

use App\Filament\Widgets\DailyBiddingActivity;
use App\Filament\Widgets\LotStatusDistribution;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TopAuctions;
use App\Filament\Widgets\UsersChart;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Lot;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('can load stats overview widget', function () {
    User::factory()->count(5)->create();
    Lot::factory()->count(3)->create();
    Bid::factory()->count(7)->create();

    livewire(StatsOverview::class)->assertOk();
});

it('can load daily bidding activity widget', function () {
    Bid::factory()->count(5)->create();

    livewire(DailyBiddingActivity::class)->assertOk();
});

it('can load lot status distribution widget', function () {
    Lot::factory()->count(5)->create();

    livewire(LotStatusDistribution::class)->assertOk();
});

it('can load top auctions widget', function () {
    Auction::factory()->count(3)->create();

    livewire(TopAuctions::class)->assertOk();
});

it('can load users chart widget', function () {
    User::factory()->count(5)->create();

    livewire(UsersChart::class)->assertOk();
});
