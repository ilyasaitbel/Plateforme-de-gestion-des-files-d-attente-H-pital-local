<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'hospital_id',
        'name',
        'description',
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
}