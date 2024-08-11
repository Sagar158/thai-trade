<?php

namespace App\Http\Controllers;

use App\Models\LogStatus;
use Illuminate\Http\Request;
use App\Models\RepackProduct;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RepackDataUpdate extends Controller
{

    public function update(Request $request, $id, $attribute)
    {

        $product = RepackProduct::where('id', $id)->first();

        // Log::debug($product);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Check if the attribute is allowed to be updated
        $allowedAttributes = [
            'product_id',
            'cs_did',
            'name',
            'photo1',
            'photo2',
            'photo3',
            'photo4',
            'video',
            'sku',
            'warehouse',
            'option',
            'w',
            'l',
            'h',
            'weight',
            'tpcs',
            'packageid',
            'remarks',
            'type',
            'repack',
            'bill_id',
            'ct_id',
            'log_status',
            'lc',
            'print',
            'cost',
            'dbt',
            'ntf_cs',
            'paisong_siji',
            'survey',
            'manually_status_changed'
        ];

        if (!in_array($attribute, $allowedAttributes)) {
            return response()->json(['message' => 'Invalid attribute'], 400);
        }



        if ($request->hasFile($attribute)) {
            $this->handlePhoto($request, $product, $attribute);
            $product->update([$attribute => $product[$attribute]]);
            // return response()->json(['message' => "Product $attribute   updated successfully 1"]);

        } else if ($attribute ==  "dbt") {
            $product->update([$attribute => "Started: " . now()]);
            // return response()->json(['message' => "Product $attribute   updated successfully 2"]);

        } else if ($attribute ==  "log_status") {
            $product->manually_status_changed = true;
            $product->update_log_status_date_time = now();

            // dd($request->input($attribute));
            if ($request->input($attribute) == 7 || $request->input($attribute) == 14 || $request->input($attribute) == 9 || $request->input($attribute) == 18) {

                $finishTime = now();
                $startTime = now();
                $startTimeString  = $product->dbt;
                // dd($request->input($attribute));

                if (strpos($startTimeString, "Started: ") === 0) {
                    $startTime = substr($startTimeString, strlen("Started: "));
                    $durationInSeconds = $finishTime->diffInSeconds($startTime);
                    $days = floor($durationInSeconds / (3600 * 24));
                    $hours = floor(($durationInSeconds % (3600 * 24)) / 3600);
                    $minutes = floor(($durationInSeconds % 3600) / 60);
                    $seconds = $durationInSeconds % 60;
                    $formattedDuration = sprintf('%dd %02d:%02d:%02d', $days, $hours, $minutes, $seconds);

                    // $product->update(["dbt" => "Finished: " . $formattedDuration, $attribute => $request->input($attribute), "status_changer_id" => auth()->id()]);
                    $product->dbt = "F: " . $formattedDuration;
                    $product->status_changer_id = auth()->id();
                    $product->$attribute =  $request->input($attribute);
                    $product->update_log_status_date_time = now();
                    $product->save();
                } else {
                    // return response()->json(['message' => "Product $attribute   updated successfully 3"]);

                    try {
                        // $product->update([$attribute => $request->input($attribute)]);
                        $product->$attribute =  $request->input($attribute);
                    $product->update_log_status_date_time = now();

                        $product->save();
                    } catch (\Exception $e) {
                        // Handle the exception
                        Log::info($e);
                        return response()->json(['error' => 'An error occurred while updating the product.'], 500);
                    }
                }
            } else {
                try {
                    // $product->update([$attribute => $request->input($attribute)]);
                    $product->$attribute =  $request->input($attribute);
                    $product->update_log_status_date_time = now();

                    $product->save();
                } catch (\Exception $e) {
                    // Handle the exception
                    Log::info($e);

                    return response()->json(['error' => 'An error occurred while updating the product.'], 500);
                }
            }
        } else {
            try {
                // $product->update([$attribute => $request->input($attribute)]);
                $product->$attribute =  $request->input($attribute);
                $product->update_log_status_date_time = now();

                $product->save();
            } catch (\Exception $e) {
                // Handle the exception
                Log::info($e);

                return response()->json(['error' => 'An error occurred while updating the product.'], 500);
            }
        }

        // Log::debug($product);

        return response()->json(['message' => "Product $attribute updated successfully", 'image' => $product[$attribute]]);
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

    public function bill_id_status(Request $request)
    {
        $log_status = LogStatus::where('name', 'S1')->first();

        // Check if RepackProduct with the given bill_id exists
        $repackProduct = RepackProduct::where('bill_id', $request->bill_id)->first();

        if ($repackProduct) {
            // Update the log_status of the RepackProduct
            $repackProduct->update(['log_status' => $log_status->id, 'update_log_status_date_time' => now()]);
        } else {
            // Handle case where RepackProduct with the given bill_id doesn't exist
            // You could return a response indicating failure or redirect with an error message
            return redirect()->back()->with('error', 'RepackProduct not found for the given bill ID');
        }

        // Redirect back with success message or without any message
        return redirect()->back()->with('success', 'Log status updated successfully');
    }

    public function ctid_lc_change(Request $request)
    {
        // dd($request->all());
        $repackProduct = RepackProduct::where('ct_id', $request->ci_id)->update(['lc' => $request->lc_new, 'log_status' => $request->logStatus, 'update_log_status_date_time' => now()]);
        // // dd($repackProduct);

        // $repackProduct->lc = $request->lc_new;
        // // dd($repackProduct);

        // $repackProduct->save();
        // dd($repackProduct);

        return redirect()->back()->with('success', 'Log status and LC updated successfully');
    }
}
