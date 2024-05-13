    <!DOCTYPE html>
    <html lang="en">
    <head>
        <base href="/images">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking Form</title>

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            margin: 0; 
            padding: 0; 
        }
        .container {
            max-width: 400px;
            margin: auto;
            padding: 0px;
            background-color: #fff; 
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            box-sizing: border-box;
            display: flex; 
            flex-direction: column; 
            justify-content: center;
            align-items: center; 
            
        }
        .promptpay-container {    
            text-align: center;
        }
        .thai-qr {
            position: relative;
            width: 200px;
            height: 200px;
            margin: -10px auto;
            overflow: hidden;
        }

        .thai-qr img {
            max-width: 100%;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); 
            position: absolute; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            z-index: 1; 
        }

        .promptpay-title, .promptpay-name, .total {
            margin: 10px 0;
        }

        .header-text {
            margin-top:50px;
            font-weight: bold;
            color:#00CCCC;
            font-family: system-ui;
        }

        .name-text {
            font-size: 18px;
        }
        .deposit-text {
            font-size: 18px;
            font-weight: bold;
        }
        .btn-download {
            margin-top: 10px;
            margin-bottom:30px;
            text-align: center;
            font-size:14px;
        }
        .slip-form {
            position: relative;
            margin-top: 40px;
            margin-bottom: 40px;
            width: 35%; 
            left: 50%;
            transform: translateX(-50%);
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 2; 
        }


        .slip-form label {
            font-weight: bold;
        }

        .slip-form input[type="file"] {
            margin-top: 5px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
        }             
        </style>
    </head>
    <body>
        <div class="container">
            <div class="promptpay-container">
                <div>
                    <img src="images/thai_qr_payment.png" alt="PromptPay" style="width:100%; border-radius:20px;">
                    <div class="thai-qr">
                        <img src="{{ asset('images/qrcode/qrcode_' . $booking->booking_ref . '.png') }}" alt="PromptPay QR Code">
                        <img src="images/icon-thaiqr.png" alt="PromtPayIcon" style="width:25%;">
                    </div>
                </div>    

                <p class="header-text">สแกน QR เพื่อโอนเข้าบัญชี</p>
                <p class="name-text">ชื่อ: {{$bank->account_name}}</p>
                <p class="deposit-text">{{ number_format($booking->room->deposit, 2, '.', ',') }} BAHT</p>
            </div>
            <a href="{{ asset('images/qrcode/qrcode_' . $booking->booking_ref . '.png') }}" class="btn btn-outline-info btn-download" target="_blank" download>DOWNLOAD QRCODE</a>  
        </div>

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
            <form action="{{route('payment_booking',$booking->id)}}" method="POST" enctype="multipart/form-data" class="slip-form">
                @csrf
                    <div class="form-group">
                        <label for="slip">แนบหลักฐานการชำระเงิน</label>
                        <input type="file" class="form-control-file" id="slip" name="slip" accept="image/*" required>
                    </div>
                    <a class="btn btn-outline-dark" href="{{route('all_booking')}}">Back</a>
                    <button type="submit" class="btn btn-primary" ">Submit</button>
            </form>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script>
            $(document).ready(function() {
                $('form').submit(function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure to submit slip?",
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: "Yes, I'm sure",
                        denyButtonText:  "No, not sure",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).unbind('submit').submit();
                        } else if (result.isDenied) {
                            Swal.fire("Payment are not success ", "", "info");
                        }
                    });
                });
    
                if ($('.alert-success').length) {
                    Swal.fire({
                        title: "Payment Successfully!",
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
