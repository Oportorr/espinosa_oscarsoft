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

$sql = "SELECT DISTINCT(`off_name`),`id` FROM `offices` where `estado`=1 AND `line_shipping_status_id`=1";
$result = dbQuery($sql);

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
        <title>CARGO v10.1 | ADD SHIPPING </title>

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
        <link href="assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
       
     
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

                            <h3 class="classic-title"><span><strong><i class="fa fa-truck icon text-default-lter"></i>&nbsp;&nbsp;Add Shipping</strong></h3>

                            <!-- START Checkout form -->

                            <form action="process.php?action=add-cons" name="formulario" method="post">

				<div class="row">

				    <!-- START Presonal information -->
				    <fieldset class="col-md-6">
					<legend>Data Sender :</legend>
					<!-- Name -->
					<div class="row" >
					    <div class="col-sm-2 form-group hidden-xs-up">
						<label  class="control-label"><i class="fa fa-user icon text-default-lter"></i>&nbsp;Staff Role<span class="required-field">*</span></label>
						<input type="text"  name="officename" id="officename" value="<?php echo $_SESSION['user_name']; ?>" class="form-control"  readonly="true" >
					    </div>
					    <div class="col-sm-2 form-group hidden-xs-up">
						<label  class="control-label"><i class="fa fa-user icon text-default-lter"></i>&nbsp;Staff User<span class="required-field">*</span></label>
						<input type="text"  name="user" id="user" value="<?php echo $_SESSION['user_type']; ?>" class="form-control"  readonly="true" >
					    </div>
					    <div class="col-sm-12 form-group">

						<label class="control-label" >SENDER NAME<span class="required-field">*</span></label>
						<input type="text" name="Shippername" id="Shippername" class="form-control" autocomplete="OFF" required placeholder="Enter your name" >
                                           
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
                                                <input type="text" readonly="true" name="Shippercc" id="Shippercc"class="form-control"  maxlength="20" placeholder="Sender ID" autocomplete=" off" required>
					    </div>
					</div>

					<!-- Adress and Phone -->
                                        <div class="row">
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
    						    <option value="<?php echo $row['state_id']; ?>"><?php echo $row['state_name']; ?></option>
						    <?php } ?>
						    <span class="field-validation-valid text-danger" ></span>
						</select>
					    </div>
				
					    <div class="col-sm-4 form-group">
						<label for="zipcode" class="control-label"><i class="text-default-lter"></i>&nbsp;Zipcode</label>
						<input type="text" id="zip_code" class="zip_code form-control" name="zip_code"  placeholder="Enter Zipcode" value=""  />
						</select>
					    </div>

                                        </div>
					<!-- START Shipment information -->

					<legend>Shipping information :</legend>

					<!-- Country and state -->
					<div class="row">
					    <div class="col-sm-3 form-group">
						<label class="control-label"><i class="fa fa-database icon text-default-lter"></i>&nbsp;<strong>Payment Mode</strong></label>
						<select name="Bookingmode" class="form-control"  id="Bookingmode">
						    <option value="Paid">Paid</option>
						    <option selected="selected" value="Pending">Pending</option>
						    <option value="Cash-on-Delivery">Cash on Delivery</option>
							<option value="Partial">Partial</option>

						</select>
					    </div>

					    <div class="col-sm-4 form-group">
						<label for="zipcode" class="control-label"><i class="fa fa-angle-double-right icon text-default-lter"></i>&nbsp;OFFICE OF ORIGIN</label>
						<select name="Invoiceno" id="Invoiceno" class="form-control" >
						    <?php
						    while ($data = dbFetchAssoc($result)) {
							?>
    						    <option value="<?php echo $data['id']; ?>"><?php echo $data['off_name']; ?></option>
							<?php
						    }//while
						    ?>
						</select>
					    </div>

					    <div class="col-sm-2 form-group">
						<label for="Country" class="control-label"><i class="text-default-lter"></i>&nbsp;Country</label>
						<span id="inter_origin" style="display: block;">
						    <select name="country" required class="country form-control">
							<?php
							$stmt = mysql_query("SELECT * FROM country where country_id='231'");
							while ($row = mysql_fetch_array($stmt)) {
							    ?>
    							<option value="<?php echo $row['country_id']; ?>"><?php echo $row['country_name']; ?></option>
							<?php } ?>
						    </select>

					    </div>
					    <div class="col-sm-3 form-group">
						<label class="control-label"><i class="fa fa-plane icon text-default-lter"></i>&nbsp;Service(Mode)</label>
						<select name="Mode" class="form-control"  id="Mode">
						    <option value="0">Select</option>
						    <?php
						    $sql = mysql_query("SELECT name FROM mode_bookings  GROUP BY name");
						    while ($row = mysql_fetch_array($sql)) {
							if ($cliente == $row['name']) {
							    echo '<option value="' . $row['name'] . '" selected>' . $row['name'] . '</option>';
							} else { ?>
							    <option value="<?php echo $row['name']; ?>" <?php if($row['name'] == 'SHIP'){ echo 'selected'; } ?>><?php echo $row['name']?></option>
						<?php    }
						    }
						    ?>
						</select>
					    </div>

					    <div class="col-sm-4 form-group hidden-xs-up">
						<label class="control-label">Product/Type</label>
						<input  name="Shiptype" class="form-control" id="Shiptype"  placeholder="Enter the type of products" >

					    </div>

					</div>
					<!-- Qnty -->
					<div class="row">

					    <!-- Origin Office -->

					    <div class="col-sm-4 form-group hidden-xs-up">
						<label for="ccv" class="control-label"><?php echo $company['currency']; ?>&nbsp;Insurance of the Shipment</i></label>
						<input name="Totaldeclarate" class="form-control" id="Totaldeclarate" maxlength="20" placeholder="0,00"/>
					    </div>

					    <!-- Payment Mode -->
					    <div class="row">



						<div class="col-sm-2 form-group hidden-xs-up" >
						    <label class="text-success"><i class="fa fa-cubes icon text-default-lter"></i>&nbsp;QUANTITY</label>
						    <input type="text" class="form-control" name="Qnty"  value="0"  />
						</div>
						<div class="col-sm-2 form-group hidden-xs-up">
						    <label class="text-success">Weight&nbsp;&nbsp;(Kg)</label>
						    <input  type="text" class="form-control" name="Weight" value="0"  />
						</div>
						<div class="col-sm-2 form-group hidden-xs-up">
						    <label class="text-success"><?php echo $company['currency']; ?>&nbsp;Variable&nbsp;(Kg)</label>
						    <input  type="text" class="form-control" name="variable" value="2.20"/>
						</div>
						<div class="col-sm-3 form-group hidden-xs-up">
						    <label for="ccv" class="text-success"><i class="fa fa-money icon text-default-lter"></i>&nbsp;<strong>FREIGHT PRICE</strong></i></label>
						    <input  type="text" class="form-control" name="Totalfreight" placeholder="0,00" onChange="calcula();" />
						</div>
						<div class="col-sm-3 form-group hidden-xs-up">
						    <label class="text-success">Subtotal shipping</i></label>
						    <input  type="text" class="form-control" name="shipping_subtotal" value="0,00" />
						</div>
					    </div>



					    <div class="table-responsive">
						<table id="table-product" class="table table-striped table-bordered" cellspacing="0">
						    <!--encabezado tabla-->
						    <thead>
							<tr>
							    <th>PRODUCT TYPE</th>
							    <th>SHIP QTY</th>
							    <th>DISCOUNT</th>													<th>SUBTOTAL</th>
							    <th>Actions</th>
							</tr>


						    </thead>

						    <tr>
							<td>

							    <select name="product[0][product_type]" id="product_type" required class="product_type form-control">
								<option value=""></option>
								<?php
								$stmt = mysql_query("SELECT * FROM type_shipments");
								while ($row = mysql_fetch_array($stmt)) {
								    ?>
    								<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
								<?php } ?>
							    </select>
							    <input  type="hidden" id="product_price0" class="product_price" name="product[0][product_price]" value=""/>
							</td>

							<td><input  type="text" class="form-control ship_qty" id="ship_qty0"  name="product[0][ship_qty]" placeholder="0" onChange=""/></td>
							<td><input  type="text" class="form-control discount" id="discount10"  name="product[0][discount]" placeholder="%" onChange=""/></td>
                                                        <td><input  type="text" readonly="true" class="form-control sub_total" value="0"  id="sub_total10"  name="product[0][sub_total]" placeholder="0,00" onChange="" /></td>

						

						    </tr>

						</table>

						<div class="col-sm-6 form-group"></div>
						<div class="col-sm-custom form-group">
						    <div class="text-center">
<label class="text-success-custom">Total </label><input  type="text" readonly="true" class="form-control grand_total"  id="grand_total"  name="grand_total" placeholder="0,00" onChange="" /> </div>
						</div>
						<div class="clearfix"></div> 
                                                <div class="text-right custom-right">
						    <INPUT type="button" value="Add More"  class="btn btn-success" onclick="addRow('table-product')" />
						</div>
                                                <div class="col-sm-2 form-group"></div>

					    </div>


					    <br>
					    <br>
					    <div class="clearfix"></div>
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
                                            <input type="text" class="form-control" id="Receivername" autocomplete="off" name="Receivername" list="Receivername_data"  placeholder="Enter name recipient">
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
                                                <input type="text" readonly="true" name="Receivercc_r" id="Receivercc_r"class="form-control"  maxlength="20" placeholder="Recipient id" autocomplete="off" required>
					    </div>


					    <!-- Destination country -->
					    <div class="col-sm-4 form-group">
						<label for="City" class="control-label"><i class="text-default-lter"></i>&nbsp;City</label>

						<select name="city1" required id ="city1" class="city1 form-control">
						    <option selected="selected">Select city</option>
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
    						    <option value="<?php echo $row['state_id']; ?>"><?php echo $row['state_name']; ?></option>
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
    							<option value="<?php echo $row['country_id']; ?>"><?php echo $row['country_name']; ?></option>
							<?php } ?>
						    </select>

					    </div>

					    <div class="col-sm-12 form-group">
						<label class="control-label">EMAIL <font color="#FF6100">Note: (The email must be real to be notified shipping)</font></i></label>
						<input type="text" name="Receiveremail" id="Receiveremail" class="form-control"   placeholder="demo@emo.com" autocomplete=" off" required>
					    </div>
					</div>


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

					    echo "" . $letraAleatoria . "" . $letraAleatoria1 . "" . $letraAleatoria2 . "" . $numeroAleatorio . "";
					    ?>" id="ConsignmentNo"  />
					</div>


					<!-- Status and Pickup Date -->
					<div class="form-group">
					    <label for="dtp_input1" class="control-label"><i class="fa fa-calendar icon text-default-lter"></i>&nbsp;COLLECTION DATE AND TIME</i></label>
					    <div>
						<div class="input-group">
						    <input type="text" class="form-control" name="Packupdate" placeholder="mm/dd/yyyy" id="editdatepicker">
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
                                            <?php 
                                               $res =  mysql_query("select * from courier_container Where container_status='1' ORDER bY container_number DESC LIMIT 1");
                                               $data=mysql_fetch_array($res);
                                               $cn = $data['container_number'];
                                               $ci = $data['container_id'];
                                               ?>
                                            <div class="col-sm-3 form-group">
					    <label for="input" class="control-label">&nbsp;Container :</label>
                                            <input type="text" name="container_number" class="form-control" value="<?php echo $cn; ?> " readonly='true'>
					</div>

                                                <input type="hidden" name="conid" class="form-control" value="<?php echo $ci ;?>">

					<div class="col-sm-5 form-group">
					    <label for="dtp_input1" class="control-label"><i class="fa fa-calendar icon text-default-lter"></i>&nbsp;Schedule Delivery</i></label>
					    <div>
						<div class="input-group">
						    <input type="text" class="form-control" name="Schedule" placeholder="mm/dd/yyyy" id="datepicker">
						    <span class="input-group-addon bg-custom b-0"><i class="icon-calender"></i></span>
						</div><!-- input-group -->
					    </div>
					</div>
                                            
                                        </div>
				    </fieldset>

				    <div class="clearfix"></div>
				    <div class="col-md-6 text-left">
					<br>
					<br>
					<input class="btn btn-success" name="Submit" type="submit"  id="submit" value="SAVE TRACKING">
				    </div>
				</div>

				<div class="clearfix"></div>


                            </form>
                            </tbody>
                        </div>
                    </div>
                </div>

		<input  type="hidden" id="set_val" name="set_val" value=""/>
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
             <script src="js/jquery-1.11.1.min.js"></script>
         <script src="./assets-auto/js/bootstrap-typeahead.js"></script>
        
        <script src="./assets-auto/js/jquery.mockjax.js"></script>
        
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/plugins/switchery/switchery.min.js"></script>

        <script src="assets/plugins/moment/moment.js"></script>
        <script src="assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <script src="assets/plugins/mjolnic-bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="assets/plugins/clockpicker/bootstrap-clockpicker.js"></script>
        <script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

        <script src="assets/pages/jquery.form-pickers.init.js"></script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        
      
       
     
                                              <?php
                                              $json=array();
                                                    $sql = mysql_query("SELECT * FROM tbl_clients where country='231'");
						 while($row=mysql_fetch_array($sql))
                                                    {
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
						 while($row=mysql_fetch_array($sql))
                                                    {
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
                    format: 'mm/dd/yyyy hh:ii',        
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
                                $('#zip_code').val(zipcode);
                               
								$('.state option').map(function () {
									if ($(this).val() == state)
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
                                $('#Receiveremail').val(email);
                               
				$('.state1 option').map(function () {
				    if ($(this).val() == state1)
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
	    function calTotal() {

		    var $row = $(this).closest('tr'),
			    price = $row.find('.product_price').val(),
			    quantity = $row.find('.ship_qty').val(),
			    discount = $row.find('.discount').val();

		    total = price * quantity;

		    if (discount > 0) {
			total = total - (total * (discount / 100));
		    }
		    // change the value in total                                    
		    $row.find('.sub_total').val(total);
		    var sumvak = 0;
		    $(".sub_total").each(function () {
			sumvak += parseFloat($(this).val());
		    });
		    $('#grand_total').val(sumvak);
		}
		
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

        <SCRIPT language="javascript">
	    function deleteRow(row)
	    {
		
		var i = row.parentNode.parentNode.rowIndex;
		document.getElementById('table-product').deleteRow(i);
		calTotal(); 
	    }
	    var row = 1;
	    function addRow(tableID) {
		var html = '';
		html += '<tr id="row' + row + '">';
		html += '<td class="text-left"><select name="product[' + row + '][product_type]" id="product_type' + row + '" required class="product_type form-control">';
		html += '<option value=""></option>';
<?php
$stmt = mysql_query("SELECT * FROM type_shipments");
while ($product_row = mysql_fetch_array($stmt)) {
    ?>
    		html += '<option value="<?php echo $product_row['id']; ?>"><?php echo $product_row['name']; ?></option>';
<?php } ?>
		html += '</select></td>';
		html += '<input  type="hidden" id="product_price' + row + '" class="product_price" name="product[' + row + '][product_price]	" value=""/>';
		html += '<td><input  type="text" class="form-control ship_qty" id="ship_qty' + row + '"  name="product[' + row + '][ship_qty]" placeholder="0" onChange=""/></td>';
		html += '<td><input  type="text" class="form-control discount" id="discount' + row + '"  name="product[' + row + '][discount]" placeholder="%" onChange=""/></td>';
		html += '<td><input  type="text" readonly="true" class="form-control sub_total" id="sub_total' + row + '"  name="product[' + row + '][sub_total]" placeholder="0,00" onChange="" /></td>';
		html += '<td><button type="button" class="btn btn-danger delete_btn" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>  </td>';
		html += '</tr>';

		$('#table-product tbody').append(html);

		row++;

	    }




        </SCRIPT>
        <script type="text/javascript">

	    $(document).ready(function ()
	    {

		//select price bases of product     

		$('#table-product').on('change', '.product_type', selectprice);

		function selectprice() {

		    var $row = $(this).closest('tr'),
			    sel_productid = $row.find('.product_type').val();
		    $row.find('.ship_qty').val('');
		    $row.find('.discount').val('');
		    $row.find('.sub_total').val('0');
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

			}
		    });
		}

		//perticular product calculation for price
		$('#table-product').on('change', '.product_price', calTotal)
			.on('change', '.ship_qty', calTotal).on('change', '.discount', calTotal);

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
				    $('.city option').map(function () {console.log($(this).val()+" == "+city_name);
						if ($(this).val() == city_name)
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
                    $('.city1 option').map(function () {
					if ($(this).val() == city_name1)
					    return this;
				    }).attr('selected', 'selected');



				}
			    });
		});


		//------------------zip code
		
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
                 $(document).ready( function() {
                    var now = new Date();
                    var hours = now.getHours();
                    var minutes = now.getMinutes();
                    var Seconds = now.getSeconds();
                    var ampm = hours >= 12 ? 'pm' : 'am';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0'+minutes : minutes;
                    var day = ("0" + now.getDate()).slice(-2);
                    var month = ("0" + (now.getMonth() + 1)).slice(-2);
                    var hour = ("0" + (now.getHours())).slice(-2);
                    var today = (month)+"/"+(day)+"/"+now.getFullYear()+' '+ hours+':'+minutes;
                    $("input[name*='Packupdate']").val(today);
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

           /* .product_type {
                width: 290px;
            }*/
            .discount,.sub_total,.grand_total {
                width: 120px;
		
            }
            .col-sm-custom  {
                        float: right;
    margin-right: 77px;
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
        </style>

    </body>
</html>