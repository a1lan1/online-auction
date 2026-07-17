<?php

namespace Tests\Unit\Models;

use App\Models\Lot;
use App\States\Lot\Active;
use App\States\Lot\Pending;
use App\States\Lot\Sold;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;
use Spatie\ModelStates\Exceptions\TransitionNotFound;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('has a pending status by default', function () {
    $lot = Lot::factory()->create();

    expect($lot->status)->toBeInstanceOf(Pending::class);
});

it(/**
 * @throws CouldNotPerformTransition
 */ 'can transition from pending to active', function () {
    $lot = Lot::factory()->pending()->create();

    $lot->status->transitionTo(Active::class);

    expect($lot->status)->toBeInstanceOf(Active::class);
});

it('cannot transition from pending to sold', function () {
    $lot = Lot::factory()->pending()->create();

    $this->expectException(TransitionNotFound::class);

    $lot->status->transitionTo(Sold::class);
});

it('correctly scopes to active lots', function () {
    $activeLot = Lot::factory()->active()->create();
    $pendingLot = Lot::factory()->pending()->create();
    $soldLot = Lot::factory()->sold()->create();
    $cancelledLot = Lot::factory()->cancelled()->create();
    $notStartedLot = Lot::factory()->active()->hasNotStarted()->create();
    $finishedLot = Lot::factory()->active()->hasFinished()->create();

    $activeLots = Lot::active()->get();

    expect($activeLots)->toHaveCount(1)
        ->and($activeLots->first()->id)->toBe($activeLot->id);
});
