<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketClassification extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id',
        'category',
        'explanation',
        'confidence',
        'is_override',
        'processed_at'
    ];
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }
}
