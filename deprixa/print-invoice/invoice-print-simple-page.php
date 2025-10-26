<?php
// *************************************************************************
// *                                                                       *
// * CARGO v10.0 -  logistics Worldwide Software                           *
// * Copyright (c) CNSWARE INC. All Rights Reserved                        *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: INFO@CNSWARE.COM                                               *
// * Website: http://www.cnsware.com                                       *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// *                                                                       *
// *                                                                       *
// *                                                                       *
// ***
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// * If you Purchased from Codecanyon, Please read the full License from   *
// * here- http://codecanyon.net/licenses/standard                         *
// *                                                                       *
// *************************************************************************

error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require_once('../database.php');
$cid= (int)$_GET['cid'];
$getdd = array($cid);

if (isset($_POST['pinvoice'])) {
    $getdd = $_POST['pinvoice'];
} 
    
    foreach ($getdd as $cid) {

        $sql = "SELECT *
		FROM courier
		WHERE cid = $cid";
        $result = dbQuery($sql);
        while ($row = dbFetchAssoc($result)) {
            extract($row);
        }
        $company = mysql_fetch_array(mysql_query("SELECT * FROM company"));
        $fecha = date('Y-m-d');

        $city1 = mysql_query("SELECT city_name FROM city WHERE city_id = '$s_city'");
        while ($city_name1 = mysql_fetch_array($city1)) {
            $s_city = $city_name1['city_name'];
        }


        $state1 = mysql_query("SELECT state_name FROM state WHERE state_id = '$s_state'");
        while ($state_name1 = mysql_fetch_array($state1)) {
            $s_state = $state_name1['state_name'];
        }

        $city2 = mysql_query("SELECT city_name FROM city WHERE city_id = '$r_city'");
        while ($city_name2 = mysql_fetch_array($city2)) {
            $r_city = $city_name2['city_name'];
        }

        $state2 = mysql_query("SELECT state_name FROM state WHERE state_id = '$r_state'");
        while ($state_name2 = mysql_fetch_array($state2)) {
            $r_state = $state_name2['state_name'];
        }

        $sql2 = mysql_query("SELECT user,officename FROM courier WHERE cid = $cid");
        while ($created_by = mysql_fetch_array($sql2)) {
            $user = $created_by['user'];
            $officename = $created_by['officename'];
        }
        if ($user == 'Administrator' || $user == 'ADMINISTRATOR') {
            $sql3 = mysql_query("SELECT name_parson FROM manager_admin WHERE name = '$officename'");
            while ($created_by2 = mysql_fetch_array($sql3)) {
                $created_user = $created_by2['name_parson'];
            }
        } else {
            $sql3 = mysql_query("SELECT name_parson FROM manager_user WHERE name = '$officename'");
            while ($created_by2 = mysql_fetch_array($sql3)) {
                $created_user = $created_by2['name_parson'];
            }
        }

        $sql5 = mysql_query("SELECT mu.flag, mu.phone, mu.name, c.officename, schedule, payment_due, invoice_number  FROM manager_user mu LEFT JOIN courier c ON (mu.name = c.officename) WHERE c.cid = $cid ");
        while ($created_by5 = mysql_fetch_array($sql5)) {
            $flag = $created_by5['flag'];
            $e_phone = $created_by5['phone'];
			$schedule = $created_by5['schedule'];
			$payment_due = $created_by5['payment_due'];
			$invoice_number = $created_by5['invoice_number'];
        }
        ?>

            <!DOCTYPE html>
            <html>
            <head>
                <title>Receipt</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <style>
                    @media print {
                        @page {
                            size: 80mm auto;
                            margin: 0.2cm;
                            size: 8.5in 5.5in;
                            size: portrait;
                        }
                        
            
                        body {
                            width: 196px;
                            margin: 0;
                            font-family: monospace;
                            font-size: 10px;
                            line-height: 1.2;
                        }
                        
                        tr.hwt_font_normal td {
                            font-size: 12px;
                        }
            
                        .receipt {
                            width: 100%;
                            padding: 5px;
                        }
            
                        .center {
                            text-align: center;
                        }
            
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
            
                        td, th {
                            padding: 3px 0;
                            text-align: left;
                        }
            
                        .border-top {
                            border-top: 1px dashed #000;
                        }
            
                        .totals td {
                            text-align: right;
                        }
                       
                    }
                </style>
            </head>
            <body onload="window.print();">
            <!--<body>-->
                <div class="receipt" style="width: 196px;">
                    <div class="center">
                        <img src="../images/logo.png?id=1" style="max-width: 100%; height: auto;" /><br>
                        <strong style="font-size:12px;"><?php echo $company['cname']; ?></strong><br>
                        <span style="font-size:12px;"><?php echo nl2br($company['caddress']); ?></span><br>
                        <span style="font-size:12px;">Tel: <?php echo $flag == 1 ? $e_phone : $company['cphone']; ?></span>
                    </div>
            
                    <hr>
            
                    <strong style="font-size:14px;">From:</strong>
                    <span style="font-size:12px;"><?php echo $ship_name; ?></span><br>
                    <span style="font-size:12px;"><?php echo $phone; ?></span><br>
                    <span style="font-size:12px;"><?php echo $s_add . ', ' . $s_city . ', ' . $s_state . ' ' . $s_zipcode; ?></span>
            
                    <strong style="font-size:14px;">To:</strong>
                    <span style="font-size:12px;"><?php echo $rev_name; ?></span><br>
                    <span style="font-size:12px;"><?php echo $r_phone; ?></span><br>
                    <span style="font-size:12px;"><?php echo $r_add . ', ' . $r_city . ', ' . $r_state . ' ' . $r_zipcode; ?></span>
            
                    <hr>
                    <center>
                        <img src="barcode.php?text=testing" alt="testing" /><br>
                        <?php echo $cons_no; ?><br>
                    </center>
                    <hr>
                    
                    <center>
                        <img src="barcode.php?text=<?php $cid ?>" alt="testing" /><br>
                    </center>
                    
                    <hr>
            
                    <strong style="font-size:12px;">Order ID:</strong> <span style="font-size:12px;"><?php echo $invoice_number; ?><span><br>
                    <strong style="font-size:12px;">Due:</strong> <span style="font-size:12px;"><?php echo $payment_due; ?><span><br>
                    <strong style="font-size:12px;">Delivery:</strong> <span style="font-size:12px;"><?php echo $schedule; ?><span><br>
                    <strong style="font-size:12px;">Mode:</strong> <span style="font-size:12px;"><?php echo $book_mode; ?><span><br>
                    <strong style="font-size:12px;">Container:</strong> <span style="font-size:12px;"><?php echo $container_number; ?><span><br>
                    <strong style="font-size:12px;">Created by:</strong> <span style="font-size:12px;"><?php echo $created_user; ?><span><br>
            
                    <hr>
            
                    <table>
                        <thead>
                            <tr>
                                <th style="font-size:12px;">QTY</th>
                                <th style="font-size:12px;">Product</th>
                                <th style="font-size:12px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $courier_item = mysql_query("SELECT * FROM courier_item WHERE cid = '$cid'");
                        while ($item = mysql_fetch_array($courier_item)) {
                        ?>
                            <tr>
                                <td style="font-size:12px;"><?php echo $item['ship_qty']; ?></td>
                                <td style="font-size:8px;"><?php echo $item['product_name']; ?></td>
                                <td style="font-size:8px;"><?php echo $company['currency'].$item['sub_total']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
            
                    <hr class="border-top">
            
                    <table class="totals">
                        <tr>
                            <td>Total:</td>
                            <td><?php echo $company['currency'] . ' ' . $shipping_subtotal; ?></td>
                        </tr>
                        <tr>
                            <td>Paid:</td>
                            <td>
                            <?php
                                $paid = 0;
                                $result = mysql_query("SELECT sum(amount) FROM `courier_payment` WHERE courier_id = '$cid'");
                                if ($row = mysql_fetch_array($result)) {
                                    $paid = $row[0];
                                }
                                echo $company['currency'] . ' ' . number_format($paid, 2);
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Balance:</td>
                            <td><?php echo $company['currency'] . ' ' . number_format($shipping_subtotal - $paid, 2); ?></td>
                        </tr>
                    </table>
            
                    <hr>
            
                    <?php if (!empty($comments)) { ?>
                        <strong>Note:</strong><br>
                        <p><?php echo $comments; ?></p>
                    <?php } ?>
            
                    <div class="center">
                        Thank you for your business!
                    </div>
                </div>
            </body>
            </html>


        <?php
    }
 ?>