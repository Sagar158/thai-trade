<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\LogStatus;
use App\Models\RepackProduct;

class Helper{
    public static function updateStatus()
    {
        $logStatuses = LogStatus::whereNotNull('hours')->get();

        $ekOption = [1,2,3,4,5,6,7,8,9];

        $seaOption = [10,11,12,13,14,15,16,17,18];

        foreach ($logStatuses as $logStatus)
        {
            $repackProducts = RepackProduct::where('log_status', $logStatus->id)->where('manually_status_changed',false)->get();

            foreach ($repackProducts as $product)
            {
                $targetTime = $product->update_log_status_date_time ?? $product->updated_at;
                $targetTimeCarbon = Carbon::createFromFormat('Y-m-d H:i:s', $targetTime);

                $hoursPassed = $targetTimeCarbon->diffInHours(Carbon::now());

                if ($hoursPassed >= $logStatus->hours)
                {
                    $nextStatus = LogStatus::find($logStatus->id + 1);

                    if ($product->option == 'EK')
                    {
                        if (in_array($nextStatus->id, $ekOption))
                        {
                            $product->log_status = $nextStatus->id;
                            $product->updated_at = Carbon::now();
                            $product->update_log_status_date_time = Carbon::now();
                            $product->save();
                        }
                    }
                    elseif ($product->option == 'SEA')
                    {
                        if (in_array($nextStatus->id, $seaOption))
                        {
                            $product->log_status = $nextStatus->id;
                            $product->updated_at = Carbon::now();
                            $product->update_log_status_date_time = Carbon::now();
                            $product->save();
                        }
                    }
                }
            }
        }
    }
}

?>
