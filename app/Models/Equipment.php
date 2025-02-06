<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'company',
        'name',
        'model',
        'serial_number',
        'brand',
        'provider_id',
        'status',
        'assigned_to',
        'area',
        'delivery_record',
        'notes'
    ];


    // Constantes para los estados
    const STATUS_AVAILABLE = 'available';
    const STATUS_IN_USE = 'in_use';
    const STATUS_MAINTENANCE = 'maintenance';
    const STATUS_REPAIR = 'repair';
    const STATUS_RETIRED = 'retired';
    const STATUS_RESERVED = 'reserved';

    // Array de estados disponibles
    public static $statuses = [
        self::STATUS_AVAILABLE => 'Disponible',
        self::STATUS_IN_USE => 'En uso',
        self::STATUS_MAINTENANCE => 'En mantenimiento',
        self::STATUS_REPAIR => 'En reparación',
        self::STATUS_RETIRED => 'Dado de baja',
        self::STATUS_RESERVED => 'Reservado'
    ];

    // Constantes para las compañías
    const COMPANY_ESPUMAS_MEDELLIN = 'espumas_medellin';
    const COMPANY_ESPUMADOS_LITORAL = 'espumados_litoral';

    // Array de compañías disponibles
    public static $companies = [
        self::COMPANY_ESPUMAS_MEDELLIN => 'Espumas Medellín',
        self::COMPANY_ESPUMADOS_LITORAL => 'Espumados del Litoral'
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
