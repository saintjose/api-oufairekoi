<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoriesController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::all();
        return response()->json($subcategories);
    }

    public function show($id)
    {
        $subcategory = Subcategory::find($id);
        return response()->json($subcategory);
    }

    public function store(Request $request)
    {
        $subcategory = Subcategory::create($request->all());
        return response()->json($subcategory, 201);
    }

    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::find($id);
        $subcategory->update($request->all());
        return response()->json($subcategory, 200);
    }

    public function destroy($id)
    {
        Subcategory::destroy($id);
        return response()->json(null, 204);
    }
}