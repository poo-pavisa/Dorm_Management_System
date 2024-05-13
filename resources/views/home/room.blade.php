<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div  class="our_room">
    <div class="container">
       <div class="row">
          <div class="col-md-12">
             <div class="titlepage">
                <h2>All Room</h2>
                <p>Lorem Ipsum available, but the majority have suffered </p>
             </div>
          </div>
       </div>

      
       <div class="row">
         @foreach($rooms as $room)

          <div class="col-md-4 col-sm-6">
             <div id="serv_hover"  class="room">
                <div class="room_img">
                   <figure><img style ="height: 200px; width:320px;" src="{{ asset('storage/' . $room->image) }}" alt="#"/></figure>
                </div>
                <div class="bed_room">
                   <h3>Room {{$room->room_no }}</h3>
                   <p style="padding:10px">{!! Str::limit($room->detail,60) !!}</p>

                   <a class="btn btn-primary" href="{{route('room_detail',$room->id)}}">
                     <i class="fa-solid fa-list"></i>
                     Detail</a>
                   
                </div>
             </div>
          </div>
         @endforeach
       </div>
       <div class="row">
         <div class="col-md-12">
             {{ $rooms->links("pagination::bootstrap-5") }} 
         </div>
      </div>
    </div>
 </div>