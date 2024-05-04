<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>ใบเสนอราคา</title>
  <!-- เรียกใช้งานไฟล์ CSS ของ Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        font-size: 16px;
        font-weight: 100;
    }
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
    table, td, th {  
      border: 0px solid #ddd;
      text-align: left;
      text-align: left;
      font-family: "THSarabunNew";
      font-size: 13px;
      font-weight: 100;
    }

    table {
      border-collapse:collapse;
      width: 100%;
      padding-left:5% ;
      padding-right:5% ;
      font-weight: 100;
    
    
      /* border: 1px solid black; */
    }

    th, td {
      /* border: 1px solid black; */
    
      font-weight: 100;
    }
    table.center {
      margin-left: auto; 
      margin-right: auto;
      font-weight: 100;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="text-center">ใบเสนอราคา</h1>

    <div class="row">
      <div class="col-md-6">
        <strong>บริษัท:</strong> ชื่อบริษัทของคุณ<br>
        <strong>ที่อยู่:</strong> ที่อยู่ของบริษัทของคุณ
      </div>
      <div class="col-md-6 text-right">
        <strong>ลูกค้า:</strong> ชื่อลูกค้าของคุณ<br>
        <strong>ที่อยู่ลูกค้า:</strong> ที่อยู่ลูกค้าของคุณ
      </div>
    </div>

    <table class="table table-bordered mt-4">
      <thead>
        <tr>
          <th>รายการ</th>
          <th>จำนวน</th>
          <th>ราคาต่อหน่วย</th>
          <th>ราคารวม</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>สินค้า A</td>
          <td>10</td>
          <td>100</td>
          <td>1,000</td>
        </tr>
        <tr>
          <td>สินค้า B</td>
          <td>5</td>
          <td>200</td>
          <td>1,000</td>
        </tr>
        <!-- เพิ่มรายการสินค้าเพิ่มเติมตรงนี้ -->
        <tr>
          <td colspan="3" class="text-right"><strong>รวมทั้งสิ้น</strong></td>
          <td>2,000</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- เรียกใช้งานไฟล์ JavaScript ของ Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script>
 window.print(); 
</script>

</html>
