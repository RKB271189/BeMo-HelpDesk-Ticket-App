<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory, HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'subject',
        'body',
        'status',
    ];
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }
    public function scopeClassified($query)
    {
        return $query->where('status', 'classified');
    }
    public function classification()
    {
        return $this->hasOne(TicketClassification::class);
    }
    public function note()
    {
        return $this->hasOne(TicketNote::class);
    }
}
