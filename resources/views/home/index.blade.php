<!DOCTYPE html>
<html lang="en">
  <title>Dormitory</title>
   <head>    
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
      <!-- end header inner -->
      <!-- end header -->
      <!-- banner -->
      <!-- end banner -->
       <!-- about -->
       @include('home.about')
       <!-- end about -->
       
      <!-- our_room -->
      @include('home.room')
      <!-- end our_room -->
     
      {{-- <!-- gallery -->
        @include('home.gallery')
      <!-- end gallery -->
      <!-- blog -->
        @include('home.blog')
      <!-- end blog -->
      <!--  contact --> --}}
        @include('home.contact')
      <!-- end contact -->
      <!--  footer -->
        @include('home.footer')
      <!-- end footer -->
      <!-- Javascript files-->
        @include('home.jvs')

   </body>
</html>