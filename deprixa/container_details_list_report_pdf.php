<?php
include("mpdf/mpdf.php");
ini_set('memory_limit', '3000M'); //extending php memory
$mpdf = new mPDF('win-1252', 'A4-M', '', '', 5, 5, 16, 10, 10, 10); //A4 size page in landscape orientation
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
 //The php page you want to convert to pdf
//--------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
//require_once('database.php');
require_once('library.php');
isUser();

$select_container_num = '';

$select_container_num = $_REQUEST['select_container_num'];

//----------------------------------------------
$str = '';
if (!empty($select_container_num)) {
    $str .= " AND c.container_number LIKE '%".$select_container_num."%'";
}

$rs = "SELECT c.* FROM `courier` c
					   where c.cid > 0 ".$str." ORDER BY c.cid ASC";
                       $getresult = mysql_query($rs);
$getresult = mysql_query($rs);
?>
<?php
$thmlhead = '<h2><p style="text-align:center;" >Container Details Listing Report</font></p></h2>';
$html = '<table cellpadding="0" cellspacing="0" border="1" width="100%"><tr>';
$html .='<td align="center" style="font-family: serif; font-size: 25px;font-weight: bold;">Invoice Number</td>';
$html .='<td align="center" style="font-family: serif; font-size: 25px;font-weight: bold;">Sender Name </td>';
$html .='<td align="center" style="font-family: serif; font-size: 25px;font-weight: bold;">Sender Address</td>';
$html .='<td align="center" style="font-family: serif; font-size: 25px;font-weight: bold;">Sender Telephone</td>';
$html .='<td align="center" style="font-family: serif; font-size: 25px;font-weight: bold;">Recipient Name</td>';
$html .='<td align="center" style="font-family: serif; font-size: 25px;font-weight: bold;">Recipient Address</td>';
$html .='<td align="center" style="font-family: serif; font-size: 25px;font-weight: bold;">Recipient Telephone</td>';
$html .='<td align="center" style="font-family: serif; font-size: 25px;font-weight: bold;">Cedula Number</td></tr>';
$html .='<td align="center" style="font-family: serif; font-size: 25px;font-weight: bold;">Invoice Description</td></tr>';

while ($row = mysql_fetch_array($getresult)) {
		$html .='<tr><td height="80px" width="50px" style="text-align: center; font-family: serif; font-size: 25px;">' . $row['invoice_number'] . '</td>';
		$html .='<td width="100px" style="text-align: center; font-family: serif; font-size: 25px; ">'.$row['ship_name'] . '</td>';
		$html .='<td width="350px" style="text-align: center; font-family: serif; font-size: 25px;" >' . $row['s_add'] . '</td>';
		$html .='<td width="128px" style="text-align: center; font-family: serif; font-size: 25px;" >' . $row['phone'] . '</td>';
		$html .='<td width="128px" style=" text-align: center; font-family: serif; font-size: 25px;">' . $row['rev_name'] . '</td>';
		$html .='<td width="350px" style=" text-align: center; font-family: serif; font-size: 25px;">' . $row['r_add'] . '</td>';
		$html .='<td width="128px" style=" text-align: center; font-family: serif; font-size: 25px;">' . $row['r_phone'].'</td>';
		$html .='<td width="180px" style=" text-align: center; font-family: serif; font-size: 25px;">' . $row['r_cedula_number'].'</td>';
		$html .='<td width="350px" style=" text-align: center; font-family: serif; font-size: 25px;">' . $row['comments'].'</td>
	</tr>';
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