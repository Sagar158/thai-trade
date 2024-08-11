<?php



namespace App\Http\Controllers;



use App\Models\Product;

use Illuminate\Http\Request;

use App\Models\RepackProduct;

use Illuminate\Support\Facades\Log;

use App\Models\RepackProductWithProduct;



class RepackDeleteController extends Controller

{

    public function deleteRepackProduct(Request $request)

    {

        $request->validate([

            'selectedRowsSku' => 'nullable',

            'selectedRows' => 'nullable',

        ]);



        $selectedRows = $request->input('selectedRows');

        foreach ($selectedRows as $productId) {

            $repackProduct = RepackProduct::where('id', '=', $productId)->first();

            $selectedRowsSku = explode(',', $repackProduct->products);

            // Log::debug($selectedRows);

            foreach ($selectedRowsSku as $p) {

                $product = Product::where('sku', '=', $p)->first();

                if ($product) {

                    $product->update(['bill_id' => '']);

                }

            }

            if ($repackProduct) {

                $repackProduct->delete();

            }

        }

        return response()->json(['message' => "Product deleted successfully"]);

    }



    public function updateCtIdRepackProduct(Request $request)

    {

        $request->validate([

            'selectedRowsSku' => 'nullable',

            'selectedRows' => 'nullable',

            'ctid' => 'nullable',

        ]);

        // Log::debug($request);

        $selectedRows = $request->input('selectedRows');

        foreach ($selectedRows as $productId) {

            $repackProduct = RepackProduct::where('id', '=', $productId)->first();

            if ($repackProduct) {

                $repackProduct->update(['ct_id' => $request->input('ctid')]);

            }

        }

        return response()->json(['message' => "Product deleted successfully"]);

    }

}

