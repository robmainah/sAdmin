<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandsRequest;
use App\Http\Resources\BrandsResource;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api")->except("index", "allBrands");
    }

    public function allBrands()
    {
        $brands = Brand::all();

        return BrandsResource::collection($brands);
    }

    public function index(Category $category)
    {
        // $brands = Brand::latest()->get();
        $brands = $category->brands;

        return BrandsResource::collection($brands);
    }

    public function store(BrandsRequest $request, Category $category)
    {
        /* $brand = new Brand;

            $brand->title = $request->title;
            $brand->code = Brand::generateCode();
            $brand->status = $request->status;
            $brand->admin()->associate($request->user());

            $category->brands()->save($brand);

            return new BrandsResource($brand);
        */
    }

    public function show(Brands $brands)
    {
        //
    }

    public function edit(Brands $brands)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer\Brands  $brands
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brands $brands)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer\Brands  $brands
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brands $brands)
    {
        //
    }
}
