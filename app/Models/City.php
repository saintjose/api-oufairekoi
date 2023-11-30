<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_cities',
    ];

    // Define relationship
    public function locations()
    {
        return $this->hasMany(Location::class, 'city_id');
    }
}
