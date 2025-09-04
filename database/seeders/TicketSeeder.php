<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\TicketNote;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::factory()->count(30)->create()->each(function ($ticket) {
            $notesCount = rand(0, 3);

            for ($i = 0; $i < $notesCount; $i++) {
                TicketNote::factory()->create([
                    'ticket_id' => $ticket->id
                ]);
            }
        });
    }
}
