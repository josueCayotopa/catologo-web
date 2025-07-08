<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaePais extends Model
{
    use HasFactory;

    protected $primaryKey = 'COD_PAIS';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = 'mae_pais';

    protected $fillable =[
        'COD_PAIS',
        'NOM_PAIS',
        'NOM_ABR'
    ];
    

}
