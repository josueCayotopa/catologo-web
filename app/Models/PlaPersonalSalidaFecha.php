<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaPersonalSalidaFecha extends Model
{
    use HasFactory;

    protected $table = 'PLA_PERSONAL_SALIDA_FECHA';
    protected $primaryKey = 'ID';
    public $timestamps = false; // Usamos CREATED_AT y UPDATED_AT manuales

    // Estados del permiso
    const ESTADO_PENDIENTE = 'PENDIENTE';
    const ESTADO_APROBADO = 'APROBADO';
    const ESTADO_RECHAZADO = 'RECHAZADO';
    const ESTADO_EN_SALIDA = 'EN_SALIDA';
    const ESTADO_COMPLETADO = 'COMPLETADO';

    protected $fillable = [
        'PERSONAL_ID',
        'FECHA_SALIDA',        // Fecha programada
        'FECHA_RETORNO',       // Fecha programada
        'FECHA_SALIDA_REAL',   // Fecha real marcada por seguridad
        'FECHA_RETORNO_REAL',  // Fecha real marcada por seguridad
        'MOTIVO_SALIDA',
        'USUARIO_APRUEBA',
        'CARGO_APRUEBA',
        'FECHA_APROBACION',
        'IND_AUTORIZA',
        'ESTADO_PERMISO',
        'OBSERVACION',
        'OBSERVACION_APROBACION',
        'USUARIO_SEGURIDAD_SALIDA',
        'USUARIO_SEGURIDAD_ENTRADA',
        'CREATED_AT',
        'UPDATED_AT',
        'USUARIO_CREA',
        'EMAIL_USUARIO_CREA',
        'USUARIO_MODIFICA'
    ];

    protected $casts = [
        'FECHA_SALIDA' => 'datetime',
        'FECHA_RETORNO' => 'datetime',
        'FECHA_SALIDA_REAL' => 'datetime',
        'FECHA_RETORNO_REAL' => 'datetime',
        'FECHA_APROBACION' => 'datetime',
        'CREATED_AT' => 'datetime',
        'UPDATED_AT' => 'datetime',
    ];

    // Relaciones
    public function personal()
    {
        return $this->belongsTo(PlaPersonalSalida::class, 'PERSONAL_ID');
    }

    public function usuarioCreador()
    {
        return $this->belongsTo(User::class, 'USUARIO_CREA');
    }

    public function usuarioAprobador()
    {
        return $this->belongsTo(User::class, 'USUARIO_APRUEBA');
    }

    public function usuarioSeguridadSalida()
    {
        return $this->belongsTo(User::class, 'USUARIO_SEGURIDAD_SALIDA');
    }

    public function usuarioSeguridadEntrada()
    {
        return $this->belongsTo(User::class, 'USUARIO_SEGURIDAD_ENTRADA');
    }

    // Accessors
    public function getEstadoColorAttribute()
    {
        return match($this->ESTADO_PERMISO) {
            self::ESTADO_PENDIENTE => 'warning',
            self::ESTADO_APROBADO => 'success',
            self::ESTADO_RECHAZADO => 'danger',
            self::ESTADO_EN_SALIDA => 'info',
            self::ESTADO_COMPLETADO => 'success',
            default => 'secondary'
        };
    }

    public function getEstadoLabelAttribute()
    {
        return match($this->ESTADO_PERMISO) {
            self::ESTADO_PENDIENTE => 'Pendiente Aprobación',
            self::ESTADO_APROBADO => 'Aprobado',
            self::ESTADO_RECHAZADO => 'Rechazado',
            self::ESTADO_EN_SALIDA => 'En Salida',
            self::ESTADO_COMPLETADO => 'Completado',
            default => $this->ESTADO_PERMISO
        };
    }

    // Métodos de estado
    public function puedeAprobar()
    {
        return $this->ESTADO_PERMISO === self::ESTADO_PENDIENTE;
    }

    public function puedeMarcarSalida()
    {
        return $this->ESTADO_PERMISO === self::ESTADO_APROBADO;
    }

    public function puedeMarcarEntrada()
    {
        return $this->ESTADO_PERMISO === self::ESTADO_EN_SALIDA;
    }

    public function puedeEditar()
    {
        return $this->ESTADO_PERMISO === self::ESTADO_PENDIENTE;
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->USUARIO_CREA = auth()->id();
                $model->EMAIL_USUARIO_CREA = auth()->user()->email;
                $model->CREATED_AT = now();
                $model->ESTADO_PERMISO = self::ESTADO_PENDIENTE;
                $model->IND_AUTORIZA = 'N';
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->USUARIO_MODIFICA = auth()->id();
                $model->UPDATED_AT = now();
            }
        });
    }
}