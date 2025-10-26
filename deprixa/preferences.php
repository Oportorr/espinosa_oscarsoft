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

 $qname = $_SESSION['user_name']; 	
$qrole = $_SESSION['user_type']; 
													 
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
	<title>CARGO v10.1 | COMPANY SETTINGS </title>
	
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
  
  	<!-- Plugins css -->
	<link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
	<link href="assets/plugins/mjolnic-bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
	<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<link href="assets/plugins/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet">
	<link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

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
										<tbody>
										<tr>				
											<h3 class="classic-title"><span><strong><i class="fa fa-truck icon text-default-lter"></i>&nbsp;&nbsp;Preference</strong></h3>
										
											<!-- START Checkout form -->
										

											 														
											<?php		
												$result4 = mysql_query("SELECT * FROM company WHERE  id='1' ");
												while($rr = mysql_fetch_array($result4)) {
												
											?>	
											<form action="process.php?action=company"  method="post"  class="form-horizontal" > 
												<div class="row">
												
													<!-- START Presonal information -->
													<fieldset class="col-md-6">								
													
														<legend>Company information :</legend>
														
														<!-- Country and state -->								
														<div class="row">
															<div class="col-sm-6 form-group">
																<label for="zipcode" class="control-label">COMPANY NAME</label>
																<input type="text" class="form-control" value="<?php echo $rr['cname']; ?>"  name="cname">
															</div>
															<div class="col-sm-3 form-group">
																<label for="zipcode" class="control-label"><i class="fa fa-hashtag icon text-default-lter"></i>&nbsp;NIT</label>
																<input type="text" class="form-control" value="<?php echo $rr['nit']; ?>"  name="nit">
															</div>
															
															<div class="col-sm-3 form-group">
																<label class="control-label"><i class="fa fa-phone-square icon text-default-lter"></i>&nbsp;COMPANY PHONE</label>
																<input type="text" class="form-control" value="<?php echo $rr['cphone']; ?>"  name="cphone" >
																	
															</div>									
														</div>
														<!-- Qnty -->
														<div class="row">
															<div class="col-sm-6 form-group">
																<label for="zipcode" class="control-label"><i class="fa fa-at icon text-default-lter"></i>&nbsp;Booking Notification Email  </label> 
																<input type="email" class="form-control" value="<?php echo $rr['bemail']; ?>"  name="bemail">
															</div>
															
														<!-- Origin Office -->
														   <div class="col-sm-6 form-group">
															 <label for="zipcode" class="control-label"><i class="fa fa-paypal icon text-default-lter"></i>&nbsp;PayPal Email<span class="required-field">*</span></label>
															  <input type="email" class="form-control" value="<?php echo $rr['cemail']; ?>"  name="cemail" >											
															</div>	
														</div>												
														 <!-- Payment Mode -->
														 <div class="row">
															
														</div>
														<div class="row">
															<!-- Text area -->
															<div class="col-sm-6 form-group">
																<label for="inputTextarea" class="control-label"><i class="fa fa-map-marker icon text-default-lter"></i>&nbsp;Company Address</label>
																<textarea class="form-control" name="caddress" required > <?php echo $rr['caddress']; ?></textarea>
															</div>
															<div class="col-sm-3 form-group">
																<label for="inputTextarea" class="control-label"><i class="fa  fa fa-map icon text-default-lter"></i>&nbsp;Country</label>
																<input class="form-control" name="country" required  value="<?php echo $rr['country']; ?>">
															</div>
															<div class="col-sm-3 form-group">
																<label for="inputTextarea" class="control-label"><i class="fa fa fa-map-o icon text-default-lter"></i>&nbsp;City</label>
																<input class="form-control" name="city" required  value="<?php echo $rr['city']; ?>">
															</div>															
															<!-- Destination Office -->
															<div class="col-sm-6 form-group">
																<label for="zipcode" class="control-label"><i class="fa fa fa-edge icon text-default-lter"></i>&nbsp;Website </label>
																<input value="<?php echo $rr['website']; ?>"  placeholder="http://www.example.com" name="website" class="form-control" >																				
															</div>															
															<div class="col-sm-3 form-group">
																<label for="inputTextarea" class="control-label"><i class="fa fa-usd icon text-default-lter"></i>&nbsp;Currency</label>
																<input class="form-control" name="currency" required  value="<?php echo $rr['currency']; ?>">
															</div>
															<div class="col-sm-3 form-group">
																<label for="inputTextarea" class="control-label"><i class="fa fa-calendar icon text-default-lter"></i>&nbsp;Date</label>
																<input type="text" class="form-control" name="date" value="<?php echo $rr['date']; ?>" placeholder="mm/dd/yyyy" id="datepicker-autoclose">
															</div>	
															<div class="col-sm-6 form-group">
																<label for="zipcode" class="control-label"><i class="fa fa fa-edge icon text-default-lter"></i>&nbsp;Footer Website </label>
																<input value="<?php echo $rr['footer_website']; ?>"  placeholder="2016 © name" name="footer_website" class="form-control" >																				
															</div>
														</div>
														<?php } ?>
													<div class="col-md-6 text-left">
														<br>
														<br>
														<button name="Submit" type="submit" class="btn btn-large btn-success">UPDATE</button>
														
													</div>	
													</fieldset>
											</form>
											

													<!-- START Receiver info  -->
													<fieldset class="col-md-6">
														<legend>Ideal Logo PNG dimension 240 x 45</legend>
														
														<?php
															//conexion a la base de datos
															require_once('database.php');


															//le dimos click al boton grabar?
															if (isset($_POST['guardar']))
															{
															$nombre = $_FILES['imagen']['name'];
															$imagen_temporal = $_FILES['imagen']['tmp_name'];
															$type = $_FILES['imagen']['type'];
															//archivo temporal en binario
															$itmp = fopen($imagen_temporal, 'r+b');
															$imagen = fread($itmp, filesize($imagen_temporal));
															fclose($itmp);
															//escapando los caracteres
															$imagen = mysql_real_escape_string($imagen);$respuesta = mysql_query("UPDATE subir_imagen SET nombre_imagen='$nombre',imagen='$imagen',tipo='$type'", $dbConn);
															//redireccionamos
															header("Location: preferences.php?".($respuesta ? 'ok' : 'error'));
															}
															//guardado OK
															if (isset($_GET['ok']))
															{
															echo '<p>Saved successfully</p>';}
															//si no se guardo de manera correcta?
															if (isset($_GET['error']))
															{
															echo '<p>Occurred an error when it comes to the inclusion...</p>';}

															//formulario que nos permite subir a la BD el archivo
															echo '
															<form action="preferences.php" enctype="multipart/form-data" method="post">
															<label for="zipcode" class="control-label"><i class="fa fa-upload icon text-default-lter"></i>&nbsp;UPDATE LOGO</label>
															<input type="file" name="imagen" id="imagen" class="form-control" />
															<br><br>
															<button type="submit" name="guardar" class="btn btn-large btn-success">UPDATE IMAGE</button>
															<br><br>
															</form>';
															
															?>
															<br><br>
														<div class="row">									
															<div class="col-sm-6 form-group">
																<label for="currentPassword">Present logo </label></br>
																<img src="image_logo.php?id=1"/>
																

															</div>
															
														</div>																			
													</fieldset>

												</div>					
											</article>				
										  <div class="clearfix"></div>
									   </div>
									  </div>
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

        <script src="assets/plugins/moment/moment.js"></script>
     	<script src="assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
     	<script src="assets/plugins/mjolnic-bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
     	<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
     	<script src="assets/plugins/clockpicker/bootstrap-clockpicker.js"></script>
     	<script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

        <script src="assets/pages/jquery.form-pickers.init.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

		
	
	</body>	
</html>
