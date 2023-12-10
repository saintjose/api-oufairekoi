<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_subcategories',
        'rank_subcategories',
        'category_id',
    ];

    // Define relationship
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'subcategory_id', 'id');
    }
}