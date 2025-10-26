<?php
// *************************************************************************
// *                                                                       *
// * DEPRIXA -  logistics Worldwide Software                               *
// * Copyright (c) JAOMWEB. All Rights Reserved                            *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: osorio2380@yahoo.es                                            *
// * Website: http://www.jaom.info                                         *
// *                                                                       *
// *************************************************************************
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
require_once('database.php');
require_once('library.php');

$company = mysql_fetch_array(mysql_query("SELECT * FROM company"));
isUser();
?>
<?php
if(isset($_POST['submit']))
  {
    foreach ($_POST['check'] as $value) {
      $sql="update courier SET status='Delivered' WHERE cid = $value";
      $result= mysql_query($sql);
  }
}
?>
<!DOCname html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- Page Description and Author -->
        <meta name="description" content="Courier Deprixa V2.5 "/>
        <meta name="keywords" content="Courier DEPRIXA-Integral Web System" />
        <meta name="author" content="Jaomweb" />

        <!-- App Favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico" />

        <!-- App title -->
        <title>CARGO v10.1 | List of Shipments </title>

        <!-- Switchery css -->
        <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" />

        <!-- Sweet Alert css -->
        <link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" name="text/css" />
        <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" name="text/css" />
        <!-- Responsive datatable examples -->
        <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" name="text/css" />

        <!-- App CSS -->
        <link href="assets/css/style.css" rel="stylesheet" name="text/css" />
        <style> .delivered { background: #363C56; } .Delayed { background: #F76063; } .On-Hold { background: #4ECCDB; } .Landed { background: #FF8A4B; } .Finished { background: #333333; } .label{padding: 5px;} .In-Transit { background:#00D96D; } .OK { background:#00D96D; } .&nbsp;&nbsp; { background:#F1B53D; }
        </style>
        <style> .Paid { background: #675F99; } .ToPay { background: #FF8441; } .Cash-on-Delivery { background: #F6565A; } .Partial{ background: #f1b53d; } .Shipment-arrived { background: #FFC734; } .Returned { background: #F6565A; } .Pending { background: #FF5D48; } .Bank { background: #999; } .Paypal { background: #4DD2FF; }
        </style>


        <!-- App CSS -->
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />
        <link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" />
        <!-- <link href="assets/plugins/mjolnic-bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" /> -->
        <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" />
        <link href="assets/plugins/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" />
        <link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
        <link href="assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />

        <link href="js/css/dataTables.bootstrap.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script >
            function unselectall() {
                //alert("enter");
                if ($("#checkAll").is(':checked')) {
                    $('input:checkbox').prop('checked', true);
                } else {
                    $('input:checkbox').prop('checked', false);
                }
            }
        </script>
    </head>
    <body>
        <?php
        include("header.php");
        ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="wrapper">
            <div class="container">

                <!-- Page-Title -->
                <?php
                include("icon_settings.php");
                ?>

                <!-- star row Administrator-->

                <div class="row">
                    <?php
                    $sql_1 = mysql_query("SELECT container_number FROM courier_container WHERE  container_status='1' ORDER BY  `container_id` DESC
LIMIT 1 ");
                    $cn = mysql_fetch_array($sql_1);
                    $cn = $cn['container_number'];


                    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
                        $user = $_SESSION['user_name'];
                        $officename = $_SESSION['user_type'];
                        ?>
                        <?php
                        // Always first connect to the database mysql
                        $sql = "SELECT * FROM courier WHERE  status='In-Transit' AND container_number = '$cn' ";  // sentence sql
                        $result = mysql_query($sql);
                        $numero1 = mysql_num_rows($result); // get the number of rows
                        ?>
                        <div class="col-xs-6 col-md-3 col-lg-3 col-xl-2">
                            <div class="card-box tilebox-one cl-box">
                                <i class="icon-plane pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20">Shipping In Transit</h6>
                                <h2 class="m-b-20" data-plugin="counterup"><?php echo $numero1; ?></h2>
                                <span class="label label-success">
                                    <?php
                                    $sql_1 = mysql_query("SELECT concat(round(count( * ) *100 /(SELECT count( * ) FROM courier)) , \"%\") AS percent
								FROM courier WHERE  status = 'In-Transit' AND container_number = '$cn' GROUP BY status");

                                    while ($rr = mysql_fetch_array($sql_1))
                                        for ($i = 0; $i < mysql_num_fields($sql_1); $i++)
                                            echo $rr[$i] . " ";
                                    echo "<br>";
                                    ?>
                                </span> <span class="text-muted">Shipments In Transit</span>
                            </div>
                        </div>

                        <?php
                        // Always first connect to the database mysql
                        $sql = "SELECT * FROM courier_online WHERE  status='In-Transit' ";  // sentence sql
                        $result = mysql_query($sql);
                        $numero2 = mysql_num_rows($result); // get the number of rows
                        ?>
                        <div class="col-xs-6 col-md-3 col-lg-3 col-xl-2">
                            <div class="card-box tilebox-one cl-box">
                                <i class="icon-envelope-open pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-15 m-t-10">CASH-ON-Delivery</h6>
                                <h2 class="m-b-20"><?php echo $company['currency']; ?><span data-plugin="counterup"><?php
                                        $result = mysql_query("SELECT SUM(shipping_subtotal) as total FROM courier WHERE book_mode='Cash-on-Delivery' AND container_number = '$cn'");
                                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                        echo $s . formato($row["total"]);
                                        ?></span></h2>
                                <span class="label label-danger">
                                    <?php
                                    $sql = mysql_query("SELECT concat(round(count( * ) *100 /(SELECT count( * ) FROM courier)) , \"%\") AS percent
								FROM courier WHERE  book_mode='Cash-on-Delivery' AND container_number = '$cn' GROUP BY book_mode");
                                    while ($rr = mysql_fetch_array($sql))
                                        for ($i = 0; $i < mysql_num_fields($sql); $i++)
                                            echo $rr[$i] . " ";
                                    echo "<br>";
                                    ?>
                                </span>
                                <span class="text-muted">Cash-on-Delivery</span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-3 col-lg-3 col-xl-2">
                            <div class="card-box tilebox-one cl-box">
                                <i class="icon-paypal pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20">Paid</h6>
                                <h2 class="m-b-20"><?php echo $company['currency']; ?><span data-plugin="counterup"><?php
                                        $result = mysql_query("SELECT SUM(shipping_subtotal) as total FROM courier WHERE book_mode='Paid' AND status != 'Delivered' AND container_number = '$cn' ");
                                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                        echo $s . formato($row["total"]);
                                        ?></span></h2>
                                <span class="label label-danger">
                                    <?php
                                    $sql = mysql_query("SELECT concat(round(count( * ) *100 /(SELECT count( * ) FROM courier)) , \"%\") AS percent
								FROM courier WHERE  book_mode='Paid' AND status != 'Delivered' AND container_number = '$cn' GROUP BY book_mode");
                                    while ($rr = mysql_fetch_array($sql))
                                        for ($i = 0; $i < mysql_num_fields($sql); $i++)
                                            echo $rr[$i] . " ";
                                    echo "<br>";
                                    ?>
                                </span>
                                <span class="text-muted">Paid</span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-3 col-lg-3 col-xl-2">
                            <div class="card-box tilebox-one cl-box">
                                <i class="icon-credit-card pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20">Pending</h6>
                                <h2 class="m-b-20"><?php echo $company['currency']; ?>
                                    <span data-plugin="counterup"><?php
                                        $result = mysql_query("SELECT SUM(shipping_subtotal) as total FROM courier WHERE book_mode='Pending' AND container_number = '$cn'");
                                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                        echo $s . formato($row["total"]);
                                        ?>
                                    </span>
                                </h2>
                                <span class="label label-pink">
                                    <?php
                                    $sql = mysql_query("SELECT concat(round(count( * ) *100 /(SELECT count( * ) FROM courier)) , \"%\") AS percent
								FROM courier WHERE  book_mode='Pending' AND container_number = '$cn' GROUP BY book_mode");
                                    while ($rr = mysql_fetch_array($sql))
                                        for ($i = 0; $i < mysql_num_fields($sql); $i++)
                                            echo $rr[$i] . " ";
                                    echo "<br>";
                                    ?>
                                </span>
                                <span class="text-muted">Pending</span>
                            </div>
                        </div>
                        <!-- ---------------------------------Add New------------------------------  -->

                        <div class="col-xs-12 col-md-3 col-lg-3 col-xl-2">
                            <div class="card-box tilebox-one cl-box">
                                <i class="icon-credit-card pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20">Total Sales</h6>
                                <h2 class="m-b-20"><?php echo $company['currency']; ?>
                                    <span data-plugin="counterup"><?php
                                        $result = mysql_query("SELECT SUM(c.shipping_subtotal) as saletotal FROM courier c LEFT JOIN courier_container co ON (c.container_id = co.`container_id`) where co.container_status = 1 AND  c.container_number = '$cn'");
                                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                        echo $s . formato($row["saletotal"]);
                                        ?>
                                    </span>
                                </h2>
                                <span class="text-muted">Active Container</span>
                                <span class="label label-pink">
                                    <?php
                                    $sql = mysql_query("SELECT * FROM courier_container WHERE  container_status='1'");
                                    while ($rr = mysql_fetch_array($sql))
                                        echo $rr['container_number'] . " ";
                                    echo "<br>";
                                    ?>
                                </span>
                            </div>
                        </div>
                        <!-- ---------------------------------Add New -----------------------------  -->
                        <div class="col-xs-12 col-md-3 col-lg-3 col-xl-2">
                            <div class="card-box tilebox-one cl-box">
                                <i class="icon-rocket pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20">Partial</h6>
                                <h2 class="m-b-20"><?php echo $company['currency']; ?>
                                    <span data-plugin="counterup"><?php
                                        $result = mysql_query("SELECT SUM(shipping_subtotal	) as total FROM courier WHERE book_mode='Partial' AND container_number = '$cn'");
                                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                        echo $s . formato($row["total"]);
                                        ?>
                                    </span>
                                </h2>
                                <span class="label label-warning">
                                    <?php
                                    $sql = mysql_query("SELECT concat(round(count( * ) *100 /(SELECT count( * ) FROM courier)) , \"%\") AS percent
								FROM courier WHERE  book_mode='Partial' AND container_number = '$cn' GROUP BY book_mode");
                                    while ($rr = mysql_fetch_array($sql))
                                        for ($i = 0; $i < mysql_num_fields($sql); $i++)
                                            echo $rr[$i] . " ";
                                    echo "<br>";
                                    ?>
                                </span>
                                <span class="text-muted">Partial</span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- end row Administrator---->



                <!-- star row Employee-->
                <div class="row">
                    <?php
                    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Employee') {
                        ?>
                        <?php
                        // Always first connect to the database mysql
                        $sql = "SELECT * FROM courier WHERE  status='In-Transit' AND officename='" . $_SESSION["user_name"] . "' AND container_number = '$cn'  ";  // sentence sql
                        $result = mysql_query($sql);
                        $numero1 = mysql_num_rows($result); // get the number of rows
                        ?>
                        <div class="col-xs-6 col-md-3 col-lg-3 col-xl-2">
                            <div class="card-box tilebox-one cl-box">
                                <i class="icon-plane pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20">Shipping In Transit</h6>
                                <h2 class="m-b-20" data-plugin="counterup"><?php echo $numero1; ?></h2>
                                <span class="label label-success">
                                    <?php
                                    $sql_1 = mysql_query("SELECT concat(round(count( * ) *100 /(SELECT count( * ) FROM courier)) , \"%\") AS percent
								FROM courier WHERE  status = 'In-Transit' AND officename='" . $_SESSION["user_name"] . "' AND container_number = '$cn' GROUP BY status");
                                    while ($rr = mysql_fetch_array($sql_1))
                                        for ($i = 0; $i < mysql_num_fields($sql_1); $i++)
                                            echo $rr[$i] . " ";
                                    echo "<br>";
                                    ?>
                                </span>
                                <span class="text-muted">Shipments In Transit</span>
                            </div>
                        </div>

                        <?php
                        // Always first connect to the database mysql
                        $sql = "SELECT * FROM courier_online WHERE  status='In-Transit' ";  // sentence sql
                        $result = mysql_query($sql);
                        $numero2 = mysql_num_rows($result); // get the number of rows
                        ?>
                        <div class="col-xs-6 col-md-3 col-lg-3 col-xl-2">
                            <div class="card-box tilebox-one cl-box">
                                <i class="icon-envelope-open pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20 ">CASH-ON-Delivery</h6>
                                <h2 class="m-b-20"><?php echo $company['currency']; ?>
                                    <span data-plugin="counterup"><?php
                                        $result = mysql_query("SELECT SUM(shipping_subtotal) as total FROM courier WHERE book_mode='Cash-on-Delivery' AND officename='" . $_SESSION["user_name"] . "' AND container_number = '$cn'");
                                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                        echo $s . formato($row["total"]);
                                        ?>
                                    </span>
                                </h2>
                                <span class="label label-danger">
                                    <?php
                                    $sql = mysql_query("SELECT concat(round(count( * ) *100 /(SELECT count( * ) FROM courier)) , \"%\") AS percent
								FROM courier WHERE  book_mode='Cash-on-Delivery' AND officename='" . $_SESSION["user_name"] . "' AND container_number = '$cn' GROUP BY book_mode");
                                    while ($rr = mysql_fetch_array($sql))
                                        for ($i = 0; $i < mysql_num_fields($sql); $i++)
                                            echo $rr[$i] . " ";
                                    echo "<br>";
                                    ?>
                                </span>
                                <span class="text-muted">Cash-On-Delivery</span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-3 col-lg-3 col-xl-2">
                            <div class="card-box tilebox-one cl-box">
                                <i class="icon-paypal pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20">Paid</h6>
                                <h2 class="m-b-20"><?php echo $company['currency']; ?>
                                    <span data-plugin="counterup"><?php
                                        $result = mysql_query("SELECT SUM(shipping_subtotal) as total FROM courier WHERE book_mode='Paid' AND officename='" . $_SESSION["user_name"] . "' AND status != 'Delivered' AND container_number = '$cn'");
                                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                        echo $s . formato($row["total"]);
                                        ?>
                                    </span>
                                </h2>
                                <span class="label label-danger">
                                    <?php
                                    $sql = mysql_query("SELECT concat(round(count( * ) *100 /(SELECT count( * ) FROM courier)) , \"%\") AS percent
								FROM courier WHERE  book_mode='Paid' AND status != 'Delivered' AND officename='" . $_SESSION["user_name"] . "' AND container_number = '$cn' GROUP BY book_mode");
                                    while ($rr = mysql_fetch_array($sql))
                                        for ($i = 0; $i < mysql_num_fields($sql); $i++)
                                            echo $rr[$i] . " ";
                                    echo "<br>";
                                    ?>
                                </span>
                                <span class="text-muted">Paid</span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-3 col-lg-3 col-xl-2">
                            <div class="card-box tilebox-one cl-box">
                                <i class="icon-credit-card pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20">Pending</h6>
                                <h2 class="m-b-20"><?php echo $company['currency']; ?>
                                    <span data-plugin="counterup"><?php
                                        $result = mysql_query("SELECT SUM(shipping_subtotal) as total FROM courier WHERE book_mode='Pending' AND officename='" . $_SESSION["user_name"] . "' AND container_number = '$cn'");
                                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                        echo $s . formato($row["total"]);
                                        ?></span>
                                </h2>
                                <span class="label label-pink">
                                    <?php
                                    $sql = mysql_query("SELECT concat(round(count( * ) *100 /(SELECT count( * ) FROM courier)) , \"%\") AS percent
								FROM courier WHERE  book_mode='Pending' AND officename='" . $_SESSION["user_name"] . "' AND container_number = '$cn' GROUP BY book_mode");
                                    while ($rr = mysql_fetch_array($sql))
                                        for ($i = 0; $i < mysql_num_fields($sql); $i++)
                                            echo $rr[$i] . " ";
                                    echo "<br>";
                                    ?>
                                </span>
                                <span class="text-muted">Pending</span>
                            </div>
                        </div>


                        <!-- ---------------------------------Add New------------------------------  -->

                        <div class="col-xs-12 col-md-3 col-lg-3 col-xl-2">
                            <div class="card-box tilebox-one cl-box">
                                <i class="icon-credit-card pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20">Total Sales</h6>
                                <h2 class="m-b-20"><?php echo $company['currency']; ?>
                                    <span data-plugin="counterup"><?php
                                        $result = mysql_query("SELECT SUM(c.shipping_subtotal) as saletotal FROM courier c LEFT JOIN courier_container co ON (c.container_id = co.`container_id`) where co.container_status = 1 AND officename='" . $_SESSION["user_name"] . "' AND c.container_number = '$cn'");
                                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                        echo $s . formato($row["saletotal"]);
                                        ?>
                                    </span>
                                </h2>
                                <span class="text-muted">Active Container</span>
                                <span class="label label-pink">
                                    <?php
                                    $sql = mysql_query("SELECT * FROM courier_container WHERE  container_status='1'");
                                    while ($rr = mysql_fetch_array($sql))
                                        echo $rr['container_number'] . " ";
                                    echo "<br>";
                                    ?>
                                </span>
                            </div>
                        </div>
                        <!-- ---------------------------------Add New -----------------------------  -->

                        <div class="col-xs-12 col-md-3 col-lg-3 col-xl-2">
                            <div class="card-box tilebox-one cl-box">
                                <i class="icon-rocket pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20">Partial</h6>
                                <h2 class="m-b-20"><?php echo $company['currency']; ?>
                                    <span data-plugin="counterup"><?php
                                        $result = mysql_query("SELECT SUM(shipping_subtotal) as total FROM courier WHERE book_mode='Partial' AND officename='" . $_SESSION["user_name"] . "' AND container_number = '$cn'");
                                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                        echo $s . formato($row["total"]);
                                        ?>
                                    </span>
                                </h2>
                                <span class="label label-warning">
                                    <?php
                                    $sql = mysql_query("SELECT concat(round(count( * ) *100 /(SELECT count( * ) FROM courier)) , \"%\") AS percent
								FROM courier WHERE  book_mode='Partial' AND officename='" . $_SESSION["user_name"] . "' AND container_number = '$cn' GROUP BY book_mode");
                                    while ($rr = mysql_fetch_array($sql))
                                        for ($i = 0; $i < mysql_num_fields($sql); $i++)
                                            echo $rr[$i] . " ";
                                    echo "<br>";
                                    ?>	 </span> <span class="text-muted">Partial</span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- end row Employee-->


                <div class="row">
                    <div class="col-xs-12 col-lg-12 col-xl-12">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-20">List of Shipments</h4>
                            <div class="table-responsive">
                                <div class="col-xs-12 col-lg-12 col-xl-12">

                                    <ul class="nav nav-tabs m-b-10" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-expanded="true">
                                                <i class="icon-plane"></i>&nbsp;&nbsp;LIST OF MAIN SHIPPING</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="search-tab" data-toggle="tab" href="#search" role="tab" aria-controls="search" aria-controls="search">
                                                <i class="fa fa-search"></i>&nbsp;&nbsp;SEARCH</a>
                                        </li>
                                        <?php
                                        // Always first connect to the database mysql
                                        $sql = "SELECT * FROM courier_online WHERE  status='In-Transit' ";  // sentence sql
                                        $result = mysql_query($sql);
                                        $numero2 = mysql_num_rows($result); // get the number of rows
                                        ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile">
                                                <i class="icon-envelope-open"></i>&nbsp; <strong><span class="text-danger text-uppercase m-b-15 m-t-10"><?php echo $numero2; ?></span></strong>&nbsp;LIST OF SHIPMENTS ONLINE BOOKING</a>
                                        </li>
                                    </ul>
                                    
                                    <form name="" method="post" >
          <input class="btn btn-info" name="submit"  value="Delivery" type="submit" style="margin-bottom: 10px;">                         <div class="tab-content" id="myTabContent">
                                        <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
                                            <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <?php
                                                        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
                                                            ?>
                                                            <th>Select All <input id="checkAll" type="checkbox" value="" onclick="unselectall();"  name="selectall"></th>

                                                            <th></th>
                                                            <th></th>

                                                        <?php } ?>
                                                        <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Employee') {
                                                            ?>
                                                            <th>Select All <input id="checkAll" type="checkbox" value="" onclick="unselectall();"  name="selectall"></th>
                                                            <th></th>
                                                        <?php } ?>
                                                        <th>Deliver</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Container No. </th>
                                                        <th>Order Id </th>
                                                        <th>Tracking </th>
                                                        <th>Pay Mode</th>
                                                        <th>Sender</th>
                                                        <th>Recipient</th>
                                                        <th>Date</th>
                                                        <th>Employee</th>
                                                        <th> Status</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
                                                    ?>
                                                    <tbody>

                                                        <?php
                                                        //Added the limit to 100 records and Active container -> Oscar
                                                        //$result3 = mysql_query("SELECT * FROM courier WHERE status != 'delivered' AND container_number = '$cn'  ORDER BY cid DESC LIMIT 400");
                                                         $result3 = mysql_query("SELECT * FROM courier WHERE status != 'delivered'  ORDER BY cid DESC"); 
                            //$result3 = mysql_query("SELECT * FROM courier ORDER BY cid DESC");

                                                        while ($row = mysql_fetch_array($result3)) {
                                                            ?>
                                                            <tr>
                                                                <td><input type="checkbox" name="check[]" value="<?php echo $row['cid']; ?>"></td>
                                                                <td align="center">
                                                                    <a href="edit-courier.php?cid=<?php echo $row['cid']; ?>">
                                                                        <img src="images/edit.png"  height="20" width="20"></a>
                                                                </td>
                                                                <td align="center">
                                                                    <a href="#" onclick="del_list_admin(<?php echo $row['cid']; ?>);">
                                                                        <img src="images/delete.png"  height="20" width="18"></a>
                                                                </td>
                                                                <td class="gentxt" align="center">
                                                                    <a href="process.php?action=delivered&cid=<?php echo $row['cid']; ?>" onclick="return confirm('Sure like to change the status of shipping?');">
                                                                        <img src="images/delivery.png"  height="20" width="20"></a>
                                                                </td>
                                                                <td align="center">
                                                                    <a data-toggle="tooltip" title="Invoice Print" target="_blank" href="print-invoice/invoice-print-old.php?cid=<?php echo $row['cid']; ?>">
                                                                        <img src="images/print.png"  height="20" width="20"></a>

                                                                </td>
                                                                <td align="center">
                                                                    <a data-toggle="tooltip" title="Invoice Print 80mm" target="_blank" href="print-invoice/invoice-print-simple-page.php?cid=<?php echo $row['cid']; ?>">
                                                                        <img src="images/print.png"  height="20" width="20"></a>

                                                                </td>
                                                                <td align="center">
																		 <!--Adding Label replaced 	invoice-print by  OP-20220519 -->	
                                                                    <a data-toggle="tooltip" title="Label Print" target="_blank" href="print-invoice/invoice-label.php?cid=<?php echo $row['cid']; ?>">
                                                                        <img src="images/print.png"  height="20" width="20"></a>
                                                                </td>
                                                                <td align="center" >
                                                                    <a href="javascript:;" data-toggle="modal" data-target="#nuevo" data-id="<?php echo $row['cid']; ?>" class="open-pay"><img src="images/paynow.png" height="20" width="20"></a></td>
                                                                <td align="center">
                                                                    <a  href="barcode/html/BCGcode39.php?cons_no=<?php echo $row['cons_no']; ?>" target="_blank">
                                                                        <img src="images/barcode.png" height="20" width="20"></a>
                                                                </td>
                                                                <td><?php echo $row['container_number']; ?></td>
                                                                <td><?php echo $row['invoice_number']; ?></td>
                                                                <td><font color="#000"><?php echo $row['cons_no']; ?></font></td>
                                                                <td><span class="label <?php echo $row['book_mode']; ?> label-large"><?php echo $row['book_mode']; ?></span></td>
                                                                <td><?php echo $row['ship_name']; ?></td>
                                                                <td><?php echo $row['rev_name']; ?></td>
                                                                <td><?php echo date("m/d/Y", strtotime($row['pick_date'])); ?></td>
                                                                <td><?php echo $row['officename']; ?></td>
                                                                <td><span class="label <?php echo $row['status']; ?> label-large"><?php echo $row['status']; ?></span></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                <?php } ?>
                                                <?php
                                                if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Employee') {
                                                    ?>
                                                    <tbody>
                                                        <?php
                                                        //Added the limit to 100 records and Active container usuarios normales -> Oscar 
                                                        //$result3 = mysql_query("SELECT * FROM courier WHERE status != 'delivered' and user='" . $_SESSION["user_type"] . "' AND container_number = '$cn'  ORDER BY cid DESC LIMIT 400 ORDER BY cid DESC");
                                                        $result3 = mysql_query("SELECT * FROM courier WHERE status != 'delivered' and user='" . $_SESSION["user_type"] . "' ORDER BY cid DESC");

                                                        while ($row = mysql_fetch_array($result3)) {
                                                            ?>
                                                            <tr>
                                                                <td><input type="checkbox" name="check[]" value="<?php echo $row['cid']; ?>"></td>
                                                                <td align="center">
                                                                    <a href="edit-courier.php?cid=<?php echo $row['cid']; ?>">
                                                                        <img src="images/edit.png"  height="20" width="20"></a>
                                                                </td>
                                                                <td class="gentxt" align="center">
                                                                    <a href="process.php?action=delivered&cid=<?php echo $row['cid']; ?>" onclick="return confirm('Sure like to change the status of shipping?');">
                                                                        <img src="images/delivery.png" height="20" width="20"></a>
                                                                </td>
                                                                <td align="center">
                                                                    <a data-toggle="tooltip" title="Invoice Print" target="_blank" href="print-invoice/invoice-print-old.php?cid=<?php echo $row['cid']; ?>">
                                                                        <img src="images/print.png"  height="20" width="20"></a>

                                                                </td>
                                                                <td align="center">

                                                                    <a data-toggle="tooltip" title="Label Print" target="_blank" href="print-invoice/invoice-print.php?cid=<?php echo $row['cid']; ?>">
                                                                        <img src="images/print.png"  height="20" width="20"></a>
                                                                </td>

                                                                <td align="center" >
                                                                    <a href="javascript:;" data-toggle="modal" data-target="#nuevo" data-id="<?php echo $row['cid']; ?>" class="open-pay"><img src="images/paynow.png" height="20" width="20"></a>
                                                                </td>
                                                                <td align="center">
                                                                    <a  href="barcode/html/BCGcode39.php?cons_no=<?php echo $row['cons_no']; ?>" target="_blank">
                                                                        <img src="images/barcode.png" height="20" width="20"></a>
                                                                </td>
                                                                <td><?php echo $row['cid']; ?></td>
                                                                <td><font color="#000"><?php echo $row['cons_no']; ?></font></td>
                                                                <td><span class="label <?php echo $row['book_mode']; ?> label-large"><?php echo $row['book_mode']; ?></span></td>
                                                                <td><?php echo $row['ship_name']; ?></td>
                                                                <td><?php echo $row['rev_name']; ?></td>
                                                                <td><?php echo date("m/d/Y", strtotime($row['pick_date'])); ?></td>
                                                                <td><?php echo $row['officename']; ?></td>
                                                                <td><span class="label <?php echo $row['status']; ?> label-large"><?php echo $row['status']; ?></span></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                <?php } ?>
                                            </table>
                                        </div>

                                        <div role="tabpane2" class="tab-pane fade in" id="search" aria-labelledby="search-tab">
                                            <?php
                                            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
                                                ?>
                                                <form  name="formulario" method="post" id="formulario" >
                                                    <div class="row" >

                                                        <div class="col-sm-3 form-group">
                                                            <label  class="control-label">Phone<span class="required-field"></span></label>
                                                            <input type="text"  name="phone" id="txt_phone" class="form-control phone " value="" placeholder="input phone number">
                                                        </div>

                                                        <div class="col-sm-3 form-group">
                                                            <label  class="control-label"><i class="text-default-lter"></i>&nbsp;Order Id</label>
                                                            <input type="text" class="form-control" name="order_id" id="txt_orderid" value="" placeholder="input order id">
                                                            <input type="hidden" name="txt_container_number" value="" id="txt_container_number">
                                                        </div>

                                                        <div class="col-sm-3 form-group">
                                                            <label class="control-label">Sender Name</label>
                                                            <input type="text" name="Sender_name" id="txt_sendername" class="form-control"  value=""  placeholder="input sender name">
                                                        </div>

                                                        <div class="col-sm-3 form-group">
                                                            <label class="control-label">Recipient Name</label>
                                                            <input type="text" name="receiver_name" id="txt_receivername" class="form-control"  value="" placeholder="input receiver name">
                                                        </div>

                                                        <div class="col-sm-12 form-group" align="right">
                                                                <!--<input class="btn btn-search submited" name="Submit" type="submit"  id="submit" value="SEARCH">-->
                                                            <button type="button" class="btn btn-md btn-info search_info"  name="Submit"  id="submit"><i class="fa fa-refresh"></i></button>
                                                        </div>
                                                    </div>
                                                </form>

                                            <?php } ?>
                                            <?php
                                            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Employee') {
                                                ?>
                                                <form  name="formulario" method="post" id="formulario" >
                                                    <div class="row" >
                                                        <div class="col-sm-3 form-group">
                                                            <label  class="control-label">Phone<span class="required-field"></span></label>
                                                            <input type="text"  name="phone" id="txt_phone" class="form-control phone " value="" placeholder="input phone number">
                                                        </div>

                                                        <div class="col-sm-3 form-group">
                                                            <label  class="control-label"><i class="text-default-lter"></i>&nbsp;Order Id</label>
                                                            <input type="text" class="form-control" name="order_id" id="txt_orderid" value="" placeholder="input order id">
                                                        </div>

                                                        <div class="col-sm-3 form-group">
                                                            <label class="control-label">Sender Name</label>
                                                            <input type="text" name="Sender_name" id="txt_sendername" class="form-control"  value=""  placeholder="input sender name">
                                                        </div>

                                                        <div class="col-sm-3 form-group">
                                                            <label class="control-label">Recipient Name</label>
                                                            <input type="text" name="receiver_name" id="txt_receivername" class="form-control"  value="" placeholder="input receiver name">
                                                        </div>

                                                        <div class="col-sm-12 form-group" align="right">
                                                                <!--<input class="btn btn-search submited" name="Submit" type="submit"  id="submit" value="SEARCH">-->
                                                            <button type="button" class="btn btn-md btn-info"  name="Submit"  id="submit"><i class="fa fa-refresh"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php } ?>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card-box table-responsive">
                                                        <table border="0" align="center" width="100%">
                                                            <tr>
                                                                <td class="TrackTitle" valign="top">
                                                                    <div  align="">
                                                                        <h3 class="classic-title1">
                                                                            <span><strong></strong></span>
                                                                        </h3>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="table">
                                                                    <br>
                                                                    <!--Inicio de tabla usuarios-->
                                                                    <table id="tabla-usuarios" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                        <!--encabezado tabla-->
                                                                        <thead>
                                                                            <tr>

                                                                                <th rowspan="1" colspan="1"></th>
                                                                                <th rowspan="1" colspan="1">ORDER IN</th>
                                                                                <th>Container No.</th>
                                                                                <th>Sender Name</th>
                                                                                <th>PRODUCT LINE</th>
                                                                                <th>QTY</th>
                                                                                <th rowspan="1" colspan="1">BALANCE</th>
                                                                                <th>STATUS</th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                    <!--fin de tabla-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="profile" role="tabpanel"
                                             aria-labelledby="profile-tab">
                                            <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Update</th>
                                                        <?php
                                                        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
                                                            ?>
                                                            <th></th>
                                                        <?php } ?>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>To Pay</th>
                                                        <th>Payments </th>
                                                        <th>Customer</th>
                                                        <th>From</th>
                                                        <th>Recipient</th>
                                                        <th>To</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $result3 = mysql_query("SELECT * FROM courier_online WHERE status='In-Transit' OR status='Shipment-arrived'
                                                                                                                                                                OR status='Returned' ORDER BY cid DESC");
                                                    while ($row = mysql_fetch_array($result3)) {
                                                        ?>
                                                        <tr>
                                                            <td align="center">
                                                                <a href="edit-courier-customer.php?cid=<?php echo $row['cid']; ?>">
                                                                    <img src="images/delivery.png"  height="20" width="20"></a>
                                                            </td>
                                                            <?php
                                                            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
                                                                ?>
                                                                <td align="center">
                                                                    <a href="#" onclick="del_list_online(<?php echo $row['cid']; ?>);">
                                                                        <img src="images/delete.png"  height="20" width="18"></a>
                                                                </td>
                                                            <?php } ?>
                                                            <td align="center">
                                                                <a target="_blank" href="print-invoice/invoice-print-online.php?cid=<?php echo $row['cid']; ?>">
                                                                    <img src="images/print.png"  height="20" width="20"></a>
                                                            </td>
                                                            <td align="center">
                                                                <a  href="barcode/html/BCGcode39.php?cons_no=<?php echo $row['cons_no']; ?>" target="_blank">
                                                                    <img src="images/barcode.png"  height="20" width="20"></a>
                                                            </td>
                                                            <td><FONT SIZE=2><font color="#000"><?php echo $row['cons_no']; ?></FONT></td>
                                                            <td><FONT SIZE=2><strong><?php echo $company['currency']; ?><?php echo $s . formato($row['shipping_subtotal']); ?></strong></FONT></td>
                                                            <td align="center"><span class="label <?php echo $row['payment']; ?> label-large"><?php echo $row['payment']; ?></span>&nbsp;<span class="label <?php echo $row['paymode']; ?> label-large"><?php echo $row['paymode']; ?></span></td>
                                                            </td>
                                                            <td><FONT SIZE=2><?php echo $row['ship_name']; ?></FONT></td>
                                                            <td><FONT SIZE=2><?php echo $row['fromcity']; ?></FONT></td>
                                                            <td><FONT SIZE=2><?php echo $row['rev_name']; ?></FONT></td>
                                                            <td><FONT SIZE=2><?php echo $row['tocity']; ?></FONT></td>
                                                            <td><FONT SIZE=2><?php echo $row['deliverydate']; ?></FONT></td>
                                                            <td><span class="label <?php echo $row['status']; ?> label-large"><?php echo $row['status']; ?></span></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col-->


                    <!--    <div class="col-xs-12 col-lg-12 col-xl-3">
                            <div class="card-box">
                                <h4 class="header-title m-t-0 m-b-30">Shipments Recent</h4>
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="50%">
                                        <thead>
                                            <tr>
                                                <th>Tracking</th>
                                                <th>Start Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                    <?php
                    $result1 = mysql_query("SELECT * FROM courier WHERE LEFT(book_date, 10) = CURDATE()    ");
                    while ($row = mysql_fetch_array($result1)) {
                        ?>
                                                    <tr>
                                                        <td><font color="#000"><?php echo $row['cons_no']; ?></font></td>
                                                        <td><?php echo $row['book_date']; ?></td>
                                                        <td><span class="label <?php echo $row['status']; ?> label-large"><?php echo $row['status']; ?></span></td>
                                                    </tr>
                    <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> --><!-- end col-->
                </div>
                <!-- end row -->

                <!-- Footer -->
                <?php
                include("footer.php");
                ?>
                <!-- End Footer -->

            </div> <!-- container -->
        </div> <!-- End wrapper -->

        <!-- Modal nuevo usuario -->
        <div class="modal fade" id="nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-money"></i> ADD PAYMENT</h4>
                    </div>
                    <div class="modal-body">
                        <!--Cuerpo del modal aquí el formulario-->
                        <form method="post" class="form-horizontal" id="payment">
                            <div class="form-group " id="gnombre">
                                <label for="office" class="col-sm-2 control-label">Date*</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="date" placeholder="mm/dd/yyyy" id="payment_date">
                                    <input type="hidden" class="form-control amount" name="cid" id="cid">

                                </div>
                                <label for="office" class="col-sm-2 control-label">Balance Amount</label>
                                <div class="col-xl-4">
                                    <input type="text" class="form-control" id="balance_amount" name="balance_amount"   placeholder="Balance Amount" readonly>
                                </div>
                            </div>
                            <div class="form-group border" id="gapellido">
                                <label for="amount" class="col-sm-2 control-label">Amount*</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="amount" id="pay_amount"   placeholder="Amount" required>
                                </div>
                                <label for="amount" class="col-sm-2 control-label">Paying by*</label>
                                <div class="col-sm-4">
                                    <span id="inter_origin" style="display: block;">
                                        <select name="paying_by" required class="country form-control" id="paying_by">
                                            <option value="">Select</option>
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="credit_card">Credit card</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group" id="gusuario">
                                <label for="phone" class="col-sm-2 control-label">Note</label>
                                <div class="col-sm-10">
                                    <textarea rows="8" id="payment_note" name="payment_note" class="form-control officer_name"></textarea>
                                </div>
                                <div class="col-sm-5">
                                    <span id="inter_origin" style="display: block;"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                </div>
                            </div>

                            <!--Fin del cuerpo del modal-->

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default " data-dismiss="modal"><i class="fa fa-times"></i>
                                    Close</button>
                                <button type="button" class="btn btn-success search_record" data-dismiss="modal" id="submit">Save</button>
                                <input class="btn btn-success search_record hidden" name="Submit" type="submit"  id="submit"  value="Save" \>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--fin de modal nuevo usuario-->
        <script>
            var resizefunc = [];
        </script>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/tether.min.js"></script><!-- Tether for Bootstrap -->
        <script src="assets/js/bootstrap.min.js"></script>

        <script src="./assets-auto/js/bootstrap-typeahead.js"></script>

        <script src="./assets-auto/js/jquery.mockjax.js"></script>

        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/plugins/switchery/switchery.min.js"></script>

        <script src="assets/plugins/moment/moment.js"></script>
        <script src="assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <script src="assets/plugins/mjolnic-bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/plugins/clockpicker/bootstrap-clockpicker.js"></script>
        <script src="assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

<!--        <script src="assets/pages/jquery.form-pickers.init.js"></script>-->
        <script type='text/javascript' src="plugins/DataTables/js/jquery.dataTables.js"></script>
        <script type='text/javascript' src="plugins/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
        <script type='text/javascript' src="js/dataTables.bootstrap.js"></script>
        <script type='text/javascript' src="plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
        <script type='text/javascript' src="plugins/sweetalert/js/sweetalert.min.js"></script>

        <script src="assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
        <script src="assets/plugins/counterup/jquery.counterup.min.js"></script>

        <script type='text/javascript' src="js/js/search.js"></script>
        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>



        <script name="text/javascript">
            //------------seach
            $(document).ready(function () {

                $('#payment_date').datetimepicker({
                    todayBtn: 'linked',
                    todayHighlight: true,
                    format: 'mm/dd/yyyy hh:ii',
                    autoclose: true
                });

                $("input[name='phone']").keyup(function () {
                    $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d)+$/, "$1-$2-$3"));
                });

            });
            //// it is used for get balance show
            $(document).on("click", ".open-pay", function () {
                var hid_document_id = $(this).data('id');
                $("#cid").val(hid_document_id);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: 'getbalance.php',
                    data: {cid: hid_document_id},
                    success: function ($json) {
                        $("#balance_amount").val($json['balance_amount']);
                    }
                });
            });
            $('#datatable').DataTable({"bDestroy": true});

            //Buttons examples
            /*var table = $('#datatable-buttons').DataTable({
             lengthChange: false,
             buttons: ['copy', 'excel', 'pdf', 'colvis']
             });
             table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');*/


        </script>

        <script type="text/javascript">
            function del_list_admin(cid) {// it is used for delete record
                if (window.confirm("Aviso:\n Sure you want to delete the selected  file?")) {
                    window.location = "deletes/delete_list_admin.php?action=del&cid=" + cid;
                }
            }
            ///////
        </script>
        <script type="text/javascript">

            $(document).ready(function () {
                var now = new Date();
                var hours = now.getHours();
                var minutes = now.getMinutes();
                var Seconds = now.getSeconds();
                var ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0' + minutes : minutes;
                var day = ("0" + now.getDate()).slice(-2);
                var month = ("0" + (now.getMonth() + 1)).slice(-2);
                var hour = ("0" + (now.getHours())).slice(-2);
                var today = (month) + "/" + (day) + "/" + now.getFullYear() + ' ' + hours + ':' + minutes;
                $("input[name*='date']").val(today);
            });
            //===============
            //   it is used for in search add payment function with change amount on same page..
            var get_search_par = '';
            $(document).ready(function () {

                $(document).on("click", "#tabla-usuarios .open-pay", function () {
                    get_search_par = '1';

                });
                //
                $(document).on("click", ".search_record", function () {
                    var cids = $('#cid').val();
                    var search_date = $('#payment_date').val();
                    //var search_amount = $('#balance_amount').val();
                    var pay_amount = $('#pay_amount').val();
                    var paying_by = $('#paying_by').val();
                    var payment_note = $('#payment_note').val();

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "process.php?action=add-pay",
                        data: {cid: cids, date: search_date, amount: pay_amount, paying: paying_by, payment_note: payment_note, search_param: get_search_par},
                        success: function ($json) {
                            $(".search_info").trigger("click");// it is used for previous record update show
                        }
                    });
                });
            });
            //---------------------------------------
        </script>
        <style>
            .cl-box {
                height: 156px;
            }
        </style>
    </body>
</html>