<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'version',
        'tipo',
        'criticidad',
        'requiere_capacitacion',
        'fecha_renovacion',
        'estado'
    ];

    protected $casts = [
        'requiere_capacitacion' => 'boolean',
        'estado' => 'boolean',
        'fecha_renovacion' => 'date'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'software_user')
            ->withPivot(['has_access', 'fecha_asignacion'])
            ->withTimestamps();
    }
}
