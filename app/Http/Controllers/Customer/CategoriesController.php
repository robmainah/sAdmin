<?php

namespace App\Http\Controllers\Customer;

use App\Http\Resources\Customer\CategoryResource;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index()
    {
        $category = Category::latest()->limit(5)->get();

        return CategoryResource::collection($category);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category)
    {
        //
    }

    public function destroy(Category $category)
    {
        //
    }
}
