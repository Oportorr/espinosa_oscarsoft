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

$qname = $_SESSION['user_name'];
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

											require_once('database.php');
												$sql_1 = "SELECT * FROM manager_user where name='$qname' LIMIT 1";
												$result45 = dbQuery($sql_1);		
											while($data = dbFetchAssoc($result45)) {
												extract($data);
											?>
										<form action="process.php?action=change-pass"  method="post"  class="form-horizontal" > 
												<div class="row">
												
													<!-- START Presonal information -->
												<fieldset class="col-md-6">
														<legend>Here goes account and change.</legend>
														
														<!-- Name -->
														<div class="row" >
														
														<div class="col-sm-6 form-group">
																<label  class="control-label"><i class="fa fa-user icon text-default-lter"></i>&nbsp;USERNAME<span class="required-field">*</span></label>
																<input type="text" name="office" value="<?php echo $_SESSION['user_name'] ;?>" class="form-control"  readonly="true" >
														</div>
														
														<div class="col-sm-3 form-group">
														
															<label class="control-label" >ROLE TYPE<span class="required-field">*</span></label>								
															 <input type="text" class="form-control" id="lastName" value="<?php echo $_SESSION['user_type'] ;?>" readonly="true" >									   									                                  
														</div>
														<div class="col-sm-3 form-group">
															<label  class="control-label">Added Since <span class="required-field">*</span></label>
																<input type="text" class="form-control" id="firstName" value="<?php echo $date; ?>" readonly> 
																<input type="hidden" class="form-control" name="cid" value="<?php echo $cid; ?>">		
															</div>

														</div>
														
														<div class="row" >
															<div class="col-sm-4 form-group">
																<label  class="control-label">EMAIL ADDRESS<span class="required-field">*</span></label>
																<p class="form-control-static" id="email"><?php echo $email; ?></p>
															</div>
															
															<div class="col-sm-4 form-group">
																<label  class="control-label"><i class="fa fa-phone icon text-default-lter"></i>&nbsp;Current Password</label>
																<input type="text" class="form-control" id="currentPassword" value="<?php echo $pwd; ?>" readonly="true" >
															</div>
															
															<div class="col-sm-4 form-group">
																<label class="control-label">New Password</i></label>
																<input type="password" class="form-control" name="pwd" placeholder="New Password" autocomplete="off" required>  
															</div>
														</div>	
														 <div class="row">
														<div class="col-md-4 text-left">
														<br><br>
														<input class="btn btn-success" name="Submit" type="submit" value="UPDATE">
														</div>
														 
														</div>								
												</fieldset>

											</div>
										</tbody>
									</form> 
								<?php } ?>
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
