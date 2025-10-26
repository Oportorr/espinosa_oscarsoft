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
	<title>CARGO v10.1 | ADD NEW USER </title>
	
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
	  <link rel="stylesheet" href="css/footer-basic-centered.css">
  
</head>
<body onload="viewdata()">
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

		        <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
						<table border="0" align="center" width="100%">
							<tr>
								<td class="TrackTitle" valign="top"><div  align=""><h3 class="classic-title1"><span><strong></strong></span></h3>
										</tr>
										<div class="row">
											<div class="col-xs-12" align="center">
												<h2>List employees account</h2>
												<br>
											</div>
										</div>
											<div class="row">
												<div class="col-xs-12">
												<!--Botones principales-->
												<button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#nuevo"><i class="fa fa-user-plus"></i>
												 New Employee</button>
												 
												</div>
											<div class="col-xs-12">
											<div class="table">
											<br>
											<!--Inicio de tabla usuarios-->
											<table id="tabla-usuarios" class="table table-striped table-bordered" cellspacing="0" width="100%">
											<!--encabezado tabla-->
											<thead>
														<tr>
															<th>Name Employee</th>															
															<th>Phone</th>
															<th>Email</th>
															<th>Office</th>
															<th>Type of user</th>
															<th>User</th>
															<th>Password</th>
															<th>Status</th>
															<th>Actions</th>
														</tr>
													</thead>

											</table>
											<!--fin de tabla-->

											</div>
											</div>
											</div>


											<!-- Modal nuevo usuario -->
											<div class="modal fade" id="nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											  <div class="modal-dialog">
												<div class="modal-content">
												  <div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
													<h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> New Employee</h4>
												  </div>
												  <div class="modal-body">
												  <!--Cuerpo del modal aquí el formulario-->
													<form action="settings/adduser/agregar.php"  class="form-horizontal" method="post">
													  <div class="form-group " id="gnombrepa">
														<label for="off_name" class="col-sm-2 control-label">Name</label>
														<div class="col-sm-10">
														  <input type="text" class="form-control off_name" name="name_parson"  placeholder="Name Employee ">
														</div>
													  </div>
													  <div class="form-group" id="gapellido">
														<label for="email" class="col-sm-2 control-label">Email </label>
														<div class="col-sm-5">
														  <input type="text" class="form-control email" name="email"   placeholder="Email ">
														</div>
														<div class="col-sm-5">
														  <input class="form-control phone" name="phone" placeholder="Phone">																		  
														</div>
													  </div>
													  <div class="form-group" id="gemail">
														<label for="office" class="col-sm-2 control-label">Office</label>
														<div class="col-sm-5">
														  <input type="text" class="form-control office" name="office"  placeholder="Office ">
														</div>
														<div class="col-sm-5">
														<select type="text" class="form-control role" name="role" >
														  <option value="Employee">Employee</option>											
														</select>
														</div>
													  </div>
													  <div class="form-group " id="gnombre">
														<label for="off_name" class="col-sm-2 control-label">User</label>
														<div class="col-sm-10">
														  <input type="text" class="form-control off_name" name="name"  placeholder="User">
														</div>
													  </div>
													  <div class="form-group" id="gpassword">
														<label for="pwd" class="col-sm-2 control-label">Password</label>
														<div class="col-sm-10">
														  <input type="text" class="form-control pwd" name="pwd"  placeholder="Password">
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
																<input type="checkbox"  name="type" value="u" checked>
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
											 Edit User</h4>
												  </div>
												  <div class="modal-body">
											<!--Cuerpo del modal aquí el formulario-->
												<form class="form-horizontal" id="formularioEditar">

											  <div class="form-group" id="Eapellido">
												<label for="email" class="col-sm-2 control-label">Email </label>
												<div class="col-sm-10">
												  <input type="text" class="form-control" name="email" placeholder="Email ">
												</div>
											  </div>
											  <div class="form-group" id="Etelefono">
												<label for="phone" class="col-sm-2 control-label">Phone</label>
												<div class="col-sm-10">
												  <input class="form-control" name="phone" placeholder="Phone ">							
												</div>
											  </div>
											  <div class="form-group" id="Eemail">
												<label for="office" class="col-sm-2 control-label">Office</label>
												<div class="col-sm-10">
												  <input type="text" class="form-control" name="office"  placeholder="Office ">
												</div>
											  </div>
											  <div class="form-group" id="Eusuario">
												<label for="role" class="col-sm-2 control-label">Type of user</label>
												<div class="col-sm-10">
												  <input type="text" class="form-control" name="role" placeholder="User">
												</div>
											  </div>
											 <div class="form-group" id="Enombre">
												<label for="name" class="col-sm-2 control-label">User</label>
												<div class="col-sm-10">
												  <input type="text" class="form-control" name="name" placeholder="Office Name">
												</div>
											  </div>
											  <div class="form-group">
												<label for="pwd" class="col-sm-2 control-label">Password</label>
												<div class="col-sm-10">
												  <input type="text" class="form-control" name="pwd" placeholder="Password">
												</div>
											  </div>
											  <div class="form-group">
												<div class="col-sm-offset-2 col-sm-10">
													<div class="checkbox checkbox-success">
														<input id="checkbox3" type="checkbox" name="estado" value="1" >
														<label for="checkbox3">
															Success
														</label>
													</div>
												</div>
											  </div>
											  <!--campo oculto-->
											  <input type="hidden" name="cid" id="id_user">
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

		<!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>	

		<script type='text/javascript' src="js/cruduser.js"></script>


  </body>
</html> 
