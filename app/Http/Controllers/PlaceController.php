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
        $places = Place::with(['category', 'location' => function($query) {
            $query->with('city');
        }])->get();
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
            'category_id' =>'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'rank' => 'required',
            'url_image_principale' => 'required|mimes:png,jpeg,jpg|max:2048',
            'url_image_banniere' => 'required|mimes:png,jpeg,jpg|max:2048',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $place = new Place;
        $place->name_places = $input['name_places'];
        $place->rank = $input['rank'];
        $place->location_id = $input['location_id'];
        $place->longitude = $input['longitude'];
        $place->latitude = $input['latitude'];
        $place->category_id = $input['category_id'];
        $place->rank = $input['rank'];
        // $name_url = $request->file('file')->getClientOriginalName();

        $path_url_image_principale = public_path($request->file('url_image_principale')->store('public/files'));
        $path_url_image_banniere = public_path($request->file('url_image_banniere')->store('public/files'));
            
        $place->url_image_principale = $path_url_image_principale;
        $place->url_image_banniere = $path_url_image_banniere;
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
            'rank' => 'required',
            'location_id' =>'required',
            'category_id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $place->name_places = $input['name_places'];
        $place->rank = $input['rank'];
        $place->location_id = $input['location_id'];
        $place->latitude = $input['latitude'];
        $place->category_id = $input['category_id'];
        $place->longitude = $input['longitude'];
        if(!empty($request->file('url_image_principale')) && !empty($request->file('url_image_banniere'))) {
            
            if(file_exists($place->url_image_principale)) {
                unlink($place->url_image_principale);
            }
            
            if(file_exists($place->url_image_banniere)) {
                unlink($place->url_image_banniere);
            }
            $ext_p = $request->file('url_image_principale')->getClientOriginalExtension();
            $filename_p = rand(100,100000) + 365 * 3024;
            $filename_b = rand(100,100000) + 365 * 3065;
            $path_p = $request->file('url_image_principale')->storeAs('public/' . $filename_p .'.'.$ext_p);

            $ext_b = $request->file('url_image_banniere')->getClientOriginalExtension();
            $path_b = $request->file('url_image_banniere')->storeAs('public/' . $filename_b .'.'.$ext_b);

            $path_url_image_principale = url('storage/' .$filename_p .'.'. $ext_p);
            $path_url_image_banniere = url('storage/' . $filename_b .'.'. $ext_b);
            
            $place->url_image_principale = $path_url_image_principale;
            $place->url_image_banniere = $path_url_image_banniere;

        }

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

    public function showWithRelations($id)
    {
        try {
            $place = Place::with(['location', 'category', 'image'])->find($id);
    
            if (is_null($place)) {
                return $this->sendError('Cette place n\'existe pas.', 404);
            }
    
            return $this->sendResponse(new PlaceResource($place), 'Informations sur la place avec relations.');
        } catch (\Exception $e) {
            \Log::error('Error in PlaceController showWithRelations: ' . $e->getMessage());
            return $this->sendError('Une erreur interne du serveur s\'est produite.', 500);
        }
    }
}
