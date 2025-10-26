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
require_once('funciones.php');

isUser();
if ($_POST['cons'] == "") {
    $cid = $_GET['cid'];
    $invoic_id = $_GET['cid'];
    $sql = "SELECT * FROM courier WHERE cid ='$cid'";
} else {
    $posted = $_POST['cons'];
    $sql = "SELECT * FROM courier WHERE cons_no ='$posted'";
}
$result = dbQuery($sql);

$count = mysql_num_rows($result);
if ($count > 0) {
    while ($data = dbFetchAssoc($result)) {
	extract($data);

	$company = mysql_fetch_array(mysql_query("SELECT * FROM company"));
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
		<title>CARGO v10.1 | EDIT COURIER </title>

		<!-- Switchery css -->
		<link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" />

		<!-- App CSS -->
		<link href="assets/css/style.css" rel="stylesheet" type="text/css" />


		<!-- Plugins css -->
		<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />
		<link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="assets/plugins/mjolnic-bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
		<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
		<link href="assets/plugins/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet">
		<link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
                <link href="assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
                <link href="js/plugins/sweetalert/css/sweetalert.css" rel="stylesheet">
		<script src="assets/js/modernizr.min.js"></script>
		<script>
		    (function (i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r;
			i[r] = i[r] || function () {
			    (i[r].q = i[r].q || []).push(arguments)
			}, i[r].l = 1 * new Date();
			a = s.createElement(o),
				m = s.getElementsByTagName(o)[0];
			a.async = 1;
			a.src = g;
			m.parentNode.insertBefore(a, m)
		    })(window, document, 'script', '../../../www.google-analytics.com/analytics.js', 'ga');

		    ga('create', 'UA-79190402-1', 'auto');
		    ga('send', 'pageview');

		</script>

		<script src="js/jquery-1.11.1.min.js"></script>
		<script type= "text/javascript" src="../process/countries.js"></script> 

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
			   <div class="col-xs-12">  <!-- col-lg-12 col-xl-7-->
				<div class="card-box">
				    <div class="text-xs-left">



					<h3 class="classic-title"><span><i class="fa fa-truck icon text-default-lter"></i><strong>&nbsp;&nbsp;Update Shipping</strong></h3>																					
					<!-- START Checkout form -->										
					<form action="process.php?action=update-addcourier" name="formulario" method="post"> 

					    <div class="row">

						<!-- START Presonal information -->
						<fieldset class="col-md-6">
						    <legend>Data Sender :</legend>	
						    <!-- Name -->
						    <div class="row" >
							<div class="col-sm-3 form-group hidden-xs-up">
							    <label  class="control-label"><i class="fa fa-user icon text-default-lter"></i>&nbsp;Staff Role<span class="required-field">*</span></label>
							    <input type="text"  name="officename" id="officename" value="<?php echo $_SESSION['user_name']; ?>" class="form-control"  readonly="true" >
							</div>
							<div class="col-sm-3 form-group hidden-xs-up">
							    <label  class="control-label"><i class="fa fa-user icon text-default-lter"></i>&nbsp;Staff User<span class="required-field">*</span></label>
							    <input type="text"  name="user" id="user" value="<?php echo $_SESSION['user_type']; ?>" class="form-control"  readonly="true" >
							</div>
							<div class="col-sm-12 form-group">

							    <label class="control-label" >SENDER NAME<span class="required-field">*</span></label>								
							    <input type="text" name="Shippername" id="Shippername"  class="form-control" autocomplete="off" required value="<?php echo $ship_name; ?>" >									                                  
							</div>
						    </div>

						    <div class="row" >
							<div class="col-sm-5 form-group">
							    <label  class="control-label">ADDRESS<span class="required-field">*</span></label>
							    <input type="text"  name="Shipperaddress" class="form-control" required value="<?php echo $s_add; ?>" >
							</div>
							<div class="col-sm-3 form-group">
                                                            <label  class="control-label"><i class="fa fa-phone icon text-default-lter"></i>&nbsp;PHONE</label>                            
							    <input type="text" class="form-control" name="Shipperphone" required value="<?php echo $phone; ?>">
							</div>

							<div class="col-sm-4 form-group">
							    <label class="control-label">ID</i></label>
                                                            <input type="text" name="Shippercc" class="form-control"  value="<?php echo $cc; ?>" readonly="true"  required>
							</div>									
						    </div>	
							
							<?php $state_id = $s_state;
                                                        	$city_id = $s_city ?>
	                        <div class="row" >
							<div class="col-sm-4 form-group">
							    <label for="City" class="control-label"><i class="text-default-lter"></i>&nbsp;City</label>

							    <select name="city" required id ="city" class="city form-control">
								<option>Select city</option>
								<span class="field-validation-valid text-danger" ></span>
							    </select>
							</div>							
							<div class="col-sm-4 form-group">
							    <label for="State" class="control-label"><i class="text-default-lter"></i>&nbsp;State</label>

							    <select name ="state" required  id ="state" class="state form-control">
								<option>Select State</option>
								<?php
								$stmt = mysql_query("SELECT * FROM state where country_id='231'");
								while ($row = mysql_fetch_array($stmt)) {
								    ?>
                                                                    <option value="<?php echo $row['state_id']; ?>" <?php
                                                                    if ($row['state_id'] == $s_state) {
									echo "selected";
                                                                    }
                                                                    ?>><?php echo $row['state_name']; ?></option>
	<?php } ?>
								<span class="field-validation-valid text-danger" ></span>
							    </select>

							</div>
							<div class="col-sm-4 form-group">
							    <label for="zipcode" class="control-label"><i class="text-default-lter"></i>&nbsp;Zipcode</label>
							    <input type="text" id="zip_code" class="zip_code form-control" name="zip_code" value="<?php echo $s_zipcode; ?>"  placeholder="Enter Zipcode" value=""  />
							    </select>
							</div>
                            </div>
						    <!-- Adress and Phone -->

						    <!-- START Shipment information -->

						    <legend>Shipping information:</legend>

						    <!-- Country and state -->
						    <div class="row">
							<div class="col-sm-3 form-group">
							    <label class="control-label"><i class="fa fa-database icon text-default-lter"></i>&nbsp;<strong>Payment Mode</strong></label>
							    <input name="Bookingmode" class="form-control"  id="Bookingmode" value="<?php echo $book_mode; ?>" readonly="true">

							</div>

							<div class="col-sm-4 form-group">
							    <label for="zipcode" class="control-label"><i class="fa fa-angle-double-right icon text-default-lter"></i>&nbsp;OFFICE OF ORIGIN</label>
 <select name="office_origin"  id="office_origin"  class="status form-control" value="" >                                                                        
                                                                                    <?php                                                                              
                                                                                    $getdd2 = mysql_query("SELECT `off_name`,`id` FROM `offices` where `estado`=1 ");
                                                                                    while ($row1 = mysql_fetch_array($getdd2)) {
                                                                                        ?>
                                                                                        <option value="<?php echo $row1['id']; ?>" <?php
                                                                                        if ($row1['id'] == $office_origin) {
                                                                                            echo "selected";
                                                                                        }
                                                                                        ?>><?php echo $row1['off_name']; ?></option>
                                                                                            <?php } ?>
                                                                                </select>  

							</div>

                                                        
                                                        
       <!--                                                 <div class="col-sm-4 form-group">
                                                            <label for="zipcode" class="control-label"><i class="fa fa-angle-double-right icon text-default-lter"></i>&nbsp;OFFICE OF ORIGIN</label>
<?PHP  
// $getdd = mysql_fetch_array(mysql_query("SELECT `id`,`off_name` FROM `offices` where id='$invice_no'"));

?>
                                                            <input name="Invoiceno" id="Invoiceno" class="form-control" value="<?php //echo $getdd['off_name']; ?>">

                                                        </div> -->

							<div class="col-sm-2 form-group">
							    <label for="Country" class="control-label"><i class="text-default-lter"></i>&nbsp;Country</label>
							    <span id="inter_origin" style="display: block;">
								<select name="country" required class="country form-control">
								    <?php
								    $stmt = mysql_query("SELECT * FROM country where country_id='231'");
								    while ($row = mysql_fetch_array($stmt)) {
									?>
                                                                        <option value="<?php echo $row['country_id']; ?>" <?php
                                                                        if ($row['country_id'] == $s_country) {
								echo "selected";
                                                                        }
                                                                        ?>"><?php echo $row['country_name']; ?></option>
	<?php } ?>
								</select>

							</div>

							<div class="col-sm-5 form-group hidden-xs-up">
							    <label class="control-label">Product/Type</label>
							    <input  name="Shiptype" class="form-control" id="Shiptype"  value="<?php echo $type; ?>" >											

							</div>
							<div class="col-sm-3 form-group">
							    <label class="control-label"><i class="fa fa-plane icon text-default-lter"></i>&nbsp;Service(Mode)</label>
							    <input name="Mode" class="form-control"  id="Mode" value="<?php echo $mode; ?>">

							</div>
	
							<div class="col-sm-7 form-group" hidden>
							    <label for="zipcode" class="control-label"><i class="fa fa-angle-double-right icon text-default-lter"></i>&nbsp;DESTINATION OFFICE</label>
							    <input name="Pickuptime" id="Pickuptime" class="form-control" value="<?php echo $pick_time; ?>">

							</div>
						    </div>
						    <!-- Qnty -->
						    <div class="row">

							<!-- Origin Office -->

							<div class="col-sm-3 form-group hidden-xs-up">
							    <label for="ccv" class="control-label"><?php echo $company['currency']; ?>&nbsp;Insurance</i></label>
							    <input name="Totaldeclarate" class="form-control" id="Totaldeclarate" value="<?php echo $declarate; ?>"/>
							</div>

							<!-- Destination Office -->

						    </div>	

						    <!-- Payment Mode -->
						    <div class="row">
							<div class="col-sm-3 form-group hidden-xs-up" >
							    <label class="text-success"><i class="fa fa-cubes icon text-default-lter"></i>&nbsp;QUANTITY</label>
							    <input type="text" class="form-control" name="Qnty"  value="<?php echo $qty; ?>"  />
							</div>
							<div class="col-sm-4 form-group hidden-xs-up">
							    <label class="text-success">Weight&nbsp;&nbsp;(Kg)</label>
							    <input  type="text" class="form-control" name="Weight" value="<?php echo $weight; ?>"  />
							</div>
							<div class="col-sm-5 form-group hidden-xs-up">
							    <label class="text-success"><?php echo $company['currency']; ?>&nbsp;Variable&nbsp;(Kg)</label>
							    <input  type="text" class="form-control" name="variable" value="<?php echo $variable; ?>"/>
							</div>														

						    </div>
						    <div class="row">												
							<div class="col-sm-4 form-group hidden-xs-up">
							    <label for="ccv" class="text-success"><i class="fa fa-money icon text-default-lter"></i>&nbsp;<strong>FREIGHT PRICE</strong></i></label>
							    <input  type="text" class="form-control" name="Totalfreight" value="<?php echo $freight; ?>" onChange="calcula();" />
							</div>
							<div class="col-sm-4 form-group hidden-xs-up">
							    <label class="text-success">Subtotal shipping</i></label>
							    <input  type="text" class="form-control" name="shipping_subtotal" value="<?php echo $shipping_subtotal; ?>" />
							</div>
						    </div>
						    <div class="row">
							<!-- Text area -->
							<div class="table-responsive">
							    <table id="table-product" class="table table-striped table-bordered" cellspacing="0">
								<!--encabezado tabla-->
								<thead>
								 	<tr>
							    <th style="width: 75%">PRODUCT TYPE</th>
                                <th style="width: 10%">PRICE</th>
							    <th style="width: 2%">SHIP QTY</th>
							    <th style="width: 3%">DISCOUNT</th>
							    <th style="width: 5%">SUBTOTAL</th>
							    <th style="width: 5%">Actions</th>
							</tr>


								</thead>

								<tr>
									    <?php $product_row = 0; ?>		    
									    <?php $courier_item = mysql_query("SELECT * FROM courier_item WHERE cid ='$cid'");
									    while ($item = mysql_fetch_array($courier_item)) {
										?>
	    							    <td >

<!--	    								<select name="product[<?php //echo $product_row; ?>][product_type]" id="product_type" required class="product_type form-control">
	    <?php
	 //   $stmt = mysql_query("SELECT * FROM type_shipments order by name ASC");
	//    while ($row = mysql_fetch_array($stmt)) {
		?>
										    <option value="<?php//echo $row['id']; ?>" <?php //if ($row['id'] == $item['product_type']) {
		  //  echo "selected";
		//} ?>><?php //echo $row['name']; ?></option>
	    <?php //} ?>
	    								</select> -->
                
                <input  type="text"  id="product_type1" class="form-control product_type1" name="product[<?php echo $product_row; ?>][product_type1]" value="<?php echo $item['product_name']; ?>" list="product_auto" required="required"/>
                                                            <datalist id="product_auto" >
                                                                        <?php
                                                                        $sql=mysql_query("SELECT distinct(product_name) FROM courier_item");
                                                                        while($row=mysql_fetch_array($sql)){
                                                                        echo '<option value="'.$row['product_name'].'">';
                                                                        }
                                                                        ?>
                                                             </datalist>
	    							    </td>
 <td><input  type="text" id="product_price" style="width:70px;"  class="form-control product_price" name="product[<?php echo $product_row; ?>][product_price]" value="<?php echo $item['product_price']; ?>" required="required"/> </td>
 
	    							    <td><input  type="text" style="width:40px;" class="form-control ship_qty" id="ship_qty"  name="product[<?php echo $product_row; ?>][ship_qty]" value="<?php echo $item['ship_qty']; ?>" placeholder="0" onChange=""/></td>
	    							    <td><input  type="text" class="form-control discount" id="discount1"  name="product[<?php echo $product_row; ?>][discount]" style="width:60px;"  value="<?php echo $item['discount']; ?>" placeholder="%" onChange=""/></td>
	    							    <td><input  type="text" readonly="true" style="width:65px;" class="form-control sub_total"  id="sub_total1"  name="product[<?php echo $product_row; ?>][sub_total]" value="<?php echo $item['sub_total']; ?>" placeholder="0,00" onChange="" /></td>

	    							    <td><button type="button" class="btn btn-danger delete_btn" onclick="deleteRow(this)"/><i class="fa fa-trash"></i></button>  </td>
                                                                       <td>                                                                            
                                                                         <select name="product[<?php echo $product_row; ?>][ship_status]" value="<?php echo $row['id']; ?><?php echo $row['status']; ?>" id="ship_status" required class="status form-control ship_status" value="" >
                                                                             <option value="">Select Status</option>
                                                                                <?php
                                                                                $stmt = mysql_query("SELECT `off_name`,`id` FROM `offices` where `estado`=1 ");
                                                                                while ($row = mysql_fetch_array($stmt)) {
                                                                                    ?>
                                                                                    <option value="<?php echo $row['id']; ?>" <?php																					
                                                                                    if ($row['id'] == $item['line_shipping_status']) {
                                                                                        echo "selected";
                                                                                    }?> ><?php echo $row['off_name']; ?></option>
                                                                                        <?php } ?>
                                                                            </select>
                                                                        </td> 

	    							</tr>

	    <?php $product_row++; ?>	
	<?php } ?>


							    </table>
                                                        
                                                <div class="col-sm-6 form-group"></div>
						<div class="col-sm-custom form-group">
						    <div class="text-center">
                                                        <?php $courier_item = mysql_query("SELECT * FROM courier WHERE cid ='$cid'");
                                                            while ($item = mysql_fetch_array($courier_item)) {


                                                             $shipping_subtotal = $item['shipping_subtotal'];
                                                            } ?>
                                                           <?php $courier_item = mysql_query("SELECT sum(amount) FROM `courier_payment` WHERE courier_id = '$cid'");
                                                                while ($item = mysql_fetch_array($courier_item)) {
                                                                    if(!empty($item['sum(amount)'])){
                                                                    $paid = $item['sum(amount)'];
                                                                    }else{
                                                                        $paid = '0';
                                                                    }
                                                               }
                                                              ?>
                                                        <label class="text-success-custom">Total </label><input  type="text" readonly="true" class="form-control grand_total"  id="grand_total"  name="grand_total" placeholder="0,00" onChange="" value="<?php echo $shipping_subtotal; ?>"/> <div class="clearfix"></div>
                                                                      
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>    
                                                    <div class="col-sm-custom form-group">
                                                        <div class="text-center">
                                                                <label class="text-success-custom">Paid </label><input  type="text" readonly="true" class="form-control grand_total"  id="paid"  name="paid" placeholder="0,00" onChange="" value="<?php echo $paid; ?>"/> 
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>                              
                                                    <div class="col-sm-custom form-group">
                                                        <div class="text-center">
                                                            <label class="text-success-custom">Balance </label><input type="text" readonly="true" class="form-control grand_total"  id="balance"  name="balance" placeholder="0,00" onChange="" value="<?php echo number_format($shipping_subtotal - $paid, 2); ?>"/> 
                                                        </div>
                                                    </div>
                                                                                                                                                                                                 
						<div class="clearfix"></div> 
                                                <div class="text-right custom-right">
						    <INPUT type="button" value="Add More"  class="btn btn-success add_more" onclick="addRow('table-product')" />
						</div>
                                                <div class="col-sm-2 form-group"></div>
							</div>     
							
						
							<div class="col-sm-12 form-group">
							    <label for="inputTextarea" class="control-label"><i class="fa fa-comments icon text-default-lter"></i>&nbsp;Shipping Detail</label>
							    <input class="form-control" name="Comments" id="Comments" value="<?php echo $comments; ?>">
							</div>
						    </div>
						</fieldset>


					    <!-- START Receiver info  -->
					    <fieldset class="col-md-6">
						<legend>Data Recipient :</legend>
						<div class="row">
						    <!-- Name -->
                                                    
						    <div class="col-sm-12 form-group">
							<label  class="control-label">RECIPIENT NAME<span class="required-field">*</span></label>
							<input type="text" class="form-control" id="Receivername" name="Receivername" value="<?php echo $rev_name; ?>" autocomplete="off">

						    </div>
						</div>
						<!-- Adress and Phone -->
						<div class="row">
						    <div class="col-sm-6 form-group">
							<label  class="control-label">ADDRESS <span class="required-field">*</span></label>
							<input type="text"  name="Receiveraddress" class="form-control"  required value="<?php echo $r_add; ?>">
						    </div>

						    <div class="col-sm-3 form-group">
							<label  class="control-label"><i class="fa fa-phone icon text-default-lter"></i>&nbsp;PHONE</label>
							<input type="text" class="form-control" name="Receiverphone" required value="<?php echo $r_phone; ?>">
						    </div>

						    <div class="col-sm-3 form-group">
							<label class="control-label">ID</i></label>
                                                            <input type="text" name="Receivercc_r" id="Receivercc_r"class="form-control"   value="<?php echo $cc_r; ?>" readonly="true" required>
						    </div>
						    <!-- Destination country -->							
	<?php $state_id1 = $r_state;
	$city_id1 = $r_city; ?>										
						    <div class="col-sm-4 form-group">
							<label for="City" class="control-label"><i class="text-default-lter"></i>&nbsp;City</label>

							<select name="city1" required id ="city1" class="city1 form-control">
							    <option>Select city</option>
							    <span class="field-validation-valid text-danger" ></span>
							</select>
						    </div>


						    <!--by AT state -->
						    <div class="col-sm-4 form-group">
							<label for="State" class="control-label"><i class="text-default-lter"></i>&nbsp;State</label>

							<select name ="state1" required  id ="state1" class="state1 form-control">
							    <option selected="selected">Select State</option>
	<?php
	$stmt = mysql_query("SELECT * FROM state where country_id='61'");
	while ($row = mysql_fetch_array($stmt)) {
	    ?>
	    						    <option value="<?php echo $row['state_id']; ?>" <?php if ($row['state_id'] == $r_state) {
		echo 'selected';
	    } ?>><?php echo $row['state_name']; ?></option>
								<?php } ?>
							    <span class="field-validation-valid text-danger" ></span>
							</select>
						    </div>

						    <div class="col-sm-4 form-group">
							<label for="Country" class="control-label"><i class="text-default-lter"></i>&nbsp;Country</label>
							<span id="inter_origin" style="display: block;">
							    <select name="country1" required class="country1 form-control">
	<?php
	$stmt = mysql_query("SELECT * FROM country where country_id='61'");
	while ($row = mysql_fetch_array($stmt)) {
	    ?>
	    							<option value="<?php echo $row['country_id']; ?>" <?php if ($row['country_id'] == $r_country) {
		echo "selected";
	    } ?>><?php echo $row['country_name']; ?></option>
	<?php } ?>
							    </select>

						    </div>
						    <div class="col-sm-12 form-group">
							<label class="control-label">SENDER EMAIL <font color="#FF6100">Note: (The email must be real to be notified shipping)</font></i></label>
							<input type="text" name="Receiveremail" id="Receiveremail" class="form-control" value="<?php echo $email; ?>"  required readonly="true">
						    </div>
						</div>							
						<div class="row">
						    <!-- Name -->
						    <div class="col-sm-12 form-group">
							<label for="name-card" class="text-success"><strong>TRACKING NUMBER</strong></label>
							<input type="text" class="form-control" name="ConsignmentNo"  value="<?php echo $cons_no; ?>" id="ConsignmentNo"  readonly="true"/>
						    </div>

						    <!-- Status and Pickup Date -->
						   <div class="col-sm-6 form-group">
					    <label for="dtp_input1" class="control-label"><i class="fa fa-calendar icon text-default-lter"></i>&nbsp;COLLECTION DATE AND TIME</i></label>
					    <div>
						<div class="input-group">
						    <input type="text" class="form-control payment_date" name="Packupdate" placeholder="mm/dd/yyyy" id="editdatepicker">
						    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
						</div><!-- input-group -->
					    </div>
					</div>

					<div class="col-sm-6 form-group">
					    <label for="dtp_input2" class="control-label"><i class="fa fa-calendar icon text-default-lter"></i>&nbsp;Payment Due</i></label>
					    <div>
						<div class="input-group">
						    <input type="text" class="form-control" name="Payment_Due" id="payment_due" placeholder="mm/dd/yyyy" >
						    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
						</div><!-- input-group -->
					    </div>


					</div>	

						</div>

						<div class="row">
						    <div class="col-sm-3 form-group">
							<label for="month" class="control-label"><i class="fa fa-sort-amount-asc icon text-default-lter"></i>&nbsp;STATUS</label>
							<input class="form-control" name="status" id="status" value="<?php echo $status; ?>" readonly="true">
						    </div>	

                                                    <?php
                                                   
                                                     if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
                                                      
                                                    ?>
                                               <div class="col-sm-3 form-group">
                                                   <label for="input" class="control-label">&nbsp;Container :</label>
                                                   	<select name ="container_number" required  id ="container_number" class="state1 form-control">
                                                            <option>Select Option</option>
	<?php
	 $rs = mysql_query("select * from courier_container");
                                               while ($newrs = mysql_fetch_array($rs)) {
                                                    $dataid = $newrs['container_id'];   
                                                    $firstdata = $newrs['container_number'];                                               
                                                    $secondata = $container_number; 
	    ?>
                                                            <option value="<?php echo $firstdata.','.$dataid; ?>" <?php if ($firstdata == $secondata) { echo "selected";  } ?> > <?php echo $firstdata; ?> </option>
                                                               
								<?php } ?>
							    <span class="field-validation-valid text-danger" ></span>
							</select>
                                                                                           
                                                   </div>
                                                     <?php  } else { ?>     
							

<div class="col-sm-3 form-group">
								<label for="input" class="control-label">&nbsp;Container :</label><input type="hidden" name="container_number" class="form-control" value="<?php echo $container_number.','.$container_id; ?>" readonly="true">
								<input type="text" name="container_numb" class="form-control" value="<?php echo $container_number; ?>" readonly="true">
							</div>
                                                     <?php  }  ?>
                                                    <div class="col-sm-3 form-group">
								<label for="input" class="control-label">&nbsp;Invoice number :</label>
                                                                <input type="text" name="shipping_number" class="form-control" value="<?php echo $invoice_number ; ?> " readonly="true">
							</div>
						    <div class="col-sm-3 form-group">
							<label for="dtp_input1" class="control-label"><i class="fa fa-calendar icon text-default-lter"></i>&nbsp;Schedule Delivery</i></label>
							<div>
							    <div class="input-group">
								<input type="text" class="form-control" name="Schedule" value="<?php echo $schedule; ?>"  id="datepicker">
								<span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
							    </div><!-- input-group -->
							</div>		
                                                    </div>
                                                </div>   
                                                <div class="row">
                                                <legend>Payment History:</legend>
						<div class="table-responsive">
						<table id="table-payment" class="table table-striped table-bordered" cellspacing="0">
						    <thead>
							<tr>
							    <th>Payment Date</th>
							    <th>Payment</th>
                                                                        <th>User Name</th>
                                                                        <th>Cancel</th>
							</tr>
						    </thead>
							<?php
                                                            $stmt = mysql_query("SELECT * FROM courier_payment WHERE courier_id='$cid'");
                                                                $count = mysql_num_rows($stmt);
                                                                if ($count < 1) {
                                                                    ?>  <tr><td colspan="4" align="center"><?php echo "No Record Found."; ?> </td></tr>
																	 <?php 
																		$stmt = mysql_query("SELECT * FROM courier WHERE cid='$cid'");
																		$data = mysql_fetch_array($stmt);
																		$status = $data['status']; 
                                                                           
                                                                     ?>
                                                                    <?php
                                                                } else {
                                                            while($row = mysql_fetch_array($stmt)){
                                                                $date=$row['date'];
                                                                        $amount = $row['amount'];
                                                                        $user = $row['username'];
                                                                        $cancel = $row['iscancelled'];
                                                                        $pid = $row['payment_id'];
                                                                        
                                                                        ?>
                                                                <tr>
                                                                <td><?php echo $date; ?></td>
                                                                <td><?php echo $amount; ?></td>
                                                                            <td><?php echo $user; ?></td>
                                                                          
                                                                            <td align="center"> <?php  if($cancel == 0 && $status == 'In-Transit'){ ?><button type="button" payment_id="<?php echo $pid; ?>" pamount="<?php echo $amount; ?>"  c_id="<?php echo "$cid"; ?>" class="btn btn-danger delete_btn payrow"/><i class="fa fa-ban"></i></button> <?php  } ?></td>
                                                                          
                                                                </tr>
                                                            <?php }?>
                                                                <?php } ?>
						</table>
                                                </div>
                                                </div>
							</fieldset>
							<div class="col-sm-12 form-group">
							    <br>
							    <br>
                                                            <input class="btn btn-success" name="Submit" type="submit"  id="submit" value="UPDATE TRACKING">                                                             <a class="btn btn-success"  href="print-invoice/invoice-print-old.php?cid=<?php echo $cid; ?>" target="_blank">Print Invoice</a>  
                                                            
                                                                                     <a class="btn btn-success"  title="Label Print" target="_blank" href="print-invoice/invoice-print.php?cid=<?php echo $cid; ?>" target="_blank">Print Label  </a>                                                         
                                                            
                                                             <a class="btn btn-success open-pay"  href="javascript:;" data-toggle="modal" data-target="#nuevo" data-id="<?php echo $cid; ?>" >Add Payment</a>   
   <?php                                                   
              if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
   ?>                                                           
                                                                    <a class="btn btn-success"  title="Deliver" href="process.php?action=delivered&cid=<?php echo $cid; ?>" onclick="return confirm('Sure like to change the status of shipping?');" >Deliver  </a>
              <?php }  ?>                                                                    
							    <input name="cid" id="cid" value="<?php echo $cid; ?>" type="hidden">
							</div>
						    </div>					
                                                     

						    </form>
                                           
                                           

    <?php } ?>											
    					</div>
    					</div>
    					</div><!-- end col-->
                                        
                                        
                                        
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
                        <form method="post" action="process.php?action=add-pay2"  class="form-horizontal" id="payment">
                            <div class="form-group " id="gnombre">
                                <label for="office" class="col-sm-2 control-label">Date*</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="date" placeholder="mm/dd/yyyy" id="payment_date">
                                    <input type="hidden" class="form-control amount" name="cid" id="cid" value="<?php echo $cid ?>">
                                </div>
                                <label for="office" class="col-sm-2 control-label">Balance Amount</label>
                                <div class="col-xl-4">
                                    <input type="text" class="form-control" id="balance_amount" name="balance_amount"   placeholder="Balance Amount" readonly>
                                </div>
                            </div>
                            <div class="form-group border" id="gapellido">
                                <label for="amount" class="col-sm-2 control-label">Amount*</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control amount" name="amount"   placeholder="Amount" required>
                                </div>
                                <label for="amount" class="col-sm-2 control-label">Paying by*</label>
                                <div class="col-sm-4">
                                    <span id="inter_origin" style="display: block;">
                                        <select name="paying_by" required class="country form-control">
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
                                    <textarea rows="8" class="form-control officer_name"></textarea>
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
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>
                                    Close</button>
                                <input class="btn btn-success" name="Submit" type="submit"  id="submit"  value="Save" \>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--fin de modal nuevo usuario-->                                       
  
<!--    					<div class="col-xs-12 col-lg-12 col-xl-5">
    					    <div class="card-box">

    						<h4 class="header-title m-t-0 m-b-30">UPDATE STATUS</h4>

    						 START Review form 

    						<form action="process.php?action=update-status" method="post" name="frmShipment" id="frmShipment">
    						    <div class="row">
    							 Origin Office 
    							<div class="col-md-4 form-groupform-group">
    							    <label for="zipcode" class="control-label">NEW LOCATION:</label>
    							    <span id="inter_origin" style="display: block;">     
    								<select onchange="print_state('state', this.selectedIndex);" id="country" required   name="pick_time"  class="form-control"></select>	<script language="javascript">print_country("country");</script>
    							</div>	

    							 Origin Office 
    							<div class="col-md-4 form-groupform-group">
    							    <label for="zipcode" class="control-label">NEW STATE:</label>
    							    <select name="status" class="form-control" >
    								<option value="Finished">Finished</option>
    								<option value="In-Transit">In Transit</option>
    								<option value="On-Hold">On Hold</option>
    								<option value="Landed">Landed</option>
    								<option value="Delayed">Delayed</option>
    							    </select>
    							</div>	
    							 Comments 
    							<div class="col-md-4 form-groupform-group">
    							    <label for="message" class="control-label">COMMENTS:</label>
    							    <textarea class="form-control" name="comments" id="comments"  required></textarea>
    							</div>							

    							 Send button 
    							<div class="col-md-3 form-group">
    							    <p><font color="#FF6100"><strong>Update if necessary</strong></font></p>

    							    <input name="submit" type="submit" class="btn btn-success" value="UPDATE STATUS">
    							    <input name="user" id="user" value="<?php echo $_SESSION['user_name']; ?>" type="hidden">
    							    <input name="cid" id="cid" value="<?php echo $cid; ?>" type="hidden">
    							    <input name="cons_no" id="cons_no" value="<?php echo $cons_no; ?>" type="hidden"> 							
    							</div>						
    						</form>												
    						<div class="table-responsive">
    						    <br><br><br>
    						    <h4 class="header-title m-t-0 m-b-30">SHIPPING HISTORY</h4>
    						    <br>
    						    <table class="table table-bordered m-b-0">
    							<thead>
    							    <tr>
    								<th># Tracking</th>
    								<th>Location</th>
    								<th>STATUS</th>
    								<th>Date and Time</th>
    								<th>Observations</th>
    							    </tr>
    							</thead>
    							<tbody>
    <?php
    $result3 = mysql_query("SELECT * FROM courier_track WHERE cid = $cid AND cons_no = '$cons_no' ORDER BY bk_time");
    while ($row = mysql_fetch_array($result3)) {
	?> 												
								    <tr>
									<td><?php echo $row['cons_no']; ?></td>
									<td><?php echo $row['pick_time']; ?></td>
									<td><?php echo $row['status']; ?></td>
									<td><?php echo $row['bk_time']; ?></td>				
									<td><?php echo $row['comments']; ?></td>
								    </tr>
					    <?php } ?>
    							</tbody>													
    						    </table>
    						</div>
    					    </div>
    					</div>
    					</div>

    						<div class="table-responsive">
    						    <br><br><br>
    						    <h4 class="header-title m-t-0 m-b-30">SHIPPING HISTORY</h4>
    						    <br>
    						    <table class="table table-bordered m-b-0">
    							<thead>
    							    <tr>
    								<th># Tracking</th>
    								<th>Location</th>
    								<th>STATUS</th>
    								<th>Date and Time</th>
    								<th>Observations</th>
    							    </tr>
    							</thead>
    							<tbody>
    <?php
    $result3 = mysql_query("SELECT * FROM courier_track WHERE cid = $cid AND cons_no = '$cons_no' ORDER BY bk_time");
    while ($row = mysql_fetch_array($result3)) {
	?> 												
								    <tr>
									<td><?php echo $row['cons_no']; ?></td>
									<td><?php echo $row['pick_time']; ?></td>
									<td><?php echo $row['status']; ?></td>
									<td><?php echo $row['bk_time']; ?></td>				
									<td><?php echo $row['comments']; ?></td>
								    </tr>
					    <?php } ?>
    							</tbody>													
    						    </table>
    						</div>
    					    </div>
    					</div>
    					</div> end col-->
    					</div>
    					<!-- end row -->


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
                                        <script src="js/jquery-1.11.1.min.js"></script>
                                        <script src="./assets-auto/js/bootstrap-typeahead.js"></script>
                <script type='text/javascript' src="plugins/bootstrap-notify/bootstrap-notify.min.js"></script> 
										<script src="./assets-auto/js/jquery.mockjax.js"></script>
    					<script src="assets/js/waves.js"></script>
    					<script src="assets/js/jquery.nicescroll.js"></script>
    					<script src="assets/plugins/switchery/switchery.min.js"></script>
                <script src="plugins/sweetalert/js/sweetalert.min.js"></script> 
    					<script src="assets/plugins/moment/moment.js"></script>
    					<script src="assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    					<script src="assets/plugins/mjolnic-bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    					<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
                                        <script src="assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    					<script src="assets/plugins/clockpicker/bootstrap-clockpicker.js"></script>
    					<script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
                <script src="js/cancel_payment.js"</script>

    					<script src="assets/pages/jquery.form-pickers.init.js"></script>

    					<!-- App js -->
    					<script src="assets/js/jquery.core.js"></script>
    					<script src="assets/js/jquery.app.js"></script>
                                                                                     <?php
                                              $json=array();
                                                    $sql = mysql_query("SELECT * FROM tbl_clients where country='231'");
                while ($row = mysql_fetch_array($sql)) {
                                                        $json[] = array(
                                                        "id" => $row['id'],
                                                        "name" => $row['name']
                                                           );


                                                   $json_sender= json_encode($json);
                                                    }
						?>
        
                                                 <?php
                                              $json1=array();
						$sql = mysql_query("SELECT * FROM tbl_clients where country='61'");
                while ($row = mysql_fetch_array($sql)) {
                                                        $json1[] = array(
                                                        "id" => $row['id'],
                                                        "name" => $row['name']
                                                           );


                                                   $json_sender1= json_encode($json1);
                                                    }
						?>
        
          <script>
                $(document).ready(function() {
            $('#editdatepicker').datetimepicker({
                   todayBtn: 'linked',
                    todayHighlight: true,
                    format: 'yyyy-mm-dd hh:ii',        
                    autoclose: true
                   
            });
            });
            
            
              var id,name,address,email,phone,password,company,country,email,state,city_name,zipcode;
            $(function() {
               
                function displayResult(item) {
               
		    //var el = item.value;
		    var dataString = 'id=' + item.value;
                    $.ajax({
			    url: 'get_clientdata.php',
			    type: 'get',
			    data: dataString,
			    dataType: 'JSON',
			    success: function (response) {
				id = response['0'].id;
                                address = response['0'].address;
                                phone = response['0'].phone;
                                country = response['0'].country;
                                state = response['0'].state;
                                city_name = response['0'].city_name;
                                 zipcode = response['0'].zipcode;
                                 email = response['0'].email;
                                    
                                $('#Shippercc').val(id);
                                $('#Shipperaddress').val(address);
                                $('#Shipperphone').val(phone);
                                 $('#Receiveremail').val(email);
                                 $('#zip_code').val(zipcode);
                               
				$('.state option').map(function () {
				    if ($(this).text() == state)
					return this;
				}).attr('selected', 'selected');
				$('.state').trigger('change');
                                
                                
                                
			    }
			});
		   
                }
                $('#Shippername').typeahead({
                    source: <?php echo $json_sender; ?>,
                    onSelect: displayResult
                });

            });
            
//----------------------- Add Payment --------------------------
     
                $('#payment_date').datetimepicker({
                    todayBtn: 'linked',
                    todayHighlight: true,
                    format: 'mm/dd/yyyy hh:ii',
                    autoclose: true
                });
                            
            $(document).on("click", ".open-pay", function () {
                var hid_document_id = $(this).data('id');
                $("#cid").val(hid_document_id);                
                // it is superfluous to have to manually call the modal.
                // $('#addBookDialog').modal('show');
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
            
            
            
            
            
            
            
        </script>
        
          <script>
            var id1,name1,address1,email1,phone1,password1,company1,country1,state1,city_name1;
            $(function() {
               var id1,name1,address1,email1,phone1,password1,company1,country1;
                function displayResult1(item) {
               
		    //var el = item.value;
		    var dataString = 'id=' + item.value;
                    $.ajax({
			    url: 'get_clientdata.php',
			    type: 'get',
			    data: dataString,
			    dataType: 'JSON',
			    success: function (response) {
				id1 = response['0'].id;
                                address1 = response['0'].address;
                                phone1 = response['0'].phone;
                                country1 = response['0'].country;
                                state1 = response['0'].state;
                                city_name1 = response['0'].city_name;
                              email = response['0'].email;
                                    
                                $('#Receivercc_r').val(id1);
                                $('#Receiveraddress').val(address1);
                                $('#Receiverphone').val(phone1);
                                 $('#Receiveremail1').val(email);
                               
				$('.state1 option').map(function () {
				    if ($(this).text() == state1)
					return this;
				}).attr('selected', 'selected');
				$('.state1').trigger('change');
                                
                                
                                
			    }
			});
		   
                }
                $('#Receivername').typeahead({
                    source: <?php echo $json_sender1; ?>,
                    onSelect: displayResult1
                });

            });
        </script>

    					<script language="javascript" type="text/javascript">
    										    function calcula() {
    											with (document.formulario) {
    											    var tempResult = Math.round(Qnty.value * Weight.value * variable.value * Totalfreight.value * 100);  // calculo general sin perder precision		
    											    var integerDigits = Math.floor(tempResult / 100);  // extraer la parte no decimal
    											    var decimalDigits = "" + (tempResult - integerDigits * 100); // extraer la parte decimal			
    											    while (decimalDigits.length < 2) {  // formatear la parte decimal a dos digitos 
    												decimalDigits = "0" + decimalDigits;
    											    }
    											    shipping_subtotal.value = integerDigits + "," + decimalDigits + " "; // componer la cadena resultado
    											}
    										    }
    					</script>

    					</body>

<?php } ?>


					<SCRIPT language="javascript">
					    function calTotal() {

						var $row = $(this).closest('tr'),
							price = $row.find('.product_price').val(),
							quantity = $row.find('.ship_qty').val(),
							discount = $row.find('.discount').val(),
                                                        paid = $('#paid').val();

						total = price * quantity;

						if (discount > 0) {
						    total = total - (total * (discount / 100));
						}
						// change the value in total

						$row.find('.sub_total').val(total);
						var sumvak = 0;
                                                var balance;
						$(".sub_total").each(function () {
						    sumvak += parseFloat($(this).val());
                                                     var sunpaid = parseInt(paid);
                                                    balance = (sumvak-sunpaid);
						});
						$('#grand_total').val(sumvak);
                                                $('#balance').val(balance);

						// calc_total();

					    }
					    function deleteRow(row)
					    {
						var i = row.parentNode.parentNode.rowIndex;
						document.getElementById('table-product').deleteRow(i);
						calTotal();
					    }
					    var row = '<?php echo $product_row; ?>';
                                                                                        
					    function addRow(tableID) {
						var html = '';
						html += '<tr id="row' + row + '">';
                                                
                                     html += '<td><input required="required"  type="text" id="product_type1' + row + '" list="product_auto" class="form-control product_type1" name="product[' + row + '][product_type1]" value="<?php echo $item['product_name']; ?>"/></td>';           
                                          
						html += '<td><input required="required"  type="text" id="product_price' + row + '" class="form-control product_price" name="product[' + row + '][product_price]"/></td>';
						html += '<td><input  type="text" class="form-control ship_qty" id="ship_qty' + row + '"  name="product[' + row + '][ship_qty]" placeholder="0" onChange=""/></td>';
						html += '<td><input  type="text" class="form-control discount" id="discount' + row + '"  name="product[' + row + '][discount]" placeholder="%" style="width:60px;" onChange=""/></td>';
						html += '<td><input  type="text" readonly="true" style="width:40px;"  class="form-control sub_total"  id="sub_total' + row + '"  name="product[' + row + '][sub_total]" placeholder="0,00" onChange="" /></td>';
						html += '<td><button type="button" class="btn btn-danger delete_btn" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>  </td>';
             
             
 html += '<td><select name="product[' + row + '][ship_status]" value="<?php echo $row['id']; ?><?php echo $row['status']; ?>" id="ship_status' + row + '" required class="status form-control ship_status" value="" >';
             
   <?php
            $stmt = mysql_query("SELECT `off_name`,`id` FROM `offices` where `estado`=1 ");
                     while ($row = mysql_fetch_array($stmt)) {
               ?>
            html += '<option value="<?php echo $row['id']; ?>" <?php   if ($row['id'] == $item['line_shipping_status']) {  echo "selected";  }?> ><?php echo $row['off_name']; ?></option>';    
        <?php } ?>    
            html +='</select></td>';              

           
						html += '</tr>';

						$('#table-product tbody').append(html);
						row++;
						//inp1.id += len;
					    } 

				  



					</SCRIPT>
					<script type="text/javascript">

					    $(document).ready(function ()
					    {

                            $("input[name='Shipperphone']").keyup(function() {
                    $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d)+$/, "$1-$2-$3"));
                });

               $("input[name='Receiverphone']").keyup(function() {
                    $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d)+$/, "$1-$2-$3"));
                });

						$('#table-product').on('change', '.product_type', selectprice);

						function selectprice() {

						    var $row = $(this).closest('tr'),
							    sel_productid = $row.find('.product_type').val();
                $row.find('.ship_qty').val('1');
						    $row.find('.discount').val('');
						    $row.find('.sub_total').val('');
						    //-------   
						    var dataString = 'id=' + sel_productid;
						    $.ajax({
							url: 'get_product_price.php',
							type: 'get',
							data: dataString,
							dataType: 'JSON',
							success: function (response) {
							    var product_price = response['0'].product_price;

							    $row.find('.product_price').val(product_price);
                        $('.ship_qty').trigger('change');
							}
						    });
						}

						//perticular product calculation for price
						$('#table-product').on('change', '.product_price', calTotal)
							.on('change', '.ship_qty', calTotal).on('change', '.discount', calTotal);


				    //                                function calc_total(){
				    //                                  var sumvak = 0;
				    //                                  $(".sub_total").each(function(){
				    //                                    sumvak += parseFloat($(this).text());
				    //                                    
				    //                                  });
				    //                                  alert(sumvak);
				    //                              }
						//$('#sum').text(sum);

						var state_id = <?php echo $state_id; ?>;
						var city_id = <?php echo $city_id; ?>;
						if (state_id != '')
						{

						    $.ajax
							    ({
								type: "POST",
								url: "get_city.php",
								data: {'id': state_id, 'city_id': city_id},
								cache: false,
								success: function (html)
								{

								    $(".city").html(html);
								    $('.city option').map(function () {
									if ($(this).text() == city_name)
									    return this;
								    }).attr('selected', 'selected');
								}
							    });
						}
						var state_id1 = <?php echo $state_id1; ?>;
						var city_id1 = <?php echo $city_id1; ?>;
						if (state_id1 != '')
						    $.ajax
							    ({
								type: "POST",
								url: "get_city.php",
								data: {'id': state_id1, 'city_id': city_id1},
								cache: false,
								success: function (html)
								{

								    $(".city1").html(html);



								}
							    });
						//--------------------------US city
						$(".state").change(function ()
						{

						    var id = $(this).val();
						    var dataString = 'id=' + id;

						    $.ajax
							    ({
								type: "POST",
								url: "get_city.php",
								data: dataString,
								cache: false,
								success: function (html)
								{

								    $(".city").html(html);
								    $('.city option').map(function () {
									if ($(this).text() == city_name)
									    return this;
								    }).attr('selected', 'selected');
								}
							    });
						});

						//------domician republic state-city
						$(".state1").change(function ()
						{

						    var id = $(this).val();
						    var dataString = 'id=' + id;

						    $.ajax
							    ({
								type: "POST",
								url: "get_city.php",
								data: dataString,
								cache: false,
								success: function (html)
								{

								    $(".city1").html(html);



								}
							    });
						});


						//------------------zip code
						var city_name;
						$("#zip_code").keyup(function () {
						    var el = $(this);
						    //var dataString=el;

						    var dataString = 'id=' + el.val();
						    if (el.val().length === 5) {
							$.ajax({
							    url: 'check_zipcode.php',
							    type: 'get',
							    data: dataString,
							    dataType: 'JSON',
							    success: function (response) {
								var state_name = response['0'].state_name;
								city_name = response['0'].city_name;
								$('.state option').map(function () {
								    if ($(this).text() == state_name)
									return this;
								}).attr('selected', 'selected');
								$('.state').trigger('change');

							    }
							});
						    }
						});


					    });
					</script>
<script type="text/javascript">
	
$(document).ready(function(){
	
	$(".payment_date").mouseenter(function(){

		var newdate = $(".payment_date").val();

		$.ajax({
            
            type: "POST",
            url:  "date_select.php",
            data: "payment_date="+newdate,
            success: function(data){
            	if(data != ''){
            		$("#payment_due").val(data);
            	
            	} else {
            		$("#payment_due").val('');
            	}

            	
            }
		});
		return false;
	});
});


</script>


					<style>
					    #table-product thead tr th,#table-product tbody tr td {
						text-align: center;
					    }
					    #table-product thead tr th
					    {
							width: 50%;
							background: #2f4b78;
							color: WHITE;
					    }
						
        .sub_total,.grand_total {
            width: 150px;
				
					}
        
            .custom-right {
                    margin-right: 75px;
            }
            .text-success-custom {
    color: #2f4b78 !important;
    float: left;
    margin-top: 2px;
    margin-right: 11px;
    font-size: 19px;
}
        .col-sm-custom {
    float: right;
    margin-right: 242px;
}
.add_more {
    float: right;
    margin-right: 232px;
}
 .text-right {
    text-align: right;
    margin-right: 13px;
}
bordered td {
    border: 1px solid #ddd;
}
 .b, strong {
    font-weight: bold;
}

select.product_type {
    width: 228px;
}
select#status {
    width: 10em;
}
input.ship_qty {
    width: 68px;
}
input#discount {
    width: 68px;
}
.sub_total {
    width: 90px;
}
.grand_total {
    width: 94px;
}
.product_status {
    width: 145px;
}
select.ship_status {
    width: 145px;
}
					</style>
					</html>
                                        
                                        
                                        
                                        