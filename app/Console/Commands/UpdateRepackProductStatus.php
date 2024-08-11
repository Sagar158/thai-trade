<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use App\Models\LogStatus;
use App\Models\RepackProduct;
use Illuminate\Console\Command;

class UpdateRepackProductStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repack:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the status of repack products based on LogStatus hours and timings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logStatuses = LogStatus::get();

        $ekOption = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $seaOption = [10, 11, 12, 13, 14, 15, 16, 17, 18];

        foreach ($logStatuses as $logStatus) {

            $repackProducts = RepackProduct::where('log_status', $logStatus->id)->get();

            foreach ($repackProducts as $product) {
                $targetTime = $product->update_log_status_date_time ?? $product->updated_at;
                $targetTimeCarbon = Carbon::createFromFormat('Y-m-d H:i:s', $targetTime);
                $hoursPassed = $targetTimeCarbon->diffInHours(Carbon::now());

                if (!empty($logStatus->hours) && ($hoursPassed >= $logStatus->hours))
                {
                    $nextStatus = LogStatus::where('id', '>', $logStatus->id)->orderBy('id', 'asc')->first();

                    if (isset($nextStatus->hours))
                    {
                        if ($product->option == 'EK' && in_array($nextStatus->id, $ekOption))
                        {
                            $product->log_status = $nextStatus->id;
                        }
                        elseif ($product->option == 'SEA' && in_array($nextStatus->id, $seaOption))
                        {
                            $product->log_status = $nextStatus->id;
                        }

                        // Update timestamps only if the status was changed
                        if ($product->isDirty('log_status')) {
                            $product->updated_at = Carbon::now();
                            $product->update_log_status_date_time = Carbon::now();
                            $product->save();
                        }
                    }
                }
                else
                {
                    $nextStatus = LogStatus::where('id', '>', $logStatus->id)->orderBy('id', 'asc')->first();

                    if (isset($nextStatus->hours))
                    {
                        $targetTimeCarbon = Carbon::createFromFormat('Y-m-d H:i:s', $targetTime);
                        $hoursPassed = $targetTimeCarbon->diffInHours(Carbon::now());

                        if ($hoursPassed >= $nextStatus->hours)
                        {
                            if ($product->option == 'EK' && in_array($nextStatus->id, $ekOption))
                            {
                                $product->log_status = $nextStatus->id;
                            }
                            elseif ($product->option == 'SEA' && in_array($nextStatus->id, $seaOption))
                            {
                                $product->log_status = $nextStatus->id;
                            }

                            // Update timestamps only if the status was changed
                            if ($product->isDirty('log_status'))
                            {
                                $product->updated_at = Carbon::now();
                                $product->update_log_status_date_time = Carbon::now();
                                $product->save();
                            }
                        }
                    }
                }
            }
        }

        $this->info('Repack product statuses updated successfully.');
    }
}
