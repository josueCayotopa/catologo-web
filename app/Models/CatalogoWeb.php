<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CatalogoWeb extends Model
{
    protected $table = 'CATALOGO_WEB';
    protected $primaryKey = 'COD_ARTICULO_SERV';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'COD_ARTICULO_SERV',
        'DES_ARTICULO',
        'DES_CORTA',
        'PRECIO_MOSTRAR',
        'PRECIO_PROMOCION',
        'MONEDA',
        'CATEGORIA',
        'SUBCATEGORIA',
        'COD_ESPECIALIDAD',
        'COD_SUCURSAL',
        'TIPO_SERVICIO',
        'IMAGEN_URL',
        'PALABRAS_CLAVE',
        'ORDEN_MOSTRAR',
        'URL_AMIGABLE',
        'ESTADO',
        'DISPONIBLE',
        'IND_DESTACADO',
        'IND_PROMOCION',
        'FECHA_INICIO_PROMO',
        'FECHA_FIN_PROMO',
        'DURACION_ESTIMADA',
        'REQUIERE_CITA',
        'PREPARACION_PREVIA',
        'TIEMPO_ENTREGA',
        'AYUNO_REQUERIDO',
        'EDAD_MINIMA',
        'EDAD_MAXIMA',
        'GENERO_RESTRICCION',
        'CONTRAINDICACIONES',
        'INCLUYE',
        'OBSERVACIONES',
        'HORARIO_ESPECIAL',
        'DIAS_DISPONIBLE',
        'REQUIERE_ORDEN_MEDICA',
        'ES_PAQUETE',
        'SERVICIOS_INCLUIDOS',
        'META_TITLE',
        'META_DESCRIPCION',
        'TAGS',
        'FECHA_CREACION'
    ];

    protected $casts = [
        'PRECIO_MOSTRAR' => 'decimal:2',
        'PRECIO_PROMOCION' => 'decimal:2',
        'ORDEN_MOSTRAR' => 'integer',
        'FECHA_INICIO_PROMO' => 'date',
        'FECHA_FIN_PROMO' => 'date',
        'FECHA_CREACION' => 'datetime',
        'EDAD_MINIMA' => 'integer',
        'EDAD_MAXIMA' => 'integer'
    ];

    protected $attributes = [
        'ESTADO' => 'A',
        'DISPONIBLE' => 'S',
        'IND_DESTACADO' => 'N',
        'IND_PROMOCION' => 'N',
        'MONEDA' => 'PEN',
        'ORDEN_MOSTRAR' => 999,
        'AYUNO_REQUERIDO' => 'N',
        'REQUIERE_ORDEN_MEDICA' => 'N',
        'ES_PAQUETE' => 'N'
    ];

    // Scopes existentes
    public function scopeActivo($query)
    {
        return $query->where('ESTADO', 'A');
    }

    public function scopeDisponible($query)
    {
        return $query->where('DISPONIBLE', 'S');
    }

    public function scopeDestacado($query)
    {
        return $query->where('IND_DESTACADO', 'S');
    }

    public function scopeEnPromocion($query)
    {
        return $query->where('IND_PROMOCION', 'S');
    }

    // Nuevos scopes para los campos agregados
    public function scopeLaboratorio($query)
    {
        return $query->where('CATEGORIA', 'LABORATORIO');
    }

    public function scopeImagen($query)
    {
        return $query->where('CATEGORIA', 'IMAGEN');
    }

    public function scopeConsulta($query)
    {
        return $query->where('CATEGORIA', 'CONSULTA');
    }

    public function scopePaquetes($query)
    {
        return $query->where('ES_PAQUETE', 'S');
    }

    public function scopeRequiereAyuno($query)
    {
        return $query->where('AYUNO_REQUERIDO', 'S');
    }

    public function scopeRequiereOrdenMedica($query)
    {
        return $query->where('REQUIERE_ORDEN_MEDICA', 'S');
    }

    public function scopePorSubcategoria($query, $subcategoria)
    {
        return $query->where('SUBCATEGORIA', $subcategoria);
    }

    public function scopePorEdad($query, $edad)
    {
        return $query->where(function($q) use ($edad) {
            $q->where('EDAD_MINIMA', '<=', $edad)
              ->orWhereNull('EDAD_MINIMA');
        })->where(function($q) use ($edad) {
            $q->where('EDAD_MAXIMA', '>=', $edad)
              ->orWhereNull('EDAD_MAXIMA');
        });
    }

    public function scopePorGenero($query, $genero)
    {
        return $query->where(function($q) use ($genero) {
            $q->where('GENERO_RESTRICCION', $genero)
              ->orWhereNull('GENERO_RESTRICCION');
        });
    }

    // Mutators para convertir boolean a S/N (existentes + nuevos)
    public function setDisponibleAttribute($value)
    {
        if (is_bool($value)) {
            $this->attributes['DISPONIBLE'] = $value ? 'S' : 'N';
        } else {
            $this->attributes['DISPONIBLE'] = $value;
        }
    }

    public function setIndDestacadoAttribute($value)
    {
        if (is_bool($value)) {
            $this->attributes['IND_DESTACADO'] = $value ? 'S' : 'N';
        } else {
            $this->attributes['IND_DESTACADO'] = $value;
        }
    }

    public function setIndPromocionAttribute($value)
    {
        if (is_bool($value)) {
            $this->attributes['IND_PROMOCION'] = $value ? 'S' : 'N';
        } else {
            $this->attributes['IND_PROMOCION'] = $value;
        }
    }

    public function setRequiereCitaAttribute($value)
    {
        if (is_bool($value)) {
            $this->attributes['REQUIERE_CITA'] = $value ? 'S' : 'N';
        } else {
            $this->attributes['REQUIERE_CITA'] = $value;
        }
    }

    public function setAyunoRequeridoAttribute($value)
    {
        if (is_bool($value)) {
            $this->attributes['AYUNO_REQUERIDO'] = $value ? 'S' : 'N';
        } else {
            $this->attributes['AYUNO_REQUERIDO'] = $value;
        }
    }

    public function setRequiereOrdenMedicaAttribute($value)
    {
        if (is_bool($value)) {
            $this->attributes['REQUIERE_ORDEN_MEDICA'] = $value ? 'S' : 'N';
        } else {
            $this->attributes['REQUIERE_ORDEN_MEDICA'] = $value;
        }
    }

    public function setEsPaqueteAttribute($value)
    {
        if (is_bool($value)) {
            $this->attributes['ES_PAQUETE'] = $value ? 'S' : 'N';
        } else {
            $this->attributes['ES_PAQUETE'] = $value;
        }
    }

    // Accessors para convertir S/N a boolean (existentes + nuevos)
    public function getDisponibleAttribute($value)
    {
        return $value === 'S';
    }

    public function getIndDestacadoAttribute($value)
    {
        return $value === 'S';
    }

    public function getIndPromocionAttribute($value)
    {
        return $value === 'S';
    }

    public function getRequiereCitaAttribute($value)
    {
        return $value === 'S';
    }

    public function getAyunoRequeridoAttribute($value)
    {
        return $value === 'S';
    }

    public function getRequiereOrdenMedicaAttribute($value)
    {
        return $value === 'S';
    }

    public function getEsPaqueteAttribute($value)
    {
        return $value === 'S';
    }

    // Accessor para la imagen (existente)
    public function getImagenUrlAttribute($value)
    {
        if (!$value) {
            return '/placeholder.svg?height=400&width=600&text=' . urlencode($this->DES_ARTICULO);
        }

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        if (Storage::disk('public')->exists($value)) {
            return Storage::disk('public')->url($value);
        }

        return '/placeholder.svg?height=400&width=600&text=' . urlencode($this->DES_ARTICULO);
    }

    // Nuevos accessors para campos agregados
    public function getServiciosIncluidosArrayAttribute()
    {
        if (empty($this->SERVICIOS_INCLUIDOS)) {
            return [];
        }
        return explode('|', $this->SERVICIOS_INCLUIDOS);
    }

    public function getDiasDisponibleArrayAttribute()
    {
        if (empty($this->DIAS_DISPONIBLE)) {
            return [];
        }
        return explode(',', $this->DIAS_DISPONIBLE);
    }

    public function getTagsArrayAttribute()
    {
        if (empty($this->TAGS)) {
            return [];
        }
        return explode(',', $this->TAGS);
    }

    public function getIncluyeArrayAttribute()
    {
        if (empty($this->INCLUYE)) {
            return [];
        }
        return explode('|', $this->INCLUYE);
    }

    // Relaciones (existentes)
    public function especialidad()
    {
        return $this->belongsTo(CveEspecialidad::class, 'COD_ESPECIALIDAD', 'COD_ESPECIALIDAD');
    }

    public function sucursal()
    {
        return $this->belongsTo(MaeSucursal::class, 'COD_SUCURSAL', 'COD_SUCURSAL');
    }

    // Métodos auxiliares existentes
    public function estaEnPromocion()
    {
        if ($this->IND_PROMOCION !== 'S') {
            return false;
        }

        $hoy = now()->toDateString();
        
        if ($this->FECHA_INICIO_PROMO && $this->FECHA_FIN_PROMO) {
            return $hoy >= $this->FECHA_INICIO_PROMO && $hoy <= $this->FECHA_FIN_PROMO;
        }

        return true;
    }

    public function getPrecioFinal()
    {
        return $this->estaEnPromocion() && $this->PRECIO_PROMOCION 
            ? $this->PRECIO_PROMOCION 
            : $this->PRECIO_MOSTRAR;
    }

    public function getDescuentoPorcentaje()
    {
        if (!$this->estaEnPromocion() || !$this->PRECIO_PROMOCION || !$this->PRECIO_MOSTRAR) {
            return 0;
        }

        return round((($this->PRECIO_MOSTRAR - $this->PRECIO_PROMOCION) / $this->PRECIO_MOSTRAR) * 100);
    }

    // Nuevos métodos auxiliares
    public function esLaboratorio()
    {
        return $this->CATEGORIA === 'LABORATORIO';
    }

    public function esImagen()
    {
        return $this->CATEGORIA === 'IMAGEN';
    }

    public function esConsulta()
    {
        return $this->CATEGORIA === 'CONSULTA';
    }

    public function esPaquete()
    {
        return $this->ES_PAQUETE === 'S';
    }

    public function requiereAyuno()
    {
        return $this->AYUNO_REQUERIDO === 'S';
    }

    public function requiereOrdenMedica()
    {
        return $this->REQUIERE_ORDEN_MEDICA === 'S';
    }

    public function esAptoParaEdad($edad)
    {
        if ($this->EDAD_MINIMA && $edad < $this->EDAD_MINIMA) {
            return false;
        }
        if ($this->EDAD_MAXIMA && $edad > $this->EDAD_MAXIMA) {
            return false;
        }
        return true;
    }

    public function esAptoParaGenero($genero)
    {
        return !$this->GENERO_RESTRICCION || $this->GENERO_RESTRICCION === $genero;
    }

    public function getSubcategoriaInfo()
    {
        $subcategorias = [
            // Laboratorio
            'HEMATOLOGIA' => ['nombre' => 'Hematología', 'icono' => 'fas fa-tint', 'color' => '#e74c3c'],
            'BIOQUIMICA' => ['nombre' => 'Bioquímica', 'icono' => 'fas fa-flask', 'color' => '#3498db'],
            'MICROBIOLOGIA' => ['nombre' => 'Microbiología', 'icono' => 'fas fa-microscope', 'color' => '#2ecc71'],
            'INMUNOLOGIA' => ['nombre' => 'Inmunología', 'icono' => 'fas fa-shield-alt', 'color' => '#9b59b6'],
            'HORMONAS' => ['nombre' => 'Hormonas', 'icono' => 'fas fa-dna', 'color' => '#f39c12'],
            'ORINA' => ['nombre' => 'Examen de Orina', 'icono' => 'fas fa-vial', 'color' => '#f1c40f'],
            'HECES' => ['nombre' => 'Examen de Heces', 'icono' => 'fas fa-search', 'color' => '#95a5a6'],
            'GENETICA' => ['nombre' => 'Genética', 'icono' => 'fas fa-dna', 'color' => '#e67e22'],
            'TOXICOLOGIA' => ['nombre' => 'Toxicología', 'icono' => 'fas fa-exclamation-triangle', 'color' => '#e74c3c'],
            
            // Imagen
            'RADIOGRAFIA' => ['nombre' => 'Radiografía', 'icono' => 'fas fa-x-ray', 'color' => '#34495e'],
            'ECOGRAFIA' => ['nombre' => 'Ecografía', 'icono' => 'fas fa-heartbeat', 'color' => '#3498db'],
            'TOMOGRAFIA' => ['nombre' => 'Tomografía', 'icono' => 'fas fa-brain', 'color' => '#9b59b6'],
            'RESONANCIA' => ['nombre' => 'Resonancia Magnética', 'icono' => 'fas fa-head-side-brain', 'color' => '#2ecc71'],
            'MAMOGRAFIA' => ['nombre' => 'Mamografía', 'icono' => 'fas fa-female', 'color' => '#e91e63'],
            'DENSITOMETRIA' => ['nombre' => 'Densitometría', 'icono' => 'fas fa-bone', 'color' => '#795548'],
            'ENDOSCOPIA' => ['nombre' => 'Endoscopía', 'icono' => 'fas fa-search-plus', 'color' => '#607d8b']
        ];

        return $subcategorias[$this->SUBCATEGORIA] ?? [
            'nombre' => $this->SUBCATEGORIA,
            'icono' => 'fas fa-stethoscope',
            'color' => '#6b7280'
        ];
    }

    // Boot method (existente con mejoras)
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->FECHA_CREACION) {
                $model->FECHA_CREACION = now();
            }
            
            if (!$model->COD_ARTICULO_SERV) {
                $model->COD_ARTICULO_SERV = 'ART' . time() . rand(100, 999);
            }

            // Auto-generar URL amigable si no existe
            if (!$model->URL_AMIGABLE) {
                $model->URL_AMIGABLE = \Str::slug($model->DES_ARTICULO);
            }

            // Auto-generar meta title si no existe
            if (!$model->META_TITLE) {
                $model->META_TITLE = $model->DES_ARTICULO;
            }
        });

        static::updating(function ($model) {
            // Prevenir errores al actualizar campos que no existen
            if (isset($model->attributes['FECHA_MODIFICACION'])) {
                unset($model->attributes['FECHA_MODIFICACION']);
            }
        });

        static::deleting(function ($model) {
            // Limpiar imagen al eliminar
            if ($model->IMAGEN_URL && !filter_var($model->IMAGEN_URL, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($model->IMAGEN_URL);
            }
        });
    }
}
