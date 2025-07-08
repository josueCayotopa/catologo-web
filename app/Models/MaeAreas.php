<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaeAreas extends Model
{
    use HasFactory;
    protected $table = 'MAE_AREAS'; // nombre exacto de la tabla en SQL Server
    protected $primaryKey = 'COD_AREA';
    public $incrementing = false; // si el ID no es autoincremental
    protected $keyType = 'string'; // tipo de clave primaria
    public $timestamps = false; // si no usas created_at y updated_at automáticos
    protected $fillable = [
        'COD_EMPRESA',
        'COD_AREAS',
        'DES_AREAS',
        'IND_BAJA',
    ];
}
