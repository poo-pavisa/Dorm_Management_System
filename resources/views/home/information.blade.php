<!DOCTYPE html>
<html lang="en">
   <head>
        <base href="/images">
        <title>Information</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">    
        <style>
            body {
              font-family: Arial, sans-serif;
              margin: 0;
              padding: 0;
            }
            .container2 {
              max-width: 800px;
              margin: 60px auto;
              padding: 20px;
              background-color: #f9f9f9;
              border-radius: 8px;
              box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            tr:hover {
              background-color: #f5f5f5;
            }
            .text-center {
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
              <h1>Dormitory Information</h1>
              <div>
                 <h2>Utilities Charges</h2>
                 <table>
                    <thead>
                       <tr>
                          <th>Utility</th>
                          <th>Type</th>
                          <th>Charge</th>
                       </tr>
                    </thead>
                    <tbody>
                       <tr>
                          <td>Water</td>
                      @if(isset($water))
                          <td>{{$water->type}}</td>
                        @if($water->type == 'Base On Meter')
                          <td>{{$water->price_per_unit}} Baht Per Unit</td>
                        @else
                           <td>{{$water->price_per_unit}} Baht Per Month</td>
                        @endif
                      @else
                        <td colspan="2">N/A</td>
                      @endif
                       </tr>
                       <tr>
                          <td>Electricity</td>
                      @if(isset($electric))
                          <td>{{$electric->type}}</td>
                        @if($electric->type == 'Base On Meter')
                          <td>{{$electric->price_per_unit}} Baht Per Unit</td>
                        @else
                           <td>{{$electric->price_per_unit}} Baht Per Month</td>
                       </tr>
                       @endif
                      @else
                       <td colspan="2"> N/A</td>
                      @endif
                    </tbody>
                 </table>
              </div>
              <div class="mt-4">
                 <h2>Bank Account</h2>
                 <table>
                    <thead>
                       <tr>
                          <th>Account Name</th>
                          <th>Account No.</th>
                          <th>Bank Name</th>
                       </tr>
                    </thead>
                    <tbody>
                  @if($banks->isEmpty())
                    <tr>
                      <td colspan="3" style="text-align: center;">Bank Account has not been set.</td>
                    </tr>
                  @else
                     @foreach($banks as $bank)
                       <tr>
                          <td>{{$bank->account_name}}</td>
                          <td>{{$bank->account_no}}</td>
                          <td>{{$bank->bank_name}}</td>
                       </tr>
                    </tbody>
                    @endforeach
                  @endif

                 </table>
            </div>
          </div>
        
         <!--  footer -->
        @include('home.footer')
      <!-- end footer -->
      <!-- Javascript files-->
        @include('home.jvs')   
                           
   </body>
</html>