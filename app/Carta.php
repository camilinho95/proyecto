<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carta extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'comuna','barrio', 'manzana','idmanzana','pdf','dwg'
    ];
}
