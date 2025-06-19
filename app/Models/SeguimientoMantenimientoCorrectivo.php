<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeguimientoMantenimientoCorrectivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'fecha_realizacion',
        'servicio_realizado',
        'repuestos',
        'responsable',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
