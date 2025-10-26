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
// *************************************************************************

error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require_once('database.php');
require_once('library.php');
isUser();

$select_container_num = $bookingmode = $zone = '';
$from_date = date('Y-m-d');
$to_date = date('Y-m-d');

if (isset($_POST['submit'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $select_container_num = $_POST['select_container_num'];
    $bookingmode = $_POST['bookingmode'];
    $username = $_POST['username'];
    $zone = $_POST['zone'];
}
//----------------------------------------------
$str_t_d_s = '';
if (!empty($username)) {
    $str_t_d_s .=" AND c.officename LIKE '%$username%'";
}

//if (!empty($from_date)) {  
//    $str_t_d_s .= " AND c.`book_date` >= '$from_date' ";
//}
//if (!empty($to_date)) {   
//    $str_t_d_s .= " AND c.`book_date` <= '$to_date' ";
//}
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
if(!empty($zone)){
    $zonestate = $zonecity = '';
    $zoneStateArr = mysql_query("SELECT state_id FROM zone_state WHERE zone_id = '$zone'");
    while ($zsrow = mysql_fetch_array($zoneStateArr)) {
         $zonestate .= $zsrow['state_id'].', ';
    }
    $zonestate = rtrim($zonestate, ', '); 

    $zoneCityArr = mysql_query("SELECT city_id FROM zone_city WHERE zone_id = '$zone'");
    while ($zcrow = mysql_fetch_array($zoneCityArr)) {
         $zonecity .= $zcrow['city_id'].', ';
    }
    $zonecity = rtrim($zonecity, ', ');

    $str .=" AND c.r_city IN ($zonecity) AND c.r_state IN ($zonestate)";
}
//----------------------------------------------
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Page Description and Author -->
        <meta name="description" content="Cargo V10.1"/>
        <meta name="keywords" content="Cargo Web System" />
        <meta name="author" content="CNSWARE INC">

        <!-- App Favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App title -->
        <title>CARGO v10.1 | Container Report  </title>

        <!-- Switchery css -->
        <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" />

        <!-- DataTables -->
        <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- App CSS -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="bower_components/animate.css/animate.css" type="text/css" />
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css" type="text/css" />
        <link rel="stylesheet" href="bower_components/simple-line-icons/css/simple-line-icons.css" type="text/css" />
        <link rel="stylesheet" href="css/footer-basic-centered.css">

    </head>
    <body>
        <?php include("header.php"); ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="wrapper">
            <div class="container">

                <!-- Page-Title -->
                <?php
                include("icon_settings.php");
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">                            
                            <h4 class="header-title m-t-0 m-b-20">Container Report</h4>

                            <!-- =========================my Code========================= -->
                            <?php
                            $from_date1 = date('Y-m-d');
                            $to_date1 = date('Y-m-d');
                            ?>                            
                            <form  name="formulario" method="post" id="formulario" >

                                <div class="row" >
                                    
                                    <div class="col-sm-3 form-group">
                                        <label  class="control-label">Zone:<span class="required-field"></span></label>
                                        <select name="zone" id="zone" class="product_type form-control">
                                            <option value="" >Select All</option>
                                            <?php
                                            $stmt = mysql_query("SELECT id, name FROM zone ORDER BY `name` ASC ");
                                            while ($row = mysql_fetch_array($stmt)) {
                                                $selected = "";
                                                if ($row['id'] == $zone) {
                                                    $selected = 'selected = "selected"';
                                                }
                                                ?>
                                                <option value="<?php echo $row['id']; ?>" <?php echo $selected ?>  ><?php echo $row['name']; ?></option>
                                                <?php
                                            } ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-3 form-group">
                                        <label  class="control-label">Username:<span class="required-field"></span></label>
                                        <select name="username" id="product_type" class="product_type form-control">
                                            <option value="" >Select All</option>
                                            <?php
                                            $stmt = mysql_query("SELECT * FROM `manager_admin` where estado=1 ORDER BY `name_parson` ASC ");
                                            while ($row = mysql_fetch_array($stmt)) {
                                                $selected = "";
                                                if ($row['name'] == $username) {
                                                    $selected = 'selected = "selected"';
                                                }
                                                ?>
                                                <option value="<?php echo $row['name']; ?>" <?php echo $selected ?>  ><?php echo $row['name_parson']; ?></option>
                                                <?php
                                            }

                                            $stmt1 = mysql_query("SELECT * FROM `manager_user` where estado=1 ORDER BY `name_parson` ASC ");
                                            while ($row1 = mysql_fetch_array($stmt1)) {
                                                $selected = "";
                                                if ($row1['name'] == $username) {
                                                    $selected = 'selected = "selected"';
                                                }
                                                ?>
                                                <option value="<?php echo $row1['name']; ?>" <?php echo $selected ?>  ><?php echo $row1['name_parson']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>                                 

                                    <div class="col-sm-3 form-group">
                                        <label  class="control-label">Container Number<span class="required-field"></span></label>
                                        <select name="select_container_num" id="select_container_num" class="product_type form-control">
                                            <option value="" >Select Container Number</option>
                                            <?php
              
                                            $stmt = mysql_query("SELECT * FROM `courier_container`");
                                            while ($row = mysql_fetch_array($stmt)) {
                                                $selected = "";
                                                if ($row['container_id'] == $select_container_num) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option value="<?php echo $row['container_id']; ?>" <?php echo $selected; ?> ><?php echo $row['container_number']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-3 form-group">
                                        <label  class="control-label">Pay Mode<span class="required-field"></span></label>
                                        <select name="bookingmode" class="form-control"  id="bookingmode">
                                            <option value="">All Payment </option>

                                            <option value="Paid" <?php
                                            if ($bookingmode == "Paid") {
                                                echo 'selected="selected"';
                                            }
                                            ?> >Paid</option>
                                            <option value="Pending" <?php
                                            if ($bookingmode == "Pending") {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Pending</option>
                                            <option value="Cash-on-Delivery" <?php
                                            if ($bookingmode == "Cash-on-Delivery") {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Cash on Delivery</option>
                                            <option value="Partial" <?php
                                            if ($bookingmode == "Partial") {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Partial</option>
                                        </select>
                                    </div>

                                </div>


                                <!-- -------------------------------       ----------------------------------- -->

                                <div class="row" >

                                    <div class="col-sm-3 form-group">
                                        <label class="control-label">Container Total Sales:</label>
                                        <input type="text" name="" id="txt_sendername" class="form-control"  value="<?php echo $total_sale_rs_p; ?>"  placeholder="">
                                    </div>

                                    <div class="col-sm-3 form-group">
                                        <label class="control-label">Unpaid Total Amount:</label>
                                        <input type="text" name="" id="txt_receivername" class="form-control"  value="<?php echo $total_unpaid_rs_p; ?>" placeholder="">
                                    </div>

                                    <div class="col-sm-3 form-group">
                                        <label class="control-label">Paid Total Amount:</label>
                                        <input type="text" name="" id="txt_receivername" class="form-control"  value="<?php echo $total_paid_rs_p; ?>" placeholder="">
                                    </div>

                                    <div class="col-sm-3 form-group">
                                        <label class="control-label"></label>
                                        <input type="submit" class="btn btn-md btn-info " value="Search" name="submit"  id="submit" style="    margin-top: 30px;
                                               ">
                                    </div>


                                </div>

                            </form>


                            <!-- ========================= End my Code========================= -->
                            <a class="btn btn-md print-btn btn-secondary"  href="container_pdf.php?zone=<?php echo $zone; ?>&select_container_num=<?php echo $select_container_num; ?>&bookingmode=<?php echo $bookingmode; ?>&username=<?php echo $username; ?>" target="_blank" >Print</a>


                            <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <style> .Finished { background: #363C56; } .Delayed { background: #F76063; } .On-Hold { background: #4ECCDB; } .Landed { background: #FF8A4B; } .label{padding: 5px;} .In-Transit { background:#00D96D; }</style>
                                <style> .Paid { background: #675F99; } .ToPay { background: #FF8441; } .Cash-on-Delivery { background: #F6565A; } </style>
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <th>Payment Amount </th>
                                        <th>Balance Due</th>
                                        <th>Sender Address</th>
                                        <th>Shipping Notes</th>
                                        <th>Delivery Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                  
                                    
                    <?php
                            $rs = " SELECT c.cid,c.invoice_number,c.ship_name,c.status_delivered,c.status,c.s_zipcode,c.comments,c.s_add,c.paid_amount,c.shipping_subtotal,c.paid_amount, ct.city_name , st.state_name , co.country_name FROM `courier` c
                                             LEFT JOIN `city` ct ON (ct.city_id = c.r_city)
                                             LEFT JOIN `state` st ON (st.state_id = c.r_state)
                                             LEFT JOIN `country` co ON (co.country_id = c.r_country)
                                             where c.cid > 0 $str ORDER BY c.cid ASC";
                            $getresult = mysql_query($rs);
                                    while ($row = mysql_fetch_array($getresult)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['invoice_number']; ?></td>
                                            <td><?php echo $row['paid_amount']; ?></td>
                                            <td><?php echo $inquedata = bcsub($row['shipping_subtotal'], $row['paid_amount'], 2); ?></td>  
                                            <td>
                                                <?php echo $row['ship_name']; ?><br>
                                                <?php echo $row['s_add']; ?><br>
                                                <?php echo $row['city_name']; ?>, <?php echo $row['state_name']; ?>, <?php echo $row['s_zipcode']; ?>, <?php echo $row['country_name']; ?>
                                            </td>
                                            
                                            <td><?php echo $row['comments']; ?></td>
                                            <td>
                                             <?php echo $row['status']; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>


                            </table>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <!-- Footer -->
                <?php
                include("footer.php");
                ?>
                <!-- End Footer -->

            </div> <!-- container -->
        </div> <!-- End wrapper -->



        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/tether.min.js"></script><!-- Tether for Bootstrap -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/plugins/switchery/switchery.min.js"></script>

        <!-- Required datatable js -->
        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="assets/plugins/datatables/jszip.min.js"></script>
        <script src="assets/plugins/datatables/pdfmake.min.js"></script>
        <script src="assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="assets/plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#datatable').DataTable();

                //Buttons examples
                var table = $('#datatable-buttons').DataTable({
                    lengthChange: false,
                    buttons: []
                });

                table.buttons().container()
                        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            });

        </script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script src="js/myjava.js"></script>
        <script src="js/payments_list.js"></script>
 <style>
            a.btn.btn-md.print-btn.btn-secondary {
    position: absolute;
    z-index: 9;
}           
        </style>      
    </body>
</html>