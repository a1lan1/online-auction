<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\actingAs;

it('allows a user to update their password', function () {
    $user = User::factory()->create();

    actingAs($user);

    visit(route('password.edit'))
        ->fill('current_password', 'password')
        ->fill('password', 'new-password')
        ->fill('password_confirmation', 'new-password')
        ->press('Save password')
        ->assertSee('Saved.');

    // Verify the password was actually changed in the database
    $user->refresh();
    expect(Hash::check('new-password', $user->password))->toBeTrue();
});

it('shows an error if the current password is incorrect', function () {
    $user = User::factory()->create();

    actingAs($user);

    visit(route('password.edit'))
        ->fill('current_password', 'wrong-password')
        ->fill('password', 'new-password')
        ->fill('password_confirmation', 'new-password')
        ->press('Save password')
        ->assertSee('The password is incorrect.');

    $user->refresh();
    expect(Hash::check('password', $user->password))->toBeTrue();
});

it('shows an error if the new passwords do not match', function () {
    $user = User::factory()->create();

    actingAs($user);

    visit(route('password.edit'))
        ->fill('current_password', 'password')
        ->fill('password', 'new-password')
        ->fill('password_confirmation', 'different-password')
        ->press('Save password')
        ->assertSee('The password field confirmation does not match.');
});
