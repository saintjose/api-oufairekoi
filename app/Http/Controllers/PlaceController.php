<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Place;
use App\Http\Resources\PlaceResource;

class PlaceController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Place::all();
        return $this->sendResponse(PlaceResource::collection($places), 'Toutes les sous categorie.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name_places' => 'required',
            'location_id' =>'required',
            'category_id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $place = new Place;
        $place->name_places = $input['name_places'];
        $place->location_id = $input['location_id'];
        $place->category_id = $input['category_id'];
        $place->longitude = $input['longitude'];
        $place->latitude = $input['latitude'];
        $place->save();
        return $this->sendResponse(new PlaceResource($place), 'quartier crée.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $place = place::find($id);
        if (is_null($place)) {
            return $this->sendError('Cet espace n\'existe pas.');
        }
        return $this->sendResponse(new PlaceResource($place), 'Espace trouvée.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, place $place)
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'name_places' => 'required',
            'location_id' =>'required',
            'category_id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $place->name_places = $input['name_places'];
        $place->location_id = $input['location_id'];
        $place->latitude = $input['latitude'];
        $place->category_id = $input['category_id'];
        $place->longitude = $input['longitude'];
        $place->save();
        
        return $this->sendResponse(new PlaceResource($place), 'Espace Modifiée.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(place $place)
    {
        if($place->delete()) {
            return $this->sendResponse([], 'Espace Supprimer.');
        }
        return $this->sendError('Impossible de supprimer cette Espace');
    }
}
