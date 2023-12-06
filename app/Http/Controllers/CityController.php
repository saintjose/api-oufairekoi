<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use App\Models\City;
use App\Http\Resources\CityResource;

class CityController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::all();
        return $this->sendResponse(CityResource::collection($cities), 'Toutes les villes.');
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
            'name_cities' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $city = City::create($input);
        return $this->sendResponse(new CityResource($city), 'Ville crée.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $city = City::find($id);
        if (is_null($city)) {
            return $this->sendError('Cette ville n\'existe pas.');
        }
        return $this->sendResponse(new CityResource($city), 'Post fetched.');
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
    public function update(Request $request, City $city)
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'name_cities' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $city->name_cities = $input['name_cities'];
        $city->save();
        
        return $this->sendResponse(new CityResource($city), 'Ville Modifiée.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        if($city->delete()) {
            return $this->sendResponse([], 'Ville Supprimer.');
        }
        return $this->sendError('Impossible de supprimer cette ville');
    }
}
