<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaCategorias extends Model
{
    use HasFactory;
    protected $table = 'PLA_CATEGORIAS';
    protected $primaryKey = 'COD_PERSONAL';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = 
    [
        'COD_EMPRESA',
        'COD_CATEGORIA',
        'DES_CATEGORIA',
        'COD_NIVEL',
        'FACTOR_HE',
        'FACTOR_VIA',        
    ];
    //CARGOS
    public function cargos()
    {
        return $this->hasMany(PlaCargos::class, 'COD_CATEGORIA', 'COD_CATEGORIA');
    }
    // empresa 
    public function empresa()
    {
        return $this->belongsTo(MaeEmpresa::class, 'COD_EMPRESA', 'COD_EMPRESA');
    }

    
}
