 <!-- header inner -->
 <div class="header">
    <div class="container">
       <div class="row">
         <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section ">
            <div class="full">
                <div class="center-desk">
                   <div class="logo">
                      <a href="{{route('index')}}"><img src="images/dormitory_logo.png"style="width:50px; height:50px;" alt="#" /></a>
                   </div>
                </div>
             </div>
          </div>
          
          <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
             <nav class="navigation navbar navbar-expand-md navbar-dark ">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse ml-auto" id="navbarsExample04">
                  <ul class="navbar-nav mr-auto">
                     <li class="nav-item">
                        <a class="nav-link" href="{{route('index')}}">Home</a>
                     </li>
                     
                     <li> 
                        <a class="nav-link" href="{{route('information')}}">Information</a>
                     </li>
                     @if(Auth::check())
                        <li class="nav-item"> 
                           <a class="nav-link" href="{{ route('all_booking') }}">Booking</a>
                        </li>
                        @if(Auth::user()->role == 'Tenant')
                           <li class="nav-item">
                                 <a class="nav-link" href="{{ route('announcement') }}">Announcement</a>
                           </li>

                           <li class="nav-item">
                              <a class="nav-link" href="{{ route('all_request') }}">Request</a>
                           </li>

                        @endif
                     @endif 
                          
                     @if (Route::has('login'))

                           @auth
                              <div class="dropdown">
                                 <button class="btn btn-sm btn-outline-dark dropdown-toggle float-end" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </button>                                
                                 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a>
                                    @if(Auth::user()->role == 'Tenant')
                                       <a class="dropdown-item" href="{{ route('all_invoice') }}">Invoice</a>
                                    @endif                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                       @csrf
                                    </form>
                                 </div>
                           </div>
                           @else
                              <li class="nav-item" style="padding-right:10px;">
                                 <a class="btn btn-success" href="{{ route('login') }}">Login</a>
                              </li>
                                 @if (Route::has('register'))
                                    <li class="nav-item">
                                       <a class="btn btn-outline-info" href="{{ route('register') }}">Register</a>
                                    </li>
                                 @endif
                           @endauth
                     @endif


                   </ul>
                </div>
             </nav>
          </div>
       </div>
    </div>
 </div>