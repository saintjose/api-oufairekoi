<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\CategoryResource;
use Validator;

class CategoryController extends BaseController
{

    public function index()
    {
        $categories = Category::all();
        return $this->sendResponse(CategoryResource::collection($categories), 'Toutes les categories.');
    }

    public function show(string $id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return $this->sendError('Cette categorie n\'existe pas.');
        }
        return $this->sendResponse(new CategoryResource($category), 'Categorie trouvée');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name_categories' => 'required',
            // 'description_categories' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $category = Category::create($input);
        return $this->sendResponse(new CategoryResource($category), 'Categorie crée.');
    }

    public function update(Request $request, Category $category)
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'name_categories' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $category->name_categories = $input['name_categories'];
        $category->description_categories = (!empty($input['description_categories'])) ? $input['description_categories']: null;
        $category->save();
        
        return $this->sendResponse(new CategoryResource($category), 'Categorie Modifiée.');
    }

    public function destroy(Category $category)
    {
        if($category->delete()) {
            return $this->sendResponse([], 'Categorie Supprimer.');
        }
        return $this->sendError('Impossible de supprimer cette categorie');        
    }
}