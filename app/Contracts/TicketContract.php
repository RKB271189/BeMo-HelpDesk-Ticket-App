<?php

namespace App\Contracts;

use App\Contracts\Base\ModelRepository;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

final class TicketContract extends ModelRepository
{
    public function __construct(private Ticket $ticket)
    {
        parent::__construct($ticket);
    }
    public function getNewTicketQuery(): Builder
    {
        return $this->ticket::new();
    }
    public function getNewTickets()
    {
        return $this->ticket::new()->get();
    }
}
