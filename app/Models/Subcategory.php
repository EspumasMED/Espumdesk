<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'sede', 'inherit_sede'];

    protected $casts = [
        'sede' => 'string',
        'inherit_sede' => 'boolean',
    ];

    public const SEDES = [
        'Medellin' => 'Medellín',
        'Barranquilla' => 'Barranquilla',
        'Ambas' => 'Ambas',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted()
    {
        static::saving(function ($subcategory) {
            if ($subcategory->inherit_sede) {
                $subcategory->sede = $subcategory->category->sede;
            }
        });
    }
}