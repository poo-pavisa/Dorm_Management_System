<!DOCTYPE html>
<html lang="en">
   <head>
        <base href="/images">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">    
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            .slideshow{
                max-width: 1500px;
                max-height: 250px;
                margin: 0 auto;
                margin-top: 100px;
                position: relative;
                left: 0;
            }
            .items {
                max-width: 1500px;
                max-height: 250px;
                padding: 10px;
                overflow :hidden;
            }
            .items img {
                width: 1500px;
                height: 250px;
                object-fit: cover;
            }

            .slideshow .slick-prev {
                position: absolute;
                top: 150px;
                left: 20px;
                z-index: 10;
            }
            .slideshow .slick-next {
                position: absolute;
                top: 150px;
                right: 20px;
                z-index: 10;
            }
            .slideshow .slick-arrow {
                z-index: 10;
                width:30px;
                height:30px;
                display:flex;
                justify-content: center;
                align-items: center;
                border-radius: 50%;
                border: none;
                outline: none;
            }
            .slideshow .slick-dots {
                position: absolute;
                bottom:10px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
            }

            .slideshow .slick-dots li {
                list-style: none;
                margin : 0 2px;
                width: 10px;
                height: 10px;
                background: white;
                border-radius: 50%;
            }
            .slideshow .slick-active {
                background: white !important; 
            }
            .fullscreen {
                display: none;
                background-color: rgba(0, 0, 0, 0.9);
                position: fixed;
                z-index: 1000;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
            }

            .fullscreen-content {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                display: block;
                width: 700px;
                height: 500px;
                max-width: 100%;
                max-height: 100%; 
            }


            .close {
                color: #fff;
                position: absolute;
                top: 15%;
                right: 29%;
                font-size: 50px;
                font-weight: bold;
                transition: 0.3s;
                cursor: pointer;
            }

            .close:hover,
            .close:focus {
                color: #bbb;
                text-decoration: none;
                cursor: pointer;
            }
            label{
            display: inline-block;
            width:200px;
            }

            input {
                width: 100%;
            }
            
        </style>
        @include('home.css')
        
   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#"/></div>
      </div>
      <!-- end loader -->
      <!-- header -->
      <header>
        @include('home.header')
      </header>

      <div  class="our_room">
        <div class="container">
           <div class="row">
              <div class="col-md-12">
                 <div class="titlepage">
                    <h2>Detail Room</h2>
                 </div>
              </div>
           </div>
    
          
           <div class="row">

            <div class="col-md-8 ">
                <div id="serv_hover" class="room">
                    <div style="padding:20px" class="room_img">
                        <figure><img style="height: 300px; width:800px;" src="{{ asset('storage/' . $room->image) }}" alt="#"/></figure>
                    </div>
                    <div class="bed_room">
                        <h2>Room {{ $room->room_no }}</h2>
                        <p style="padding: 12px">{{ $room->detail }}</p>
                        <h4 style="padding: 12px">{{ number_format($room->daily_rate, 0, '.', ',') }} THB Per Day / {{ number_format($room->monthly_rate, 0, '.', ',') }} THB Per Month  </h4>
                        <h4 style="padding: 12px">Deposit : {{ number_format($room->deposit, 0, '.', ',') }} THB</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <h1 style= "font-size:40px!important">Book Room</h1>

                <div>
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{session()->get('success')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{session()->get('error')}}
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

                <form action="{{route('add_booking' , $room->id ) }}" method="POST">
                    @csrf
                <div>
                    <label>First Name</label>
                    <input type="text" name="first_name" required>
                </div>
                <div>
                    <label>Last Name</label>
                    <input type="text" name="last_name" required>
                </div>


                <div>
                    <label>Phone</label>
                    <input type="number" name="phone" required>
                </div>

                <div style="display: flex; align-items: center; margin-top:15px; margin-bottom:15px;">
                    <div class="form-check form-check-inline" style="margin-left:50px;">
                        <input class="form-check-input" type="radio" name="booking_type" id="inlineRadio1" value="daily" required>
                        <label class="form-check-label" for="inlineRadio1"  >Daily</label>
                    </div>
                    <div class="form-check form-check-inline" style="margin-left:-140px;">
                        <input class="form-check-input" type="radio" name="booking_type" id="inlineRadio2" value="monthly" required>
                        <label class="form-check-label" for="inlineRadio2" >Monthly</label>
                    </div>
                </div>                
                


                <div>
                    <label>Check In Date</label>
                    <input type="date" name="check_in_date" id="check_in_date" required>
                </div>

                <div class="monthly-booking" style="display: none;">
                    <div>
                        <label>Number of Months</label>
                        <input type="number" name="num_months">
                    </div>
                </div>

                <div class="daily-booking" style="display: none;"  >
                    <label id="check_out_date_label">Check Out Date</label>
                    <input type="date" name="check_out_date" id="check_out_date">
                </div>

                <div style="padding-top:20px;">
                    <input type="submit"class="btn btn-primary"value="Book Room">
                </div>
                </form>
            </div>


        
            <div class="container">
                <div class="slideshow">
                    @foreach($galleries as $gallery)
                    <div class="items"><img src="{{asset('storage/' . $gallery->image) }}" onclick="openFullscreen('{{asset('storage/' . $gallery->image)}}')" alt="Room Image"></div>
                    @endforeach                 
                </div>
            </div>

            <div class="fullscreen" id="fullscreen">
                <span class="close" onclick="closeFullscreen()">&times;</span>
                <img class="fullscreen-content" id="img01">
            </div> 
            
           
           </div>
        </div>
     </div>

         <!--  footer -->
        @include('home.footer')
      <!-- end footer -->
      <!-- Javascript files-->
        @include('home.jvs')
    
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
        <script>
            function openFullscreen(imgSrc) {
                var img = document.getElementById("img01");
                img.src = imgSrc;
                document.getElementById("fullscreen").style.display = "block";
            }

            function closeFullscreen() {
                document.getElementById("fullscreen").style.display = "none";
            }
                $(document).ready(() =>{
                $('.slideshow').slick({
                dots:true,
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                });
                $(".slideshow .slick-prev").html('<i class="fa-solid fa-chevron-left"></i>')
                $(".slideshow .slick-next").html('<i class="fa-solid fa-chevron-right"></i>')
                $(".slideshow .slick-dots li").html('')
            $('.items img').click(function(){
                var imgSrc = $(this).attr('src');
                openFullscreen(imgSrc);
            });
        });
        $(function(){

            $('input[type=radio][name=booking_type]').change(function(){
                if (this.value === 'daily') {
                    $('.monthly-booking').hide();
                    $('.daily-booking').show();
                    $('#check_out_date_label').show();
                    $('#check_out_date').show();
                }
                else if (this.value === 'monthly') {
                    $('.monthly-booking').show();
                    $('#check_out_date_label').hide();
                    $('#check_out_date').hide();
                }
            });
            // รับวันที่ปัจจุบัน
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();

            // ปรับรูปแบบเดือนและวันให้เป็น 2 ตัวหลัก
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();

            // กำหนดวันที่สูงสุดเป็นวันปัจจุบัน
            var maxDate = year + '-' + month + '-' + day;
            $('#check_in_date').attr('min', maxDate);
            $('#check_out_date').attr('min', maxDate);

            // เมื่อเลือกวันเช็คอิน
            $('#check_in_date').change(function(){
                var checkin = $(this).val();

                // ถ้ามีวันเช็คอินถูกเลือก
                if(checkin){
                    // ตั้งค่าของวันเช็คเอาท์เริ่มต้นใหม่เป็นวันถัดไปของวันเช็คอิน
                    var nextDay = new Date(checkin);
                    nextDay.setDate(nextDay.getDate() + 1);
                    var nextMonth = nextDay.getMonth() + 1;
                    if(nextMonth < 10)
                        nextMonth = '0' + nextMonth.toString();
                    var nextDate = nextDay.getFullYear() + '-' + nextMonth + '-' + (nextDay.getDate() < 10 ? '0' + nextDay.getDate() : nextDay.getDate());
                    $('#check_out_date').attr('min', nextDate);
                }
            });
        });

        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure to booking this room?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Yes, I'm sure",
                    denyButtonText:  "No, not sure",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ให้ฟอร์ม submit โดยใช้ JavaScript
                        $(this).unbind('submit').submit();
                    } else if (result.isDenied) {
                        Swal.fire("Booking are not success ", "", "info");
                    }
                });
            });

            if ($('.alert-success').length) {
                Swal.fire("Booking Successfully!", "", "success");
            }
            else if ($('.alert-danger').length) {
                Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Room Is Already Booked. Please Try Different Date!",
            });
            }

        });
        
        </script>
                           
   </body>
</html>