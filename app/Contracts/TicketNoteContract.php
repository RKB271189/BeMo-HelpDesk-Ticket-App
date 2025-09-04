<?php

namespace App\Contracts;

use App\Contracts\Base\ModelRepository;
use App\Models\TicketNote;

final class TicketNoteContract extends ModelRepository
{
    public function __construct(private TicketNote $ticketNote)
    {
        parent::__construct($ticketNote);
    }
}
