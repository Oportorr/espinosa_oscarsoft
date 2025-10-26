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

if ($_POST['cons']=="") {	
    $cid = $_GET['cid'];
	$sql = "SELECT * FROM courier_online WHERE cid ='$cid'";
} else {	
	$posted = $_POST['cons'];
	$sql = "SELECT * FROM courier_online WHERE cons_no ='$posted'";
}	
	$result = dbQuery($sql);
	$count=mysql_num_rows($result );
if ($count > 0){
while($data = dbFetchAssoc($result)) {
	extract($data);
															 
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
	<title>CARGO v10.1 | ADD SHIPPING </title>
	
	<!-- Switchery css -->
    <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" />

    <!-- App CSS -->
	<link href="assets/css/style.css" rel="stylesheet" type="text/css" />
    
	
	<!-- Plugins css -->
	<link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
	<link href="assets/plugins/mjolnic-bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
	<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<link href="assets/plugins/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet">
	<link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	
	 <script src="assets/js/modernizr.min.js"></script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-79190402-1', 'auto');
	  ga('send', 'pageview');

	</script>

   
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
					<div class="col-xs-12 col-lg-12 col-xl-5">
						<div class="card-box">

							<h4 class="header-title m-t-0 m-b-20">DELIVERY OF SHIPMENTS</h4>
							
							<?php 
									if($payment !='OK'){
										echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
												<button type="button" class="close" data-dismiss="alert"
														aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
												<h5><strong>IMPORTANT</strong>, the delivery of shipments is performed if the customer has paid for <strong>PAYPAL</strong></h5>
											</div>';
									}else{
										echo "<div class='alert alert-success alert-dismissible fade in' role='alert'>
												<button type='button' class='close' data-dismiss='alert'
														aria-label='Close'>
													<span aria-hidden='true'>&times;</span>
												</button>
												<h5><strong>The payment to the number of shipment <strong>$cons_no</strong> was successfully paid</strong></h5>
											</div>";
									}
								?>
							
								<br><br>							
							<div class="text-xs-center">
								<table border="0" align="center" width="100%">
									<form  action="process.php?action=deliveredondelivery" method="post" class="form-horizontal" >
										
										<div class="row" >
											<div class="col-sm-4 form-group">
												<label  class="control-label">DELIVERY BOY<span class="required-field">*</span></label>
												<input type="text"  name="deliveryboy" value="<?php echo $deliveryboy; ?>" class="form-control" required>
											</div>
											
											<div class="col-sm-2 form-group">
												<label  class="control-label">ID</label>
												<input type="text" class="form-control" name="drs" value="<?php echo $drs; ?>">
											</div>

											<div class="col-sm-3 form-group">
												<label  class="control-label">Received Person</label>
												<input type="text" class="form-control" name="receivedby" value="<?php echo $receivedby; ?>">
											</div>
											
											<?php if($payment !='Pending'){?>
											<div class="col-sm-3 form-group">
												<img src="images/delivery_time.png" border="0" height="80" width="122"></a>
											</div>
											<br><br>
											<div class="col-sm-12 form-group">																																					
												 <input name="cid" id="cid" value="<?php echo $cid; ?>" type="hidden">
												<div class="col-md-12 text-center">
													<input class="btn btn-danger" name="Submit" type="submit"  value="DELIVER SHIPMENT">
												</div>
											</div>
											<?php } ?>
										</div>										
									</form>	
								</table>	
							</div>
						</div>
					</div><!-- end col-->

				<div class="col-xs-12 col-lg-12 col-xl-7">
					<div class="card-box">

							<h4 class="header-title m-t-0 m-b-30">Manage Courier No : <font style="color:#090;"><?php echo $cons_no; ?></font></h4>

						<div class="text-xs-center">
							<table border="0" align="center" width="100%">
								<form  action="process.php?action=update-courier" method="post" class="form-horizontal" >
								
										<div class="row">
										
											<!-- START Presonal information -->
											<fieldset class="col-md-6">
												<legend>General Details :</legend>
												
												<!-- Name -->
												<div class="row" >
												<div class="col-sm-4 form-group">
														<label  class="control-label"><i class="fa fa-user icon text-default-lter"></i>&nbsp;Staff Name<span class="required-field">*</span></label>
														<input type="text"  name="user"  value="<?php echo $_SESSION['user_name'] ;?>" class="form-control"  readonly="true" >
												</div>
												<div class="col-sm-8 form-group">
												
													<label class="control-label" >CLIENT NAME<span class="required-field">*</span></label>								
													 <input type="text" name="sname" value="<?php echo $ship_name; ?>" class="form-control" readonly="true" >									   									                                  
												</div>
												</div>
												
												<div class="row" >
													<div class="col-sm-6 form-group">
														<label  class="control-label">EMAIL<span class="required-field">*</span></label>
														<input type="text"  name="sadd" class="form-control"  value="<?php echo  $s_add; ?>" readonly="true">
													</div>
													
													<div class="col-sm-6 form-group">
														<label  class="control-label"><i class="fa fa-phone icon text-default-lter"></i>&nbsp;PHONE</label>
														<input type="text" class="form-control" name="sphone" value="<?php echo $s_phone; ?>" readonly="true">
													</div>									
												</div>	
												
												
												<!-- START Shipment information -->
											
												<legend>Shipping information :</legend>
												
												<!-- Country and state -->
												<div class="row">														
													<div class="col-sm-4 form-group" >
														<label class="text-success"><i class="fa fa-cubes icon text-default-lter"></i>&nbsp;QUANTITY</label>
														<input type="text" class="form-control" name="Qnty"  value="<?php echo  $Qnty; ?>"  readonly="true"/>
													</div>
													<div class="col-sm-4 form-group">
														<label class="text-success">Weight&nbsp;&nbsp;(Kg)</label>
														<input  type="text" class="form-control" name="weight" value="<?php echo  $weight; ?>"  readonly="true"/>
													</div>
													<div class="col-sm-4 form-group">
														<label class="text-success"><?php echo $company['currency']; ?>&nbsp;Variable&nbsp;(Kg)</label>
														<input  type="text" class="form-control" name="variable" value="<?php echo  $variable; ?>" readonly="true"/>
													</div>														

												</div>
												<div class="row">																												
													<div class="col-sm-5 form-group">
														<label for="ccv" class="text-success"><i class="fa fa-money icon text-default-lter"></i>&nbsp;<strong>FREIGHT PRICE</strong></i></label>
														<input  type="text" class="form-control" name="freight" value="<?php echo  $freight; ?>" onChange="calcula();" readonly="true"/>
													</div>
													<div class="col-sm-5 form-group">
														<label class="text-success">Subtotal shipping</i></label>
														<input  type="text" class="form-control" name="shipping_subtotal" value="<?php echo  $shipping_subtotal; ?>" readonly="true"/>
													</div>

												</div>
																								
												 <!-- Payment Mode -->
												 <div class="row">
													<div class="col-sm-4 form-group">
														<label class="control-label">Product/Type</label>
														<input name="type" value="<?php echo $type; ?>" class="form-control" readonly="true">											
													</div>
													<div class="col-sm-4 form-group">
														<label class="control-label"><i class="fa fa-plane icon text-default-lter"></i>&nbsp;Service(Mode)</label>
													  <input name="mode" value="<?php echo $book_mode;?>"  class="form-control" readonly="true">										
													</div>
													<div class="col-sm-4 form-group">
														<label for="ccv" class="control-label"><i class="fa fa-money icon text-default-lter"></i>&nbsp;<strong>BOOKING TIME</strong></i></label>
														<input name="btime" value="<?php echo $time; ?>"  class="form-control" readonly="true">
													</div>
												</div>																															
											</fieldset>

											<!-- START Receiver info  -->
											<fieldset class="col-md-6">
												<legend>Data Receiver :</legend>
												
												<!-- Name -->
												<div class="form-group">
													<label  class="control-label">RECEIVER NAME<span class="required-field">*</span></label>
													<input type="text" name="rname" class="form-control"  value="<?php echo $rev_name; ?>" readonly="true">
													
												</div>
												
												<!-- Adress and Phone -->
												<div class="row">
													<div class="col-sm-6 form-group">
														<label  class="control-label">ADDRESS <span class="required-field">*</span></label>
														<input type="text"  name="radd"  class="form-control" value="<?php echo  $r_add; ?>" readonly="true">
													</div>
													
													<div class="col-sm-6 form-group">
														<label  class="control-label"><i class="fa fa-phone icon text-default-lter"></i>&nbsp;PHONE</label>
														<input type="text" name="rphone" class="form-control"  value="<?php echo  $r_phone; ?>" readonly="true">
													</div>
																						
												</div>							
											
												<br>
												<br>
												
												<!-- Name -->
												<div class="form-group">
													<label for="name-card" class="control-label"><font color="#FF6100"><strong>TRACKING NUMBER</strong></font></label>
													<input type="TEXT" class="form-control" name="no" value="<?php echo $cons_no; ?>"  readonly="true"/>
												</div>
												<div class="row">
												<!-- Destination Office -->
												<div class="col-sm-6 form-group">
													<label for="zipcode" class="control-label"><i class="fa fa-angle-double-right icon text-default-lter"></i>&nbsp;FROM CITY</label>
													<input name="fcity" value="<?php echo $fromcity; ?>" class="form-control"  readonly="true">																			
												</div>															
												<div class="col-sm-6 form-group">
													<label for="zipcode" class="control-label"><i class="fa fa-angle-double-right icon text-default-lter"></i>&nbsp;TO CITY</label>
													<input name="tcity" value="<?php echo $tocity; ?>" class="form-control"  readonly="true">																				
												</div>		
												<!-- Status and Pickup Date -->

													<div class="col-sm-6 form-group">
														<label for="month" class="control-label"><i class="fa fa-calendar icon text-default-lter"></i>&nbsp;BOOKING DATE</label>
														<input class="form-control" name="bdate" value="<?php echo  $date; ?>" readonly="true">											
													</div>								

												</div>
										   </fieldset>
										   
										   	<fieldset class="col-md-12">
												<br><br>											
												<div class="row">
													<div class="col-sm-4 form-group">
														<label for="month" class="control-label"><i class="fa fa-sort-amount-asc icon text-default-lter"></i>&nbsp;STATUS</label>
														<select class="form-control" name="status" id="status">
															<option value="Shipment-arrived">Shipment arrived</option>
															<option value="Returned">Returned</option>
														</select>
													</div>																											
													<div class="col-sm-4 form-group">
													<label for="dtp_input1" class="control-label"><i class="fa fa-calendar icon text-default-lter"></i>&nbsp;SCHEDULED DATE</i></label>
														<div class="input-group">
															<input type="text" class="form-control" name="ddate" value="<?php echo  $deliverydate; ?>" placeholder="mm/dd/yyyy" id="datepicker-autoclose" required>
															<span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
														</div><!-- input-group -->
													</div>
													<div class="col-sm-4 form-group">		
													<label for="dtp_input1" class="control-label"><i class=" text-default-lter"></i>Update shipment of the package</i></label>																																			
														<div class="col-md-12 text-left">
															<input class="btn btn-success" name="Submit" type="submit"  value="UPDATE">
															<input name="cid" id="cid" value="<?php echo $cid; ?>" type="hidden">
														</div>
													</div>	
												</div>
											</fieldset>	
										 </form>
									</table>	 
								</div>
							<?php  } ?>
						</div>
					</div><!-- end col-->
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
<?php } ?>
</html>