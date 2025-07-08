<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenTarifarioPrecio extends Model
{
    use HasFactory;
    protected $fillable = [
        'COD_EMPRESA',
        'COD_ARTICULO_SERV',
        'COD_FAMILIA',
        'COD_PRECIO',
        'IMP_PRECIO',
        'COD_MONEDA',
        'COD_UNI_MEDIDA',
        'COD_TIPO_MEDIDA',
        'IND_GRAVADO',
        'IMD_EXONERADO',
        'IMP_COSTO_UNI_SIMP',
    ];
}
