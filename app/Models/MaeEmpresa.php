<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaeEmpresa extends Model
{
    use HasFactory;
    protected $table = 'MAE_EMPRESAS';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $primaryKey = 'COD_EMPRESA';
    protected $fillable = [
        'COD_EMPRESA',
        'DES_RAZON_SOCIAL',
        'DES_NOMBRE_COMERCIAL',
        'NUEVO_RUC',
        'DES_DIRECCION',
        'NUM_REG_PATRONAL',
        'COD_PAIS',
        'NUM_DECRET_SUPRE',
        'NUM_EMAIL',
        'DES_REPRES_LEGAL',
        'NUM_DOC_REPRES',
        'NUM_TELEFONO',
        'COD_MONEDA_BASE',
        'COD_MONEDA_SECUN',
        'IND_BAJA',
        'COD_UBIGEO',
        'COD_AUXILIAR',

    ];




    public function pais()
    {
        return $this->belongsTo(MaePais::class, 'COD_PAIS', 'COD_PAIS');
    }
    public function moneda()
    {
        return $this->belongsTo(MaeMoneda::class, 'COD_MONEDA_BASE', 'COD_MONEDA');
    }
    public function monedasecun()
    {
        return $this->belongsTo(MaeMoneda::class, 'COD_MONEDA_SECUN', 'COD_MONEDA');
    }


    // Relación con Sucursales
    public function sucursales()
    {
        return $this->hasMany(MaeSucursal::class, 'COD_EMPRESA', 'COD_EMPRESA');
    }

    // Relación con Usuarios
    // public function usuarios()
    // {
    //     return $this->hasMany(MaeUsuario::class, 'COD_EMPRESA', 'COD_EMPRESA');
    // }
}
