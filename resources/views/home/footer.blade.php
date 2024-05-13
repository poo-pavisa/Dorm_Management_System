<footer>
    <div class="footer">
       <div class="container">
          <div class="row">
             <div class=" col-md-4">
                <h3>Contact US</h3>
                <ul class="conta">
                  @foreach($dorms as $dorm)
                   <li><i class="fa fa-map-marker" aria-hidden="true"></i>{{$dorm->address}}</li>
                   <li><i class="fa fa-mobile" aria-hidden="true"></i> +66 {{$dorm->phone}}</li>
                   <li> <i class="fa fa-envelope" aria-hidden="true"></i><a href="#"> {{$dorm->email}}</a></li>
                   @endforeach
                </ul>
             </div>
             
             <div class="col-md-4">
                <h3>Menu Link</h3>
                <ul class="link_menu">
                   <li class="active"><a href="{{route('index')}}">Home</a></li>
                   <li><a href="{{route('all_room')}}">All Room</a></li>
                   <li><a href="{{route('information')}}">Information</a></li>

                </ul>
             </div>
             <div class="col-md-4">
                  <ul class="social_icon">
                     <li><a href="#"><i class="fa-brands fa-facebook" aria-hidden="true"></i></a></li>
                     <li><a href="#"><i class="fa-brands fa-square-x-twitter" aria-hidden="true"></i></a></li>
                     <li><a href="#"><i class="fa-brands fa-linkedin"></i></i></a></li>
                     <li><a href="#"><i class="fa-brands fa-youtube-play" aria-hidden="true"></i></a></li>
                  </ul>
             </div>
          </div>
       </div>
       
    </div>
 </footer>
