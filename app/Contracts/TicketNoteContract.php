<?php

namespace App\Contracts;

use App\Contracts\Base\ModelRepository;
use App\Models\TicketNote;
use Illuminate\Database\Eloquent\Model;

final class TicketNoteContract extends ModelRepository
{
    public function __construct(private TicketNote $ticketNote)
    {
        parent::__construct($ticketNote);
    }
    public function updateData(array $params, $id): Model
    {
        $note = $this->ticketNote::updateOrCreate(
            ['id' => $id],
            $params
        );
        return $note;
    }
}
