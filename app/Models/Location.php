<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_locations',
        'city_id',
    ];

    // Define relationship
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}