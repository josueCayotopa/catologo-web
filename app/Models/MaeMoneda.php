<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaeMoneda extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'COD_MONEDA';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = 'mae_monedas';
    protected  $fillable =[
        'COD_MONEDA',
        'DES_MONEDA',
        'DES_ABREVIATURA'
    ];

}
