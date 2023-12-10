<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_categories',
        'description_categories',
    ];

    // Définir la relation avec la clé étrangère 
    public function locations()
    {
        return $this->hasManyThrough(Location::class, SubCategory::class, 'categorie_id', 'subcategory_id', 'id', 'id');
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'categorie_id');
    }

    public function places()
    {
        return $this->hasMany(Place::class, 'categorie_id');
    }
}