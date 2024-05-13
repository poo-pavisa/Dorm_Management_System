<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Room;
use App\Models\RoomGallery;
use App\Models\Booking;
use App\Models\Dormitory;
use App\Models\User;
use App\Models\ElectricityType;
use App\Models\WaterType;
use App\Models\ContractRent;
use App\Models\Tenant;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PDF;


class HomeController extends Controller
{
    public function index()
    {
        if(Auth::id())
        {
            $role = Auth()->user()->role;

            if($role == 'User' || $role == 'Tenant')
            {
                $rooms = Room::where('is_available', 1)
                                ->orderBy('room_no')
                                ->paginate(6);

                $dorms = Dormitory::all();


                return view('home.index', compact('rooms','dorms'));
            }

            else if($role == 'Admin')
            {
                return Redirect::to('/nova');
            }

            else
            {
            return redirect()->back();  
            }
        }
    }

    public function home()
    {
        $rooms = Room::where('is_available', 1)
                            ->orderBy('room_no')
                            ->paginate(6);

        $dorms = Dormitory::all();


        return view('home.index', compact('rooms','dorms'));
    }

    public function all_room()
    {
        $rooms = Room::where('is_available', 1)
                        ->orderBy('room_no')
                        ->paginate(6);

        $dorms = Dormitory::all();

        return view('home.all_room', compact('rooms','dorms'));
    }

    public function information()
    {
        $banks = BankAccount::all();
        $dorms = Dormitory::all();
        $electric = ElectricityType::first();
        $water = WaterType::first();


        return view('home.information',compact('banks','dorms','electric','water'));
    }

    public function all_booking()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        $user = Auth::user();

        $bookings = Booking::where('user_id', $user->id)
                            ->orderBy('move_in_date')
                            ->paginate(8);

        $dorms = Dormitory::all();

        
        return view('home.all_booking', compact('bookings','dorms'));
    }
    

    public function room_detail($id)
    {
        $room = Room::find($id);
        $galleries = RoomGallery::where('room_id', $id)
                                ->where('is_published', 1)
                                ->orderBy('sort_order')
                                ->get();

        $assets = Asset::where('room_id', $id)
                                ->where('is_published', 1)
                                ->get();
        
        $dorms = Dormitory::all();

        return view('home.room_detail', compact('room','galleries','assets','dorms'));
    }

    public function DownloadContract($id)
    {
        
        $tenant = Tenant::findOrFail($id);
        $contracts = ContractRent::where('tenant_id', $tenant->id)->first();

        $data = [
            'date' => date('m/d/Y'),
            'tenant' => $tenant,
            'contracts' => $contracts,
        ]; 
            
        $pdf = PDF::loadView('contract.complete', $data);
        
        return $pdf->download('contract.complete');
    }
    

    // public function Check_In_Availability(Request $request)
    // {
    //     $roomId = $request->room_id;
    //     $checkInDate = $request->check_in_date;

    //     // ตรวจสอบว่ามีการจองห้องในวันที่เลือกหรือไม่
    //     $isBooked = Booking::where('room_id', $roomId)
    //         ->where('check_in_date', '<=', $checkInDate)
    //         ->where('check_out_date', '>', $checkInDate)
    //         ->exists();

    //     return response()->json(['is_booked' => $isBooked]);
    // }

    // public function Check_Out_Availability(Request $request)
    // {
    //     $roomId = $request->room_id;
    //     $checkOutDate = $request->check_out_date;

    //     // ตรวจสอบว่ามีการจองห้องในวันที่เลือกหรือไม่
    //     $isBooked = Booking::where('room_id', $roomId)
    //         ->where('check_in_date', '<', $checkOutDate)
    //         ->where('check_out_date', '>=', $checkOutDate)
    //         ->exists();

    //     return response()->json(['is_booked' => $isBooked]);
    // }




}
