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
            'rank',
            'category_id',
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
        return $this->belongsTo(Category::class, 'category_id');
    }
    }
