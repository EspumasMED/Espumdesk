<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'title',
        'description',
        'status',
        'priority',
        'sede',
        'assigned_to',
        'closed_at',
    ];

    protected $casts = [
        'closed_at' => 'datetime',
    ];

    public const STATUS = [
        'abierto' => 'Abierto',
        'en_progreso' => 'En Progreso',
        'cerrado' => 'Cerrado',
        'pendiente' => 'Pendiente',
    ];

    public const PRIORITY = [
        'baja' => 'Baja',
        'media' => 'Media',
        'alta' => 'Alta',
        'urgente' => 'Urgente',
    ];

    public const SEDE = [
        'Medellin' => 'Medellín',
        'Barranquilla' => 'Barranquilla',
        'Ambas' => 'Ambas',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}