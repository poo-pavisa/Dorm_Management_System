<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WaterMeter;
use App\Models\ElectricityMeter;
use App\Models\WaterType;
use App\Models\ElectricityType;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\Tenant;
use Carbon\Carbon;


class CreateNewInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new invoice ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $waterMeters = WaterMeter::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        $electricityMeters = ElectricityMeter::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();

        // สร้างคอลเลคชันเพื่อเก็บ room_id ของห้องที่มีการวัดทั้งน้ำและไฟฟ้า
        $roomsWithMeters = collect();
        foreach ($waterMeters as $waterMeter) {
            $room_id = $waterMeter->room_id;
            $electricityMeter = ElectricityMeter::where('room_id', $room_id)
                                                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                                ->first();
            if ($electricityMeter) {
                $roomsWithMeters->push($room_id);
            }
        }

        foreach ($roomsWithMeters as $room_id) {
            $room = Room::find($room_id);
            if ($room) {
                $tenant = Tenant::where('room_id', $room_id)->first();
                if ($tenant) {
                    $invoice = new Invoice();
                    $invoice->tenant_id = $tenant->id;
                    $invoice->room_rate = $room->monthly_rate;

                    $waterMeter = WaterMeter::where('room_id', $room_id)
                                            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                            ->first();
                    if ($waterMeter) {
                        // ค้นหาประเภทน้ำ
                        $waterType = WaterType::find($waterMeter->water_type_id);
                        if ($waterType) {
                            if ($waterType->type === 'Flat Rate') {
                                $invoice->water_rate = $waterType->price_per_unit; 
                            } elseif ($waterType->type === 'Base On Meter') {
                                $invoice->water_rate = $waterType->price_per_unit * $waterMeter->quantity_consumed;
                            }
                        }
                    } else {
                        $invoice->water_rate = 0;
                    }

                    $electricityMeter = ElectricityMeter::where('room_id', $room_id)
                                                        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                                        ->first();
                    if ($electricityMeter) {
                        $electricityType = ElectricityType::find($electricityMeter->electricity_type_id);
                        if ($electricityType) {
                            if ($electricityType->type === 'Flat Rate') {
                                $invoice->electricity_rate = $electricityType->price_per_unit; 
                            } elseif ($electricityType->type === 'Base On Meter') {
                                $invoice->electricity_rate = $electricityType->price_per_unit * $electricityMeter->quantity_consumed;
                            }
                        }
                    } else {
                        $invoice->electricity_rate = 0;
                    }

                    $invoice->total_amount = $invoice->room_rate + $invoice->water_rate + $invoice->electricity_rate;
                    $invoice->status = 0;
                    $invoice->is_published = 0;

                    $invoice->save();
                }
            } 
        }
        $this->info('Invoices created successfully.');
    }
}