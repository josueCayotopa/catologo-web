<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogoWeb extends Model
{
    use HasFactory;

    protected $table = 'CATALOGO_WEB';
    protected $primaryKey = 'COD_ARTICULO_SERV';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'COD_EMPRESA',
        'COD_SUCURSAL',
        'COD_ESPECIALIDAD',
        'DES_ARTICULO',
        'DES_CORTA',
        'PRECIO_MOSTRAR',
        'COD_MONEDA',
        'IMAGEN_URL',
        'ORDEN_MOSTRAR',
        'IND_DESTACADO',
        'IND_PROMOCION',
        'PRECIO_PROMOCION',
        'FECHA_INICIO_PROMO',
        'FECHA_FIN_PROMO',
        'ESTADO',
        'FECHA_CREACION',
        // Nuevos campos
        'CATEGORIA',
        'TIPO_SERVICIO',
        'PALABRAS_CLAVE',
        'DISPONIBLE',
        'DURACION_ESTIMADA',
        'REQUIERE_CITA',
        'META_DESCRIPCION',
        'META_KEYWORDS',
        'URL_AMIGABLE',
        'STOCK_DISPONIBLE',
        'STOCK_MINIMO',
        'HORARIO_DISPONIBLE',
        'DIAS_DISPONIBLE',
    ];

    protected $casts = [
        'PRECIO_MOSTRAR' => 'decimal:2',
        'PRECIO_PROMOCION' => 'decimal:2',
        'FECHA_INICIO_PROMO' => 'date',
        'FECHA_FIN_PROMO' => 'date',
        'FECHA_CREACION' => 'datetime',
        'STOCK_DISPONIBLE' => 'integer',
        'STOCK_MINIMO' => 'integer',
        'ORDEN_MOSTRAR' => 'integer',
        'DIAS_DISPONIBLE' => 'array', // Para manejar múltiples días
    ];

    protected $attributes = [
        'COD_MONEDA' => 'PEN',
        'ORDEN_MOSTRAR' => 1,
        'IND_DESTACADO' => 'N',
        'IND_PROMOCION' => 'N',
        'ESTADO' => 'A',
        'DISPONIBLE' => 'S',
        'REQUIERE_CITA' => 'S',
        'STOCK_DISPONIBLE' => 999,
        'STOCK_MINIMO' => 0,
    ];

    // Relaciones
    public function sucursal()
    {
        return $this->belongsTo(MaeSucursal::class, 'COD_SUCURSAL', 'COD_SUCURSAL');
    }

    public function especialidad()
    {
        return $this->belongsTo(CveEspecialidad::class, 'COD_ESPECIALIDAD', 'COD_ESPECIALIDAD');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('ESTADO', 'A');
    }

    public function scopeDisponibles($query)
    {
        return $query->where('DISPONIBLE', 'S');
    }

    public function scopeDestacados($query)
    {
        return $query->where('IND_DESTACADO', 'S');
    }

    public function scopeEnPromocion($query)
    {
        return $query->where('IND_PROMOCION', 'S');
    }

    public function scopePorSucursal($query, $sucursal)
    {
        return $query->where('COD_SUCURSAL', $sucursal);
    }

    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('CATEGORIA', $categoria);
    }

    // Mutators
    public function setDiasDisponibleAttribute($value)
    {
        $this->attributes['DIAS_DISPONIBLE'] = is_array($value) ? implode(',', $value) : $value;
    }

    public function getDiasDisponibleAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    // Accessors
    public function getImagenUrlAttribute($value)
    {
        if (empty($value)) {
            return '/placeholder.svg?height=400&width=400&text=Servicio+Médico';
        }
        
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        
        return asset('storage/' . $value);
    }

    public function getEsPromocionAttribute()
    {
        return $this->IND_PROMOCION === 'S' && !empty($this->PRECIO_PROMOCION);
    }

    public function getEsDestacadoAttribute()
    {
        return $this->IND_DESTACADO === 'S';
    }

    public function getEstaDisponibleAttribute()
    {
        return $this->DISPONIBLE === 'S' && $this->ESTADO === 'A';
    }
}
