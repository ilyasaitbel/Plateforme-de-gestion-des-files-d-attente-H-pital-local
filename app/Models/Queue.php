<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = [
        'service_id',
        'name',
        'current_number',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}