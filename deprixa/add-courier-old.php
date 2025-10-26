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
require_once('funciones.php');

$sql = "SELECT DISTINCT(off_name)
		FROM offices";
$result = dbQuery($sql);

$company=mysql_fetch_array(mysql_query("SELECT * FROM company"));
																 
?>
<!DOCTYPE html>
<html>
 
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Page Description and Author -->
	<meta name="description" content="Courier Deprixa V2.5 "/>
	<meta name="keywords" content="Courier DEPRIXA-Integral Web System" />
	<meta name="author" content="Jaomweb">

	<!-- App Favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">

	<!-- App title -->
	<title>DEPRIXA | ADD SHIPPING </title>
	
	<!-- Switchery css -->
    <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" />

    <!-- App CSS -->
	<link href="assets/css/style.css" rel="stylesheet" type="text/css" />
    
    <!-- ######### CSS STYLES ######### -->
	
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css" type="text/css" />
	<link rel="stylesheet" href="bower_components/simple-line-icons/css/simple-line-icons.css" type="text/css" />
	<link rel="stylesheet" href="css/font.css" type="text/css" />
	<link href="js/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="js/plugins/sweetalert/css/sweetalert.css" rel="stylesheet">
	<link rel="stylesheet" href="css/footer-basic-centered.css">
	
	<!-- Plugins css -->
	<link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
	<link href="assets/plugins/mjolnic-bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
	<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<link href="assets/plugins/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet">
	<link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script type= "text/javascript" src="../process/countries.js"></script> 


<body>
<?php include("header.php"); ?>

<!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="wrapper" id="main">
            <div class="container">

                <!-- Page-Title -->
				<?php
				include("icon_settings.php");
				?> 

	


		<div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
										<tbody>
										<tr>				
										<h3 class="classic-title"><span><strong><i class="fa fa-truck icon text-default-lter"></i>&nbsp;&nbsp;Add Shipping</strong></h3>
									
										<!-- START Checkout form -->
										
								<form action="process.php?action=add-cons" name="formulario" method="post"> 
									<table border="0" align="center" width="100%" >
											<div class="row">
											
												<!-- START Presonal information -->
												<fieldset class="col-md-6">
													<legend>Data Sender :</legend>	
													<!-- Name -->
													<div class="row" >
													<div class="col-sm-2 form-group">
															<label  class="control-label"><i class="fa fa-user icon text-default-lter"></i>&nbsp;Staff Role<span class="required-field">*</span></label>
															<input type="text"  name="officename" id="officename" value="<?php echo $_SESSION['user_type'] ;?>" class="form-control"  readonly="true" >
													</div>
													<div class="col-sm-2 form-group">
															<label  class="control-label"><i class="fa fa-user icon text-default-lter"></i>&nbsp;Staff User<span class="required-field">*</span></label>
															<input type="text"  name="user" id="user" value="<?php echo $_SESSION['user_name'] ;?>" class="form-control"  readonly="true" >
													</div>
													<div class="col-sm-8 form-group">
													
														<label class="control-label" >SENDER NAME<span class="required-field">*</span></label>								
														 <input type="text" name="Shippername" id="Shippername" class="form-control" autocomplete="off" required placeholder="Enter your name" >
														   <datalist id="browsers">
															<?php
																$sql=mysql_query("SELECT * FROM customer");
																while($row=mysql_fetch_array($sql)){
																	echo '<option value="'.$row['Shippername'].'">';
																}
															?>
														  </datalist>									                                  
													</div>
													</div>
													
													<div class="row" >
														<div class="col-sm-6 form-group">
															<label  class="control-label">ADDRESS<span class="required-field">*</span></label>
															<input type="text"  name="Shipperaddress" id="Shipperaddress"class="form-control"  autocomplete="off" required placeholder="Sender address" >
														</div>
														
														<div class="col-sm-3 form-group">
															<label  class="control-label"><i class="fa fa-phone icon text-default-lter"></i>&nbsp;PHONE</label>
															<input type="text" class="form-control" name="Shipperphone" id="Shipperphone" autocomplete="off" required placeholder="Sender phone">
														</div>
														
														<div class="col-sm-3 form-group">
															<label class="control-label">ID</i></label>
															<input type="text" name="Shippercc" id="Shippercc"class="form-control"  maxlength="20" placeholder="Sender phone" autocomplete=" off" required>
														</div>									
													</div>	
													
													<!-- Adress and Phone -->
													
													<!-- START Shipment information -->
												
													<legend>Shipping information :</legend>
													
													<!-- Country and state -->
													<div class="row">
														<div class="col-sm-5 form-group">
															<label class="control-label"><i class="fa fa-database icon text-default-lter"></i>&nbsp;<strong>Payment Mode</strong></label>
															<select name="Bookingmode" class="form-control"  id="Bookingmode">
																<option selected="selected" value="Paid">Paid</option>
																<option value="ToPay">ToPay</option>
																<option value="Cash-on-Delivery">Cash on Delivery</option>
																
															</select>
														</div>
														
														<div class="col-sm-4 form-group">
															<label class="control-label">Product/Type</label>
															<input  name="Shiptype" class="form-control" id="Shiptype"  placeholder="Enter the type of products" >											
																
														</div>
														<div class="col-sm-3 form-group">
															<label class="control-label"><i class="fa fa-plane icon text-default-lter"></i>&nbsp;Service(Mode)</label>
														  <select name="Mode" class="form-control"  id="Mode">
															<option value="0">Select</option>
															<?php 
																	$sql=mysql_query("SELECT name FROM mode_bookings  GROUP BY name");
																	while($row=mysql_fetch_array($sql)){
																	if($cliente==$row['name']){
																	echo '<option value="'.$row['name'].'" selected>'.$row['name'].'</option>';
																	}else{
																	echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
																 }
																}
															?> 
														  </select>
														</div>
													</div>
													<!-- Qnty -->
													<div class="row">

													<!-- Origin Office -->
													
														<div class="col-sm-4 form-group">
															<label for="ccv" class="control-label"><?php echo $company['currency']; ?>&nbsp;Insurance of the Shipment</i></label>
															<input name="Totaldeclarate" class="form-control" id="Totaldeclarate" maxlength="20" placeholder="0,00"/>
														</div>
													   <div class="col-sm-4 form-group">
														 <label for="zipcode" class="control-label"><i class="fa fa-angle-double-right icon text-default-lter"></i>&nbsp;OFFICE OF ORIGIN</label>
														  <select name="Invoiceno" id="Invoiceno" class="form-control" >
																<?php 
																while($data = dbFetchAssoc($result)){
																?>
																<option value="<?php echo $data['off_name']; ?>"><?php echo $data['off_name']; ?></option>
																<?php 
																}//while
																?>
														   </select>
														</div>
														<!-- Destination Office -->
														<div class="col-sm-4 form-group">
															<label for="zipcode" class="control-label"><i class="fa fa-angle-double-right icon text-default-lter"></i>&nbsp;DESTINATION OFFICE</label>
																<span id="inter_origin" style="display: block;">     
																<select onchange="print_state('state', this.selectedIndex);" id="country" required   name="Pickuptime" class="form-control"></select>	<script language="javascript">print_country("country");</script>								
														</div>		
													</div>	
													
													 <!-- Payment Mode -->
													 <div class="row">
														<div class="col-sm-2 form-group" >
															<label class="text-success"><i class="fa fa-cubes icon text-default-lter"></i>&nbsp;QUANTITY</label>
															<input type="text" class="form-control" name="Qnty"  value="0"  />
														</div>
														<div class="col-sm-2 form-group">
															<label class="text-success">Weight&nbsp;&nbsp;(Kg)</label>
															<input  type="text" class="form-control" name="Weight" value="0"  />
														</div>
														<div class="col-sm-2 form-group">
															<label class="text-success"><?php echo $company['currency']; ?>&nbsp;Variable&nbsp;(Kg)</label>
															<input  type="text" class="form-control" name="variable" value="2.20"/>
														</div>														
														<div class="col-sm-3 form-group">
															<label for="ccv" class="text-success"><i class="fa fa-money icon text-default-lter"></i>&nbsp;<strong>FREIGHT PRICE</strong></i></label>
															<input  type="text" class="form-control" name="Totalfreight" placeholder="0,00" onChange="calcula();" />
														</div>
														<div class="col-sm-3 form-group">
															<label class="text-success">Subtotal shipping</i></label>
															<input  type="text" class="form-control" name="shipping_subtotal" value="0,00" />
														</div>
													</div>												
													<!-- Text area -->
													<div class="form-group">
														<label for="inputTextarea" class="control-label"><i class="fa fa-comments icon text-default-lter"></i>&nbsp;Shipping Detail</label>
														<textarea class="form-control" name="Comments" id="Comments" placeholder="Write the details of the shipment"></textarea>
													</div>
													
												</fieldset>


												<!-- START Receiver info  -->
												<fieldset class="col-md-6">
													<legend>Data Recipient :</legend>
													
													<!-- Name -->
													<div class="form-group">
														<label  class="control-label">RECIPIENT NAME<span class="required-field">*</span></label>
														<input type="text" class="form-control" name="Receivername" placeholder="Enter name recipient">
														
													</div>
													
													<!-- Adress and Phone -->
													<div class="row">
														<div class="col-sm-6 form-group">
															<label  class="control-label">ADDRESS <span class="required-field">*</span></label>
															<input type="text"  name="Receiveraddress" id="Receiveraddress"class="form-control"  autocomplete="off" required placeholder="Recipient address">
														</div>
														
														<div class="col-sm-3 form-group">
															<label  class="control-label"><i class="fa fa-phone icon text-default-lter"></i>&nbsp;PHONE</label>
															<input type="text" class="form-control" name="Receiverphone" id="Receiverphone" autocomplete="off" required placeholder="Recipient phone">
														</div>
														
														<div class="col-sm-3 form-group">
															<label class="control-label">ID</i></label>
															<input type="text" name="Receivercc_r" id="Receivercc_r"class="form-control"  maxlength="20" placeholder="Recipient id" autocomplete="off" required>
														</div>
														<div class="col-sm-12 form-group">
															<label class="control-label">EMAIL <font color="#FF6100">Note: (The email must be real to be notified shipping)</font></i></label>
															<input type="text" name="Receiveremail" id="Receiveremail" class="form-control"   placeholder="demo@emo.com" autocomplete=" off" required>
														</div>
													</div>							
												
													<br>
													<br>
													
													<!-- Name -->
													<div class="form-group">
														<label for="name-card" class="text-success"><strong>TRACKING NUMBER</strong></label>
														<input type="text" class="form-control" name="ConsignmentNo"  value="<?php 
														//Variables
															$DesdeLetra = "A";										
															$DesdeLetra1 = "W";										
															$DesdeLetra2 = "B";
															$DesdeNumero2 = 1;
															$HastaNumero2 = 1;
															$DesdeNumero3 = 87;
															$HastaNumero3 = 87;
															$DesdeNumero = 1;
															$HastaNumero = 1000000000000;										
															$letraAleatoria = ($DesdeLetra);
															$letraAleatoria1 = ($DesdeLetra1);
															$letraAleatoria2 = ($DesdeLetra2);
															$numeroAleatorio2 = chr(rand(ord($DesdeNumero2), ord($HastaNumero2)));
															$numeroAleatorio3 = ($DesdeNumero3);
															$numeroAleatorio = rand($DesdeNumero, $HastaNumero);
														
														echo "".$letraAleatoria."".$letraAleatoria1."".$letraAleatoria2."".$numeroAleatorio."";?>" id="ConsignmentNo"  />
													</div>
													
													
													<!-- Status and Pickup Date -->
													<div class="form-group">
														<label for="dtp_input1" class="control-label"><i class="fa fa-calendar icon text-default-lter"></i>&nbsp;COLLECTION DATE AND TIME</i></label>
														<div>
															<div class="input-group">
																<input type="text" class="form-control" name="Packupdate" placeholder="mm/dd/yyyy" id="datepicker-autoclose">
																<span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
															</div><!-- input-group -->
														</div>		
													</div>										
																											
													<div class="row">
														<div class="col-sm-4 form-group">
															<label for="month" class="control-label"><i class="fa fa-sort-amount-asc icon text-default-lter"></i>&nbsp;STATUS</label>
															<select class="form-control" name="status" id="status">
																<option selected="selected" value="In-Transit">In Transit</option>
															</select>
														</div>								
													<div class="col-sm-8 form-group">
															<label for="dtp_input1" class="control-label"><i class="fa fa-calendar icon text-default-lter"></i>&nbsp;Schedule Delivery</i></label>
														<div>
															<div class="input-group">
																<input type="text" class="form-control" name="Schedule" placeholder="mm/dd/yyyy" id="datepicker">
																<span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
															</div><!-- input-group -->
														</div>		
															
														</fieldset>
														<div class="col-md-6 text-left">
															<br>
															<br>
															<input class="btn btn-success" name="Submit" type="submit"  id="submit" value="SAVE TRACKING">
														</div>
													</div>					
												</article>				
											<div class="clearfix"></div>
										</div>
									</div>
									</table>
								</form>
							</tbody>							
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
		
		<script language="javascript" type="text/javascript">
			function calcula() {
			  with (document.formulario) {
				var tempResult = Math.round(Qnty.value * Weight.value * variable.value *  Totalfreight.value * 100);  // calculo general sin perder precision		
				var integerDigits = Math.floor(tempResult/100);  // extraer la parte no decimal
				var decimalDigits = "" + (tempResult - integerDigits * 100); // extraer la parte decimal			
				while (decimalDigits.length<2) {  // formatear la parte decimal a dos digitos 
				  decimalDigits = "0"+decimalDigits;
				}
				shipping_subtotal.value = integerDigits + "," + decimalDigits + " "; // componer la cadena resultado
			  }
			}			
		</script>
		
	
		
	
	</body>
</html>