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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function software()
    {
        return $this->belongsToMany(Software::class, 'software_user')
            ->withPivot(['has_access', 'fecha_asignacion'])
            ->withTimestamps();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Opción básica: acceso al panel llamado 'inicio'
        return $panel->getId() === 'inicio';

        // Opción más segura:
        // return $panel->getId() === 'inicio' && $this->hasRole('super_admin');
    }
}
