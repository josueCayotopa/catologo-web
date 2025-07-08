<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaCargos extends Model
{
    use HasFactory;
    protected $table = 'PLA_CARGOS';
    protected $primaryKey = 'COD_CARGO';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'COD_EMPRESA',
        'COD_CARGO',
        'COD_CATEGORIA',
        'DES_CARGO',
        'COD_SUNAT',
        'IND_DIRECTIVO'
    ];
    // CATEFORIAS

    public function categoria()
    {
        return $this->belongsTo(PlaCategorias::class, 'COD_CATEGORIA', 'COD_CATEGORIA');
    }
    // EMPRESAS
    public function empresa()
    {
        return $this->belongsTo(MaeEmpresa::class, 'COD_EMPRESA', 'COD_EMPRESA');
    }

}
