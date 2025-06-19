<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeguimientoMantenimientoPreventivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'fecha_mantenimiento_programado',
        'fecha_realizacion',
        'responsable',
        'observaciones',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
