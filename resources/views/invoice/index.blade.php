<!DOCTYPE html>
<html lang="en">
   <head>
        <base href="/images">
        <title>All Invoice</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">    
        <style>
            body {
              font-family: Arial, sans-serif;
              margin: 0;
              padding: 0;
            }
            h1 {
              text-align: center;
              margin-top: 50px;
            }
            .container2 {
                max-width: 1000px;
                min-height: 350px;
                margin: 60px auto;
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                
            }
            .invoice-card {
                background-color: #fff;
                border: 1px solid rgba(0, 0, 0, 0.125);
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                width: 75%; 
                margin: 10px auto;
            }
            .invoice-card .card-body {
                padding: 20px;

            }
            .invoice-card .card-title {
                color: #333;
                font-size: 1.2rem; 
                margin-bottom: 10px;
            }
            .invoice-card .card-text {
                color: #666; 
                margin-bottom: 8px;
            }
            .invoice-card .card-body .card-title,
            .invoice-card .card-body .card-text {
                margin: 0;
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
            @if($invoices->isEmpty())
                <div>
                    <h1 style= "text-align: center;font-weight:bold; ">No Invoice Yet.</h1>
                </div>
            @else
            <h1 style="font-weight:bold; font-size:35px;" >All Invoice</h1>
                @foreach($invoices as $invoice)
                <div class="row justify-content-center">
                    <div class="invoice-card card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Invoice for {{ \Carbon\Carbon::parse($invoice->created_at)->format('F / Y') }} ( {{$invoice->invoice_ref}} )  </h5>
                                @if($invoice->status == 'Awaiting Payment')
                                    <p class="card-text" style="color: #0a46BD;"><i class="fa-solid fa-money-bill-wave" style="color: #0a46BD;; margin-right:5px;"></i>{{$invoice->status}}</p>
                                @elseif($invoice->status == 'Pending Review')
                                    <p class="card-text" style="color: #efbb01;"><i class="fa-solid fa-hourglass" style="color: #efbb01; margin-right:5px;"></i>{{$invoice->status}}</p>
                                @elseif($invoice->status == 'Paid')
                                    <p class="card-text" style="color: #008539;" ><i class="fa-solid fa-circle-check" style="color: #008539; margin-right:5px;"></i></i>{{$invoice->status}}</p>
                                @else
                                    <p class="card-text" style="color: #ff0000;"><i class="fa-solid fa-triangle-exclamation" style="color: #ff0000; margin-right:5px;"></i>{{$invoice->status}}</p>
                                @endif
                            </div>
                            <a href="{{route('invoice_detail', $invoice->id)}}">
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
                <div class="pagination-container">
                    {{$invoices->links("pagination::bootstrap-5")}}
                </div>
            </div>
        </div>

         <!--  footer -->
        @include('home.footer')
      <!-- end footer -->
      <!-- Javascript files-->
        @include('home.jvs')
   </body>
</html>