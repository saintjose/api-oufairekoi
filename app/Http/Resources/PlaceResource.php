<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name_places' => $this->name_places,
            'location_id' => $this->location_id,
            'category_id' => $this->category_id,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'location' => $this->location,
            'category' => $this->category,
            'rank' => $this->rank,
            'url_image_principale' => $this->url_image_principale,
            'url_image_banniere' => $this->url_image_banniere,
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y')
        ];
    }
}
