<?php

namespace Tests\Unit\Services;

use App\Actions\PlaceBidAction;
use App\Contracts\BidServiceInterface;
use App\DTOs\BidData;
use App\Events\NewBidPlaced;
use App\Models\Bid;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

use function Pest\Laravel\mock;

uses(TestCase::class);

it('successfully places a bid and dispatches an event', function () {
    // 1. Arrange
    // Fake the event dispatcher to catch dispatched events.
    Event::fake();

    // Create a DTO with bid data.
    $user = User::factory()->make(['id' => 1]);
    $bidData = new BidData(
        lot_id: 10,
        user_id: $user->id,
        amount: 1500.00
    );

    // Mock the Bid model that the service will return.
    // The action should load its relationships before dispatching the event.
    $bidMock = mock(Bid::class);
    $bidMock->shouldReceive('load')->with(['user', 'lot'])->once()->andReturnSelf();

    // Mock the BidService, which is the dependency of our action.
    $bidServiceMock = mock(BidServiceInterface::class);
    $bidServiceMock->shouldReceive('placeBid')
        ->with($bidData)
        ->once()
        ->andReturn($bidMock);

    // 2. Act
    // Execute the action we want to test.
    (new PlaceBidAction($bidServiceMock))->execute($bidData);

    // 3. Assert
    // Ensure that the NewBidPlaced event was dispatched.
    Event::assertDispatched(NewBidPlaced::class);
});
