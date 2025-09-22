<?php

namespace Tests\Unit\Models;

use App\Enums\LotStatus;
use App\Models\Lot;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(\Tests\TestCase::class, RefreshDatabase::class);

it('correctly scopes to active lots', function () {
    // 1. Arrange: Create lots with various states.

    // This lot should be returned by the scope.
    $activeLot = Lot::factory()->create([
        'status' => LotStatus::ACTIVE,
        'starts_at' => now()->subDay(),
        'ends_at' => now()->addDay(),
    ]);

    // These lots should be ignored by the scope.
    Lot::factory()->create([
        'status' => LotStatus::ACTIVE,
        'starts_at' => now()->addDay(), // Not started yet
        'ends_at' => now()->addDays(2),
    ]);

    Lot::factory()->create([
        'status' => LotStatus::ACTIVE,
        'starts_at' => now()->subDays(2),
        'ends_at' => now()->subDay(), // Already finished
    ]);

    Lot::factory()->create([
        'status' => LotStatus::CANCELED, // Wrong status
        'starts_at' => now()->subDay(),
        'ends_at' => now()->addDay(),
    ]);

    // 2. Act: Apply the active scope.
    $activeLots = Lot::active()->get();

    // 3. Assert: Check that only the truly active lot was returned.
    expect($activeLots)->toHaveCount(1)
        ->and($activeLots->first()->id)->toBe($activeLot->id);
});
