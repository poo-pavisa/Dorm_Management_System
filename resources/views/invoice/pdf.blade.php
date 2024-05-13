<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice</title>
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
        body, p, h3, h4 {
            font-family: "THSarabunNew";
            font-weight: normal;
        }
        h3 {
            font-size: 20px;
        }

        h4 {
            font-size: 16px;
        }

        p {
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .address {
            text-align: center;
            margin-bottom: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        .body-table {
            width: 80%;
            margin-top: 20px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            padding: 15px; 
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 15px; 
            text-align: left;
        }
        th {
            width: 200px;
        }
        .total {
            font-weight: bold;
            text-align: center;
        }
        .total-amount {
            text-align: center;
        }

        .tenant-info {
            float: left;
            text-align: left;
        }
        .item-column {
            width: 66.7%;
        }
        .invoice-header{
            display: inline-block; 
            border: 2px solid #000;
            padding: 2px 20px;
            text-align:center; 
            align-items: center;
            margin-left: 300px;
        }
        .invoice-info{
            float: right;
            text-align: right;
            margin-right:150px; 
            margin-bottom:400px;
        }
    </style>
</head>
<body>
    <div class="header" >
        <h3>{{$dormitory->name}}</h1>
        <h4>{{$dormitory->address}}</h4>
        <div class="invoice-header">
            <h3>ใบแจ้งหนี้</h3>
        </div>
        <div class="invoice-info">
            <p>เลขที่บิล: {{$invoice->invoice_ref}}</p>
            <p>ประจำเดือน: {{\Carbon\Carbon::parse($date)->thaidate('F Y')}}</p>
            <p>วันที่แจ้งค่าใช้จ่าย: {{\Carbon\Carbon::parse($date)->thaidate()}}</p>
            <p>เลขห้อง: {{$invoice->tenant->room->room_no}}</p>
        </div>
    </div>
    <div class="container">
        <div class="tenant-info">
            <p>ชื่อ:{{$invoice->tenant->first_name}} {{$invoice->tenant->last_name}}</p>
        </div>
        
    </div>
    <div class="body-table">
        <table>
            <tr>
                <th style="width: 66.7%;">รายละเอียด</th>
                <th>จำนวนเงิน (บาท)</th>
            </tr>
            <tr>
                <td class="item-column">ค่าห้อง ({{\Carbon\Carbon::parse($date)->thaidate('M y')}} )</td>
                <td>{{ number_format($invoice->room_rate , 0, '.', ',') }}</td>
            </tr>
            <tr>
                <td class="item-column">ค่าไฟ ({{\Carbon\Carbon::parse($date)->thaidate('M y')}} )</td>
                <td>{{ number_format($invoice->electricity_rate , 0, '.', ',') }}</td>
            </tr>
            <tr>
                <td class="item-column">ค่าน้ำ ({{\Carbon\Carbon::parse($date)->thaidate('M y')}} )</td>
                <td>{{ number_format($invoice->water_rate , 0, '.', ',') }}</td>
            </tr>
        @foreach($additionals as $additional)
            <tr>
                <td class="item-column">{{$additional->description}}</td>
                <td>{{ number_format($additional->additional_rate , 0, '.', ',') }}</td>
            </tr>
        @endforeach
            <tr class="total">
                <td colspan="1" class="total">รวมทั้งหมด</td>
                <td>{{ number_format($invoice->total_amount , 0, '.', ',') }}</td>
            </tr>
        </table>
        <p style="margin-left:10px;">โปรดชำระเงินภายใน: {{$dormitory->payment_due_date}} {{\Carbon\Carbon::parse($date)->addMonth()->thaidate('F Y')}}</p>

    </div>
</body>
</html>