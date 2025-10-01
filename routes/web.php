<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LotController;
use Illuminate\Support\Facades\Route;

Route::controller(AuctionController::class)
    ->name('auctions.')
    ->group(function (): void {
        Route::get('', 'index')->name('index');
        Route::get('auctions/{auction}', 'show')->name('show');
    });

Route::controller(LotController::class)
    ->name('lots.')
    ->prefix('lots')
    ->group(function (): void {
        Route::get('autocomplete', 'autocomplete')->name('autocomplete');
        Route::get('{lot}', 'show')->name('show');
        Route::post('{lot}/bid', 'placeBid')
            ->middleware(['auth', 'verified', 'throttle:12,1'])
            ->name('bids.store');

    });

Route::middleware('auth')->group(function (): void {
    Route::controller(DashboardController::class)
        ->prefix('dashboard')
        ->name('dashboard.')
        ->group(function (): void {
            Route::get('', 'index')->name('index');
            Route::get('my-bids', 'myBids')->name('my-bids');
            Route::get('action-history', 'actionHistory')->name('action-history');
        });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
