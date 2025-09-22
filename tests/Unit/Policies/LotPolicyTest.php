<?php

namespace Tests\Unit\Policies;

use App\Models\Auction;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(\Tests\TestCase::class, RefreshDatabase::class);

test('owner can update their own lot', function () {
    $owner = User::factory()->create();
    $auction = Auction::factory()->for($owner, 'owner')->create();
    $lot = Lot::factory()->for($auction)->create();

    expect($owner->can('update', $lot))->toBeTrue();
});

test('another user cannot update a lot', function () {
    $owner = User::factory()->create();
    $anotherUser = User::factory()->create();
    $auction = Auction::factory()->for($owner, 'owner')->create();
    $lot = Lot::factory()->for($auction)->create();

    expect($anotherUser->can('update', $lot))->toBeFalse();
});

test('owner can delete their own lot', function () {
    $owner = User::factory()->create();
    $auction = Auction::factory()->for($owner, 'owner')->create();
    $lot = Lot::factory()->for($auction)->create();

    expect($owner->can('delete', $lot))->toBeTrue();
});

test('another user cannot delete a lot', function () {
    $owner = User::factory()->create();
    $anotherUser = User::factory()->create();
    $auction = Auction::factory()->for($owner, 'owner')->create();
    $lot = Lot::factory()->for($auction)->create();

    expect($anotherUser->can('delete', $lot))->toBeFalse();
});
