<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบฟอร์มแจ้งปัญหาหอพัก</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        <form action="{{route('add_request')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="room_no">Room No</label>
                
                <input type="text" class="form-control" id="room_no" name="room_no" value="{{$tenant->room->room_no}}" readonly>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            <div class="form-group">
                <label for="detail">Detail</label>
                <textarea class="form-control" id="detail" name="detail" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input type="datetime-local" class="form-control" id="due_date" name="due_date" required>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            
            

            <div class="btn-container">
                <a class="btn btn-dark btn-back" href="{{route('all_request')}}">Back</a>
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script> 
        $(function(){
            var dtToday = new Date();
            dtToday.setDate(dtToday.getDate() + 1);
        
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
        
            if(month < 10)
                month = '0' + month.toString();
        
            if(day < 10)
                day = '0' + day.toString();
        
            var minDate = year + '-' + month + '-' + day + 'T00:00';
            $('#due_date').attr('min', minDate);
        });

        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure to submit this request?",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Yes, I'm sure",
                    denyButtonText:  "No, not sure",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).unbind('submit').submit();
                    } else if (result.isDenied) {
                        Swal.fire("Request submitted are not success ", "", "info");
                    }
                });
            });

            if ($('.alert-success').length) {
                Swal.fire({
                    title: "Request Submitted Successfully!",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1000 
                }).then(() => {
                    setTimeout(function() {
                        window.location.href = "{{ route('all_request') }}";
                    }, 1000);
                });
            }

        });

        
    </script>
        
        

</body>
</html>
