<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
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
                ->withAvatar()
                ->create($userData);
        }
    }
}
