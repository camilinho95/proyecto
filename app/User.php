<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

    use SoftDeletes;
    use Notifiable;
    
    protected $fillable = [
        'name', 'email','password','role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     
    public function getIsAdminAttribute()
    {
        return $this->role == 0;
    }

    public function getIsVentanillaAttribute()
    {
        return $this->role == 1;
    }

    public function getIsCartografiaAttribute()
    {
        return $this->role == 2;
    }

}
