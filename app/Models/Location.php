<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_locations',
        'city_id', 
        'slug',
    ];

    // Define relationships
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($location) {
            $location->slug = Str::slug($location->name_locations);
        });

        static::updating(function ($location) {
            $location->slug = Str::slug($location->name_locations);
        });
    }


}