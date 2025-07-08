<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaPersonalSalida extends Model
{
    use HasFactory;

    protected $table = 'PLA_PERSONAL_SALIDA';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'NOMBRES',
        'APELLIDOS',
        'AREA',
        'CARGO',
        'USUARIO_CREA',
        'EMAIL_USUARIO_CREA', // Nuevo campo para el email
        'FECHA_REGISTRO',
        'ESTADO'
    ];

    // Relación con el usuario que creó el registro
    public function usuarioCreador()
    {
        return $this->belongsTo(User::class, 'USUARIO_CREA');
    }

    // Relación: Un personal tiene muchas salidas
    public function salidas()
    {
        return $this->hasMany(PlaPersonalSalidaFecha::class, 'PERSONAL_ID');
    }

    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return "{$this->NOMBRES} {$this->APELLIDOS}";
    }

    // Boot method para auto-llenar campos al crear
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->USUARIO_CREA = auth()->id();
                $model->EMAIL_USUARIO_CREA = auth()->user()->email;
                $model->FECHA_REGISTRO = now();
            }
        });

        static::updating(function ($model) {
            // Opcional: también puedes trackear quién modifica
            if (auth()->check() && !$model->isDirty('USUARIO_CREA')) {
                // Solo actualizar si no se está modificando manualmente
            }
        });
    }
}