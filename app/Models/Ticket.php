<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'queue_id',
        'citoyen_id',
        'number',
        'status',
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function citoyen()
    {
        return $this->belongsTo(Citoyen::class);
    }

}
