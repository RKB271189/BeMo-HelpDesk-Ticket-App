<?php

namespace App\Contracts;

use App\Contracts\Base\ModelRepository;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

final class TicketContract extends ModelRepository
{
    public function __construct(private Ticket $ticket)
    {
        parent::__construct($ticket);
    }
    public function getAllTickets(): Collection
    {
        return $this->ticket::with(['classification', 'note'])->get();
    }
    public function getNewTicketQuery(): Builder
    {
        return $this->ticket::new();
    }
}
