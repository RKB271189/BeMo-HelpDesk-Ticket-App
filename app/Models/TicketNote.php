<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'note',
        'created_by',
    ];
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }
}
