<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;
    use HasRoles, HasPanelShield;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'area',
        'sede',
        'telefono',
        'cargo',
        'estado',
    ];

    /**
     * Los atributos que deben ocultarse al serializar.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben castearse.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relación con los softwares asignados.
     */
    public function software()
    {
        return $this->belongsToMany(Software::class, 'software_user')
            ->withPivot(['has_access', 'fecha_asignacion'])
            ->withTimestamps();
    }

    /**
     * Verifica si el usuario puede acceder a un panel específico.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Opción 1: acceso solo si el panel es 'inicio'
        return $panel->getId() === 'inicio';

        // Opción 2: acceso solo si el usuario tiene un rol específico
        // return $panel->getId() === 'inicio' && $this->hasAnyRole(['admin', 'super_admin']);
    }
}
