<!DOCTYPE html>
<html lang="en">
   <head>
    <title>Detail Room</title>
        <base href="/images">
            
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
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
                margin-top: 40px;
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
                top: 120px;
                left: 20px;
                z-index: 10;
            }
            .slideshow .slick-next {
                position: absolute;
                top: 120px;
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

            .asset {
            width: 300px;
            margin: 50px 50px 50px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            vertical-align: top;
            text-align: center;
            }
            .asset img {
            max-width: 100%;
            border-radius: 5px;
            }
            .asset h2 {
            margin-top: 10px;
            font-size: 20px;
            }
            .asset p {
            margin: 10px 0;
            font-size: 16px;
            }
            .all-asset {
                display:flex;
                justify-content: center;
                align-items: center;
                margin-top: 50px;  
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

            <div class="col-md-8 mx-auto">
                <div id="serv_hover" class="room">
                    <div style="padding:20px" class="room_img">
                        <figure><img style="height: 300px; width:800px;" src="{{ asset('storage/' . $room->image) }}" alt="#"/></figure>
                    </div>
                    <div class="bed_room">
                        <h2>Room {{ $room->room_no }}</h2>
                        <p style="padding: 12px">{{ $room->detail }}</p>
                        <h4 style="padding: 12px"> Price : {{ number_format($room->monthly_rate, 0, '.', ',') }} Baht / Month  </h4>
                        <h4 style="padding: 12px"> Security Deposit : {{ number_format($room->security_deposit, 0, '.', ',') }} Baht</h4>
                        <h4 style="padding: 12px"> Deposit : {{ number_format($room->deposit, 0, '.', ',') }} Baht</h4>
                        <a class="btn btn-warning" href="{{route('booking_room',$room->id)}}" style="margin-top:10px;">
                            <i class="fa-regular fa-calendar-check"></i>
                            Booking</a>
                    </div>
                </div>
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

            @if(!$assets->isEmpty())

                <div class ="all-asset">
                    <h1 style="font-weight:bold; font-size:40px; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">All Assets</h1>
                </div>

                @foreach($assets as $asset)
                    <div class="asset">
                        <img  style="height: 250px; width:300px;" src="{{ asset('storage/' . $asset->image) }}" alt="Asset 1">
                        <h2>{{$asset->name}}</h2>
                        <p>Damage Price : {{ number_format($asset->damage_price, 0, '.', ',') }} Baht</p>
                    </div>
                @endforeach

            @endif
                
            
           </div>
        </div>
     </div>

         <!--  footer -->
        @include('home.footer')
      <!-- end footer -->
      <!-- Javascript files-->
        @include('home.jvs')
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
            $('.asset img').click(function(){
                var imgSrc = $(this).attr('src');
                openFullscreen(imgSrc);
            });
        });  
     
        </script>
                           
   </body>
</html>