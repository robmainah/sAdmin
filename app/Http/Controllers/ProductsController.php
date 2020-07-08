<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\AddProductRequest;
use App\Http\Requests\Products\EditProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class ProductsController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->with('category')->paginate(10);
        return view('products.index', [ 'products' => $products ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.add', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddProductRequest $request)
    {
        $product = new Product;

        $image_name = $this->storeUploadedImage($request);

        if($image_name) {
            $product->prod_code = Product::generateProductCode();
            $product->category_id = $request->category;
            $product->title =  $request->title;
            $product->slug = Str::slug($request->title);
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->stock;
            $product->created_by = auth()->user()->id;
            $product->updated_by = auth()->user()->id;
            $product->image = $image_name;

            //TODO ===== prevent storing images if data was not entered in database
            $product->save();

            return redirect()->route('products.index')->with(['status' => 'Product added successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', [ 'product' => $product ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit_product', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $image_name = $this->storeUploadedImage($request);

        if($image_name) {
            $old_image_url = $product->image; //Get old image url
            $product->image = $image_name; //Replace new image to database
        }

        $product->category_id = $request->category;
        $product->title =  $request->title;
        $product->slug = Str::slug($request->title);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->stock;
        $product->updated_by = auth()->user()->id;
        $product->save();

        Storage::delete('/public/'.$old_image_url); //Delete old image from disk

        return redirect()->route('products.index')->with(['status' => 'Updated Product successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Product::destroy($product->id);

        return redirect()->route('products.index')->with('status', 'Product Deleted successfully');
    }

    public function deleteMultiple(Request $request)
    {
        // $ids = $request->multiple_ids;
        $product = Product::destroy(explode(",", $request->multiple_ids));

        if ($product) {
            return redirect()->route('products.index')->with('status', $request->multiple_ids.' - Products Deleted successfully');
        }
    }

    protected function storeUploadedImage($request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image_name = $image->store('products/'.$request->title, "public")) {
                // $image_name = $name;
                return $image_name;
            }
        }
    }
}
