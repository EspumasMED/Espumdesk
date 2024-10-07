<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'response',
        'rating',
        'file_path',
        'file_name',
        'file_type',
    ];

    protected $casts = [
        'status' => 'string',
        'rating' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function hasFile()
    {
        return !is_null($this->file_path);
    }

    public function respond($response, $rating = null)
    {
        $this->response = $response;
        $this->rating = $rating;
        $this->status = 'cerrado';
        $this->save();
    }
    
}