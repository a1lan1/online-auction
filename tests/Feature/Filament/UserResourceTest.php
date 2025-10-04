<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('can load the user list page', function () {
    $users = User::factory()->count(3)->create();

    livewire(ListUsers::class)
        ->assertOk()
        ->assertCanSeeTableRecords($users);
});

it('can search users by name', function () {
    $users = User::factory()->count(3)->create();
    $firstUser = $users->first();

    livewire(ListUsers::class)
        ->searchTable($firstUser->name)
        ->assertCanSeeTableRecords($users->take(1));
});

it('can search users by email', function () {
    $users = User::factory()->count(3)->create();
    $firstUser = $users->first();

    livewire(ListUsers::class)
        ->searchTable($firstUser->email)
        ->assertCanSeeTableRecords($users->take(1));
});

it('can load the user create page', function () {
    livewire(CreateUser::class)->assertOk();
});

it('can create a user', function () {
    $userData = User::factory()->make();

    livewire(CreateUser::class)
        ->fillForm([
            'name' => $userData->name,
            'email' => $userData->email,
            'password' => 'password123',
        ])
        ->call('create')
        ->assertNotified();

    assertDatabaseHas('users', [
        'name' => $userData->name,
        'email' => $userData->email,
    ]);
});

it('validates required fields', function () {
    livewire(CreateUser::class)
        ->fillForm([
            'name' => null,
            'email' => null,
            'password' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
});

it('validates unique email', function () {
    $email = 'existing@example.com';

    User::factory()->create(['email' => $email]);

    livewire(CreateUser::class)
        ->fillForm([
            'name' => 'Test User',
            'email' => $email,
            'password' => 'password123',
        ])
        ->call('create')
        ->assertHasFormErrors(['email' => 'unique']);
});

it('can load the user edit page', function () {
    $user = User::factory()->create();

    livewire(EditUser::class, [
        'record' => $user->id,
    ])
        ->assertOk();
});

it('can update a user', function () {
    $user = User::factory()->create();
    $newUserData = User::factory()->make();

    livewire(EditUser::class, [
        'record' => $user->id,
    ])
        ->fillForm([
            'name' => $newUserData->name,
            'email' => $newUserData->email,
        ])
        ->call('save')
        ->assertNotified();

    assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $newUserData->name,
        'email' => $newUserData->email,
    ]);
});

it('can update user password', function () {
    $user = User::factory()->create();
    $newPassword = 'newpassword123';

    livewire(EditUser::class, [
        'record' => $user->id,
    ])
        ->fillForm([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $newPassword,
        ])
        ->call('save')
        ->assertNotified();

    $user->refresh();
    expect(Hash::check($newPassword, $user->password))->toBeTrue();
});

it('can load the user view page', function () {
    $user = User::factory()->create();

    livewire(ViewUser::class, [
        'record' => $user->id,
    ])
        ->assertOk();
});
