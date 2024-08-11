<?php

namespace App\Http\Controllers;

use App\Models\User;;
use App\Models\Product;
use App\Models\LogStatus;
use Illuminate\Http\Request;

use App\Models\RepackProduct;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\RepackProductWithProduct;

class ProductController extends Controller
{
    public $title = 'Product Information';
    public $lc = [
                        'ABC14' => 'ABC14',
                        'ABC15' => 'ABC15',
                        'ABC16' => 'ABC16',
                        'ABC17' => 'ABC17',
                        'ABC18' => 'ABC18',
                ];

    public $ekarray = [
                        'STATUS-1',
                        'STATUS-2',
                        'STATUS-3',
                        'STATUS-4',
                        'STATUS-5',
                        'STATUS-6',
                        'STATUS-7',
                        'STATUS-8',
                        'STATUS-9',
                      ];

    public $seaarray = [
                        'STATUS10',
                        'STATUS11',
                        'STATUS12',
                        'STATUS13',
                        'STATUS14',
                        'STATUS15',
                        'STATUS16',
                        'STATUS17',
                        'STATUS18',
                       ];


    public function index(Request $request)
    {

        $bill_id = $request->filled('bill_id') ? $request->get('bill_id') :'';

        $title = $this->title;

        return view('products.index', compact('title' ,'bill_id'));
    }

    public function getProductsData(Request $request)
    {

        $products = Product::with('customer')->orderBy('id', 'desc');
        if($request->filled('bill_id'))
        {

            $products->where('bill_id', $request->get('bill_id'));
        }
        else if( request('search') ){
            // dd("fd");
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing('products');
            foreach( $columns as $column ){
                $products->orWhere($column, 'LIKE', "%" . $request->search['value'] ."%");
            }
        }

        return DataTables::of($products)
               ->addColumn('checkbox', function($product){
                    return '<input type="checkbox" class="row-checkbox select-product" data-remarks="'.$product->remarks.'" data-productid="'.$product->product_id.'" data-product-code="'.$product->cs_did.'" data-productname="'.$product->name.'" data-w="'.$product->w.'" data-l="'.$product->l.'" data-h="'.$product->h.'" data-tcube="'.$product->tpcs.'" data-product-sku="'.$product->sku.'" data-weight="'.$product->weight.'" data-option="'.$product->option.'" data-type="'.$product->type.'" data-warehouse="'.$product->warehouse.'" data-photo1="'. Storage::url($product->photo1).'" data-photo2="'. Storage::url($product->photo2).'" data-photo3="'. Storage::url($product->photo3).'" data-photo4="'. Storage::url($product->photo4).'" >';
               })
               ->addColumn('csd_id', function($product){
                    $csd_id = isset($product->customer->CS) ? $product->customer->CS : '';
                    return $csd_id;
               })
               ->addColumn('maitou', function($product){
                    return $product->product_id;
               })
               ->addColumn('bill_id', function($product){
                    return $product->bill_id;
               })
               ->addColumn('product_name', function($product){
                    return $product->name;
               })
               ->addColumn('photo1', function($product){
                   $photo1 = '';
                    if ($product->photo1)
                    {
                        $photo1 = '<a href="#" class="view-image image1" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="'. Storage::url($product->photo1).'"><img src="'.asset('assets/images/picture.png').'" alt="Photo 1"></a>';
                    }
                    else{
                        $photo1 = '<a href="#" class="upload-product-image" data-attribute="photo1" data-id="'.$product->id.'">
                                    <img src="'.asset('assets/images/upload.png').'" alt="Upload Image">
                                </a>';
                    }
                    return $photo1;
               })
               ->addColumn('photo2', function($product){

                    $photo2 = '';
                    if ($product->photo2)
                    {
                        $photo2 = '<a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="'.Storage::url($product->photo2) .'""> <img src="'.asset('assets/images/picture.png').'" alt="Photo 2"></a>';
                    }
                    else{
                        $photo2 = '<a href="#" class="upload-product-image" data-attribute="photo2" data-id="'.$product->id.'">
                                    <img src="'.asset('assets/images/upload.png').'" alt="Upload Image">
                                </a>';
                    }
                    return $photo2;
               })
               ->addColumn('photo3', function($product){
                $photo3 = '';
                if ($product->photo3)
                {
                    $photo3 = '<a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="'.Storage::url($product->photo3) .'""> <img src="'.asset('assets/images/picture.png').'" alt="Photo 2"></a>';
                }
                else{
                    $photo3 = '<a href="#" class="upload-product-image" data-attribute="photo3" data-id="'.$product->id.'">
                                <img src="'.asset('assets/images/upload.png').'" alt="Upload Image">
                            </a>';
                }
                return $photo3;
               })
               ->addColumn('photo4', function($product){
                    $photo4 = '';
                    if ($product->photo4)
                    {
                        $photo4 = '<a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="'.Storage::url($product->photo4) .'""> <img src="'.asset('assets/images/picture.png').'" alt="Photo 2"></a>';
                    }
                    else{
                        $photo4 = '<a href="#" class="upload-product-image" data-attribute="photo4" data-id="'.$product->id.'">
                                    <img src="'.asset('assets/images/upload.png').'" alt="Upload Image">
                                </a>';
                    }
                    return $photo4;
               })
               ->addColumn('sku', function($product){

                    $for_copy = '';
                    $product_str = '<div class="barcode-container"><a class="primary-barcode" target="_blank" href="https://dhl.com/index.php?route=account%2Fshipping&search='.$product->sku.'">'. ($product->sku ?? 'N/A') . '</a>';
                    $product_str .= '<input type="hidden" class="products" value="' . $product->sku . '"/>';
                    if (count(explode(',', $product->sku)) > 1){
                        $product_str .= '<div class="popup">';
                        foreach (explode(',', $product->sku) as $p){
                            $product_str .= '<span>' . $p .'</span><br>';
                            $for_copy .= $p.' ';
                        }
                        $product_str .= '</div>';
                    }
                    return $product_str;
               })
               ->addColumn('warehouse', function($product){
                    return $product->warehouse;
               })
               ->addColumn('option', function($product){
                   return $product->option;
               })
               ->addColumn('type', function($product){
                    return $product->type;
               })
               ->addColumn('tpcs', function($product){
                    return $product->tpcs;
               })
               ->addColumn('weight', function($product){
                  return round($product->weight, 2);
               })
               ->addColumn('total_weight', function($product){
                    return round(($product->weight * $product->tpcs), 2);
                })
               ->addColumn('length', function($product){
                    return $product->l;
               })
               ->addColumn('width', function($product){
                    return $product->w;
               })
               ->addColumn('height', function($product){
                    return $product->h;
               })
               ->addColumn('t_cube', function($product){
                    return $this->calculateTCube($product->l , $product->w , $product->h);
               })
               ->addColumn('created_at', function($product){
                   return date('F j, Y h:i:s a', strtotime($product->created_at));
               })
               ->addColumn('remarks', function($product){
                  return $product->remarks;
               })
               ->addColumn('hidden_fields', function($product){
                  return '
                        <input type="hidden" class="product-id" value="' . $product->id . '">
                        <input type="hidden" class="product-code" value="' . $product->product_id . '">
                        <input type="hidden" class="product-name" value="' . $product->name . '">
                        <input type="hidden" class="product-w" value="' . $product->w . '">
                        <input type="hidden" class="product-l" value="' . $product->l . '">
                        <input type="hidden" class="product-h" value="' . $product->h . '">
                        <input type="hidden" class="product-tpcs" value="' . $product->tpcs . '">
                        <input type="hidden" class="product-sku" value="' . $product->sku . '">
                        <input type="hidden" class="product-weight" value="' . $product->weight . '">
                        <input type="hidden" class="option" value="' . $product->option . '">
                        <input type="hidden" class="type" value="' . $product->type . '">
                        <input type="hidden" class="warehouse" value="' . $product->warehouse . '">
                  ';
               })
               ->rawColumns(['checkbox','sku','photo1','photo2','photo3','photo4', 'hidden_fields'])
               ->make(true);
    }

    public function calculateTCube($length, $width, $height)
    {
        return number_format(($length * $width * $height / 1000000), 2);
    }

    // public function index(Request $request)
    // {
    //     // $this->auto_update_log_status();
    //     if (!empty($searchValue))
    //     {
    //         $search_Data = Product::where(function ($query) use ($searchValue) {
    //             $query->where('id', $searchValue)
    //                 ->orWhere('product_id', $searchValue)
    //                 ->orWhere('bill_id', $searchValue);
    //         })
    //             ->orWhereHas('customer', function ($query) use ($searchValue) {
    //                 $query->where('CS', $searchValue);
    //             })
    //             ->with('customer')
    //             ->selectRaw('*, ROUND(weight, 2) as weight')
    //             ->orderBy('id', 'desc')
    //             ->get();



    //         return response()->json(['message' => 'Data received successfully', 'repackProducts' => $search_Data]);
    //     }
    //     else
    //     {
    //         $perPage = $request->input('perPage', 50);
    //         $products = Product::with('customer')->orderBy('id', 'desc')->selectRaw('*, ROUND(weight, 2) as weight')->paginate($perPage); //->paginate(200);
    //         return view('products.index', ['products' => $products]);
    //     }
    // }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate the request data as needed
        // Validate the incoming request
        $request->validate([
            'product_id' => 'nullable',
            'name' => 'nullable',
            'photo1' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo2' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo4' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime|max:10240',
            'sku' => 'required',
            'warehouse' => 'nullable',
            'option' => 'nullable',
            'w' => 'nullable|numeric',
            'l' => 'nullable|numeric',
            'h' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'tpcs' => 'nullable|integer',
            'packageid' => 'nullable',
            'remarks' => 'nullable',
        ]);

        // return $product;

        // Handle photo2
        if ($request->hasFile('photo1')) {
            $this->handlePhoto($request, $product, 'photo1');
        }
        // Handle photo2
        if ($request->hasFile('photo2')) {
            $this->handlePhoto($request, $product, 'photo2');
        }

        // Handle photo3
        if ($request->hasFile('photo3')) {
            $this->handlePhoto($request, $product, 'photo3');
        }

        // Handle photo4
        if ($request->hasFile('photo4')) {
            $this->handlePhoto($request, $product, 'photo4');
        }

        $product->name = $request->input('name');
        $product->product_id = $request->input('product_id');
        $product->video = $request->has('video') ? $request->input('video') : $product->video;
        $product->sku = $request->input('sku');
        $product->warehouse = $request->has('warehouse') ? $request->input('warehouse') : $product->warehouse;
        $product->option = $request->has('option') ? $request->input('option') : $product->option;
        $product->w = $request->has('w') ? $request->input('w') : $product->w;
        $product->l = $request->has('l') ? $request->input('l') : $product->l;
        $product->h = $request->has('h') ? $request->input('h') : $product->h;
        $product->weight = $request->has('weight') ? $request->input('weight') : $product->weight;
        $product->tpcs = $request->has('tpcs') ? $request->input('tpcs') : $product->tpcs;
        $product->packageid = $request->has('packageid') ? $request->input('packageid') : $product->packageid;
        $product->remarks = $request->has('remarks') ? $request->input('remarks') : $product->remarks;

        $product->save();

        return redirect()->route('products')->with('success', 'Product updated successfully.');
    }

    private function handlePhoto(Request $request, $product, $photoFieldName)
    {
        $uniqueName = uniqid();
        $photo = $request->file($photoFieldName);

        if ($product->$photoFieldName) {
            Storage::delete("photos/{$product->$photoFieldName}");
        }

        $product->$photoFieldName = $photo->storeAs('photos', $uniqueName . "_{$photoFieldName}.{$photo->getClientOriginalExtension()}", 'public');
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'product_id' => 'nullable',
            'name' => 'nullable',
            'photo1' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'photo2' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'photo3' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'photo4' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime|max:10240',
            'sku' => 'required',
            'warehouse' => 'nullable',
            'option' => 'nullable',
            'w' => 'nullable|numeric',
            'l' => 'nullable|numeric',
            'h' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'tpcs' => 'nullable|integer',
            'packageid' => 'nullable',
            'remarks' => 'nullable',
        ]);
        // Handle file uploads
        $video = $request->file('video');
        $photo1Path = null;
        $photo2Path = null;
        $photo3Path = null;
        $photo4Path = null;
        // Generate a unique name for all photos and videos
        $uniqueName = uniqid();
        if($request->has('photo1'))
        {
             $photo1 = $request->file('photo1');
             $photo1Path = $photo1 ? $photo1->storeAs('photos', $uniqueName . '_photo1.' . $photo1->getClientOriginalExtension(), 'public') : null;
        }
        if($request->has('photo1'))
        {
            $photo2 = $request->file('photo2');
            $photo2Path = $photo2 ? $photo2->storeAs('photos', $uniqueName . '_photo2.' . $photo2->getClientOriginalExtension(), 'public') : null;
        }
        if($request->has('photo1'))
        {
            $photo3 = $request->file('photo3');
            $photo3Path = $photo3 ? $photo3->storeAs('photos', $uniqueName . '_photo3.' . $photo3->getClientOriginalExtension(), 'public') : null;
        }
        if($request->has('photo1'))
        {
            $photo4 = $request->file('photo4');
            $photo4Path = $photo4 ? $photo4->storeAs('photos', $uniqueName . '_photo4.' . $photo4->getClientOriginalExtension(), 'public') : null;
        }

        // Use a unique name for the video file
        $videoPath = $video ? $video->storeAs('videos', $uniqueName . '_video.' . $video->getClientOriginalExtension(), 'public') : null;

        // Create a new product
        $product = Product::create([
            'product_id' => $request->input('product_id'),
            'name' => $request->input('name'),
            'photo1' => $photo1Path,
            'photo2' => $photo2Path,
            'photo3' => $photo3Path,
            'photo4' => $photo4Path,
            'video' => $videoPath,
            'sku' => $request->input('sku'),
            'warehouse' => $request->input('warehouse'),
            'option' => $request->input('option'),
            'w' => $request->input('w'),
            'l' => $request->input('l'),
            'h' => $request->input('h'),
            'weight' => $request->input('weight'),
            'tpcs' => $request->input('tpcs'),
            'packageid' => $request->input('packageid'),
            'remarks' => $request->input('remarks'),
        ]);

        return response()->json(['message' => 'Product added successfully', 'data' => $product], 201);
    }


    public function storeV1(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'product_id' => 'nullable',
            'name' => 'nullable',
            'photo1' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo2' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo4' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime|max:10240',
            'sku.*' => 'required',
            'warehouse' => 'nullable',
            'option' => 'nullable',
            'w.*' => 'nullable|numeric',
            'l.*' => 'nullable|numeric',
            'h.*' => 'nullable|numeric',
            'weight.*' => 'nullable|numeric',
            'tpcs.*' => 'nullable|integer',
            'packageid' => 'nullable',
            'remarks' => 'nullable',
        ]);

        // Handle file uploads
        $photo1 = $request->file('photo1');
        $photo2 = $request->file('photo2');
        $photo3 = $request->file('photo3');
        $photo4 = $request->file('photo4');
        $video = $request->file('video');

        // Generate a unique name for all photos and videos
        $uniqueName = uniqid();

        $photo1Path = $photo1 ? $photo1->storeAs('photos', $uniqueName . '_photo1.' . $photo1->getClientOriginalExtension(), 'public') : null;
        $photo2Path = $photo2 ? $photo2->storeAs('photos', $uniqueName . '_photo2.' . $photo2->getClientOriginalExtension(), 'public') : null;
        $photo3Path = $photo3 ? $photo3->storeAs('photos', $uniqueName . '_photo3.' . $photo3->getClientOriginalExtension(), 'public') : null;
        $photo4Path = $photo4 ? $photo4->storeAs('photos', $uniqueName . '_photo4.' . $photo4->getClientOriginalExtension(), 'public') : null;

        // Use a unique name for the video file
        $videoPath = $video ? $video->storeAs('videos', $uniqueName . '_video.' . $video->getClientOriginalExtension(), 'public') : null;

        // Create a new product for each SKU
        $products = [];
        foreach ($request->input('sku') as $key => $sku) {

            $cleanedSku = str_replace('"', '', $sku);
            // $cleanedSku = trim(stripslashes($request->input('sku')[$key]));
            $product = Product::create([
                'product_id' =>  $request->input('product_id') ? "C2T-" . strtoupper($request->input('product_id')) : null,
                'name' => $request->input('name') ?? null,
                'photo1' => $photo1Path,
                'photo2' => $photo2Path,
                'photo3' => $photo3Path,
                'photo4' => $photo4Path,
                'video' => $videoPath,
                'sku' => $cleanedSku,
                'warehouse' => $request->input('warehouse'),
                'option' => $request->input('option'),
                'w' => $request->input('w')[$key] ?? null,
                'l' => $request->input('l')[$key] ?? null,
                'h' => $request->input('h')[$key] ?? null,
                'weight' => $request->input('weight')[$key] ?? null,
                'tpcs' => $request->input('tpcs')[$key] ?? null,
                'packageid' => $request->input('packageid'),
                'type' => $request->input('type'),
                'remarks' => $request->input('remarks'),
            ]);

            // Add each product to the array
            $products[] = $product;
        }

        return response()->json(['message' => 'Products added successfully', 'data' => $products], 201);
    }



    public function checkSku(Request $request)
    {
        $request->validate([
            'sku' => 'required',
        ]);

        $product = Product::where('sku', $request->input('sku'))->first();

        if ($product) {
            return response()->json(['message' => 'Product already present', 'status' => true, 'product' => $product], 200);
        }

        return response()->json(['message' => 'Product not present in database', 'status' => false], 200);
    }


    public function destroy(Product $product, Request $request)
    {
        try {
            // Delete the product
            $product->delete();

            // Check if the request is an AJAX request
            if ($request->ajax()) {
                return response()->json(['message' => 'Product deleted successfully.']);
            }

            // Redirect back with a success message
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., database errors)
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while deleting the product. Please try again.'], 500);
            }

            return redirect()->back()->withErrors(['error' => 'An error occurred while deleting the product. Please try again.']);
        }
    }

    public function deleteRepack(RepackProduct $product, Request $request)
    {
        try {
            // Delete the product
            $product->delete();

            // Check if the request is an AJAX request
            if ($request->ajax()) {
                return response()->json(['message' => 'Product deleted successfully.']);
            }

            // Redirect back with a success message
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., database errors)
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while deleting the product. Please try again.'], 500);
            }

            return redirect()->back()->withErrors(['error' => 'An error occurred while deleting the product. Please try again.']);
        }
    }

    public function updateRemarks(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['remarks' => $request->input('remarks')]);

        return response()->json(['message' => 'Remarks updated successfully']);
    }

    public function updateRepackRemarks(Request $request, $id)
    {
        $product = RepackProduct::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['remarks' => $request->input('remarks')]);

        return response()->json(['message' => 'Remarks updated successfully']);
    }


    public function updateW(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['w' => $request->input('w')]);

        return response()->json(['message' => 'W updated successfully']);
    }


    public function updateRepackW(Request $request, $id)
    {
        $product = RepackProduct::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['w' => $request->input('w')]);

        return response()->json(['message' => 'W updated successfully']);
    }



    public function updateL(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['l' => $request->input('l')]);

        return response()->json(['message' => 'L updated successfully']);
    }

    public function updateRepackL(Request $request, $id)
    {
        $product = RepackProduct::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['l' => $request->input('l')]);

        return response()->json(['message' => 'L updated successfully']);
    }

    public function updateH(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['h' => $request->input('h')]);

        return response()->json(['message' => 'H updated successfully']);
    }

    public function updateRepackH(Request $request, $id)
    {
        $product = RepackProduct::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['h' => $request->input('h')]);

        return response()->json(['message' => 'H updated successfully']);
    }

    public function updateTpcs(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['tpcs' => $request->input('tpcs')]);

        return response()->json(['message' => 'CTNS updated successfully']);
    }

    public function updateRepackTpcs(Request $request, $id)
    {
        $product = RepackProduct::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['tpcs' => $request->input('tpcs')]);

        return response()->json(['message' => 'CTNS updated successfully']);
    }

    public function updateWeight(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['weight' => $request->input('weight')]);

        return response()->json(['message' => 'Weight updated successfully']);
    }

    public function updateRepackWeight(Request $request, $id)
    {
        $product = RepackProduct::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['weight' => $request->input('weight')]);

        return response()->json(['message' => 'Weight updated successfully']);
    }

    public function updateProductId(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['product_id' => $request->input('product_id')]);

        return response()->json(['message' => 'Product Id updated successfully']);
    }

    public function updateRepackProductId(Request $request, $id)
    {
        $product = RepackProduct::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['product_id' => $request->input('product_id')]);

        return response()->json(['message' => 'Product Id updated successfully']);
    }

    public function updateProductName(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['name' => $request->input('name')]);

        return response()->json(['message' => 'Product Name updated successfully']);
    }

    public function updateRepackProductName(Request $request, $id)
    {
        $product = RepackProduct::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['name' => $request->input('name')]);

        return response()->json(['message' => 'Product Name updated successfully']);
    }

    public function updateCSDID(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['cs_did' => $request->input('cs_did')]);

        return response()->json(['message' => 'Product CS DID updated successfully']);
    }

    public function addToRepack(Request $request)
    {
        // dd( $request->all() , RepackProduct::first() , round( (float)$request->tcube , 2 ) , round( (float)$request->tweight , 2 ) );

        $request->validate([
            'billid' => 'nullable',
            'productid' => 'nullable',
            'productname' => 'nullable',
            'warehouse' => 'required',
            'option' => 'nullable',
            'w' => 'nullable|numeric',
            'l' => 'nullable|numeric',
            'h' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'ctns' => 'nullable|integer',
            'packageid' => 'nullable',
            'selectedRowsSku' => 'nullable',
            'type' => 'nullable',
            'remarks' => 'nullable',
            'tcube' => 'required',
            'tweight' => 'required'
        ]);

        $billId = $request->input('billid');
        $selectedRowsSku = $request->input('selectedRowsSku');
        $firstElement = $request->input('selectedRows')[0];
        $product = Product::where('id', '=', $firstElement)->first();
        $photo1 = null;
        $photo2 = null;
        $photo3 = null;
        $photo4 = null;
        if (count($selectedRowsSku) == 1) {
            $photo1 = $product->photo1;
            $photo2 = $product->photo2;
            $photo3 = $product->photo3;
            $photo4 = $product->photo4;
        }


        foreach ($selectedRowsSku as $sku) {
            $repackProduct = RepackProduct::where('sku', '=', $sku)->first();
            if ($repackProduct) {
                return response()->json(['message' => $sku . ' Already present in repack'], 406);
            }
        }
        if ($request->input('option') == 'SEA') {
            $l = 10;
        } else {
            $l = 1;
        }


        $productRepack = RepackProduct::create([
            'bill_id' => $billId,
            'product_id' => $request->input('productid'),
            'name' => $request->input('productname'),
            'sku' => $product->sku,
            'photo1' => $photo1,
            'photo2' => $photo2,
            'photo3' => $photo3,
            'photo4' => $photo4,
            'warehouse' => $request->input('wirehouse'),
            'option' => $request->input('option'),
            'w' => $request->input('w'),
            'l' => $request->input('l'),
            'h' => $request->input('h'),
            'weight' => $request->input('weight'),
            'tpcs' => $request->input('ctns'),
            'type' => $product->type,
            // 'log_status' => $l,
            'update_log_status_date_time' => now(),
            'packageid' => $request->input('packageid'),
            'products' => implode(',', $request->input('selectedRowsSku')),
            'remarks' => $request->input('remarks'),
            'log_status' => $request->option == 'EK' ? 1 : 10,
            't_cube' => round( (float)$request->tcube , 2 ) ,   #$request->tcube,
            't_weight' => round( (float)$request->tweight , 2 ) #$request->tweight
        ]);
        // $repackProduct->update_log_status_date_time = now();

        $selectedRows = $request->input('selectedRows');
        foreach ($selectedRows as $productId) {
            $product = Product::where('id', '=', $productId)->first();
            $product->update(['bill_id' => $billId]);
        }

        return response()->json(['message' => 'Repack successfully']);
    }




    public function BKW_C2T(Request $request, $searchValue = null)
    {
        $title = 'BKW-C2T Product Information';
        $logStatus = LogStatus::select('id','name')->pluck('name','id')->toArray();

        $ct_idss = RepackProduct::whereNotNull('ct_id')->select('ct_id', 'log_status')->get();
        $ct_idaa = [];

        foreach ($ct_idss as $temp)
        {
            if ($temp->log_status != 9 && $temp->log_status != 18)
            {
                $ct_idaa[] = $temp->ct_id;
            }
        }
        $ct_ids = $ct_idaa;
        $ct_ids = array_unique($ct_ids);

        $values = array_values($ct_ids);

        // Use array_combine to swap keys with values
        $ct_ids = array_combine($values, $values);

        $lcs = $this->lc;


        return view('bkw-c2t.index', compact('logStatus','ct_ids','title','lcs'));
    }

    public function bkwc2tData(Request $request)
    {
        $products = RepackProduct::with(['customer'])->orderBy('id', 'desc');
        return DataTables::of($products)
        ->addColumn('checkbox', function($product){
             return '<input type="checkbox" class="row-checkbox" data-product-id="0" data-product-code="" data-product-name="" data-product-w="" data-product-l="" data-product-h="" data-product-tpcs="" data-product-sku="" data-product-weight="" data-option="" data-type="" data-warehouse="">';
        })
        ->addColumn('csd_id', function($product){
             $csd_id = isset($product->customer->CS) ? $product->customer->CS : '';
             return $csd_id;
        })
        ->addColumn('maitou', function($product){
             return $product->product_id;
        })
        ->addColumn('bill_id', function($product){
             return $product->bill_id;
        })
        ->addColumn('t_cube', function($product){
            return $this->calculateTCube($product->l , $product->w , $product->h);
        })
        ->addColumn('ct_id', function($product){
             return $product->ct_id;
        })
        ->addColumn('log_status', function($product){

             $logStatus = LogStatus::get();

             $html = '
                     <select class="editable-log_status" data-id="'. $product->id .'">
                         <option data-description="" value="" '.( $product->log_status == "" || $product->log_status == null ? 'selected' : "") .' >N/A</option>';
             foreach ($logStatus as $status)
             {
                 if ($product->option == 'EK')
                 {
                     if (in_array($status->name, $this->ekarray))
                     {
                         $selected = ($product->log_status == $status->id) ? 'selected' : '';
                         $html .= '<option data-description="' . htmlspecialchars($status->description) .'" value="' . htmlspecialchars($status->id) . '" ' . $selected . '>' .htmlspecialchars($status->name) . '</option>';
                     }
                 }
                 elseif ($product->option == 'SEA')
                 {
                     if (in_array($status->name, $this->seaarray)) {
                         $selected = ($product->log_status == $status->id) ? 'selected' : '';
                         $html .= '<option data-description="' . htmlspecialchars($status->description) . '" value="' . htmlspecialchars($status->id) . '" ' . $selected . '>' . htmlspecialchars($status->name) . '</option>';
                     }
                 }
                 else
                 {
                     $selected = ($product->log_status == $status->id) ? 'selected' : '';
                     $html .= '<option data-description="' . htmlspecialchars($status->description) . '" value="' . htmlspecialchars($status->id) . '" ' . $selected . '>' . htmlspecialchars($status->name) . '</option>';
                 }
             }
             $html .= '</select>';
             return $html;
         })
         ->addColumn('lc', function($product){
             $html = '
                         <select class="editable-lc" data-id="'. $product->id .'">
                             <option value="" '.($product->lc == "" || $product->lc == null ? 'selected' : "") .'>N/A</option>
                    ';

            foreach($this->lc as $key => $value)
            {
                $html .= '<option value="'.$key.'" '. ($product->lc == $key ? "selected" : "") .'>'.$value.'</option>';
            }

            $html .= '</select>';
             return $html;
         })
         ->addColumn('print', function($product){
             return $product->print == null ? 'Not Printed' : 'Printed';
         })
         ->addColumn('cost', function($product){
             $html = '
                     <select class="editable-cost" data-id="'. $product->id .'">
                         <option value="No" '.($product->cost == 'No' || $product->cost == null ? 'selected' : '') .'>No</option>
                         <option value="Yes" '. ($product->cost == 'Yes' ? 'selected' : '') .'>Yes</option>
                     </select>
             ';

             return $html;
         })
         ->addColumn('ntf_cs', function($product){
             $html = '
                         <select class="editable-ntf_cs" data-id="'. $product->id .'">
                             <option value="No" '.($product->ntf_cs == 'No' || $product->ntf_cs == null ? 'selected' : '') .'>No</option>
                             <option value="Yes" '. ($product->ntf_cs == 'Yes' ? 'selected' : '') .'>Yes</option>
                         </select>
                     ';

             return $html;
         })
         ->addColumn('dbt', function($product){
            $html = '';
            if ($product->dbt == null || $product->dbt == '') {
                $html .='<button class="editable-dbt" data-id="' . htmlspecialchars($product->id) . '">Start</button>';
            } else {
                $modifiedString = preg_replace('/(\d+)d/', '$1D', $product->dbt);
                $html .='<p class="dbttime">' . htmlspecialchars($modifiedString ?? $product->dbt) . '</p>';
            }
            return $html;
        })
        ->rawColumns(['checkbox','log_status','lc','cost','ntf_cs','dbt'])
        ->make(true);
    }

    public function CKW_C2T()
    {
        $title = 'BKO-C2T Product Information';
        $logStatus = LogStatus::select('id','name')->pluck('name','id')->toArray();

        $ct_idss = RepackProduct::whereNotNull('ct_id')->select('ct_id', 'log_status')->get();
        $ct_idaa = [];
        foreach ($ct_idss as $temp)
        {
            if ($temp->log_status != 9 && $temp->log_status != 18)
            {
                $ct_idaa[] = $temp->ct_id;
            }
        }
        $ct_ids = $ct_idaa;
        $ct_ids = array_unique($ct_ids);
        $values = array_values($ct_ids);
        $ct_ids = array_combine($values, $values);

        $lcs = $this->lc;
        return view('bko-c2t.index', compact('logStatus', 'ct_ids', 'title','lcs'));
    }

    public function CKWC2TData(Request $request)
    {
        $products = RepackProduct::with(['customer'])->orderBy('id', 'desc');
        if( request('search') ){
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing('repack_products');
            foreach( $columns as $column ){
                $products->orWhere($column, 'LIKE', "%" . $request->search['value'] ."%");
            }
        }
        return DataTables::of($products)
                ->addColumn('checkbox', function($product){
                    return '<input type="checkbox" class="row-checkbox" data-product-id="0" data-product-code="" data-product-name="" data-product-w="" data-product-l="" data-product-h="" data-product-tpcs="" data-product-sku="" data-product-weight="" data-option="" data-type="" data-warehouse="">';
                })
                ->addColumn('csd_id', function($product){
                    $csd_id = isset($product->customer->CS) ? $product->customer->CS : '';
                    return $csd_id;
                })
                ->addColumn('maitou', function($product){
                    return $product->product_id;
                })
                ->addColumn('bill_id', function($product){
                    return $product->bill_id;
                })
                ->addColumn('photo1', function($product){
                    $photo1 = '';
                    if ($product->photo1)
                    {
                        $photo1 = '<a href="#" class="view-image image1" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="'. Storage::url($product->photo1).'"><img src="'.asset('assets/images/picture.png').'" alt="Photo 1"></a>';
                    }
                    else{
                        $photo1 = '<a href="#" class="upload-image" data-attribute="photo1" data-id="'.$product->id.'">
                                    <img src="'.asset('assets/images/upload.png').'" alt="Upload Image">
                                </a>';
                    }
                    return $photo1;
                })
                ->addColumn('photo2', function($product){
                    $photo2 = '';
                    if ($product->photo2)
                    {
                        $photo2 = '<a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="'.Storage::url($product->photo2) .'""> <img src="'.asset('assets/images/picture.png').'" alt="Photo 2"></a>';
                    }
                    else{
                        $photo2 = '<a href="#" class="upload-image" data-attribute="photo2" data-id="'.$product->id.'">
                                    <img src="'.asset('assets/images/upload.png').'" alt="Upload Image">
                                </a>';
                    }
                    return $photo2;
                })
                ->addColumn('photo3', function($product){
                    $photo3 = '';
                    if ($product->photo3)
                    {
                        $photo3 = '<a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="'.Storage::url($product->photo3) .'""> <img src="'.asset('assets/images/picture.png').'" alt="Photo 2"></a>';
                    }
                    else{
                        $photo3 = '<a href="#" class="upload-image" data-attribute="photo3" data-id="'.$product->id.'">
                                    <img src="'.asset('assets/images/upload.png').'" alt="Upload Image">
                                </a>';
                    }
                    return $photo3;
                })
                ->addColumn('photo4', function($product){
                    $photo4 = '';
                    if ($product->photo4)
                    {
                        $photo4 = '<a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="'.Storage::url($product->photo4) .'""> <img src="'.asset('assets/images/picture.png').'" alt="Photo 2"></a>';
                    }
                    else{
                        $photo4 = '<a href="#" class="upload-image" data-attribute="photo4" data-id="'.$product->id.'">
                                    <img src="'.asset('assets/images/upload.png').'" alt="Upload Image">
                                </a>';
                    }
                    return $photo4;
                })
                ->addColumn('sku', function($product){
                    $for_copy = '';
                    $product_str = '<div class="barcode-container"><a class="primary-barcode" target="_blank" href="https://dhl.com/index.php?route=account%2Fshipping&search='.$product->sku.'">'. substr(($product->sku ?? 'N/A') ,0, 5) . '...</a>';
                    $product_str .= '<input type="hidden" class="products" value="' . $product->products . '"/>';
                    if (count(explode(',', $product->products)) > 1){
                        $product_str .= '<div class="popup">';
                        foreach (explode(',', $product->products) as $p){
                            $product_str .= '<span>' . $p .'</span><br>';
                            $for_copy .= $p.' ';
                        }
                        $product_str .= '</div>';
                    }
                    $product_str .= '<button onclick="copyProducts(`' . $for_copy . '`)">C</button></div>';
                    return $product_str;
                })
                ->addColumn('warehouse', function($product){
                    return $product->warehouse;
                })
                ->addColumn('type', function($product){
                    return $product->type;
                })
                ->addColumn('tpcs', function($product){
                    return $product->tpcs;
                })
                ->addColumn('total_weight', function($product){
                    return round(($product->weight * $product->tpcs), 2);
                })
                ->addColumn('length', function($product){
                    return $product->l;
                })
                ->addColumn('width', function($product){
                    return $product->w;
                })
                ->addColumn('height', function($product){
                    return $product->h;
                })
                ->addColumn('t_cube', function($product){
                    return $this->calculateTCube($product->l , $product->w , $product->h);
                })
                ->addColumn('created_at', function($product){
                    return date('F j, Y h:i:s a', strtotime($product->created_at));
                })
                ->addColumn('remarks', function($product){
                    return $product->remarks;
                })
                ->addColumn('log_status', function($product){

                    $logStatus = LogStatus::get();

                    $html = '
                            <select class="editable-log_status" name="log_status" data-id="'. $product->id .'">
                                <option data-description="" value="" '.( $product->log_status == "" || $product->log_status == null ? 'selected' : "") .' >N/A</option>';
                    foreach ($logStatus as $status)
                    {
                        if ($product->option == 'EK')
                        {
                            if (in_array($status->name, $this->ekarray))
                            {
                                $selected = ($product->log_status == $status->id) ? 'selected' : '';
                                $html .= '<option data-description="' . htmlspecialchars($status->description) .'" value="' . htmlspecialchars($status->id) . '" ' . $selected . '>' .htmlspecialchars($status->name) . '</option>';
                            }
                        }
                        elseif ($product->option == 'SEA')
                        {
                            if (in_array($status->name, $this->seaarray)) {
                                $selected = ($product->log_status == $status->id) ? 'selected' : '';
                                $html .= '<option data-description="' . htmlspecialchars($status->description) . '" value="' . htmlspecialchars($status->id) . '" ' . $selected . '>' . htmlspecialchars($status->name) . '</option>';
                            }
                        }
                        else
                        {
                            $selected = ($product->log_status == $status->id) ? 'selected' : '';
                            $html .= '<option data-description="' . htmlspecialchars($status->description) . '" value="' . htmlspecialchars($status->id) . '" ' . $selected . '>' . htmlspecialchars($status->name) . '</option>';
                        }
                    }
                    $html .= '</select>';
                    return $html;
                })
                ->addColumn('print', function($product){
                    return $product->print == null ? 'Not Printed' : 'Printed';
                })
                ->addColumn('cost', function($product){
                    $html = '
                            <select class="editable-cost" name="cost" data-id="'. $product->id .'">
                                <option value="No" '.($product->cost == 'No' || $product->cost == null ? 'selected' : '') .'>No</option>
                                <option value="Yes" '. ($product->cost == 'Yes' ? 'selected' : '') .'>Yes</option>
                            </select>
                    ';

                    return $html;
                })
                ->addColumn('ntf_cs', function($product){
                    $html = '
                                <select class="editable-ntf_cs" name="ntf_cs" data-id="'. $product->id .'">
                                    <option value="No" '.($product->ntf_cs == 'No' || $product->ntf_cs == null ? 'selected' : '') .'>No</option>
                                    <option value="Yes" '. ($product->ntf_cs == 'Yes' ? 'selected' : '') .'>Yes</option>
                                </select>
                            ';

                    return $html;
                })
                ->addColumn('survey', function($product){
                    $html = '
                                <select class="editable-survey" name="survey" data-id="'.$product->id.'">
                                    <option value="No" '.($product->ntf_cs == 'No' || $product->ntf_cs == null ? 'selected' : '') .'>No</option>
                                    <option value="Yes" '. ($product->ntf_cs == 'Yes' ? 'selected' : '') .'>Yes</option>
                                </select>
                            ';

                    return $html;
                })
                ->addColumn('hidden_fields', function($product){
                  return '
                        <input type="hidden" class="product-id" value="' . $product->id . '">
                        <input type="hidden" class="product-code" value="' . $product->product_id . '">
                        <input type="hidden" class="product-name" value="' . $product->name . '">
                        <input type="hidden" class="product-w" value="' . $product->w . '">
                        <input type="hidden" class="product-l" value="' . $product->l . '">
                        <input type="hidden" class="product-h" value="' . $product->h . '">
                        <input type="hidden" class="product-tpcs" value="' . $product->tpcs . '">
                        <input type="hidden" class="product-sku" value="' . $product->sku . '">
                        <input type="hidden" class="product-weight" value="' . $product->weight . '">
                        <input type="hidden" class="option" value="' . $product->option . '">
                        <input type="hidden" class="type" value="' . $product->type . '">
                        <input type="hidden" class="warehouse" value="' . $product->warehouse . '">
                  ';
                })
                ->rawColumns(['checkbox','sku','photo1','photo2','photo3','photo4','log_status','cost','ntf_cs','survey','hidden_fields'])
                ->make(true);
    }


    // public function CKW_C2T(Request $request)
    // {
    //     // dd( RepackProduct::where('bill_id', '05190636')->get() );

    //     // $this->auto_update_log_status();
    //     $ct_idss = RepackProduct::whereNotNull('ct_id')->select('ct_id', 'log_status')->get();
    //     $ct_idaa = [];

    //     foreach ($ct_idss as $temp) {
    //         if ($temp->log_status != 9 && $temp->log_status != 18) {
    //             $ct_idaa[] = $temp->ct_id;
    //         }
    //     }
    //     $ct_ids = $ct_idaa;
    //     // $ct_ids = RepackProduct::whereNotNull('ct_id')->where('log_status', '!=', '9')->where('log_status', '!=', '18')->pluck('ct_id')->toArray();
    //     $ct_ids = array_unique($ct_ids);

    //     $perPage = $request->input('perPage', 50);
    //     $logStatus = LogStatus::get();
    //     $products = RepackProduct::orderBy('id', 'desc')->with('customer')
    //     ->selectRaw('*, ROUND(weight, 2) as weight')
    //     ->paginate($perPage);

    //     if (!empty($searchValue)) {
    //         $search_Data = RepackProduct::where('id', $searchValue)
    //             ->orWhere('product_id', $searchValue)
    //             ->orWhere('bill_id', $searchValue)

    //             ->orWhere(function ($query) use ($searchValue) {
    //                 $query->where('products', $searchValue)
    //                     ->orWhere('products', 'like', "$searchValue,%")
    //                     ->orWhere('products', 'like', "%,$searchValue")
    //                     ->orWhere('products', 'like', "%,$searchValue,%");
    //             })
    //             ->orWhere('sku', $searchValue)
    //             ->orWhere('ct_id', $searchValue)
    //             ->selectRaw('*, ROUND(weight, 2) as weight')
    //             ->with('customer')
    //             ->get();


    //         // dd($search_Data);

    //         return response()->json(['message' => 'Data received successfully', 'repackProducts' => $search_Data, 'logStatus' => $logStatus, 'ct_ids' => $ct_ids]);
    //     }

    //     return view('CKW_C2T', ['products' => $products, 'logStatus' => $logStatus, 'ct_ids' => $ct_ids]);
    // }

    public function product_C2T(Request $request, $searchValue = null)
    {


        if (!empty($searchValue)) {
            $search_Data = Product::where(function ($query) use ($searchValue) {
                $query->where('id', $searchValue)
                    ->orWhere('product_id', $searchValue)
                    ->orWhere('name','like', '%'.$searchValue.'%')

                    ->orWhere('bill_id', $searchValue)
                    ->orWhere('sku', $searchValue);
            })
                ->orWhereHas('customer', function ($query) use ($searchValue) {
                    $query->where('CS', $searchValue);
                })
                ->with('customer')
                ->selectRaw('*, ROUND(weight, 2) as weight')
                ->get();


            // dd($search_Data);

            return response()->json(['message' => 'Data received successfully', 'repackProducts' => $search_Data]);
        }
    }

    public function repackProducts()
    {
        $title = 'Repack Product Information';
        return view('repack-products.index',compact('title'));
    }

    public function repackProductsData(Request $request)
    {
        $products = RepackProduct::with(['customer'])->orderBy('id', 'desc');
        if( request('search') ){
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing('repack_products');
            foreach( $columns as $column ){
                $products->orWhere($column, 'LIKE', "%" . $request->search['value'] ."%");
            }
        }
        return DataTables::of($products)
               ->addColumn('checkbox', function($product){
                    return '<input type="checkbox" class="row-checkbox" data-product-id="0" data-product-code="" data-product-name="" data-product-w="" data-product-l="" data-product-h="" data-product-tpcs="" data-product-sku="" data-product-weight="" data-option="" data-type="" data-warehouse="">';
               })
               ->addColumn('csd_id', function($product){
                    $csd_id = isset($product->customer->CS) ? $product->customer->CS : '';
                    return $csd_id;
               })
               ->addColumn('maitou', function($product){
                    return $product->product_id;
               })
               ->addColumn('bill_id', function($product){
                    return $product->bill_id;
               })
               ->addColumn('product_name', function($product){
                    return $product->name;
               })
               ->addColumn('photo1', function($product){
                    $photo1 = '';
                    if ($product->photo1)
                    {
                        $photo1 = '<a href="#" class="view-image image1" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="'. Storage::url($product->photo1).'"><img src="'.asset('assets/images/picture.png').'" alt="Photo 1"></a>';
                    }
                    return $photo1;
               })
               ->addColumn('photo2', function($product){
                    $photo2 = '';
                    if ($product->photo2)
                    {
                        $photo2 = '<a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="'.Storage::url($product->photo2) .'""> <img src="'.asset('assets/images/picture.png').'" alt="Photo 2"></a>';
                    }
                    return $photo2;
               })
               ->addColumn('photo3', function($product){
                    $photo3 = '';
                    if ($product->photo3)
                    {
                        $photo3 = '<a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="'.Storage::url($product->photo3) .'""> <img src="'.asset('assets/images/picture.png').'" alt="Photo 2"></a>';
                    }
                    return $photo3;
               })
               ->addColumn('photo4', function($product){
                    $photo4 = '';
                    if ($product->photo4)
                    {
                        $photo4 = '<a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="'.Storage::url($product->photo4) .'""> <img src="'.asset('assets/images/picture.png').'" alt="Photo 2"></a>';
                    }
                    return $photo4;
               })
               ->addColumn('sku', function($product){
                    $for_copy = '';
                    $product_str = '<div class="barcode-container"><a class="primary-barcode" target="_blank" href="https://dhl.com/index.php?route=account%2Fshipping&search='.$product->sku.'">'. ($product->sku ?? 'N/A') . '</a>';
                    $product_str .= '<input type="hidden" class="products" value="' . $product->sku . '"/>';
                    if (count(explode(',', $product->products)) > 1){
                        $product_str .= '<div class="popup">';
                        foreach (explode(',', $product->products) as $p){
                            $product_str .= '<span>' . $p .'</span><br>';
                            $for_copy .= $p.' ';
                        }
                        $product_str .= '</div>';
                    }
                    return $product_str;
               })
               ->addColumn('warehouse', function($product){
                    return $product->warehouse;
               })
               ->addColumn('option', function($product){
                   return $product->option;
               })
               ->addColumn('type', function($product){
                    return $product->type;
               })
               ->addColumn('tpcs', function($product){
                    return $product->tpcs;
               })
               ->addColumn('weight', function($product){
                  return round($product->weight, 2);
               })
               ->addColumn('total_weight', function($product){
                    return round(($product->weight * $product->tpcs), 2);
                })
               ->addColumn('length', function($product){
                    return $product->l;
               })
               ->addColumn('width', function($product){
                    return $product->w;
               })
               ->addColumn('height', function($product){
                    return $product->h;
               })
               ->addColumn('t_cube', function($product){
                    return $this->calculateTCube($product->l , $product->w , $product->h);
                })
               ->addColumn('created_at', function($product){
                   return date('F j, Y h:i:s a', strtotime($product->created_at));
               })
               ->addColumn('remarks', function($product){
                  return $product->remarks;
               })
               ->addColumn('ct_id', function($product){
                    return $product->ct_id;
               })

               ->addColumn('log_status', function($product){

                    $logStatus = LogStatus::get();

                    $html = '
                            <select class="editable-log_status" data-id="'. $product->id .'">
                                <option data-description="" value="" '.( $product->log_status == "" || $product->log_status == null ? 'selected' : "") .' >N/A</option>';
                    foreach ($logStatus as $status)
                    {
                        if ($product->option == 'EK')
                        {
                            if (in_array($status->name, $this->ekarray))
                            {
                                $selected = ($product->log_status == $status->id) ? 'selected' : '';
                                $html .= '<option data-description="' . htmlspecialchars($status->description) .'" value="' . htmlspecialchars($status->id) . '" ' . $selected . '>' .htmlspecialchars($status->name) . '</option>';
                            }
                        }
                        elseif ($product->option == 'SEA')
                        {
                            if (in_array($status->name, $this->seaarray)) {
                                $selected = ($product->log_status == $status->id) ? 'selected' : '';
                                $html .= '<option data-description="' . htmlspecialchars($status->description) . '" value="' . htmlspecialchars($status->id) . '" ' . $selected . '>' . htmlspecialchars($status->name) . '</option>';
                            }
                        }
                        else
                        {
                            $selected = ($product->log_status == $status->id) ? 'selected' : '';
                            $html .= '<option data-description="' . htmlspecialchars($status->description) . '" value="' . htmlspecialchars($status->id) . '" ' . $selected . '>' . htmlspecialchars($status->name) . '</option>';
                        }
                    }
                    $html .= '</select>';
                    return $html;
                })
                ->addColumn('lc', function($product){
                    $html = '
                                <select class="editable-lc" data-id="'. $product->id .'">
                                    <option value="" '.($product->lc == "" || $product->lc == null ? 'selected' : "") .'>N/A</option>';

                    foreach($this->lc as $key => $value)
                    {
                        $html .= '<option value="'.$key.'" '. ($product->lc == $key ? "selected" : "") .'>'.$value.'</option>';
                    }
                    $html .= '</select>';
                    return $html;
                })
                ->addColumn('print', function($product){
                    return $product->print == null ? 'Not Printed' : 'Printed';
                })
                ->addColumn('cost', function($product){
                    $html = '
                            <select class="editable-cost" data-id="'. $product->id .'">
                                <option value="No" '.($product->cost == 'No' || $product->cost == null ? 'selected' : '') .'>No</option>
                                <option value="Yes" '. ($product->cost == 'Yes' ? 'selected' : '') .'>Yes</option>
                            </select>
                    ';

                    return $html;
                })
                ->addColumn('dbt', function($product){
                    $html = '';
                    if ($product->dbt == null || $product->dbt == '') {
                        $html .='<button class="editable-dbt" data-id="' . htmlspecialchars($product->id) . '">Start</button>';
                    } else {
                        $modifiedString = preg_replace('/(\d+)d/', '$1D', $product->dbt);
                        $html .='<p class="dbttime">' . htmlspecialchars($modifiedString ?? $product->dbt) . '</p>';
                    }
                    return $html;
                })
                ->addColumn('ntf_cs', function($product){
                    $html = '
                                <select class="editable-ntf_cs" data-id="'. $product->id .'">
                                    <option value="No" '.($product->ntf_cs == 'No' || $product->ntf_cs == null ? 'selected' : '') .'>No</option>
                                    <option value="Yes" '. ($product->ntf_cs == 'Yes' ? 'selected' : '') .'>Yes</option>
                                </select>
                            ';

                    return $html;
                })
                ->addColumn('paisong_siji', function($product){
                    $html = '
                            <select class="editable-paisong_siji" data-id="'. $product->id .'">
                                <option value="" '.  ($product->paisong_siji == null ? 'selected' : '') .'>Not Selected</option>
                                <option value="1" '. ($product->paisong_siji == '1' ? 'selected' : '') .'>PAISONG SIJI 1</option>
                                <option value="2" '. ($product->paisong_siji == '2' ? 'selected' : '') .'>PAISONG SIJI 2</option>
                                <option value="3" '. ($product->paisong_siji == '3' ? 'selected' : '') .'>PAISONG SIJI 3</option>
                                <option value="4" '. ($product->paisong_siji == '4' ? 'selected' : '') .'>PAISONG SIJI 4</option>
                            </select>';

                    return $html;
                })
                ->addColumn('survey', function($product){
                    $html = '
                            <select class="editable-survey" data-id="'. $product->id .'">
                                <option value="No" '.($product->survey == 'No' || $product->survey == null ? 'selected' : '') .'>No</option>
                                <option value="Yes" '. ($product->survey == 'Yes' ? 'selected' : '') .'>Yes</option>
                            </select>
                    ';

                    return $html;
                })
                ->addColumn('hidden_fields', function($product){
                  return '
                        <input type="hidden" class="product-id" value="' . $product->id . '">
                        <input type="hidden" class="product-code" value="' . $product->product_id . '">
                        <input type="hidden" class="product-name" value="' . $product->name . '">
                        <input type="hidden" class="product-w" value="' . $product->w . '">
                        <input type="hidden" class="product-l" value="' . $product->l . '">
                        <input type="hidden" class="product-h" value="' . $product->h . '">
                        <input type="hidden" class="product-tpcs" value="' . $product->tpcs . '">
                        <input type="hidden" class="product-sku" value="' . $product->sku . '">
                        <input type="hidden" class="product-weight" value="' . $product->weight . '">
                        <input type="hidden" class="option" value="' . $product->option . '">
                        <input type="hidden" class="type" value="' . $product->type . '">
                        <input type="hidden" class="warehouse" value="' . $product->warehouse . '">
                  ';
                })
               ->rawColumns(['checkbox','sku','photo1','photo2','photo3','photo4','log_status','lc','cost','survey','paisong_siji','ntf_cs','dbt', 'hidden_fields'])
               ->make(true);

    }

    // public function repackProducts(Request $request)
    // {
    //     // $request->user()->is_admin = 1;
    //     // $request->user()->save();
    //     // dd($request->user(), User::all());
    //     // $this->auto_update_log_status();
    //     $perPage = $request->input('perPage', 50);
    //     $logStatus = LogStatus::get();
    //     $products = RepackProduct::orderBy('id', 'desc')->with('customer')
    //     ->selectRaw('*, ROUND(weight, 2) as weight')

    //     ->paginate($perPage);
    //     // dd($products);
    //     return view('repack-products', ['products' => $products, 'logStatus' => $logStatus]);
    // }


    public function handleSearch($searchValue)
    {
        $BKW_C2T = RepackProduct::where('id', 'like', '%' . $searchValue . '%')
            ->orWhere('product_id', 'like', '%' . $searchValue . '%')
            // ->orWhere('name','like', '%'.$searchValue.'%')
            ->with('customer')
            ->selectRaw('*, ROUND(weight, 2) as weight')
            ->get();

        // dd($BKW_C2T);



        return response()->json(['message' => 'Data received successfully', 'repackProducts' => $BKW_C2T]);
    }

    public function getProductData(Request $request)
    {
        // Query to fetch products from the database
        $query = Product::query();

        // Return data as DataTables JSON
        return \DataTables::of($query)
            ->addColumn('photo1', function ($product) {
                // Logic to generate the photo1 column data
                return $product->photo1_url;
            })
            ->addColumn('photo2', function ($product) {
                // Logic to generate the photo2 column data
                return $product->photo2_url;
            })
            ->addColumn('photo3', function ($product) {
                // Logic to generate the photo3 column data
                return $product->photo3_url;
            })
            ->addColumn('photo4', function ($product) {
                // Logic to generate the photo4 column data
                return $product->photo4_url;
            })
            ->toJson();
    }

    public function auto_update_log_status()
    {
        $log_statuses = LogStatus::whereNotIn('id', [6, 8, 9, 15, 17, 18, 10])->get();
        // dd($log_statuses);
        foreach ($log_statuses as $log_status) {
            $hour = $log_status->hours; //contains number of hours 24 , 36 etc
            $currentTime = now();
            $thresholdTime = $currentTime->subHours($hour);


            $repack_products = RepackProduct::where('log_status', $log_status->id)
                ->where('update_log_status_date_time', '<=', $thresholdTime)
                ->get();

                // dd($repack_products);


            foreach ($repack_products as $repack_product) {
                $repack_product->log_status = $repack_product->log_status + 1;
                $repack_product->update_log_status_date_time = now();

                $repack_product->save();
                // dd($repack_product->log_status,$repack_product);

            }
        }
        return;
    }


    public function updateProductImage(Request $request, $id, $attribute)
    {
        $product = Product::where('id', $id)->first();

        if (!$product) {

            return response()->json(['message' => 'Product not found'], 404);

        }

        $allowedAttributes = [
            'photo1',
            'photo2',
            'photo3',
            'photo4'
        ];

        if (!in_array($attribute, $allowedAttributes)) {
            return response()->json(['message' => 'Invalid attribute'], 400);
        }

        if ($request->hasFile($attribute)) {

            $this->handlePhoto($request, $product, $attribute);

            $product->update([$attribute => $product[$attribute]]);

            // return response()->json(['message' => "Product $attribute   updated successfully 1"]);



        }
        return response()->json(['message' => "Product $attribute updated successfully", 'image' => $product[$attribute]]);

    }
}
