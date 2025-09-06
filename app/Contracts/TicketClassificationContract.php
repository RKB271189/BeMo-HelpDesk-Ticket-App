<?php

namespace App\Contracts;

use App\Contracts\Base\ModelRepository;
use App\Models\TicketClassification;
use Illuminate\Database\Eloquent\Model;

final class TicketClassificationContract extends ModelRepository
{
    public function __construct(private TicketClassification $ticketClassification)
    {
        parent::__construct($ticketClassification);
    }
    public function updateData(array $params, $id): Model
    {
        $classification = $this->ticketClassification::updateOrCreate(
            ['id' => $id],
            $params
        );
        return $classification;
    }
    public function getCategories()
    {
        $categories = $this->ticketClassification::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
        return $categories;
    }
}
