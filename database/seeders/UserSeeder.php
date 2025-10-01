<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $imgUrl = 'https://picsum.photos/500';
        $usersData = [
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ],
            [
                'name' => 'Demo User',
                'email' => 'demo@example.com',
            ],
        ];

        foreach ($usersData as $userData) {
            User::factory()
                ->afterCreating(function (User $user) use ($imgUrl): void {
                    $user->addMediaFromUrl($imgUrl)
                        ->toMediaCollection('user.avatar');
                })
                ->create($userData);
        }

        User::factory(5)
            ->afterCreating(function (User $user) use ($imgUrl): void {
                $user->addMediaFromUrl($imgUrl)
                    ->toMediaCollection('user.avatar');
            })
            ->create();
    }
}
