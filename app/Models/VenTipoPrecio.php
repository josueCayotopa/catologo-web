<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenTipoPrecio extends Model
{
    use HasFactory;
    protected $fillable = [
        'COD_PRECIO',
        'COD_EMPRESA',
        'DES_PRECIO',
    ];
}
