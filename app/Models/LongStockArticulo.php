<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LongStockArticulo extends Model
{
    use HasFactory;
    protected $primaryKey = null   ;
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = 'LOG_STOCK_ARTICULO';
    protected $fillable = [
        'COD_EMPRESA',
        'COD_ANO',
        'COD_MES',
        'COD_ARTICULO_SERV',
        'CAN_ACTUAL',
        'IMP_COSTO_UNIT_SOLES_ACT',
        'IMP_COSTO_UNIT_DOLAR_ACT',
        'IMP_COSTO_TOT_SOLES_ACT',
        'IMP_COSTO_TOT_DOLAR_ACT',
        'COD_FAMILIA',
    ];
}
