<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles, HasPanelShield;

    /**
     * The attributes that are mass assignable.
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
}
