<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Tipos de roles para el sistema de permisos
    const TIPO_ADMIN = 'admin';
    const TIPO_SUPERVISOR = 'supervisor';
    const TIPO_SEGURIDAD = 'seguridad';
    const TIPO_USUARIO = 'usuario';
    const TIPO_SIN_ACCESO = 'sin_acceso';

    protected $fillable = [
        'name',
        'usuario',
        'type', // admin, doctor, etc (rol general del sistema)
        'type_sis_permiso', // Rol específico para sistema de permisos
        'email',
        'password',
        'active', // Campo para activar/desactivar usuario
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
    ];

    // Relaciones
    public function permisosCreados()
    {
        return $this->hasMany(PlaPersonalSalidaFecha::class, 'USUARIO_CREA');
    }

    public function permisosAprobados()
    {
        return $this->hasMany(PlaPersonalSalidaFecha::class, 'USUARIO_APRUEBA');
    }

    public function salidasControladas()
    {
        return $this->hasMany(PlaPersonalSalidaFecha::class, 'USUARIO_SEGURIDAD_SALIDA');
    }

    public function entradasControladas()
    {
        return $this->hasMany(PlaPersonalSalidaFecha::class, 'USUARIO_SEGURIDAD_ENTRADA');
    }

    // Métodos de verificación de permisos
    public function puedeAccederSistemaPermisos()
    {
        return $this->active && 
               in_array($this->type_sis_permiso, [
                   self::TIPO_ADMIN,
                   self::TIPO_SUPERVISOR,
                   self::TIPO_SEGURIDAD,
                   self::TIPO_USUARIO
               ]);
    }

    public function puedeAprobarPermisos()
    {
        return $this->puedeAccederSistemaPermisos() && 
               in_array($this->type_sis_permiso, [
                   self::TIPO_ADMIN,
                   self::TIPO_SUPERVISOR
               ]);
    }

    public function puedeControlarSeguridad()
    {
        return $this->puedeAccederSistemaPermisos() && 
               in_array($this->type_sis_permiso, [
                   self::TIPO_ADMIN,
                   self::TIPO_SEGURIDAD
               ]);
    }

    public function esAdmin()
    {
        return $this->type_sis_permiso === self::TIPO_ADMIN;
    }

    public function puedeVerTodosLosPermisos()
    {
        return $this->puedeAccederSistemaPermisos() && 
               in_array($this->type_sis_permiso, [
                   self::TIPO_ADMIN,
                   self::TIPO_SUPERVISOR,
                   self::TIPO_SEGURIDAD
               ]);
    }

    // Accessor para mostrar el rol de manera amigable
    public function getTipoSisPermisoLabelAttribute()
    {
        return match($this->type_sis_permiso) {
            self::TIPO_ADMIN => 'Administrador',
            self::TIPO_SUPERVISOR => 'Supervisor',
            self::TIPO_SEGURIDAD => 'Seguridad',
            self::TIPO_USUARIO => 'Usuario',
            self::TIPO_SIN_ACCESO => 'Sin Acceso',
            default => 'No Definido'
        };
    }

    public function getTipoSisPermisoColorAttribute()
    {
        return match($this->type_sis_permiso) {
            self::TIPO_ADMIN => 'danger',
            self::TIPO_SUPERVISOR => 'warning',
            self::TIPO_SEGURIDAD => 'info',
            self::TIPO_USUARIO => 'success',
            self::TIPO_SIN_ACCESO => 'gray',
            default => 'gray'
        };
    }
}
