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
                        <strong><?php echo $company['cname']; ?></strong><br>
                        <?php echo nl2br($company['caddress']); ?><br>
                        Tel: <?php echo $flag == 1 ? $e_phone : $company['cphone']; ?>
                    </div>
            
                    <hr>
            
                    <strong>From:</strong><br>
                    <?php echo $ship_name; ?><br>
                    <?php echo $phone; ?><br>
                    <?php echo $s_add . ', ' . $s_city . ', ' . $s_state . ' ' . $s_zipcode; ?><br>
            
                    <strong>To:</strong><br>
                    <?php echo $rev_name; ?><br>
                    <?php echo $r_phone; ?><br>
                    <?php echo $r_add . ', ' . $r_city . ', ' . $r_state . ' ' . $r_zipcode; ?><br>
            
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
            
                    <strong>Order ID:</strong> <?php echo $invoice_number; ?><br>
                    <strong>Due:</strong> <?php echo $payment_due; ?><br>
                    <strong>Delivery:</strong> <?php echo $schedule; ?><br>
                    <strong>Mode:</strong> <?php echo $book_mode; ?><br>
                    <strong>Container:</strong> <?php echo $container_number; ?><br>
                    <strong>Created by:</strong> <?php echo $created_user; ?><br>
            
                    <hr>
            
                    <table>
                        <thead>
                            <tr>
                                <th>QTY</th>
                                <th>Product</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $courier_item = mysql_query("SELECT * FROM courier_item WHERE cid = '$cid'");
                        while ($item = mysql_fetch_array($courier_item)) {
                        ?>
                            <tr>
                                <td><?php echo $item['ship_qty']; ?></td>
                                <td><?php echo $item['product_name']; ?></td>
                                <td><?php echo $company['currency'] . ' ' . $item['sub_total']; ?></td>
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