<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_subcategories',
        'rank_subcategories',
        'categorie_id',
    ];

    // Define relationship
    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }
}