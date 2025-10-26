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

        $sql5 = mysql_query("SELECT mu.flag, mu.phone, mu.name, c.officename FROM manager_user mu LEFT JOIN courier c ON (mu.name = c.officename) WHERE c.cid = $cid ");
        while ($created_by5 = mysql_fetch_array($sql5)) {
            $flag = $created_by5['flag'];
            $e_phone = $created_by5['phone'];
        }
        ?>

        <!DOCTYPE html>
        <html>
            <head>
                <title>DEPRIXA | Invoice</title>

                <!-- Define Charset -->
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

                <!-- Page Description and Author -->
                <meta name="description" content="Courier Deprixa V2.5 "/>
                <meta name="keywords" content="Courier DEPRIXA-Integral Web System" />
                <meta name="author" content="Jaomweb">

                <!-- Tell the browser to be responsive to screen width -->
                <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
                <!-- Bootstrap 3.3.4 -->
                <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
                <!-- Font Awesome Icons -->
                <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
                <!-- Ionicons -->
                <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
                <!-- Theme style -->
                <link href="css/print-invoice.min.css" rel="stylesheet" type="text/css" />

                <script src="barcode.js"></script>

                <style media="print">
                    @media print {
                        @page { margin: 0; }
                        body { margin: 1.6cm; }
                        footer {page-break-after: always;}
                    }
                </style>

            </head>
            <body onload="window.print();">
                <div class="wrapper">

                    <!-- Main content -->
                    <section class="invoice">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-xs-12">

                                <span><img src="../image_logo.php?id=1"><br>

                                    <p style="font-size:15px; padding-top: 10px;">  <?php echo nl2br($company['caddress']); ?><br>
                                        Tel:<?php
                                        if ($flag == 1) {
                                            echo $e_phone;
                                        } else {
                                            echo $company['cphone'];
                                        }
                                        ?></p>



                            </div><!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <h4><strong><?php echo $ship_name; ?></strong></h4><br>

                                    <b>Phone:</b>  <?php echo $phone; ?><br/>
                                    <b>Address:</b> <?php echo $s_add; ?><br/>
                                    <b>City:</b> <?php echo $s_city; ?><br/>
                                    <b>State:</b> <?php echo $s_state; ?><br/>
                                    <b>ZIP CODE (US):</b> <?php echo $s_zipcode; ?><br/>

                                </address>
                            </div><!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <h4><strong><?php echo $rev_name; ?></strong></h4><br>

                                    <b>Phone:</b> <?php echo $r_phone; ?><br/>
                                    <b>Address:</b> <?php echo $r_add; ?><br/>
                                    <b>City:</b> <?php echo $r_city; ?><br/>
                                    <b>State:</b> <?php echo $r_state; ?><br/>
                                    <b>ZIP CODE(DR):</b> <?php echo $r_zipcode; ?><br/>

                                </address>
                            </div><!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <table>
                                    <tr>
                                        <td>
                                    <center>
                                        <img src="barcode.php?text=testing" alt="testing" /><br>
                                        <?php echo $cons_no; ?><br>
                                    </center>
                                    </td>

                                    </tr>
                                </table>
                                <br/>
                                <table>
                                    <tr>
                                        <td>
                                    <center>
                                        <img src="barcode.php?text=<?php $cid ?>" alt="testing" /><br>
                                    </center>
                                    </td>

                                    </tr>
                                </table>
                                <b>Order ID:</b>&nbsp;&nbsp;<?php echo $cid; ?><br/>
                                <b>Payment Due:</b>&nbsp;<?php echo $book_date; ?><br/>
                                <b>Payment Mode:</b> <small class="label label-danger"><i class="fa fa-money"></i>&nbsp;&nbsp;<?php echo $book_mode; ?></small><br/>
                                <b>Container:</b>&nbsp;<?php echo $container_number; ?>&nbsp;<br/>
                                <b>Created by:</b>&nbsp;<?php echo $created_user; ?>&nbsp;<br/>
                            </div><!-- /.col -->
                        </div><!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-xs-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Product</th>
                                            <th>Status</th>
                                            <th>Price</th>
                                            <th>Discount</th>
                                            <th>Subtotal</th>
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
                                                <td><small class="label label-success"><?php echo $status; ?></small></td>
                                                <td><?php echo $item['product_price']; ?></td>
                                                <td><?php echo $item['discount']; ?></td>
                                                <td><?php echo $company['currency']; ?>&nbsp;<?php echo $item['sub_total']; ?></td>
                                                <!--<td><?php echo $comments; ?></td>-->
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <br>
                        <br>
                        <div class="row">
                            <!-- accepted payments column -->
                            <?php if (!empty($comments)) { ?>
                                <div class="col-xs-6">
                                    <p class="lead"> NOTE :</p>
                                    <p class="text-muted well well-sm no-shadow">
                                        <?php echo $comments; ?>
                                    </p>
                                </div>
                            <?php } ?>

                            <div class="col-xs-4" style="float: right;">
                                <p class="lead">Amount Due </p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Total Amount:</th>
                                            <td><?php echo $company['currency']; ?>&nbsp;<?php echo $shipping_subtotal; ?></td>
                                        </tr>
                                        <tr>

                                            <?php
                                            $courier_item = mysql_query("SELECT sum(amount) FROM `courier_payment` WHERE courier_id = '$cid'");
                                            while ($item = mysql_fetch_array($courier_item)) {
                                                if (!empty($item['sum(amount)'])) {
                                                    $paid = $item['sum(amount)'];
                                                } else {
                                                    $paid = '0';
                                                }
                                                ?>
                                                <th>Paid:</th>
                                                <td><?php echo $company['currency']; ?>&nbsp;<?php echo $paid; ?></td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <th>Balance:</th>
                                            <td><?php echo $company['currency']; ?>&nbsp;<?php echo number_format($shipping_subtotal - $paid, 2); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </section><!-- /.content -->
                </div><!-- ./wrapper -->
                <footer></footer>
            </body>

        </html>
        <?php
    }
 ?>