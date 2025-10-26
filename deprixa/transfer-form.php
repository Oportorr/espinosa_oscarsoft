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
require_once('database-settings.php');
require_once('database.php');
require_once('library.php');

$sql = "SELECT *
		FROM offices";
$result = dbQuery($sql);
isUser();
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
        <title>CARGO v10.1 | Transfer </title>

        <!-- Switchery css -->
        <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" />

        <!-- App CSS -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css" type="text/css" />
        <link rel="stylesheet" href="bower_components/simple-line-icons/css/simple-line-icons.css" type="text/css" />
        <link rel="stylesheet" href="css/font.css" type="text/css" />
        <link href="css/estilos.css" rel="stylesheet">
        <link href="js/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="js/plugins/sweetalert/css/sweetalert.css" rel="stylesheet">
        <!--<script type="text/javascript" src="../process/countries.js"></script>-->


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
                            <table border="0" align="center" width="100%">
                                <tr>
                                    <td class="TrackTitle" valign="top"><div  align=""><h3 class="classic-title1"><span><strong></strong></span></h3>
                                </tr>
                                <div class="row">
                                    <div class="col-xs-12" align="center">
                                        <h2>Transfer List</h2>
                                        <br>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <!--Botones principales-->
                                        <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#nuevo"><i class="fa fa-exchange"></i>
                                            Transfer</button>
                                        <button type="button" class="btn btn-md btn-info" ><i class="fa fa-refresh"></i>
                                            To Update</button>
                                    </div>
                                </div>
                            </table>
                            <div class="col-xs-12">
                                <div class="table">
                                    <table id="tabla-usuarios" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <!--encabezado tabla-->
                                        <thead>
                                            <tr>
                                                <th>Order Id</th>
                                                <th>Product Line</th>
                                                <th>Quantity</th>
                                                <th>Container Assignet</th>
                                                <th>Container Ship</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-exchange"></i> Transfer Form</h4>
                            </div>
                            <div class="modal-body">
                                <!--Cuerpo del modal aquí el formulario-->
                                <form  class="form-horizontal" id="formularioNuevo"  method="post">

                                    <div class="form-group" id="gusuario">
                                        <label for="f_location" class="col-sm-2 control-label ">Location</label>
                                        <div class="col-sm-5">
                                            <select name="f_id" class="f_location form-control" required id ="f_location"   >
                                                <option value="">From Location</option>
                                                <?php
                                                $stmt = mysql_query("SELECT * FROM offices WHERE estado = '1'");

                                                while ($row = mysql_fetch_array($stmt)) {
                                                    $f_id = $row['id'];
                                                    ?>
                                                    <option value="<?php echo $f_id; ?>"><?php echo $row['off_name']; ?></option>
                                                <?php } ?>
                                                <span class="field-validation-valid text-danger form-control" ></span>
                                            </select>

                                            <span class="field-validation-valid text-danger"  ></span>
                                        </div>
                                        <div class="col-sm-5">
                                            <select name="t_id" class="t_location form-control" required id ="t_location" >
                                                <option value="">To Location</option>
                                                <?php
                                                $stmt = mysql_query("SELECT * FROM offices WHERE estado = '1'");

                                                while ($row1 = mysql_fetch_array($stmt)) {
                                                    $t_id = $row1['id'];
                                                    ?>
                                                    <option value="<?php echo $t_id; ?>"><?php echo $row1['off_name']; ?></option>
                                                <?php } ?>
                                                <span class="field-validation-valid text-danger form-control" ></span>
                                            </select>
                                            <span class="field-validation-valid text-danger" ></span>
                                        </div>
                                    </div>
                                    <div class="form-group" id="gusuario">

                                        <label for="phone" class="col-sm-2 control-label">Container Number</label>
                                        <div class="col-sm-5">
                                            <span id="inter_origin" style="display: block;">
                                                <select name="container_id" required class="country form-control" id="container_number">
                                                    <option value="">Select Container</option>
                                                    <?php
                                                    $stmt = mysql_query("SELECT * FROM courier_container");

                                                    while ($row = mysql_fetch_array($stmt)) {
                                                        ?>
                                                        <option value="<?php echo $row['container_id']; ?>"><?php echo $row['container_number']; ?></option>
                                                    <?php } ?>
                                                </select>

                                        </div>
                                    </div>
                                    <div class="form-group" id="gusuario">

                                        <label for="order" class="col-sm-2 control-label">Order Id</label>
                                        <div class="col-sm-5">
                                            <span id="inter_origin" style="display: block;">
                                                <div class="col-sm-10 form-group">
                                                    <input type="text" class="form-control" name="order_id" id="order_id" required placeholder="Enter Order id " value="">
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group" id="gusuario">
                                        <!--							<label for="officer_name" class="col-sm-2 control-label">Company</label>-->
                                        <label for="order" class="col-sm-2 control-label">Line Item</label>
                                        <div class="col-sm-5">
                                            <span id="inter_origin" style="display: block;">
                                                <div class="col-sm-10 form-group">
                                                    <input type="text" class="form-control" name="line_item" id="line_item" required placeholder="Enter Line Item  id" value="">
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                    <!--						   <div id="transfer-result">
                                                                                     </div>-->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>
                                            Close</button>
                                        <button type="button" id="transfer_submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>Save</button>
                                    </div>
                                </form>    <!--Fin del cuerpo del modal-->
                            </div>
                            <!-- code for validation  -->


                        </div>
                    </div>
                </div>
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

<script type='text/javascript' src="js/jquery.js"></script>
<script type='text/javascript' src="js/bootstrap.min.js"></script>
<script type='text/javascript' src="plugins/DataTables/js/jquery.dataTables.js"></script>
<script type='text/javascript' src="plugins/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type='text/javascript' src="js/dataTables.bootstrap.js"></script>
<script type='text/javascript' src="plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
<script type='text/javascript' src="plugins/sweetalert/js/sweetalert.min.js"></script>
<script type='text/javascript' src="js/check_transfer.js"></script>

<!-- App js -->
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>


</body>
</html>
