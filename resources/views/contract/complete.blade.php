<!DOCTYPE html>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Complete Contract Rent</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <style>
      @font-face {
          font-family: 'THSarabunNew';
          font-style: normal;
          font-weight: normal;
          src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
      }
      @font-face {
          font-family: 'THSarabunNew';
          font-style: normal;
          font-weight: bold;
          src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
      }
      @font-face {
          font-family: 'THSarabunNew';
          font-style: italic;
          font-weight: normal;
          src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
      }
      @font-face {
          font-family: 'THSarabunNew';
          font-style: italic;
          font-weight: bold;
          src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
      }
      body{
         font-family: "THSarabunNew";
         font-weight: normal;
      }
   </style>
</head>
<body>
   <img src="{{asset('storage/' . $contracts->image) }}" alt="Contract Image">

</body>
</html>