<?php

use App\Http\Controllers\AuctionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::controller(AuctionController::class)
    ->name('auctions.')
    ->group(function (): void {
        Route::get('', 'index')->name('index');
        Route::get('auctions/{auction}', 'show')->name('show');
    });

Route::middleware('auth')->group(function (): void {
    Route::get('dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
