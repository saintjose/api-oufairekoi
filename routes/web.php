<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\City;
use App\Models\Location;
use App\Models\Place;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/add-data', function () {
    // Ajout d'une Catégorie
    $category = new Category([
        'name_categories' => 'Hotel',
        'description_categories' => 'tres bon',
    ]);
    $category->save();

    // Ajout d'une Sous-catégorie
    $subcategory = new Subcategory([
        'name_subcategories' => 'fastfood',
        'category_id' => 1, 
    ]);
    $subcategory->save();

    // Ajout d'une Ville
    $city = new City([
        'name_cities' => 'abidjan',
    ]);
    $city->save();

    // Ajout d'une Location
    $location = new Location([
        'name_locations' => 'yopougon',
        'city_id' => 1, 
        'category_id' => 1, 
    ]);
    $location->save();

    // Ajout d'une Place
    $place = new Place([
        'name_places' => 'cocovico',
        'location_id' => 1, 
        'category_id' => 1, 
        'rank' => 1,
        'latitude' => 12.345,
        'longitude' => 67.890,
        'url_image_principale' => '/images/scolaire.jpg',
        'url_image_banniere' => '/images/téléchargement.png',
    ]);
    $place->save();

    return 'Données ajoutées avec succès!';
});