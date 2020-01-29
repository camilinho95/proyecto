<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Carta extends Model
{
    use Notifiable;
    protected $fillable = [
        'comuna','barrio', 'manzana','idmanzana','pdf','dwg'
    ];
}
