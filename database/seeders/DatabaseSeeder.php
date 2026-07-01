<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('users')->updateOrInsert(
            ['email' => 'admin@example.com'],
            [
            'name' => 'Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            'is_admin' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'user@example.com'],
            [
            'name' => 'User',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            'is_admin' => false,
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );
    }
}
