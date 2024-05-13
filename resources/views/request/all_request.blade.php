<!DOCTYPE html>
<html lang="en">
   <head>
        <base href="/images">
        <title>Request History</title>
        
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
            .status {
                padding: .4rem 0;
                border-radius: 2rem;
                text-align: center;
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
                <h1>Request History</h1>
                <div class="d-flex justify-content-end mb-3">
                    <a class="btn btn-primary" href="{{route('request_form')}}">
                      <i class="fa-solid fa-plus"></i> Add Request</a>
                </div>
                  @if(session()->has('success'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                          {{session()->get('success')}}
                          <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                      </div>
                  @endif
              <table>
                <thead>
                  <tr >
                    <th>References</th>
                    <th>Room No.</th>
                    <th>Subject</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>
                @foreach($requests as $request)
                  <tr>
                    <td>{{$request->request_ref}}</td>
                    <td>{{$request->room->room_no}}</td>
                    <td>{{$request->subject}}</td>
                    <td>{{\Carbon\Carbon::parse($request->due_date)->toFormattedDateString() }}</td>
                    <td>
                      <p class="status @if($request->status == 'Pending') pending @elseif($request->status == 'In Progress') in-progress  @elseif($request->status == 'Completed') completed @endif">{{$request->status}}</p>
                    </td>
                    <td>
                  @if($request->status == 'Pending')
                      <a style="margin-bottom:10px;"class="btn btn-primary btn-sm"href="{{route('detail_request',$request->id)}}">
                        <i class="fa-regular fa-pen-to-square"></i> Detail</a><br>
                      <a class="btn btn-danger btn-sm delete-btn" href="{{route('delete_request',$request->id)}}" >
                        <i class="fa-regular fa-trash-can"></i> Delete</a>
                  @else
                      <a style="margin-bottom:10px;"class="btn btn-primary btn-sm"href="{{route('detail_request',$request->id)}}">
                        <i class="fa-regular fa-pen-to-square"></i> Detail</a><br>

                    </td>
                  @endif
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
        </div>

         <!--  footer -->
        @include('home.footer')
      <!-- end footer -->
      <!-- Javascript files-->
        @include('home.jvs')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    
        <script>
          document.addEventListener('DOMContentLoaded', function() {
              var deleteButtons = document.querySelectorAll('.delete-btn');
              deleteButtons.forEach(function(button) {
                  button.addEventListener('click', function(event) {
                      event.preventDefault();
                      var url = this.getAttribute('href');

                      Swal.fire({
                          title: "Are you sure?",
                          text: "You won't be able to delete this!",
                          icon: "warning",
                          showCancelButton: true,
                          confirmButtonColor: "#3085d6",
                          cancelButtonColor: "#d33",
                          confirmButtonText: "Yes, delete it!"
                      }).then((result) => {
                          if (result.isConfirmed) {
                              window.location.href = url;
                              Swal.fire({
                              title: "Deleted!",
                              text: "Your request has been deleted.",
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