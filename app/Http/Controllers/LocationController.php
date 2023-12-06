<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Location;
use App\Http\Resources\LocationResource;

class LocationController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();
        return $this->sendResponse(LocationResource::collection($locations), 'Toutes les sous categorie.');
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
            'name_locations' => 'required',
            'city_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $Location = Location::create($input);
        return $this->sendResponse(new LocationResource($Location), 'quartier crée.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Location = Location::find($id);
        if (is_null($Location)) {
            return $this->sendError('Cet quartier n\'existe pas.');
        }
        return $this->sendResponse(new LocationResource($Location), 'Quartier trouvée.');
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
    public function update(Request $request, Location $Location)
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'name_locations' => 'required',
            'city_id' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $Location->name_locations = $input['name_locations'];
        $Location->city_id = $input['city_id'];
        $Location->save();
        
        return $this->sendResponse(new LocationResource($Location), 'Quartier Modifiée.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $Location)
    {
        if($Location->delete()) {
            return $this->sendResponse([], 'Quartier Supprimer.');
        }
        return $this->sendError('Impossible de supprimer cette Quartier');
    }
}
