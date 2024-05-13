<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/images">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            margin-top: 50px;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        form-group {
        width: 100%;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-top: 20px;
        }

        .btn-back {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div>
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session()->get('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        
        @if($errors)

            @foreach($errors->all() as $errors)
                <li style="color:red;">
                    {{$errors}}
                </li>
            @endforeach

        @endif
        <form action="{{ route('add_booking', $room->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name"  value="{{ $userArray['first_name'] }}" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $userArray['last_name'] }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required >
            </div>
            <div class="form-group">
                <label>Gender</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="Male" value="Male" required>
                    <label class="form-check-label" for="Male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="Female" value="Female" required>
                    <label class="form-check-label" for="Female">Female</label>
                </div>
            </div>
            <div class="form-group">
                <label for="move_in_date">Move In Date</label>
                <input type="date" class="form-control" id="move_in_date" name="move_in_date" required>
            </div>
            
            

            <div class="btn-container">
                <a class="btn btn-dark btn-back" href="{{route('room_detail',$room->id)}}">Back</a>
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(function(){
            var dtToday = new Date();
            var dtMax = new Date();
            dtMax.setDate(dtMax.getDate() + 2);
    
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
    
            var maxMonth = dtMax.getMonth() + 1;
            var maxDay = dtMax.getDate();
            var maxYear = dtMax.getFullYear();
    
            if(month < 10)
                month = '0' + month.toString();
    
            if(day < 10)
                day = '0' + day.toString();
    
            if(maxMonth < 10)
                maxMonth = '0' + maxMonth.toString();
    
            if(maxDay < 10)
                maxDay = '0' + maxDay.toString();
    
            var minDate = year + '-' + month + '-' + day;
            var maxDate = maxYear + '-' + maxMonth + '-' + maxDay;
    
            $('#move_in_date').attr('min', minDate);
            $('#move_in_date').attr('max', maxDate);

        });

        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure to booking this room?",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Yes, I'm sure",
                    denyButtonText:  "No, not sure",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).unbind('submit').submit();
                    } else if (result.isDenied) {
                        Swal.fire("Booking are not success ", "", "info");
                    }
                });
            });

            if ($('.alert-success').length) {
                Swal.fire({
                    title: "Booking Successfully!",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1000 
                }).then(() => {
                    setTimeout(function() {
                        window.location.href = "{{ route('all_booking') }}";
                    }, 1000);
                });
            }

        });
        
        
    </script>
    
</body>
</html>
