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
	<title>CARGO v10.1 | ADD NEW CUSTOMER </title>

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
					<h2>Manage New Clients</h2>
					<br>
				    </div>
				</div>

				<div class="row">
				    <div class="col-xs-12">
					<!--Botones principales-->
					<button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#nuevo"><i class="fa fa-user-plus"></i>
					    New Client</button>
					<button type="button" class="btn btn-md btn-info" id="recarga"><i class="fa fa-refresh"></i>
					    To Update</button>
				    </div>
				    <div class="col-xs-12">
					<div class="table">
					    <br>
					    <!--Inicio de tabla usuarios-->
					    <table id="tabla-usuarios" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<!--encabezado tabla-->
						<thead>
						    <tr>
							<th>Customer Name</th>
							<th>Address</th>
							<th>Phone Number</th>
							<th>Email</th>
							<th>Country</th>
							<th>State</th>
							<th>Status</th>
							<th>Actions</th>
						    </tr>
						</thead>

					    </table>
					    <!--fin de tabla-->

					</div>
				    </div>
				</div>
				
				
<?php		
												$result4 = mysql_query("SELECT * FROM company WHERE  id='1' ");
												$rr = mysql_fetch_array($result4);
												
											?>
											

				<!-- Modal nuevo usuario -->
				<div class="modal fade" id="nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				    <div class="modal-dialog">
					<div class="modal-content">
					  <form action="settings/add-new-clients/agregar.php"  class="form-horizontal" method="post">
					    <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> New Client</h4>
					    </div>
					    <div class="modal-body">
						<!--Cuerpo del modal aquí el formulario-->
						    <div class="form-group " id="gnombre">
							<label for="office" class="col-sm-2 control-label">Name </label>
							<div class="col-sm-10">
							    <input type="text" class="form-control office" name="name"  placeholder="Customer Name">
							</div>
						    </div>
							<div class="form-group" id="gapellido">
							<label for="officer_name" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
							    <input type="text" class="form-control officer_name" value="<?php echo $rr['cemail'];?>" name="email"  placeholder="Email">
							</div>
							</div>
						    <div class="form-group" id="gapellido">
							<label for="address" class="col-sm-2 control-label">Address </label>
							<div class="col-sm-10">
							    <input type="text" class="form-control address" name="address"   placeholder="Address ">
							</div>

						    </div>					  
						    <div class="form-group" id="gusuario" hidden>
							
							<div class="col-sm-5">
							    <input type="text" class="form-control off_pwd" name="password"  placeholder="Password">
							</div>					  
						    </div>
						    <div class="form-group" id="gusuario">
							<label for="City" class="col-sm-2 control-label">City</label>
							<div class="col-sm-3">
							    <select name="city" required id ="city" class="city form-control">
						    <option>Select City</option>
						    <span class="field-validation-valid text-danger" ></span>
						</select>
							    <span class="field-validation-valid text-danger" ></span>
							</div>
							<div class="col-sm-3">
							    <select name="state" required id ="state" class="state form-control">
						    <option>Select State</option>
						    <span class="field-validation-valid text-danger" ></span>
						</select>
							    <span class="field-validation-valid text-danger" ></span>
							</div>
                                                        <div class="col-sm-4">
							    <input type="text" class="form-control off_pwd" name="zipcode" id="zipcode"  placeholder="zipcode">
							</div>							
						    </div>
						    <div class="form-group" id="gusuario">
<!--							<label for="officer_name" class="col-sm-2 control-label">Company</label>-->
							<div class="col-sm-5" hidden>
							    <input type="text" class="form-control officer_name" name="company"  placeholder="Company name">
							</div>
                                                        <label for="phone" class="col-sm-2 control-label">Telephone</label>
							<div class="col-sm-5">
							    <input class="form-control ph_no" id="phone-number" name="phone" placeholder="Phone Number">							      </div>
							<div class="col-sm-5">
							    <span id="inter_origin" style="display: block;">								
								<select name="country" required class="country form-control">
								    <option>Select Country</option>
								    <?php
								    $stmt = mysql_query("SELECT * FROM `country` WHERE `country_id` in (231, 61)");

								    while ($row = mysql_fetch_array($stmt)) {
									?>
    								    <option value="<?php echo $row['country_id']; ?>" <?php if ($row['country_id'] == $s_country) {
									echo "selected";
								    } ?>"><?php echo $row['country_name']; ?></option>
<?php } ?>
								</select>

							</div>
												  
						    </div>
						    <div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
							    <div class="checkbox checkbox-success">
								<input id="checkbox3" type="checkbox" name="estado" value="1" checked>
								<label for="checkbox3">
								    Status
								</label>
							    </div>
							    <div class="checkbox checkbox-inline" >
								<input type="checkbox"  name="type" value="c" disabled checked>
								<label for="inlineCheckbox3"> Type of user </label>
							    </div>
							</div>
						    </div>

						    <!--Fin del cuerpo del modal-->
					    </div>
					    <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>
						    Close</button>
						<input class="btn btn-success" name="Submit" type="submit"  id="submit" value="Save">
					    </div>
					    </form>
					</div>
				    </div>
				</div>
				<!--fin de modal nuevo usuario-->


				<!-- Modal para editar Usuario -->
				<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				    <div class="modal-dialog">
					<div class="modal-content">
					    <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-pencil-square-o"></i>
						    Edit Client</h4>
					    </div>
					    <div class="modal-body">
						<!--Cuerpo del modal aquí el formulario-->
						<form class="form-horizontal" id="formularioEditar">
						    <div class="form-group" id="Enombre">
							<label for="office" class="col-sm-2 control-label">Name </label>
							<div class="col-sm-10">
							    <input type="text" class="form-control" name="name" placeholder="Name Client">
							</div>
							</div>
							<div class="form-group" id="Eusuario">
							<label for="officer_name" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
							    <input type="text" class="form-control" name="email" placeholder="Email">
							</div>
						    </div>
						    <div class="form-group" id="Eapellido">
							<label for="address" class="col-sm-2 control-label">Address </label>
							<div class="col-sm-10">
							    <input type="text" class="form-control" name="address" placeholder="Address ">
							</div>
						    </div>
						     <!-- <div class="form-group" id="Etelefono">
							<label for="ph_no" class="col-sm-2 control-label">Phone Number</label>
							<div class="col-sm-10">
							    <input class="form-control" name="phone" placeholder="Phone Number">							
							</div>
						    </div>
						     <div class="form-group" id="Eemail">
							<label for="email" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
							    <input type="text" class="form-control" name="email"  placeholder="Email">
							</div>
						    </div> -->
						    
						    <div class="form-group" hidden>
							<label for="off_pwd" class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
							    <input type="text" class="form-control" name="password" placeholder="Password">
							</div>
						    </div>
							<div class="form-group" id="gusuario">
							<label for="City" class="col-sm-2 control-label">City</label>
							<div class="col-sm-3">
							    <select name="city" required id ="city1"  class="city1 form-control">
						    <option>Select City</option>
						    <span class="field-validation-valid text-danger" ></span>
						</select>
							    <span class="field-validation-valid text-danger" ></span>
							</div>
							<div class="col-sm-3">
							    <select name="state" id="state1" required id ="state" class="state1 form-control">
						    <option>Select State</option>
						    <span class="field-validation-valid text-danger" ></span>
						</select>
							    <span class="field-validation-valid text-danger" ></span>
							</div>
                                                        <div class="col-sm-4">
							    <input type="text" class="form-control off_pwd" name="zipcode" id="zipcode"  placeholder="zipcode">
							</div>							
						    </div>
							<div class="form-group" id="gusuario">
<!--							<label for="officer_name" class="col-sm-2 control-label">Company</label>-->
							<div class="col-sm-5" hidden>
							    <input type="text" class="form-control officer_name" name="company"  placeholder="Company name">
							</div>
                            <label for="phone"  class="col-sm-2 control-label">Telephone</label>
							<div class="col-sm-5">
							    <input class="form-control ph_no" id="phone-number1" name="phone" placeholder="Phone Number">							      </div>
							<div class="col-sm-5">
							    <span id="inter_origin" style="display: block;">								
								<select name="country" id="country1" required class="country1 form-control">
								    <?php
								    $stmt = mysql_query("SELECT * FROM `country` WHERE `country_id` in (231, 61)");

								    while ($row = mysql_fetch_array($stmt)) {
									?>
    								    <option value="<?php echo $row['country_id']; ?>" <?php if ($row['country_id'] == $s_country) {
									echo "selected";
								    } ?>><?php echo $row['country_name']; ?></option>
<?php } ?>
								</select>

							</div>
						    <div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
							    <div class="checkbox checkbox-success">
								<input id="estado" type="checkbox" name="estado" value="1" >
								<label for="checkbox3">
								    Success
								</label>
							    </div>
							</div>
						    </div>
						    <!--campo oculto-->
						    <input type="hidden" name="id" id="id_user">
						</form>   
						<!--Fin del cuerpo del modal-->  
					    </div>
					    <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" id="actualizar" class="btn btn-primary">Save</button>
					    </div>
					</div>
				    </div>
				</div>
				<!--fin de modal nuevo usuario-->


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

	<script type='text/javascript' src="js/add-new-client.js"></script>

	<!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
	<script type= "text/javascript" src="../process/countries.js"></script>
	<script language="javascript" type="text/javascript">
	   
		$('#phone-number').keyup(function(){
			$(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
		});
		$('#phone-number1').keyup(function(){
			$(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
		});


		    
	</script>
    </body></html>