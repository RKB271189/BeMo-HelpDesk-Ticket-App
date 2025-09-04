<?php

namespace App\Contracts;

use App\Contracts\Base\ModelRepository;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

final class TicketContract extends ModelRepository
{
    public function __construct(private Ticket $ticket)
    {
        parent::__construct($ticket);
    }   
}
