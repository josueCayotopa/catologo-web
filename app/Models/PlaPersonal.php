<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaPersonal extends Model
{

    use HasFactory;
    protected $table = 'PLA_PERSONAL';
    protected $primaryKey = 'COD_PERSONAL';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'COD_EMPRESA',
        'COD_PERSONAL',
        'COD_TIPO_PLANILLA',
        'COD_AUXILIAR',
        'APE_PATERNO',
        'APE_MATERNO',
        'NOM_TRABAJADOR',
        'COD_PROFESION',
    ];    
   


}
