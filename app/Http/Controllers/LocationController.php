<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Location;
use App\Http\Resources\LocationResource;
use App\Http\Resources\PlaceResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SubcategoryResource;
use App\Http\Resources\CityResource;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Place;
use App\Models\City;

class LocationController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::with('city')->get();
        
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

    public function listByCategory($categoryId)
{
    try {
        // Récupère la catégorie par son ID
        $category = Category::findOrFail($categoryId);

        // Récupère toutes les places associées à cette catégorie
        $places = $category->places;

        // Transforme les données pour inclure les locations
        $locations = collect();

        foreach ($places as $place) {
            // On récupère la location associée à chaque place
            $location = $place->location;
            
            // On vérifie si la location n'est pas déjà dans la collection
            if (!$locations->contains($location)) {
                $locations->push($location);
            }
        }

        $result = [
            'category' => $category->name_categories,
            'locations' => LocationResource::collection($locations),
        ];

        return $this->sendResponse($result, 'Locations par catégorie.');
    } catch (\Exception $e) {
        // Log the exception details
        \Log::error('Error in LocationController listByCategory: ' . $e->getMessage());

        // Return a generic error response
        return $this->sendError('Une erreur interne du serveur s\'est produite.', 500);
    }
}


public function listByRank()
{
    try {
        // Récupérez toutes les places triées par rang décroissant
        $places = Place::orderByDesc('rank')->get();

        // Transformez les données pour inclure les locations
        $result = $places->map(function ($place) {
            return [
                'place' => $place->name_places,
                'location' => new LocationResource($place->location),
            ];
        });

        return $this->sendResponse($result, 'Locations triées par rang décroissant.');
    } catch (\Exception $e) {
        // Log the exception details
        \Log::error('Error in LocationController listByRank: ' . $e->getMessage());

        // Return a generic error response
        return $this->sendError('Une erreur interne du serveur s\'est produite.', 500);
    }
}

    /**
     * Search for a place, category, subcategory, or city.
     */
    public function search(Request $request)
{
    try {
        // Récupérez le terme de recherche depuis la requête
        $searchTerm = $request->input('search_term');

        // Recherchez les lieux qui correspondent au terme de recherche
        $places = Place::where('name_places', 'like', '%' . $searchTerm . '%')->get();

        // Recherchez les catégories qui correspondent au terme de recherche
        $categories = Category::where('name_categories', 'like', '%' . $searchTerm . '%')->get();

        // Recherchez les sous-catégories qui correspondent au terme de recherche
        $subcategories = Subcategory::where('name_subcategories', 'like', '%' . $searchTerm . '%')->get();

        // Recherchez les villes qui correspondent au terme de recherche
        $cities = City::where('name_cities', 'like', '%' . $searchTerm . '%')->get();

        // Transformez les résultats en format JSON
        $result = [
            'places' => PlaceResource::collection($places),
            'categories' => CategoryResource::collection($categories),
            'subcategories' => SubcategoryResource::collection($subcategories),
            'cities' => CityResource::collection($cities),
        ];

        return $this->sendResponse($result, 'Résultats de la recherche.');
    } catch (\Exception $e) {
        // Log the exception details
        \Log::error('Error in LocationController search: ' . $e->getMessage());

        // Return a generic error response
        return $this->sendError('Une erreur interne du serveur s\'est produite.', 500);
    }
}


public function showBySlug(string $slug)
{
    try {
        // Récupère l'emplacement par son slug
        $location = Location::where('slug', $slug)->first();

        if (is_null($location)) {
            return $this->sendError('Cet emplacement n\'existe pas.', 404);
        }

        return $this->sendResponse(new LocationResource($location), 'Informations sur l\'emplacement.');
    } catch (\Exception $e) {
        // Log the exception details
        \Log::error('Error in LocationController showBySlug: ' . $e->getMessage());

        // Return a generic error response
        return $this->sendError('Une erreur interne du serveur s\'est produite.', 500);
    }
}

}
