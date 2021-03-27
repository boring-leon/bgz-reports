<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function reports(){
        return $this->hasMany(Report::class);
    }

    public function transfers(){
        return $this->hasManyThrough(Transfer::class, Report::class);
    }
}
