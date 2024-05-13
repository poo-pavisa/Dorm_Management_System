<!DOCTYPE html>
<html lang="en">
   <head>
        <base href="/images">
        <title>Invoice Detail</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">    
        <style>
        body {
              font-family: Arial, sans-serif;
              margin: 0;
              padding: 0;
            }
            .container2 {
              max-width: 1000px;
              margin: 50px auto;
              padding: 20px;
              padding-bottom: 50px;
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
              border: 1px solid #ddd;
            }
            th, td {
              padding: 10px 12px;
              text-align: left;
              border-bottom: 1px solid #ddd;
            }
            th {
              background-color: #f2f2f2;
              border-right: 1px solid #ddd;

            }
            tr {
              border-bottom: 1px solid #ddd;

            }
            td {
              border-right: 1px solid #ddd; 

            }
            tr:hover {
              background-color: #f5f5f5;
            }

            th:first-child,
            td:first-child {
                width: 70%; 
            }

            th:nth-child(2),
            td:nth-child(2) {
                width: 30%; 
            }

        </style>
        @include('home.css')
        
   </head>
   <body class="main-layout">
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#"/></div>
      </div>
      <header>
        @include('home.header')
      </header>
          
        <div class="row">    
            <div class="container2">
                <h1>{{$invoice->invoice_ref}}</h1>
                <div class="d-flex justify-content-end mb-3">
                @if($invoice->status === 'Awaiting Payment')
                  <a class="btn btn-primary me-3" href="{{route('form_payment',$invoice->id)}}">
                    <i class="fa-solid fa-coins"></i> Pay</a>
                @endif
                  <a class="btn btn-warning" href="{{route('generate-pdf',$invoice->id)}}">
                    <i class="fa-solid fa-file-export"></i> Export PDF</a>
                </div>
                <table>
                    <thead>
                      <tr>
                        <th>Item</th>
                        <th>Amount(Baht)</th>
                      </tr>
                    </thead>
    
                    <tbody>
                      <tr>
                       <td>Room Rate</td>
                       <td>{{ number_format($invoice->room_rate , 0, '.', ',') }}</td>
                      </tr>

                      <tr>
                        <td>Water Rate</td>
                        <td>{{ number_format($invoice->water_rate , 0, '.', ',') }}</td>
                       </tr>

                       <tr>
                        <td>Electricity Rate</td>
                        <td>{{ number_format($invoice->electricity_rate , 0, '.', ',') }}</td>
                       </tr>

                    @foreach($additionals as $additional)
                       <tr>
                        <td>{{$additional->description}}</td>
                        <td>{{ number_format($additional->additional_rate , 0, '.', ',') }}</td>
                       </tr>

                       
                    @endforeach

                      <tr>
                        <td style="text-align:center;"><strong>Total</strong></td>
                        <td><strong>{{ number_format($invoice->total_amount , 0, '.', ',') }}</strong></td> 
                      </tr>
                    </tbody>
                  </table>
                  <div class="mt-3 ">
                    <a class="btn btn-dark" href="{{route('all_invoice')}}">Back</a>
                  </div>
            </div>
        </div>

        @include('home.footer')
      <!-- end footer -->
      <!-- Javascript files-->
        @include('home.jvs')
   </body>
</html>
