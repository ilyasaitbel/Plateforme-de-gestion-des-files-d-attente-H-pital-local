<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Agent extends Model
{
    protected $fillable = [
        'user_id',
        'queue_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function hospital(): HasOneThrough
    {
        return $this->hasOneThrough(
            Hospital::class,
            Service::class,
            'id',
            'id',
            'queue_id',
            'hospital_id'
        )->join('queues', 'queues.service_id', '=', 'services.id')
            ->whereColumn('queues.id', 'agents.queue_id')
            ->select('hospitals.*');
    }
}
