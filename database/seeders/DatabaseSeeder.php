<?php

namespace Database\Seeders;

use App\Models\TicketType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        TicketType::create([
            'name' => 'VIP',
            'price' => 500000,
            'quota' => 100,
            'remaining_stock' => 100,
            'event_name' => 'Concert 2026',
            'event_date' => '2026-10-24',
            'event_location' => 'Arena Stadium, JK',
        ]);

        TicketType::create([
            'name' => 'TENGAH',
            'price' => 200000,
            'quota' => 500,
            'remaining_stock' => 500,
            'event_name' => 'Concert 2026',
            'event_date' => '2026-10-24',
            'event_location' => 'Arena Stadium, JK',
        ]);

        TicketType::create([
            'name' => 'REGULER',
            'price' => 150000,
            'quota' => 1000,
            'remaining_stock' => 1000,
            'event_name' => 'Concert 2026',
            'event_date' => '2026-10-24',
            'event_location' => 'Arena Stadium, JK',
        ]);
    }
}
