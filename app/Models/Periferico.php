<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Periferico extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'tipo_periferico',
        'tipo_personalizado',
        'marca',
        'numero_serie',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function getTipoFinalAttribute(): string
    {
        return $this->tipo_periferico === 'Otros'
            ? ($this->tipo_personalizado ?? 'Otros')
            : $this->tipo_periferico;
    }
}
