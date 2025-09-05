<?php

namespace App\Console\Commands;

use App\Contracts\TicketContract;
use App\Jobs\ClassifyTicketJob;
use Illuminate\Console\Command;

class TicketBulkClassify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:bulk-classify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan command to classify bulk tickets by triggering the designed job';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ticketContract = app(TicketContract::class);
        $ticketContract->getNewTicketQuery()->chunk(100, function ($tickets) {
            foreach ($tickets as $ticket) {
                ClassifyTicketJob::dispatch($ticket->id);
            }
        });
    }
}
