<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CveEspecialidad extends Model
{
    use HasFactory;

    protected $table = 'CVE_ESPECIALIDAD';
    protected $primaryKey = 'COD_ESPECIALIDAD';
    public $incrementing = true;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'COD_ESPECIALIDAD',
        'DES_ESPECIALIDAD',
        'TIP_ESTADO',
        'COD_UPSS',
        'TIP_HORARAIO',
    ];
    // relacion con catalogo web 
    public function catalogoWeb()
    {
        return $this->hasMany(CatalogoWeb::class, 'COD_ESPECIALIDAD', 'COD_ESPECIALIDAD');
    }


}
