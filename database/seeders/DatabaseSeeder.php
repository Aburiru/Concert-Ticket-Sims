<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TicketType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Seed ticket types as per PRD ADVANCED.md
        TicketType::create([
            'name' => 'VIP',
            'price' => 500000,
            'quota' => 100,
            'remaining_stock' => 100,
        ]);

        TicketType::create([
            'name' => 'TENGAH',
            'price' => 200000,
            'quota' => 500,
            'remaining_stock' => 500,
        ]);

        TicketType::create([
            'name' => 'REGULER',
            'price' => 150000,
            'quota' => 1000,
            'remaining_stock' => 1000,
        ]);
    }
}
