<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\BillBooking;
use App\Models\Booking;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Farzai\PromptPay\Generator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Notifications\CompletedBooking;


class BookingController extends Controller
{
    public function booking_room($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // แยกชื่อและนามสกุล
        $nameParts = explode(' ', $user->name);
        $first_name = $nameParts[0];
        $last_name = implode(' ', array_slice($nameParts, 1));
        
        $userArray = [
            'first_name' => $first_name,
            'last_name' => $last_name
        ];

        $room = Room::find($id);

        return view('home.booking_room', compact('user','userArray','room'));
    }

    public function add_booking(Request $request, $id)
    { 
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|numeric', 
            'gender'=> 'required|in:Male,Female',
            'move_in_date' => 'required|date',
        ]);

        $booking = new Booking;

        $booking->user_id = Auth::user()->id;
        $booking->room_id = $id;
        $booking->first_name = $request->first_name;
        $booking->last_name = $request->last_name;
        $booking->phone = $request->phone;
        $booking->gender = $request->gender;
        $booking->booking_channel = 0;
        $booking->move_in_date = $request->move_in_date;
        $booking->status = 0; 
        $booking->save();
        
        return redirect()->back()->with('success', 'Booking Room Successfully');
    }

    public function edit_booking($id)
    {
        $booking = Booking::find($id);
        
        return view('home.edit_booking', compact('booking'));
    }

    public function update_booking(Request $request, $id)
    {
        
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|numeric', 
            'gender'=> 'required|in:Male,Female',
            'move_in_date' => 'required|date',
        ]);

        $booking = Booking::find($id);

        $booking->first_name = $request->first_name;
        $booking->last_name = $request->last_name;
        $booking->phone = $request->phone;
        $booking->gender = $request->gender;
        $booking->move_in_date = $request->move_in_date;
        $booking->save();
        
        return redirect()->back()->with('success', 'Edit Booking Successfully');
    }

    public function cancel_booking($id)
    {
        $booking = Booking::find($id);

        $booking->status = '3';
        $booking->save();

        return redirect()->back();
    }

    
    public function payment_form($id)
    {
        $booking = Booking::find($id);
        $bank = BankAccount::where('bank_name', 'PP')->first();
        $promtpay = $bank->account_no;
        $promtpay = substr_replace($bank->account_no, '-', 3, 0);
        $promtpay = substr_replace($promtpay, '-', 7, 0);
        
        $generator = new Generator();
        $qrCode = $generator->generate(
            target: $promtpay, 
            amount: $booking->room->deposit,
        );

        $qrCodeimg = public_path('images/qrcode/qrcode_' . $booking->booking_ref . '.png');
        $qrCode->save($qrCodeimg);

        return view('home.payment_form', compact('booking','bank', 'qrCodeimg'));
    }

    public function payment_booking(Request $request, $id)
    {
        $booking = Booking::find($id);
        $booking->status = '1';

        $booking->save();

        $bill = new BillBooking();
        $bill->booking_id = $booking->id;
        $bill->deposit = $booking->room->deposit;
        $slipName = 'slip_' . $booking->booking_ref . '.png';
        $slipPath = $request->file('slip')->storeAs('/public/images/slip', $slipName);
        $bill->slip = 'images/slip/' . $slipName;

        $bill->booking_receipt_ref = $booking->ref;
    
        $bill->save();

        return redirect()->back()->with('success', 'Payment Successfully');

    }


}
