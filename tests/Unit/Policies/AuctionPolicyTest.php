<?php

namespace Tests\Unit\Policies;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(\Tests\TestCase::class, RefreshDatabase::class);

test('owner can update their own auction', function () {
    $owner = User::factory()->create();
    $auction = Auction::factory()->for($owner, 'owner')->create();

    expect($owner->can('update', $auction))->toBeTrue();
});

test('another user cannot update an auction', function () {
    $owner = User::factory()->create();
    $anotherUser = User::factory()->create();
    $auction = Auction::factory()->for($owner, 'owner')->create();

    expect($anotherUser->can('update', $auction))->toBeFalse();
});

test('owner can delete their own auction', function () {
    $owner = User::factory()->create();
    $auction = Auction::factory()->for($owner, 'owner')->create();

    expect($owner->can('delete', $auction))->toBeTrue();
});

test('another user cannot delete an auction', function () {
    $owner = User::factory()->create();
    $anotherUser = User::factory()->create();
    $auction = Auction::factory()->for($owner, 'owner')->create();

    expect($anotherUser->can('delete', $auction))->toBeFalse();
});
