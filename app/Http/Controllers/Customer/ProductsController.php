<?php

namespace App\Http\Controllers\Customer;

// use App\Http\Resources\Customer\ProductResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index()
    {
        $product = Product::all();
        // return $product;
        // $product = Product::paginate(10);
        // $product = Product::latest()->limit(5)->get();
        // return $product;

        return ProductResource::collection($product);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}
