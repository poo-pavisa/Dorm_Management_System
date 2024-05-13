<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<title>สัญญาเช่า</title>
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
    body {
        font-family: "THSarabunNew";
    }
    h2 {
        font-family: "THSarabunNew";
        font-weight:bold;
        font-size: 22px;
    }
    p {
        font-family: "THSarabunNew";
        font-weight:normal;
        font-size: 18px;
    }
    
    .contract {
        margin: 20px auto;
        max-width: 1000px;
    }
    .contract-header, .contract-body, .contract-footer {
        padding: 10px;
        margin-bottom: 20px;
    }

    .contract-header{
        text-align:center;
        font-size:22px;
    }
    .contract-body {
        max-width:1000px;
        margin:0px 10px 0px 10px;
    }
    .signature {
        margin-top: 40px;
        text-align: right;
    }
    .signature p {
        margin-bottom: 20px;
    }
</style>
</head>
<body>
    <div class="contract">
            <h2 style="text-align:center; font-size:22px;">หนังสือสัญญาเช่า</h2>
        <div class="contract-body">
            <p style="text-indent: 3em;">สัญญานี้ทำขึ้นที่ <span class="location"><strong>{{$dormitory->name}}</strong></span> เมื่อวันที่ <span class="date"><strong>{{\Carbon\Carbon::parse($date)->thaidate()}}</strong></span> ระหว่าง <span class="party1"><strong>{{$dormitory->name}}</strong></span> อยู่บ้านเลขที่ <span class="address1"><strong>{{$dormitory->address}}</strong></span> ซึ่งต่อไปในสัญญานี้จะเรียกว่า <strong>“ผู้ให้เช่า”</strong> ฝ่ายหนึ่งกับ <span class="party2"><strong>{{$tenant->first_name}} {{$tenant->last_name}}</strong></span> อยู่บ้านเลขที่ <span class="address2"><strong>{{$tenant->address}}</strong></span> 
            <p>ซึ่งต่อไปในสัญญานี้จะเรียกว่า <strong>“ผู้เช่า”</strong> อีกฝ่ายหนึ่ง</p>
            <p style="text-indent: 3em;">ทั้งสองฝ่ายตกลงทำสัญญากันโดยมีข้อความดังต่อไปนี้</p>
            <p style="text-indent: 3em;"><strong>ข้อ 1 </strong>ผู้เช่าตกลงเช่าและผู้ให้เช่าตกลงให้เช่า <span class="room-number"> <strong>ห้อง {{$tenant->room->room_no}}</strong></span> <span class="floor-number"><strong>ชั้นที่ {{$tenant->room->floor->floor_no}} </strong></span> ของ <span class="apartment-name"><strong>{{$dormitory->name}}</strong></span> ซึ่งตั้งอยู่ที่ <span class="apartment-address"><strong>{{$dormitory->address}}</strong></span> เพื่อใช้เป็นที่พักอาศัย ในอัตราค่าเช่าเดือนละ <span class="rent-amount"><strong>{{ number_format($tenant->room->monthly_rate , 0, '.', ',') }} บาท </strong></span> ค่าเช่านี้ไม่รวมถึงค่าไฟฟ้า ค่าน้ำประปา</p>
            <p style="text-indent: 3em;"><strong>ข้อ 2 </strong>ผู้เช่าตกลงจ่ายค่าเช่าล่วงหน้าในวันทำสัญญา เป็นเงินจำนวน <span class="entract-fee"><strong>{{ number_format($tenant->room->security_deposit , 0, '.', ',') }} บาท</strong></span></p>
            <p style="text-indent: 3em;"><strong>ข้อ 3 </strong>ผู้่เช่าตกลงชำระค่าเช่าให้แก่ผู้ให้เช่า ทุก ๆ <span class="payment-due-date"><strong>วันที่  {{$dormitory->payment_due_date}} </strong></span>ของเดือน เริ่มตั้งแต่เดือนที่ตกลงทำสัญยาเช่าฉบับนี้เป็นต้นไป โดยผู้เช่าตกลงเช่ามีกำหนด <span class="month"><strong> {{$contracts->contract_duration}} เดือน </strong></span>นับตั้งแต่วันที่ <span><strong>{{\Carbon\Carbon::parse($contracts->contract_start_date)->thaidate()}}</strong></span> ถึงวันที่ <span><strong>{{\Carbon\Carbon::parse($contracts->contract_end_date)->thaidate()}}</strong></span></p>
            <p style="text-indent: 3em;"><strong>ข้อ 4 </strong>ผู้ให้เช่าตกลงให้ผู้เช่าใช้สอยทรัพย์สินทุกชนิดที่อยู่ในห้องเช่า โดยผู้เช่าจะดูแลรักษาเสมือนหนึ่งว่าเป็นทรัพย์สินของตนหากชำรุดบกพร่องใด ๆ ผู้เช่าจะต้องซ่อมแซมให้คงเดิมอยู่เสมอ</p>
            <p style="text-indent: 3em;"><strong>ข้อ 5 </strong>ผู้เช่าตกลงที่จะดูแลรักษาห้องที่เช่าให้คงสภาพดีดังเดิมทุกประการ และ ยินยอมให้ผู้ให้เช่า หรือผู้ที่ได้รับมอบหมายเข้ามาในห้องที่เช่าได้ตลอดเวลา เพื่อตรวจดูสภาพห้องที่เช่าได้ทุกเวลา โดยผู้เช่าให้สัญยาว่าจะไม่นำสิ่งผิดกฎหมายเข้ามานห้องที่เช่าหากผู้ให้เช่าพบสิ่งผิดกฎหมาย ผู้เช่ายอมให้ผู้ให้เช่าบอกเลิกสัญญาเช่าได้ทันที</p>
            <p style="text-indent: 3em;"><strong>ข้อ 6 </strong>ผู้เช่าต้องชำระค่าไฟฟ้า ค่าน้ำประปาตามจำนวนหน่วยที่ใช้ในแต่ละเดือนและต้องชำระพร้อมกับการชำระค่าเช่าของเดือนถัดไป</p>
            <p style="text-indent: 3em;"><strong>ข้อ 7 </strong>ผู้เช่าต้องเป็นผู้รับผิดชอบในบรรดาความสูญหาย เสียหาย หรือบุบสลายอย่างใดๆ อันเกิดแก่ห้องพักอาศัยและทรัพย์สินต่างๆ ในห้องพักดังกล่าว</p>
            <p style="text-indent: 3em;"><strong>ข้อ 8 </strong>ผู้เช่าต้องไม่ทำการดัดแปลง ต่อเติม หรือรื้อถอนห้องพักอาศัยและทรัพย์สินต่างๆ ในห้องพักดังกล่าว ไม่ว่าทั้งหมดหรือบางส่วน หากฝ่าฝืนผู้ให้เช่าจะเรียกให้ผู้เช่าทำทรัพย์สินดังกล่าวให้กลับคืนสู่สภาพเดิม และเรียกให้ผู้เช่ารับผิดชดใช้ค่าเสียหายอันเกิดความสูญหาย เสียหาย หรือบุบสลายใดๆ อันเนื่องมาจากการดัดแปลง ต่อเติม หรือรื้อถอนดังกล่าว</p>
            <p style="text-indent: 3em;"><strong>ข้อ 9 </strong>ผู้ให้เช่าไม่ต้องรับผิดชอบในความสูญหายหรือความเสียหายอย่างใดๆ อันเกิดขึ้นแก่รถยนต์รวมทั้งทรัพย์สินต่างๆ ในรถยนต์ของผู้เช่า ซึ่งได้นำมาจอดไว้ในที่จอดรถยนต์ที่ผู้ให้เช่าจัดไว้ให้</p>
            <p style="text-indent: 3em;"><strong>ข้อ 10 </strong>หากผู้เช่าประพฤติผิดสัญญาข้อหนึ่งข้อใด หรือหลายข้อก็ดี ผู้เช่าตกลงให้ผู้ให้เช่าใช้สิทธิดังต่อไปนี้ ข้อใดข้อหนึ่งหรือหลายข้อรวมกันก็ได้ คือ
            <p style="text-indent: 6em;">(1) บอกเลิกสัญญาเช่า</p>
            <p style="text-indent: 6em;">(2) เรียกค่าเสียหาย</p>
            <p style="text-indent: 6em;">(3) บอกกล่าวให้ผู้เช่าปฏิบัติตามข้อกำหนดในสัญญาภายในกำหนดเวลาที่ผู้ให้เช่าเห็นสมควร</p>
            <p style="text-indent: 6em;">(4) ตัดกระแสไฟฟ้าและน้ำประปา ได้ในทันที โดยไม่จำเป็นต้องบอกกล่าวแก่ผู้เช่าเป็นการล่วงหน้า</p>
            <p style="text-indent: 3em;"><strong>ข้อ 11 </strong>ในกรณีที่สัญญาเช่าระงับสิ้นลง ไม่ว่าด้วยเหตุใดๆ ก็ตาม ผู้เช่าต้องส่งมอบห้องพักอาศัยคืนแก่ผู้ให้เช่าทันที หากผู้เช่าไม่ปฏิบัติ ผู้ให้เช่าสิทธิกลับเข้าครอบครองห้องพักอาศัยที่ให้เช่าและขนย้ายบุคคลและทรัพย์สินของผู้เช่าออกจากห้องพักดังกล่าวได้ โดยผู้เช่าเป็นผู้รับผิดชอบในความสูญหายหรือความเสียหายอย่างใดๆ อันเกิดขึ้นแก่ทรัพย์สินของผู้เช่า ทั้งผู้ให้เช่ามีสิทธิริบเงินประกันการเช่า </p>
            <p style="text-indent: 3em;"><strong>ข้อ 12 </strong>ในวันทำสัญญานี้ ผู้เช่าได้ตรวจดูห้องพักอาศัยที่เช่าตลอดจนทรัพย์สินต่างๆ ในห้องพักดังกล่าวแล้วเห็นว่ามีสภาพปกติทุกประการ และผู้ให้เช่าได้ส่งมอบห้องพักอาศัยและทรัพย์สินต่างๆ ในห้องพักแก่ผู้เช่าแล้ว</p>
            <p style="text-indent: 3em;">คู่สัญญาได้อ่านและเข้าใจข้อความในสัญญานี้โดยตลอดแล้วเห็นว่าถูกต้อง จึงได้ลงลายมือชื่อไว้เป็นสำคัญต่อหน้าพยาน</p>
            <div class="signature">
                <p>ลงชื่อ .......................................................... ผู้เช่า</p>
                <p>( ............................................................. )</p>
                <p>ลงชื่อ .......................................................... ผู้ให้เช่า</p>
                <p>( ............................................................. )</p>
                <p>ลงชื่อ .......................................................... พยาน</p>
                <p>( ............................................................. )</p>
                <p>ลงชื่อ .......................................................... พยาน</p>
                <p>( ............................................................. )</p>
            </div>
        </div>
    </div>
</body>
</html>
