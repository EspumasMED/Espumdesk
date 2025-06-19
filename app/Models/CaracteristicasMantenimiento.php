<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaracteristicasMantenimiento extends Model
{
    use HasFactory;

    protected $table = 'caracteristicas_mantenimiento';

    protected $fillable = [
        'equipment_id',
        'periodicidad',
        'mantenimiento_fisico',
        'mantenimiento_software',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
