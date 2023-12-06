<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\SubCategory;
use App\Http\Resources\SubCategoryResource;

class SubCategoryController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::all();
        return $this->sendResponse(SubCategoryResource::collection($subcategories), 'Toutes les sous categorie.');
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
            'name_subcategories' => 'required',
            'rank_subcategories' => 'required',
            'category_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $subCategory = Subcategory::create($input);
        return $this->sendResponse(new SubCategoryResource($subCategory), 'Sous categorie crée.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subCategory = Subcategory::find($id);
        if (is_null($subCategory)) {
            return $this->sendError('Cette sous categorie n\'existe pas.');
        }
        return $this->sendResponse(new SubCategoryResource($subCategory), 'Sous categorie trouvée.');
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
    public function update(Request $request, subCategory $subCategory)
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'name_subcategories' => 'required',
            'rank_subcategories' => 'required',
            'category_id' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $subCategory->name_subcategories = $input['name_subcategories'];
        $subCategory->rank_subcategories = (!empty($input['rank_subcategories'])) ? $input['rank_subcategories'] : $subCategory->rank_subcategories;
        $subCategory->category_id = $input['category_id'];
        $subCategory->save();
        
        return $this->sendResponse(new SubCategoryResource($subCategory), 'Sous categories Modifiée.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subCategory)
    {
        if($subCategory->delete()) {
            return $this->sendResponse([], 'Sous categorie Supprimer.');
        }
        return $this->sendError('Impossible de supprimer cette Sous categorie');
    }
}
