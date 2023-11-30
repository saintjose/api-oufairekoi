<?php

namespace App\Models;

    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    
    class Place extends Model
    {
        use HasFactory;
    
        protected $fillable = [
            'name_places',
            'location_id',
            'categorie_id',
            'latitude',
            'longitude',
        ];
    
        // 
        public function location()
        {
            return $this->belongsTo(Location::class, 'location_id');
        }
    
        public function category()
        {
            return $this->belongsTo(Category::class, 'categorie_id');
        }
    }
