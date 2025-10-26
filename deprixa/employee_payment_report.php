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

$username = $total_daily_sales = $total_daily_payment = $total_balance = '';
 $from_date = date('m-d-Y');
 $to_date = date('m-d-Y');

if (isset($_POST['submit'])) {
    $getfrom_date = $_POST['from_date'];
    $getto_date = $_POST['to_date'];
    $username = $_POST['username'];
    
     $from_date= date( "Y-m-d", strtotime( "$getfrom_date" ) );     
     $to_date= date( "Y-m-d", strtotime( "$getto_date" ) ); 
     
     
     
}
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
        <title>CARGO v10.1 | EMPLOYEE PAYMENT REPORT  </title>

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

        <!-- Date css ---->
        
        <!-- Plugins css -->
        <link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
        <link href="assets/plugins/mjolnic-bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="assets/plugins/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet">
        <link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <link href="assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        
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
                            <h4 class="header-title m-t-0 m-b-20">Employee Payment Report</h4>
           
                            <!-- =========================my Code========================= -->
                            
                                                        
                            <form name="formulario" method="post"  id="formulario" >

                                <table border="0" align="center">
                                    <tr>
                                                <td><strong>&nbsp;&nbsp;&nbsp;&nbsp; Form Date</strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td><i class="icon-append fa fa-calendar"></i>&nbsp;&nbsp;<input type="text" name="from_date" class="gentxt1 datepicker" value="<?php
                            if (!empty($getfrom_date)) {
                                echo $getfrom_date;
                            } else {
                                echo date('Y-m-d');
                            }
                            ?>"  /></td>
                                          <td>&nbsp;&nbsp;&nbsp;&nbsp;TO&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td><i class="icon-append fa fa-calendar"></i>&nbsp;&nbsp;<input type="text" name="to_date"  class="gentxt1 datepicker" value="<?php
                                            if (!empty($getto_date)) {
                                                echo $getto_date;
                                            } else {
                                                echo date('Y-m-d');
                                            }
                            ?>"   /></td>

                                                             
                                    </tr>
                                </table><br>

                                <div class="row" >
                                    <div class="col-sm-3 form-group">
                                        <label  class="control-label">Username:<span class="required-field"></span></label>
                                        <select name="username" id="product_type" class="product_type form-control">
                                            <option value="" >Select Name</option>
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
                                        <label class="control-label">Total Daily Sales</label>
                                        <input type="text" name="" id="txt_sendername" class="form-control"  value="<?php echo $total_daily_sale_p ?>"  placeholder="">
                                    </div>

                                    <div class="col-sm-3 form-group">
                                        <label class="control-label">Total Daily Payments</label>
                                        <input type="text" name="" id="txt_receivername" class="form-control"  value="<?php echo $total_daily_payment_p; ?>" placeholder="">
                                    </div>


                                    <div class="col-sm-3 form-group">
                                        <label class="control-label">Total Balance</label>
                                        <input type="text" name="" id="txt_receivername" class="form-control"  value="<?php if($total_daily_pay_sale_p != "0") { echo $total_daily_pay_sale_p; } else { echo ""; }?>" placeholder="">
                                    </div>

                                    <div class="col-sm-12 form-group" align="right">
                                        <input type="submit" class="btn btn-md btn-info" value="Search" name="submit"  id="submit">
                                       
                                    </div>
                                </div>

                            <!-- ========================= End my Code========================= -->


<a  class="btn btn-md print-btn btn-secondary" <?php if($total_daily_sale !="") {  ?> href="employee_pdf.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&username=<?php echo $username; ?>" <?php } ?> target="_blank" >Print</a>

                            <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <style> .Finished { background: #363C56; } .Delayed { background: #F76063; } .On-Hold { background: #4ECCDB; } .Landed { background: #FF8A4B; } .label{padding: 5px;} .In-Transit { background:#00D96D; }</style>
                                <style> .Paid { background: #675F99; } .ToPay { background: #FF8441; } .Cash-on-Delivery { background: #F6565A; } </style>
                                
                                 
                                       
                         
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <th>Payment Trans Date </th>
                                        <th>Order Sales Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Open Balance</th>
                                    </tr>
                                </thead>
                              
                                <tbody>

                                    <?php    
                                   
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
                                    $sql = "SELECT cp.courier_id,cr.invoice_number,cp.amount, cp.date, cr.shipping_subtotal,cr.paid_amount,(cr.shipping_subtotal - cr.paid_amount) as rbalance FROM `courier_payment` cp LEFT JOIN `courier` cr ON (cp.courier_id=cr.cid) WHERE cr.cid > 0 AND cp.iscancelled = '0' $str AND cr.paid_amount != 0 ORDER BY cp.date ASC";
                                   
                                    $result3 = mysql_query($sql);
                                    while ($row = mysql_fetch_array($result3)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['invoice_number']; ?></td>
                                            <td><?php echo $row['date']; ?></td>
                                            <td><?php echo $row['shipping_subtotal']; ?></td>
                                            <td><?php echo $row['amount']; ?></td>
                                            <td><?php echo $row['rbalance']; ?></td>
                                        </tr>
<?php } ?>
                                </tbody>
                                 
                            </table>
                           
                             
                            </form>
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
<!--        <script src="assets/plugins/datatables/jszip.min.js"></script>-->
<!--        <script src="assets/plugins/datatables/pdfmake.min.js"></script>-->
        <script src="assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="assets/plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

<!--        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>-->
        
        <!--   --- Date -----------  -->
          <script src="assets/plugins/moment/moment.js"></script>
       
        <script src="assets/plugins/mjolnic-bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
	
        <script src="assets/plugins/clockpicker/bootstrap-clockpicker.js"></script>
<!--        <script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>-->
<!--        <script src="assets/pages/jquery.form-pickers.init.js"></script>-->

        <script type="text/javascript">
            
            $('.datepicker').datepicker({
                     format: 'yyyy-mm-dd',
                     autoclose: true,
            });
            
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
        <style>
            a.btn.btn-md.print-btn.btn-secondary {
                     position: absolute;
}           
        </style>
        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script src="js/myjava.js"></script>
        <script src="js/payments_list.js"></script>
    </body>
    
</html>