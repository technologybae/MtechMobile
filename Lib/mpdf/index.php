<?php
use Mpdf\Mpdf;
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
$mpdf->SetDirectionality('rtl');

$html = '<style>
.head{
width: 100%;
margin: 8px;
display: flex;
padding-top: 10px;
justify-content: space-between;
vertical-align: top;
}
.enghead{

padding-left: 10px;
margin-left: 5px;

}
.logohead{

margin: 5px;
text-align: center;
}
.langhead{

margin: 5px;

padding-right: 20px;
text-align: end;
}
.table{
width: 90%;
border: 1;
table-layout: auto;
}
table, td, th {
border: 1px solid black;
font-size: 16px;
border-collapse: collapse;
padding:8px;
}
thead{
font-size: 5px;
}
table { width: 100%;}
table  thead tr th label {
font-size: 16px;
}
</style>
<div dir="rtl" lang="ar">



<table dir="rtl">
<tbody><tr>
<td style="border:none; width:45%;"><div class="enghead">
<h1>صخر وطني</h1>
		  <h3>
		  House no 60 / 6 Paf base qureshi camp lahore cantt
		  
		  <br> MOB:03345138083</h3>
		  <h4>naveed.mtech@gmail.com <br> ضريبة القيمة المضافة#: V1236hU</h4>
<img src="http://localhost/MtechMobile/includes/sales/QrCodes/Sale-29.png" width="150px" style="margin-left: 30px" alt="">
</div></td>
<td style="border:none; width:15%;"><div class="logohead">
<img src="http://217.76.50.216/MtechSuperAdmin/user_images/naveed.mtech@gmail.comslazzer-edit-image (2).png" width="100%" alt="">   
<h2>فاتورة مبيعات</h2>
</div></td>
<td style="border:none; width:40%;"><div style="text-align:center;" class="langhead"></div></td>

</tr>


</tbody></table>
</div>
<div class="table1">
<table dir="rtl">
<tbody><tr>
<th><label for="#">التاريخ </label></th>
<th><label for="#">نوع الفاتورة
</label></th>
<th><label for="#">رقم الفاتورة</label></th>
<th><label for="#">رقم المرجع </label></th>
<th><label for="#">عميل  </label></th>
<th><label for="#">الفرع  </label></th>
<th><label for="#">اسم المحل
</label></th>
</tr>
<tr>
<td align="center"><label for="#">03 Mar,2023</label></td>
<td align="center"><label for="#">Credit</label></td>
<td align="center"><label for="#">29-S1-M1</label></td>
<td align="center"><label for="#">1234</label></td>
<td align="center"><label for="#">AHmed</label></td>
<td align="center"><label for="#">Main Branch</label></td>
<td align="center"><label for="#">Asadd Test Shop name</label></td>


</tr></tbody></table>
</div>
<table dir="rtl">
<tbody><tr>
<th><label for="#">التاريخ </label></th>
<th><label for="#">نوع الفاتورة
</label></th>
<th><label for="#">رقم الفاتورة</label></th>
<th><label for="#">رقم المرجع </label></th>
<th><label for="#">عميل  </label></th>
<th><label for="#">الفرع  </label></th>
<th><label for="#">اسم المحل
</label></th>
</tr>
<tr>
<td align="center"><label for="#">03 Mar,2023</label></td>
<td align="center"><label for="#">Credit</label></td>
<td align="center"><label for="#">29-S1-M1</label></td>
<td align="center"><label for="#">1234</label></td>
<td align="center"><label for="#">AHmed</label></td>
<td align="center"><label for="#">Main Branch</label></td>
<td align="center"><label for="#">Asadd Test Shop name</label></td>


</tr></tbody></table></div>


<div class="table2" dir="rtl">
<table dir="rtl">
<thead>
<tr>
<th style="width: 5%;"><label for="#"># </label></th>
<th style="width: 15%;"><label for="#">منتج
</label></th>
<th style="width: 10%;"><label for="#">الكمية</label></th>
<th style="width: 10%;"><label for="#">السعر</label></th>
<th style="width: 10%;"><label for="#">الاجمالي</label></th>
<th style="width: 10%;"><label for="#">الضريبة %</label></th>
<th style="width: 10%;"><label for="#">الضريبة</label></th>
<th style="width: 10%;"><label for="#">المجموع الإجمالي</label></th>
</tr>
</thead>
<tbody><tr>
<td align="center">1</td>
<td>P4-P4</td>
<td align="center">1.0</td>
<td align="center">480.000</td>
<td align="center">480.000</td>
<td align="center">17.000</td>
<td align="center">81.600</td>
<td align="center">561.600</td>      
</tr><tr><td rowspan="5" colspan="6"><label for="#">شروط الدفع
</label>
<br>



</td>
<td><label for="#"><b>الاجمالي</b></label></td>
<td align="center"><label for="#">480.000</label></td>
</tr>
<tr>
<td><label for="#">خصم %</label></td>
<td align="center"><label for="#">0.000</label></td>
</tr>

<tr>
<td><label for="#">الخصم </label></td>
<td align="center"><label for="#">0.000</label></td>
</tr>
<tr>
<td><label for="#">الصافي </label></td>
<td align="center"><label for="#">480.000</label></td>
</tr>
<tr>
<td><label for="#">اجمالي الضريبة </label></td>
<td align="center"><label for="#">81.600</label></td>
</tr>
<tr>
<td colspan="6"><b>Five Hundred 
        and Sixty One 
        Rupees And Six 
    Paise</b></td>
<td><label for="#"><b>المجموع الإجمالي</b> </label></td>
<td align="center"><label for="#"><b>561.600</b></label></td>
</tr>

</tbody>
</table>
</div>
';

$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;
$mpdf->WriteHTML($html);
$mpdf->WriteHTML($style_data, 1);        // The parameter 1 tells mPDF that this is CSS and not HTML

$mpdf->Output();