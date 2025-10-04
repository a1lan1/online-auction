<?php

namespace Tests\Feature\Filament;

use App\Filament\Pages\Dashboard;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('can load the dashboard page', function () {
    livewire(Dashboard::class)->assertOk();
});

it('requires authentication to access dashboard', function () {
    Auth::logout();

    $this->get('/admin/dashboard')
        ->assertStatus(404);
});
