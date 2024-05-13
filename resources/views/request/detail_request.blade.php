<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Request</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status {
            padding: .4rem 0;
            border-radius: 2rem;
            text-align: center;
        }
        .status.pending {
            background-color: #ebc474;
        }

        .status.in-progress {
            background-color: #6fcaea;
        }
        .status.completed {
            background-color: #86e49d;
            color: #006b21;
        }

        img.profile-img {
            border-radius: 50%; 
            max-width: 50px; 
            height: auto;
            top: 15px;
            left: 10px;
            margin-right: 10px;
        }


    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card mb-5 mx-auto" style="max-width: 500px;">
        <div class="card-body">
            <h2 class="card-title text-center text-2xl font-bold mb-5">{{$data->request_ref}}</h2>
            <div class="mb-3">
                <strong class="form-label">Room No : </strong> Room {{$data->room->room_no}}
            </div>
            <div class="mb-3">
                <strong class="form-label">Subject : </strong> {{$data->subject}}
            </div>
            <div class="mb-3">
                <strong class="form-label">Detail : </strong>{{$data->detail}}
            </div>
            <div class="mb-3">
                <strong class="form-label">Due Date : </strong> {{\Carbon\Carbon::parse($data->due_date)->toDayDateTimeString() }}
            </div>
            <div class="mb-3">
                <strong class="form-label">Status : </strong>
                <strong class="status @if($data->status == 'Pending') pending @elseif($data->status == 'In Progress') in-progress  @elseif($data->status == 'Completed') completed @endif">{{$data->status}}</strong>
            </div>

            <div class="border-top border-gray-200 mt-4 pt-4">
                <h3 class="text-lg font-bold mb-3">Reply</h3>
        @if($replies === null)
                <div class="bg-light p-3 rounded-lg">
                    <p class="text-muted mb-2">No reply yet.</p>
                </div>
            </div>
        @else
            <div class="comment-item mb-3">
                <div class="d-flex align-items-center">
                    <img src="{{ $replies->admin->profile_photo_path ? asset('storage/' . $replies->admin->profile_photo_path) : asset('images/avatar.png') }}" class="profile-img mt-1">
                    <div>
                        <small class="text-muted mb-0">{{\Carbon\Carbon::parse($replies->created_at)->toFormattedDateString() }}</small>
                        <p class="text-muted mb-0" style="color:black;">{{$replies->content}}</p>
                    </div>
                </div>
            </div>
        @endif
        <a class ="btn btn-sm btn-primary" style ="margin-top:10px;" href="{{route('all_request')}}">Back</a>
        </div>
    </div>
</div>

</body>
</html>
