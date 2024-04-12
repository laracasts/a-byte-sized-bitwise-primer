<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Ticket::factory()
            ->forEachSequence(
                ['name' => 'Bronze', 'description' => 'The perfect starting place for conference newcomers.', 'branding_hex' => '#ED7D3A'],
                ['name' => 'Silver', 'description' => 'For more discerning conference goers seeking a thrilling experience.', 'branding_hex' => '#7A787D'],
                ['name' => 'Gold', 'description' => 'If you\'re looking to make this year\'s conference special, look no further than the gold ticket.', 'branding_hex' => '#EDF060'],
                ['name' => 'Platinum', 'description' => 'For those who want all there is to offer. Turn your conference experience to 11.', 'branding_hex' => '#66D7D1']
            )
            ->create();
    }
}
