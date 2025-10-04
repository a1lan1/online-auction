<?php

namespace Tests\Feature\Filament;

use App\Models\User;

use function Pest\Laravel\actingAs;

it('requires authentication to access admin panel', function () {
    $this->get('/admin')
        ->assertRedirect('/admin/login');
});

it('allows authenticated users to access admin panel', function () {
    $user = User::factory()->create();
    actingAs($user);

    $this->get('/admin')
        ->assertStatus(403);
});
