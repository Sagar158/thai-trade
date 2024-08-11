<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RepackProduct;

class PrintController extends Controller
{
    public function generatePDF(Request $request)
    {
        $request->validate([
            'selectedRowsSku' => 'nullable',
            'selectedRows' => 'nullable',
            'ctid' => 'nullable',
        ]);
        $selectedRows = $request->input('selectedRows', []);
        $repackProducts = RepackProduct::whereIn('id', $selectedRows)->orderBy('id', 'desc')->with('customer')->get()->groupBy('product_id');

        foreach ($repackProducts as $productId => $products) {
            $count = 0;
            foreach ($products as $product) {
                if ($count < 5) {
                    $product->update([
                        'print' => 'yes',
                        'print_time' => now(),
                        'print_by' => auth()->user()->id
                    ]);
                    $count++;
                } else {
                    // Remove excess items from the collection
                    $products->forget($product->id);
                }
            }
        }

        return view('print', ['repackProducts' => $repackProducts]);
    }
}
