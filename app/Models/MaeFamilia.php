<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaeFamilia extends Model
{
    use HasFactory;
    protected $primaryKey = 'COD_FAMILIA';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = 'MAE_FAMILIA';
    protected $fillable = [
        'COD_FAMILIA',
        'COD_FAMILIAP',
        'DES_FAMILIA',
        'NUM_NIVEL',
        'IND_BAJA',
    ];
}
