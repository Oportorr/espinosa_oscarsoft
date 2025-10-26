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

$select_container_num = $bookingmode = '';
$from_date = date('Y-m-d');
$to_date = date('Y-m-d');

if (isset($_POST['submit'])) {
    $select_container_num = $_POST['select_container_num'];
    }
//----------------------------------------------
$str = '';
// Search Variables are Here.....
if (!empty($select_container_num)) {
    $str .= " AND c.container_number LIKE '%".$select_container_num."%'";
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
                            <h4 class="header-title m-t-0 m-b-20">Container Details Listing Report</h4>
                <!-- =========================my Code========================= -->
                            <?php
                            $from_date1 = date('Y-m-d');
                            $to_date1 = date('Y-m-d');
                            ?>                            
                            <form name="formulario" method="post" id="formulario">
                               <div class="row" >
                                   <div class="col-sm-3 form-group">
									  <label  class="control-label">Container Number<span class="required-field"></span>
									  </label>
										<input type="text" name="select_container_num" id="select_container_num" class="form-control"  value="<?php echo $select_container_num; ?>"  placeholder="Enter Container Number">
                                    </div>
									<div class="col-sm-3 form-group">
                                       <label class="control-label"></label>
                                        <input type="submit" class="btn btn-md btn-info " value="Search" name="submit"  id="submit" style="    margin-top: 30px;">
                                    </div>
                                </div>
                           </form>
                        <!-- ========================= End my Code========================= -->
                            <a class="btn btn-md print-btn btn-secondary"  href="container_details_list_report_pdf.php?select_container_num=<?php echo $select_container_num; ?>" target="_blank" >Print</a>

                            <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <style> .Finished { background: #363C56; } .Delayed { background: #F76063; } .On-Hold { background: #4ECCDB; } .Landed { background: #FF8A4B; } .label{padding: 5px;} .In-Transit { background:#00D96D; }</style>
                                <style> .Paid { background: #675F99; } .ToPay { background: #FF8441; } .Cash-on-Delivery { background: #F6565A; } </style>
                                <thead>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Sender Name</th>
                                        <th>Sender Address</th>
                                        <th>Sender Telephone</th>
                                        <th>Recipient Name</th>
                                        <th>Recipient Address</th>
										<th>Recipient Telephone</th>
										<th>Cedula Number</th>
										<th>Invoice Description</th>
									 </tr>
                                </thead>
                             <tbody>
                    <?php
                       $rs = "SELECT c.* FROM `courier` c
					   where c.cid > 0 $str ORDER BY c.cid ASC";
                       $getresult = mysql_query($rs);
                       while ($row = mysql_fetch_array($getresult)){
                       ?>
                       <tr>
								<td><?php echo $row['invoice_number']; ?></td>
								<td><?php echo $row['ship_name']; ?></td>
								<td><?php echo $row['s_add']; ?></td>  
								<td><?php echo $row['phone']; ?></td>
								<td><?php echo $row['rev_name']; ?></td>
								<td><?php echo $row['r_add']; ?></td>
								<td><?php echo $row['r_phone']; ?></td>  
								<td><?php echo $row['r_cedula_number']; ?></td>  
								<td><?php echo $row['comments']; ?></td>  
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