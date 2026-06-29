<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tutorhub.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@tutorhub.com',
                'role' => 'admin',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
