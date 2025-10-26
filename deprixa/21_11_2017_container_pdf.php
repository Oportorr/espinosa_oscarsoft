<?php

include("mpdf/mpdf.php");

ini_set('memory_limit', '3000M'); //extending php memory
$mpdf = new mPDF('win-1252', 'A4-M', '', '', 15, 10, 16, 10, 10, 10); //A4 size page in landscape orientation
$mpdf->SetHeader();
//$mpdf->setFooter('{PAGENO}');

//$mpdf->SetFooter();

//$mpdf->WriteHTML('First section text...');


$mpdf->useOnlyCoreFonts = true;    // false is default
//$mpdf->SetWatermarkText("any text");
//$mpdf->showWatermarkText = true;
//$mpdf->watermark_font = 'DejaVuSansCondensed';
//$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');
//$mpdf->SetWatermarkImage('logo.png');
$mpdf->showWatermarkImage = true;


// Buffer the following html with PHP so we can store it to a variable later
ob_start();
?>
<?php

include "container_report.php"; //The php page you want to convert to pdf
//--------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
//require_once('database.php');
require_once('library.php');
isUser();

$select_container_num = $bookingmode = '';

//$from_date = $_POST['from_date'];
//$to_date = $_POST['to_date'];
$select_container_num = $_REQUEST['select_container_num'];
$bookingmode = $_REQUEST['bookingmode'];
$username = $_REQUEST['username'];

$crs = "SELECT container_number FROM courier_container WHERE container_id = '$select_container_num' ";
$cresult = mysql_query($crs);
$crs_row = mysql_fetch_row($cresult);
$container_num = $crs_row['0'];


//----------------------------------------------
$str_t_d_s = '';
if (!empty($username)) {
    $str_t_d_s .=" AND c.officename LIKE '%$username%'";
}

if (!empty($select_container_num)) {
    $str_t_d_s .= " AND c.container_id = '$select_container_num'";
}
if (!empty($bookingmode)) {
    $str_t_d_s .=" AND c.book_mode = '$bookingmode'";
}

$rs = "SELECT SUM(shipping_subtotal) AS total_sales, SUM(paid_amount) AS p_amount  FROM `courier` AS c  WHERE c.cid > 0 $str_t_d_s ";
$myresult = mysql_query($rs);
$rs_row = mysql_fetch_row($myresult);

$total_sale_rs = $rs_row['0'];
//--------only for Print ---------------
$total_sale_rs_p = number_format("$total_sale_rs",2,".",",");

$total_paid_rs = $rs_row['1'];
//--------only for Print ---------------
$total_paid_rs_p = number_format("$total_paid_rs",2,".",",");

$total_unpaid_rs = bcsub($total_sale_rs, $total_paid_rs, 2);
//--------only for Print ---------------

$total_unpaid_rs_p =  number_format($total_unpaid_rs, 2);

//----------------------------------------------

$str = '';
if (!empty($username)) {
    $str .=" AND c.officename LIKE '%$username%' ";
}

if (!empty($select_container_num)) {
    $str .= " AND c.container_id = '$select_container_num'";
}
if (!empty($bookingmode)) {
    $str .=" AND c.book_mode = '$bookingmode'";
}

$rs = " SELECT c.cid,c.modified_by,c.phone,c.r_phone,c.modified_date,c.officename,c.book_date,c.ship_name,c.s_zipcode,c.comments,c.s_add,c.paid_amount,c.shipping_subtotal,c.paid_amount, ct.city_name , st.state_name , co.country_name FROM `courier` c
                                             LEFT JOIN `city` ct ON (ct.city_id = c.s_city)
                                             LEFT JOIN `state` st ON (st.state_id = c.s_state)
                                             LEFT JOIN `country` co ON (co.country_id = c.s_country)
                                             where c.cid > 0 $str  ORDER BY c.cid ASC ";
$getresult = mysql_query($rs);
?>

<?php

$thmlhead = '<h2><p style="text-align:center;" >Truck Report</font></p></h2>';

$html1 = '<table cellpadding="0" cellspacing="0" width="100%"><tr>';
$html1 .='<td  width="120px" style="text-align:left;" >Truck Number: </td>';
$html1 .='<td  width="120px" style="text-align:left;border:1 solid;padding-left:10px;">' . $container_num . '</td>';
$html1 .='<td  style="text-align:right;padding-right:25px;"></td>';
$html1 .='<td  style="text-align:right;padding-right:25px;">Type Of Invoices: </td>';
$html1 .='<td style="border:1 solid; padding-right:10px; padding-left:10px;">' . $bookingmode . '</td>';
$html1 .='</tr></table><br>';

$html2 = '<table cellpadding="0" cellspacing="0" width="100%"><tr>';
$html2 .='<td width="120px" style="text-align:left;" >Total Amount: </td>';
$html2 .='<td width="120px" style="text-align:left;border:1 solid;padding-left:10px;">$' . $total_sale_rs_p . '</td>';
$html2 .='<td style="border:0 callscap:2 solid; padding-left:10px;"></td>';
$html2 .='<td style="border:0 callscap:2 solid; padding-left:10px;"></td>';
$html2 .='<td style="border:0 callscap:2 solid; padding-left:10px;"></td>';
$html2 .='<td width="120px" style="text-align:right;padding-right:25px;">User Id: </td>';
$html2 .='<td style="border:1 solid; padding-left:10px;">' . $username . '</td>';
$html2 .='</tr></table><br>';

$html3 = '<table cellpadding="0" cellspacing="0" width="100%"><tr>';
$html3 .='<td width="120px" style="text-align:left;" > Not Paid: </td>';
$html3 .='<td width="120px" style="text-align:left;border:1 solid;padding-left:10px;">$' . $total_unpaid_rs_p . '</td>';
$html3 .='<td width="120px" style="border:0 solid; padding-left:10px;"></td>';
$html3 .='<td style="border:0 solid; padding-left:10px;"></td>';
$html3 .='<td colspan="2" style="text-align:right;padding-right:25px;"></td>';
$html3 .='</tr></table><br>';

$html4 = '<table cellpadding="0" cellspacing="0" width="100%"><tr>';
$html4 .='<td width="120px" style="text-align:left;" > Paid: </td>';
$html4 .='<td width="120px" style="text-align:left;border:1 solid;padding-left:10px;">$' . $total_paid_rs_p . '</td>';
$html4 .='<td colspan="2" style="text-align:right;padding-right:25px;"> </td>';
$html4 .='<td colspan="2" style="text-align:right;padding-right:25px;"> </td>';
$html4 .='<td style="border:0 ; padding-left:20px;"></td>';
$html4 .='</tr></table><br>';


$html = '<table cellpadding="0" cellspacing="0" border="1" width="100%"><tr>';
$html .='<td align="center" style="font-family: serif; font-size: 18px;font-weight: bold;">Id</td>';
$html .='<td align="center" style="font-family: serif; font-size: 18px;font-weight: bold;">Paid </td>';
$html .='<td align="center" style="font-family: serif; font-size: 18px;font-weight: bold;">Amount Due</td>';
$html .='<td align="center" style="font-family: serif; font-size: 18px;font-weight: bold;">Billing Address</td>';
$html .='<td align="center" style="font-family: serif; font-size: 18px;font-weight: bold;">Sender Telephone</td>';
$html .='<td align="center" style="font-family: serif; font-size: 18px;font-weight: bold;">Receiver Telephone</td>';
$html .='<td align="center" style="font-family: serif; font-size: 18px;font-weight: bold;">Notes</td></tr>';

while ($row = mysql_fetch_array($getresult)) {
    $inquedata = bcsub($row['shipping_subtotal'], $row['paid_amount'], 2);
    $s_address = $row['ship_name'] . '' . $row['s_add'] . '' . $row['city_name'] . ', ' . $row['state_name'] . ', ' . $row['s_zipcode'] . ', ' . $row['country_name'];
      $m_date = date('Y:m:d', strtotime($row['modified_date']));
      $b_date = date('Y:m:d', strtotime($row['book_date']));
    
      
    if ($row['modified_by'] != "") {        
        $m_result = $row['comments'] . ' Edited By: ' . $row['modified_by'] . '  Edited: ' . $m_date ;
        $m_result = ltrim($m_result, ",");
    } else {
        $m_result = $row['comments'] . ' Edited By: ' . $row['officename'] . '  Edited: ' . $b_date ;
        $m_result = ltrim($m_result, ",");
    }

    $html .='<tr><td height="80px" width="50px" >' . $row['cid'] . '</td>';
    $html .='<td width="80px" style="text-align: right; font-family: serif; font-size: 18px; ">$' . $row['paid_amount'] . '</td>';
    $html .='<td width="80px" style="text-align: right; font-family: serif; font-size: 18px;" >$' . $inquedata . '</td>';
    $html .='<td width="280px" style="font-family: serif; font-size: 18px;" >' . $s_address . '</td>';
    $html .='<td width="128px" style="font-family: serif; font-size: 18px;">' . $row['phone'] . '</td>';
    $html .='<td width="128px" style="font-family: serif; font-size: 18px;">' . $row['r_phone'] . '</td>';
    $html .='<td width="350px" style="font-family: serif; font-size: 18px;">' . $m_result . '</td></tr>';
}
$html .='</table>';

ob_end_clean();
$mpdf->WriteHTML($thmlhead);

$mpdf->WriteHTML($html1);
$mpdf->WriteHTML($html2);
$mpdf->WriteHTML($html3);
$mpdf->WriteHTML($html4);
$mpdf->WriteHTML($html);
//$mpdf->SetProtection(array(), 'mawiahl', 'password');//for password protecting your pdf

$mpdf->Output();
exit;
?>