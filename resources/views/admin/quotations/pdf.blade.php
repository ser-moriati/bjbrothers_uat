<html lang="en">
	<head>
		<title>รายการใบขอเสนอราคา</title>
  <style>

   
    @page  {
            size: A4  ;
            margin: 0;
        }
    page {
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
      font-weight: 100;
    }
    page[size="A4"] {  
      width: 21cm;
      height: 29.7cm;   
      font-weight: 100;    
    }
  

    @media print {
      body, page {
        margin: 0%;
        box-shadow: 0;
        width: 210mm;
        height: 297mm;
        font-weight: 100;
      }
    }

  </style>
	</head>

<body style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
  <table style="max-width:670px;margin:50px auto 10px;padding:50px;">
    <thead>
      <tr>
     
      <th style="text-align:left;"><img style="max-width: 50px;" src="https://www.bjbrothers.com/images/LOGO-BJ.png" alt="bachana tours"></th>
        <th style="text-align:right;font-weight:400;"></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="height:35px;"></td>
      </tr>
      <tr>
        <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
        <p style="font-size:12px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:150px">สถานะ</span><b style="color:green;font-weight:normal;margin:0">ขอใบเสนอราคา</b></p>
        <p style="font-size:12px;margin:0 0 0 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">หมายเลขใบขอเสนอราคา</span> {{$order->number}}</p>
       
          
        </td>
      </tr>
      <tr>
        <td style="height:35px;"></td>
      </tr>
      <tr>
        <td style="width:50%;padding:20px;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">ผู้ขอใบเสนอราคา :</span>  {{$order->member_firstname}} {{$order->member_lastname}}</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;"> ชื่อบริษัท :</span> {{$order->company_name}}</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Email</span> palash@gmail.com</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Phone</span> {{$order->ship_phone}}</p>
        </td>
        <td style="width:50%;padding:20px;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">ที่อยู่บริษัท</span>      (Tel. {{$order->ship_phone}})
            {{$order->ship_address}} {{$order->ship_district_name}} {{$order->ship_amphure_name}} {{$order->ship_province_name}}  {{$order->ship_zipcode}}</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">ที่อยู่ในการจัดส่ง</span>    {{$order->receipt_first_name}} {{$order->receipt_last_name}}
            (Tel. {{$order->receipt_phone}})
            {{$order->receipt_address}} {{$order->receipt_district_name}} {{$order->receipt_amphure_name}} {{$order->receipt_province_name}}  {{$order->receipt_zipcode}} </p>
        </td>
      </tr>

        <tr>
        <td colspan="2" style="font-size:20px;padding:15px 15px 0 15px;">รายการสินค้า</td>
        </tr>
        <tr>
        <td colspan="2" style="padding:15px;">
            <table style="width:100%;">
            <thead>
                <tr>
                <th style="text-align: center;width:10%;border-bottom: 1px solid black;padding-bottom: 5px;">รูปภาพ</th>
                <th style="text-align: center;width:15%;border-bottom: 1px solid black;padding-bottom: 5px;">รหัสสินค้า</th>
                <th style="text-align: center;width:25%;border-bottom: 1px solid black;padding-bottom: 5px;">ชื่อสินค้า</th>
                <th style="text-align: center;width:15%;border-bottom: 1px solid black;padding-bottom: 5px;">ราคา</th>
                <th style="text-align: center;width:15%;border-bottom: 1px solid black;padding-bottom: 5px;">จำนวน</th>
                <th style="text-align: center;width:20%;border-bottom: 1px solid black;padding-bottom: 5px;">ราคารวม</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($order->quotation_details as $item)
                <tr>
                <td style="border-bottom: 1px solid black;padding-bottom: 5px;padding-top: 5px;"><img src="https://www.bjbrothers.com/upload/product/{{$item->product->product_image}}" alt="รูปภาพสินค้า" style="max-width: 50px;"></td>
                    <td style="text-align:left;border-bottom: 1px solid black;padding-bottom: 5px;padding-top: 5px;">{{$item->product->product_code}} </td>
                    <td style="text-align:left;border-bottom: 1px solid black;padding-bottom: 5px;padding-top: 5px;">{{$item->product->product_name}} </td>
                    <td style="text-align:right;border-bottom: 1px solid black;padding-bottom: 5px;padding-top: 5px;">฿ {{number_format($item->product_curent_price)}}</td>
                    <td style="text-align:right;border-bottom: 1px solid black;padding-bottom: 5px;padding-top: 5px;">{{@$item->qty}}</td>
                    <td style="text-align:right;border-bottom: 1px solid black;padding-bottom: 5px;padding-top: 5px;">฿ {{number_format($item->product_curent_total_price)}}</td>
                </tr>
            @endforeach    
             
                <!-- รายการสินค้าอื่นๆ ... -->
            </tbody>
            </table>
        </td>
        </tr>

<!-- ... โค้ด HTML ถัดไป ... -->


<!-- ... โค้ด HTML ถัดไป ... -->



    
    </tbody>
    <tfooter>
      <!-- <tr>
        <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
          <strong style="display:block;margin:0 0 10px 0;">CONTACT US</strong> บริษัท บี.เจ.บราเดอร์ส แอนด์ ซัน จำกัด<br> 9-9/4, 24-24/3 แยก 1-3-2, 1-3-4 ซอยเอกชัย <br>76 ถนนเอกชัย แขวงคลองบางพราน เขตบางบอน กทม. 10150<br><br>
          <b>Phone:</b> 02-4511824-6<br>
          <b>Phone:</b> 0645924655<br>
          <b>Line:</b>@bjbrothers<br>
          <b>Email:</b> salecenter@bjbrothers.com<br>
          <b>Website:</b>http://www.bjbrothers.com/<br>
        </td>
      </tr> -->
    </tfooter>
  </table>
</body>
<script>
 window.print(); 
</script>
</html>