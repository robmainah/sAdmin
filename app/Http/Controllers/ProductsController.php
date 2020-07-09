<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\AddProductRequest;
use App\Http\Requests\Products\EditProductRequest;
use App\Models\Category;
use App\Models\Product;
use ErrorException;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;

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
        $image_name = $this->storeUploadedImage($request); // Get Image Name;
        //Check if we received correct Image Name
        if(!$image_name['status']) {
            // $new_file_dir = substr($request->title, 0, -3);
            $this->deleteStoredImage("products/".$request->title."/".$image_name['filename']);

            return redirect()->route('products.edit', $product->id)
                            ->withErrors(['title' => 'Enter a correct title'])
                            ->withInput();
        }

        $this->deleteStoredImage($product->image);

        $product->image = $image_name['filename']; //Replace new image to database
        $product->category_id = $request->category;
        $product->title =  $request->title;
        $product->slug = Str::slug($request->title);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->stock;
        $product->updated_by = auth()->user()->id;
        $product->save();

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
        $product = Product::destroy(explode(",", $request->multiple_ids));

        if ($product) {
            return redirect()->route('products.index')->with('status', 'Products Deleted successfully');
        }
    }

    protected function storeUploadedImage($request)
    {
        if ($request->hasFile('image')) {
            $image_extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::random(40).".".$image_extension;
            try {
                $image_name = $request->file('image')->storeAs('products/'.$request->title, $filename, 'public');
                return ['status' => true, 'filename' => $image_name ];
            } catch (ErrorException $e) {
                return ['status' => false, 'filename' => $filename ];
            }
        }
    }
    protected function deleteStoredImage($old_image_name)
    {
        if (Storage::disk('local')->exists('public/'.$old_image_name)) { //Check if old image exists
            Storage::disk('local')->delete('public/'.$old_image_name); //Delete old image from disk
        }
    }
}
