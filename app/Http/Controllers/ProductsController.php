<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Http\Requests\Products\AddProductRequest;
use App\Http\Requests\Products\EditProductRequest;
use Illuminate\Support\Facades\Storage;
use \Maatwebsite\Excel\Excel as MaatwebsiteExcel;
use App\Models\Category;
use App\Models\Product;
use ErrorException;
use Illuminate\Http\Request;
use Str;
use Excel;
// use Illuminate\Support\Facades\App;
use PDF;
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
        $products = Product::latest('updated_at')->with('category')->paginate(10);
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
            $product->stock = $request->stock;
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
    public function update(EditProductRequest $request, Product $product)
    {
        // $image_name = $this->storeUploadedImage($request); // Get Image Name;
        // //Check if we received correct Image Name
        // if(!$image_name['status']) {
        //     // $new_file_dir = substr($request->title, 0, -3);
        //     $this->deleteStoredImage("products/".$request->title."/".$image_name['filename']);

        //     return redirect()->route('products.edit', $product->id)
        //                     ->withErrors(['title' => 'Enter a correct title'])
        //                     ->withInput();
        // }

        // $this->deleteStoredImage($product->image);

        // $product->image = $image_name['filename']; //Replace new image to database
        $product->category_id = $request->category;
        $product->title =  $request->title;
        $product->slug = Str::slug($request->title);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
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
        // Product::destroy($product->id);
        $product->delete();

        return redirect()->route('products.index')->with('status', 'Product Deleted successfully');
    }

    public function deleteMultiple(Request $request)
    {
        $product = Product::destroy(explode(",", $request->multiple_ids));

        if ($product) {
            return redirect()->route('products.index')->with('status', 'Products Deleted successfully');
        }
    }

    public function exportToExcel()
    {
        // return (new ProductsExport)->download('invoices.html', \Maatwebsite\Excel\Excel::DOMPDF);
        // return Excel::download(new ProductsExport, 'products.csv);
        // return Excel::raw(new ProductsExport, MaatwebsiteExcel::CSV);

        return (new ProductsExport)->download('products.csv', MaatwebsiteExcel::CSV, [
            'Content-Type' => 'text/csv',
      ]);
    }

    public function exportToPDF()
    {
        $products = Product::all();
        // $pdf = PDF::loadView('products.export_pdf', compact('products'));
        // return $pdf->stream('products.export_pdf');
        return PDF::loadView('products.export_pdf', compact('products'))
                    // ->setPaper('a4', 'landscape')
                    ->save(storage_path().'/app/store_file/_filename.pdf')
                    ->stream('products.export_pdf.pdf');

    }

    public function searchProduct(Request $request)
    {
        if (!empty($request->search_input)) {
            $search_fields = ['title', 'slug', 'description'];
            $products = Product::with('category:id,cat_name')->where(function($query) use ($request, $search_fields) {
                $search_wildcard = '%'.$request->search_input.'%';
                foreach ($search_fields as $field) {
                    $query->orWhere($field, 'iLike', $search_wildcard);
                }
            })->paginate(10);

            $search = ['search_input' => $request->search_input];
        }
        else
        {
            $products = Product::with('category')->latest('updated_at')->paginate(10);
            $search = ['search_input' => false];
        }

        return view('products.search', compact('products', 'search'));
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
