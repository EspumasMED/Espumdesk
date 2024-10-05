<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sede'];

    protected $casts = [
        'sede' => 'string',
    ];

    public const SEDES = [
        'Medellin' => 'Medellín',
        'Barranquilla' => 'Barranquilla',
        'Ambas' => 'Ambas',
    ];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class);
    }
}