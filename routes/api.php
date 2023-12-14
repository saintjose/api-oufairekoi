<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SubcategoriesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PlaceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [AuthController::class, 'signin'])->name('login.post'); // Utilisation du nom 'login.post'
Route::post('/register', [AuthController::class, 'signup']);

// Ajoutez la nouvelle route pour lister les quartiers par catégorie
Route::get('/locations/listByCategory/{categoryId}', [LocationController::class, 'listByCategory']);
Route::get('/locations/listByRank', [LocationController::class, 'listByRank']);
Route::get('/search', [LocationController::class, 'search'])->name('locations.search');
Route::get('/locations/{slug}', [LocationController::class, 'showBySlug']);
Route::get('/places/{id}/with-relations', [PlaceController::class, 'showWithRelations']);

/**
* Toutes les routes liées à l'administration 
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('cities', CityController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubCategoryController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('places', PlaceController::class);
});