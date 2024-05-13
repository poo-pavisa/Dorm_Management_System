<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant;
use App\Models\Dormitory;
use App\Models\ServiceRequest;
use App\Models\Room;
use App\Models\Reply;
use Carbon\Carbon;


class RequestController extends Controller
{
    public function all_request()
    {
        $requests = ServiceRequest::all();
        $dorms = Dormitory::all();

        return view('request.all_request',compact('requests','dorms'));
        
    }

    public function request_form()
    {
        $user = Auth::user();
        $tenant = Tenant::where('user_id', $user->id)->first();

        return view('request.request_form', compact('tenant'));
    }

    public function add_request(Request $request)
    {
        $request->validate([
            'room_no' => 'required|numeric',
            'subject' => 'required|string',
            'detail' => 'required|string',
            'due_date' => 'required|date',
        ]);
        $room = Room::where('room_no', $request->room_no)->first();
        

        $data = new ServiceRequest;

        $data->room_id = $room->id;
        $data->subject = $request->subject;
        $data->detail = $request->detail;
        $data->due_date = $request->due_date;

        if ($request->hasFile('image')) {
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $currentDate = Carbon::now()->format('Ymd_His');
        $filename = 'request_'. $currentDate . '.' . $extension;
        $path = $file->storeAs('/images/request', $filename, 'public');
        $data->image = $path;
        }

        $data->status = 'Pending';

        $data->save();

        return redirect()->back()->with('success', 'Request Submitted Successfully');
    }

    public function delete_request($id)
    {
        $data = ServiceRequest::find($id);

        $data->delete();

        return redirect()->back()->with('success', 'Request Deleted Successfully');
    }

    public function detail_request($id)
    {
        $data = ServiceRequest::find($id);
        $replies = Reply::where('service_request_id', $data->id)->first();

        return view ('request.detail_request' , compact('data','replies'));
    }
    
}
