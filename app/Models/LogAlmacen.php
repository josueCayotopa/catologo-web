<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAlmacen extends Model
{
    use HasFactory;
    protected $primaryKey = 'COD_ALMACEN';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = 'LOG_ALMACEN';
    protected $fillable = [
        'COD_ALMACEN',
        'COD_EMPRESA',
        'COD_SUCURSAL',
        'DES_ALMACEN',
        'DES_DIRECCION',
        'TIP_TOMA_INVENTARIO',
        'TIP_ALMACEN',
        'IND_TIPO_ALMACEN',
        'IND_ALMACEN_VTA',
        'IND_REL_SB',
        'DES_DIR_ALM_CLIENTE',
        'COD_UBIGEO',
        'IND_BAJA'

      
    ];


}
