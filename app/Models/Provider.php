<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'company_name',
        'email',
        'phone',
        'belongs_to',
        'status',
        'notes',
        'contract_file'
    ];

    // Constantes para los estados
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    // Constantes para las empresas
    const COMPANY_MEDELLIN = 'espumas_medellin';
    const COMPANY_LITORAL = 'espumados_litoral';

    // Array de estados disponibles
    public static $statuses = [
        self::STATUS_ACTIVE => 'Activo',
        self::STATUS_INACTIVE => 'Inactivo'
    ];

    // Array de empresas disponibles
    public static $companies = [
        self::COMPANY_MEDELLIN => 'Espumas Medellín S.A',
        self::COMPANY_LITORAL => 'Espumados del Litoral S.A'
    ];

    // Relación con Equipment
    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }
}
