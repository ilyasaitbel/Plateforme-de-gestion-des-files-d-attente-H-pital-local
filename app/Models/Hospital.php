<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
    ];

    public function administrators()
    {
        return $this->hasMany(Administrator::class);
    }

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
