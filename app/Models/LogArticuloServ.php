<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogArticuloServ extends Model
{
    use HasFactory;
    protected $primaryKey = 'COD_ARTICULO_SERV';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = 'LOG_ARTICULO_SERV';
     protected $fillable = [
        'COD_EMPRESA',
        'COD_ARTICULO_SERV',
        'COD_C_NEGOCIOS',
        'COD_FAMILIA',
        'TIP_ARTICULO_SERV',
        'NUM_VER_C_COSTOS',
        'DES_ARTICULO_SERV',
        'DES_LARGA',
        'TIP_PRODUCTO',
        'COD_BARRA',
        'FEC_ACTUALIZA',
        'DES_INGLES'

    ];
}
