<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();

require_once('database.php');
require_once('library.php');
isUser();

$username = $total_daily_sales = $total_daily_payment = $total_balance = '';
//$from_date = date('2017-07-1');
//$to_date = date('2017-07-12');

   $from_date = $_REQUEST['from_date'];
   $to_date = $_REQUEST['to_date'];
   $username =$_REQUEST['username'];

   
    
$str_t_d_p = $str_t_d_s = '';
if (!empty($from_date)) {
    $str_t_d_p .= " AND DATE_FORMAT(cp.`date`,'%Y-%m-%d') >= '$from_date' ";
    $str_t_d_s .= " AND c.`book_date` >= '$from_date' ";
}
if (!empty($to_date)) {
    $str_t_d_p .= " AND DATE_FORMAT(cp.`date`,'%Y-%m-%d') <= '$to_date' ";
    $str_t_d_s .= " AND c.`book_date` <= '$to_date' ";
}
if (!empty($username)) {
    $str_t_d_p .= " AND cp.username LIKE '%$username%' ";
    $str_t_d_s .= " AND c.officename LIKE '%$username%' ";
}

$str = '';

$sql = "SELECT SUM(amount) AS total_daily_payments FROM `courier_payment` AS cp  WHERE cp.payment_id > 0 AND cp.iscancelled = '0' $str_t_d_p "; 
//echo $sql;echo "<BR>";
$result_t_d_p = mysql_query($sql);
$row_t_d_p = mysql_fetch_row($result_t_d_p);
$total_daily_payment = $row_t_d_p['0'];
//------------------only for Print echo ------
$total_daily_payment_p = number_format("$total_daily_payment",2,".",",");

$sqlar = "SELECT DISTINCT(cp.courier_id) FROM `courier_payment` cp LEFT JOIN `courier` cr ON (cp.courier_id=cr.cid) WHERE cr.cid > 0 $str_t_d_p AND cr.paid_amount != 0 ";

$sqlar=mysql_query($sqlar);

$cid_arr = array();
while ($row1 = mysql_fetch_array($sqlar)) {

    $cid_arr[] = $row1['courier_id'];
}

$sqlar1 ="SELECT SUM(shipping_subtotal) as s_total FROM `courier` WHERE `cid` IN (" . implode(",", $cid_arr) . ")";

$result_t_d_s = mysql_query($sqlar1);
if($result_t_d_s){
$row_t_d_s = mysql_fetch_row($result_t_d_s);
$total_daily_sale = $row_t_d_s['0'];
//--------only for Print ---------------
$total_daily_sale_p = number_format("$total_daily_sale",2,".",",");

}
$total_daily_pay_sale = bcsub($total_daily_sale, $total_daily_payment, 2);

//--------only for Print ---------------
$total_daily_pay_sale_p = number_format("$total_daily_pay_sale",2,".",",");

//----------------------pdf code-----------
require('fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',11);	
$pdf->Cell(500, 8, '                                                                EMPLOYEE PAYMENT REPORT', 0);


$pdf->SetFont('Arial','b',9);
$heading[]=array('Invoice ID','Transaction Date','Pay',' Total Sale',' Balance');

$mheading[]=array('Username','','Total Daily Sales','Total Daily Payments','Total Balance');

$fdateheading[]=array('From Date');

$tdateheading[]=array('To Date  ');
	
//$mainheading[]=array('','','EMPLOYEE PAYMENT REPORT','','');

//-----------end--------------------


  $str = '';
                                    if (!empty($from_date)) {
                                        $str .= " AND DATE_FORMAT(cp.`date`,'%Y-%m-%d') >= '$from_date' ";
                                    }
                                    if (!empty($to_date)) {
                                        $str .= " AND DATE_FORMAT(cp.`date`,'%Y-%m-%d') <= '$to_date' ";
                                    }
                                    if (!empty($username)) {
                                        $str .= " AND cp.username LIKE '%$username%' ";
                                    }
                                     $sql = "SELECT cp.courier_id,cp.amount, cp.date, cr.shipping_subtotal,cr.paid_amount,(cr.shipping_subtotal - cr.paid_amount) as rbalance FROM `courier_payment` cp LEFT JOIN `courier` cr ON (cp.courier_id=cr.cid) WHERE cr.cid > 0 AND cp.iscancelled = '0' $str AND cr.paid_amount != 0 ORDER BY cp.date ASC";
                                   
                                    $result3 = mysql_query($sql);
                                   
                                    while ($row = mysql_fetch_array($result3)) {
                                        
$result[]=array($row['courier_id'],$row['date'],'$'.$row['shipping_subtotal'],'$'.$row['amount'],'$'.$row['rbalance']);                                
                                    }
                                    
 $mresult[]=array($username,'','$'.$total_daily_sale_p,'$'.$total_daily_payment_p,'$'.$total_daily_pay_sale_p); 
 
 $fresult[]=array($from_date);    
 $tresult[]=array($to_date);    
 
 //-------------------------------End Code--------------
// foreach($mainheading as $mainheading) {
//    $pdf->Ln();
//	foreach($mainheading as $maincolumn_heading){
//		$pdf->Cell(35,12,$maincolumn_heading,0);            
//        }
//}
//----------  Form Date ----------------------  


//----------  Form Date ----------------------  
 foreach($fdateheading as $fdateheading) {
    $pdf->Ln();
	foreach($fdateheading as $fcolumn_heading)
		$pdf->Cell(20,8,$fcolumn_heading,0);
}
foreach($fresult as $frow) {
	$pdf->SetFont('Arial','',9);	
	foreach($frow as $fcolumn)
             $pdf->SetFont('Arial','',9);
		$pdf->Cell(20,8,$fcolumn,0);
}  
//----------  T Date ----------------------  
 foreach($tdateheading as $tdateheading) {
    $pdf->Ln();
	foreach($tdateheading as $tcolumn_heading)
            $pdf->SetFont('Arial','B',9);      
		$pdf->Cell(20,8,$tcolumn_heading,0);
}
foreach($tresult as $trow) {
	$pdf->SetFont('Arial','',9);	
	foreach($trow as $tcolumn)
		$pdf->Cell(20,8,$tcolumn,0);
}  

//------------Heading----------------------  
foreach($mheading as $mheading) {
    $pdf->SetFont('Arial','B',9);
    $pdf->Ln();
	foreach($mheading as $mcolumn_heading)
		$pdf->Cell(38,8,$mcolumn_heading,0);
}
foreach($mresult as $mrow) {
	$pdf->SetFont('Arial','',9);	
	$pdf->Ln();
	foreach($mrow as $mcolumn)
		$pdf->Cell(38,8,$mcolumn,0);
}                         

//------------Secont Date Heading----------------------  

foreach($heading as $heading) {
    $pdf->SetFont('Arial','B',9);    
    $pdf->Ln();
	foreach($heading as $column_heading)
		$pdf->Cell(38,8,$column_heading,1, 0,'C');
}
foreach($result as $row) {
	$pdf->SetFont('Arial','',9);
	$pdf->Ln();
        $i=0;
	foreach($row as $column) {
                if($i>1){
		$pdf->Cell(38,8,$column,1, 0,'R');
                } else {
                $pdf->Cell(38,8,$column,1, 0,'L');
                }
        $i++; 
        }
}

//------------Third Date Heading----------------------  


$pdf->Output();
?>