<!DOCTYPE html>
<html lang="en">
   <head>
        <base href="/images">
        <title>Booking History</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">    
        <style>
            body {
              font-family: Arial, sans-serif;
              margin: 0;
              padding: 0;
            }
            .container2 {
              max-width: 1000px;
              margin: 60px auto;
              padding: 20px;
              background-color: #f9f9f9;
              border-radius: 8px;
              box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
              display: flex;
              justify-content: center;
              align-items: center;
              flex-direction: column;

            }
            h1 {
              text-align: center;
            }
            table {
              width: 100%;
              border-collapse: collapse;
              margin-top: 20px;
            }
            th, td {
              padding: 12px 15px;
              text-align: left;
              border-bottom: 1px solid #ddd;
            }
            th {
              background-color: #f2f2f2;
            }
            tr {
              text-align: center;
            }
            td {
              text-align: center;
            }
            tr:hover {
              background-color: #f5f5f5;
            }
            .status {
                padding: .4rem 0;
                border-radius: 2rem;
                text-align: center;
            }

            .status.pending {
                background-color: #ebc474;
            }

            .status.payment-received {
                background-color: #6fcaea;
            }
            .status.completed {
                background-color: #86e49d;
                color: #006b21;
            }

            .status.cancelled {
                background-color: #d893a3;
                color: #b30021;
            }
            .pagination-container {
                display: flex;
                justify-content: flex-end;
                margin-top: 20px;
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
          
           <div class="row">
            <div class="container2">
              <h1>Booking History</h1>
              <table>
                <thead>
                  <tr >
                    <th>References</th>
                    <th>Room No.</th>
                    <th>Move In Date</th>
                    <th>Deposit</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>
                @if($bookings->isEmpty())
                    <tr>
                        <td colspan="7" style="text-align: center;height: 200px; font-weight:bold;">No Bookings Yet.</td>
                    </tr>
                @else
                  @foreach($bookings as $booking)
                  <tr>
                    <td>{{$booking->booking_ref }}</td>
                    <td>Room {{$booking->room->room_no}}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->move_in_date)->toFormattedDateString() }}</td>
                    <td>{{ number_format($booking->room->deposit, 0, '.', ',') }} THB</td>
                    <td>
                      <p class="status @if($booking->status == 'Pending') pending @elseif($booking->status == 'Payment Received') payment-received @elseif($booking->status == 'Cancelled') cancelled @elseif($booking->status == 'Completed') completed @endif">{{$booking->status}}</p>
                    </td>
                    <td>
                      @if($booking->status == 'Pending')
                      <a class= "btn btn-primary btn-sm" href="{{route('payment_form',$booking->id)}}">
                        <i class="fa-solid fa-coins"></i>
                        Pay</a>
                      @endif
                    </td>
                    <td>
                    @if($booking->status == 'Pending' || $booking->status == 'Payment Received')
                      <a class="btn btn-warning  btn-sm" href="{{route('edit_booking', $booking->id)}}">
                        <i class="fa-regular fa-pen-to-square"></i>
                         Edit</a><br>
                      <a class="btn btn-danger btn-sm cancel-btn" href="{{route('cancel_booking',$booking->id)}}" style="margin-top:5px;">
                        <i class="fa-regular fa-rectangle-xmark"></i>
                        Cancel</a>
                    @endif
                    </td>
                  </tr>
                  @endforeach 
                @endif 
                </tbody>
              </table>
              <div class="pagination-container">
                {{$bookings->links("pagination::bootstrap-5")}}
              </div>
            </div>
        
         <!--  footer -->
        @include('home.footer')
      <!-- end footer -->
      <!-- Javascript files-->
        @include('home.jvs')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/iconify/2.0.0/iconify.min.js" integrity="sha512-lYMiwcB608+RcqJmP93CMe7b4i9G9QK1RbixsNu4PzMRJMsqr/bUrkXUuFzCNsRUo3IXNUr5hz98lINURv5CNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    
        <script>
          document.addEventListener('DOMContentLoaded', function() {
              var deleteButtons = document.querySelectorAll('.cancel-btn');
              deleteButtons.forEach(function(button) {
                  button.addEventListener('click', function(event) {
                      event.preventDefault();
                      var url = this.getAttribute('href');

                      Swal.fire({
                          title: "Are you sure?",
                          text: "You won't be able to cancel this!",
                          icon: "warning",
                          showCancelButton: true,
                          confirmButtonColor: "#3085d6",
                          cancelButtonColor: "#d33",
                          confirmButtonText: "Yes, cancel it!"
                      }).then((result) => {
                          if (result.isConfirmed) {
                              window.location.href = url;
                              Swal.fire({
                              title: "Cancelled!",
                              text: "Your booking has been deleted.",
                              icon: "success"
                            });
                          }
                      });
                  });
              });
          });
        </script>
                           
   </body>
</html>