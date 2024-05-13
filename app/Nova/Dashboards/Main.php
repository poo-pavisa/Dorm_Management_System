<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;
use App\Models\Bill;
use App\Models\BillBooking;
use App\Models\EntranceFee;
use App\Models\Room;
use App\Models\Booking;
use App\Nova\Metrics\UsersPerRole;
use App\Nova\Metrics\TotalIncome;
use App\Nova\Metrics\TotalBooking;
use App\Nova\Metrics\TotalRoom;
use Coroowicaksono\ChartJsIntegration\PieChart;
use Coroowicaksono\ChartJsIntegration\DoughnutChart;
use Llaski\NovaScheduledJobs\Card as NovaScheduledJobsCard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */

    
    public function cards()
    {
        $totalBill = Bill::sum('amount');
        $totalBillBooking = BillBooking::sum('deposit');
        $totalEntranceFee = EntranceFee::sum('sum_payable');
        $availableRoom = Room::where('is_available' ,1)->count();
        $unavailableRoom = Room::where('is_available' ,0)->count();
        $onlineBooking = Booking::where('booking_channel',0)->count();
        $walkingBooking = Booking::where('booking_channel' ,1)->count();

        return [
            (new PieChart())
                ->title('Total Income')
                ->series(array([
                    'data' => [$totalBill, $totalBillBooking, $totalEntranceFee],
                    'backgroundColor' => ["#ffcc5c","#6f69ff","#ff6f69"],
                ]))
                ->options([
                    'xaxis' => [
                        'categories' => ['Reservation Fee','Security Deposit ','Total Expenses of Each Room']
                    ],
                ])->width('2/3'),
            TotalIncome::make(),

            (new DoughnutChart())
            ->title('Room Availability Overview')
            ->series(array([
                'data' => [$availableRoom, $unavailableRoom],
                'backgroundColor' => ["#88d8b0","#ff6f69",],
            ]))
            ->options([
                'xaxis' => [
                    'categories' => ['Available','Unavailable']
                ],
            ])->width('2/3'),
            TotalRoom::make(),

            (new DoughnutChart())
            ->title('Booking Channel')
            ->series(array([
                'data' => [$onlineBooking, $walkingBooking],
                'backgroundColor' => ["#6f69ff","#ffcc5c"],
            ]))
            ->options([
                'xaxis' => [
                    'categories' => ['Online','Walk-In']
                ],
            ])->width('2/3'),
            TotalBooking::make(),

            UsersPerRole::make(),
            
            new NovaScheduledJobsCard,


        ];
    }

    public function name()
    {
        return 'Dashboard';
    }


}
