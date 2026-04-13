<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'role',
    ];

    protected function casts()
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function administrator()
    {
        return $this->hasOne(Administrator::class);
    }

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    public function citoyen()
    {
        return $this->hasOne(Citoyen::class);
    }

    public function getRoleAttribute()
    {
        return once(function () {
            if ($this->administrator()->exists()) {
                return 'admin';
            }

            if ($this->agent()->exists()) {
                return 'agent';
            }

            if ($this->citoyen()->exists()) {
                return 'citoyen';
            }

            return null;
        });
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAgent()
    {
        return $this->role === 'agent';
    }

    public function isCitoyen()
    {
        return $this->role === 'citoyen';
    }
}
