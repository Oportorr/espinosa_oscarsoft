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

$cons= $_POST['Consignment'];

$sql = "SELECT *
		FROM courier
		WHERE cons_no = '$cons'";
$sql_1 = "SELECT DISTINCT(off_name)
		FROM offices";	
$result = dbQuery($sql);		
$result_1 = dbQuery($sql_1);
while($data = dbFetchAssoc($result)) {
extract($data);
isUser();
?>

<!doctype html>

<html lang="en">

<head>
    <!-- Basic -->
    <title>CARGO v10.1 | Search Courier</title>

	<!-- Define Charset -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<!-- Page Description and Author -->
        <meta name="description" content="Cargo V10.1"/>
        <meta name="keywords" content="Cargo Web System" />
        <meta name="author" content="CNSWARE INC">
    
    <!-- Favicon --> 
	<link rel="shortcut icon" href="images/favicon.ico">

    
    <!-- Google fonts - witch you want to use - (rest you can just remove) -->
   	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
 
    
    <!-- ######### CSS STYLES ######### -->
	
    <link rel="stylesheet" href="css/reset.css" type="text/css" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<link rel="stylesheet" href="css/footer-basic-centered.css">
	
	<!-- Required - Form style -->
	<link rel="stylesheet" href="css/flat-form.css" /> 
    
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    
    <!-- responsive devices styles -->
	<link rel="stylesheet" media="screen" href="css/responsive-leyouts.css" type="text/css" />

	
	<link rel="stylesheet" href="css/colors/orange.css" />
    
	<!-- tabs -->
    <link rel="stylesheet" type="text/css" href="js/tabs/assets/css/responsive-tabs.css">
    <link rel="stylesheet" type="text/css" href="js/tabs/assets/css/responsive-tabs2.css">
    <link rel="stylesheet" type="text/css" href="js/tabs/assets/css/responsive-tabs3.css">	
	
	<script src="js/jquery.js"></script>
		<script src="js/myjava.js"></script>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="bootstrap/js/bootstrap.js"></script>
	
</head>
<body>
<?php
include("header.php");
?>
	</td>
  </tr>
<div class="container">
    <tr>
    <tbody>
				<article class="col-sm-8 col-md-9">	
					
					<!-- Product list -->
					
					<h5><strong>Update Submission</strong></h5>
					
					<ul class="list-unstyled product-list">
						<li class="row strong">
							<div class="col-md-4 col-sm-5"># Tracking</div>
							<div class="col-md-2 col-sm-5">Print Invoice</div>
							<div class="col-md-2 col-sm-2">STATUS</div>
							<div class="col-md-2 col-sm-3">Weight</div>
							<div class="col-md-2 col-sm-3">Total freight</div>
						</li>
						<li class="row">
							<div class="col-md-4 col-sm-5"><font color="#FF6100"><strong><u><?php echo $cons_no; ?></u></strong></font></div>
							<div class="col-md-2 col-sm-5"><a target="_blank" href="print-invoice/invoice-print.php?cid=<?php echo $cid; ?>">
							<img src="images/print.png" border="0" height="15" width="15"></a></div>
							<div class="col-md-2 col-sm-2"><?php echo $status; ?></div>
							<div class="col-md-2 col-sm-3"><?php echo $weight; ?>&nbsp;kg</div>
							<div class="col-md-2 col-sm-3">$&nbsp;<?php echo $freight; ?></div>
						</li>									
					</ul>					
					<hr />
					<br>
					<!-- User data -->
					<div class="row user-data">
						<div class="col-md-4">
							<h4>Sender Details</h4>							
							<ul>
								<li><strong>Name:</strong> <?php echo $ship_name; ?></li>
								<li><strong>Phone:</strong> <?php echo $phone; ?></li>
								<li><strong>Address:</strong> <?php echo $s_add; ?></li>
								<li><strong>Charter:</strong> <?php echo $cc; ?></li>
							</ul>
						</div>
						
						<div class="col-md-3">
							<h4>Receiver Details</h4>					
							<ul>
								<li><strong>Name:</strong> <?php echo $rev_name; ?></li>
								<li><strong>Phone:</strong> <?php echo $r_phone; ?></li>
								<li><strong>Address:</strong> <?php echo $r_add; ?></li>
								<li><strong>Charter:</strong> <?php echo $cc_r; ?></li>
							</ul>
						</div>
						
						<div class="col-md-5">
							<h4>Invoice data</h4>							
							<ul>
								<li><strong>Type Post:</strong> <?php echo $type; ?></li>
								<li><strong>Origin:</strong> <?php echo $invice_no; ?></li>
								<li><strong>Destination:</strong> <?php echo $pick_time; ?></li>
								<li><strong>Payment Mode:</strong> <?php echo $book_mode; ?></li>
								<li><strong>Declared Value:</strong>&nbsp;$&nbsp;<?php echo $declarate; ?></li>
								<li><strong>Shipping mode:</strong> <?php echo $mode; ?></li>								
								<li><strong>Pick Up Date / Time:</strong> <?php echo $pick_date; ?></li>
								<li><strong>SCHEDULE DELIVERY:</strong> <?php echo $schedule; ?></li>
								<li><strong>Description:</strong> <?php echo $comments; ?></li>
							</ul>
						</div>
					</div>
					
					<div class="one_full">
									<div class="table-style">										
												
												<h5><strong>Shipping History</strong></h5> 							
					
												<?php
														require_once('database.php');
														
								
														//EJECUTAMOS LA CONSULTA DE BUSQUEDA

														$result = mysql_query("SELECT * FROM courier_track WHERE cid = $cid	AND cons_no = '$cons_no' ORDER BY bk_time");

														//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

														echo ' <table class="table-listorange" id="agrega-registros">
																	<tr>
																				<th class="newtext"><strong><font color="white"># Tracking</font></strong></th>
																				<th class="newtext"><strong><font color="white">Location</font></strong></th>
																				<th class="newtext"><strong><font color="white">STATUS</font></strong></th>
																				<th class="newtext"><strong><font color="white">Date and Time</font></strong></th>
																				<th class="newtext"><strong><font color="white">Observations</font></strong></th>
																				
																	</tr>';
														if(mysql_num_rows($result)>0){
															while($row = mysql_fetch_array($result)){
																echo '<tr>
																		<td>'.$row['cons_no'].'</td>
																		<td>'.$row['current_city'].'</td>
																		<td>'.$row['status'].'</td>
																		<td>'.$row['bk_time'].'</td>				
																		<td>'.$row['comments'].'</td>
																		
																		</tr>';
															}
														}else{
															echo '<tr>
																		<td colspan="5">No results found</td>
																	</tr>';
														}
														echo '</table>';
														?>
							</div>
							
											
					<!-- END Checkout form -->
					
				</article>
				
				
				
					<h4 class="classic-title"><strong>UPDATE STATUS</strong></h4>
				
					<!-- START Review form -->
					
					<form action="process.php?action=update-status" method="post" name="frmShipment" id="frmShipment">
						<div class="row">
							<!-- Origin Office -->
								<div class="col-md-3 form-groupform-group">
									<label for="zipcode" class="control-label">NEW LOCATION:</label>
									<select name="OfficeName"  class="form-control" >
										<?php 
											while($data = dbFetchAssoc($result_1)){
											?>
											<option value="<?php echo $data['off_name']; ?>"><?php echo $data['off_name']; ?></option>
											<?php 
											}//while
											?>
									</select>
								</div>	
							
							<!-- Origin Office -->
								<div class="col-md-3 form-groupform-group">
									<label for="zipcode" class="control-label">NEW STATE:</label>
									<select name="status" class="form-control" >
										<option value="Finished">Finished</option>
										<option value="In-Transit">In Transit</option>
										<option value="On-Hold">On Hold</option>
										<option value="Landed">Landed</option>
										<option value="Delayed">Delayed</option>
									</select>
								</div>	
							<!-- Comments -->
							<div class="col-md-3 form-groupform-group">
								<label for="message" class="control-label">COMMENTS:</label>
								<textarea class="form-control" name="comments" id="comments" cols="20" rows="3"></textarea>
							</div>							
							
						
						<!-- Send button -->
						<div class="col-md-3 form-group">
							<p><font color="#FF6100"><strong>Update if necessary</strong></font></p>
							<br><br>
							<input name="submit" type="submit" class="btn btn-success" value="UPDATE STATUS"  >
							  <input name="cid" id="cid" value="<?php echo $cid; ?>" type="hidden">
							  <input name="cons_no" id="cons_no" value="<?php echo $cons_no; ?>" type="hidden"> 							
						</div>						
					</form>
					<!-- END Review form -->					
				</article>				
				<div class="clearfix"></div>
			</div>
		</div>
 </div>
</div>
</tbody>
</table>

<!-- Start Footer Section -->
        
<?php
include("footer.php");
?>
<!-- Required - jQuery -->
		<script src="js/jquery-2.1.1.min.js"></script>
		
		<!-- Required - Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		
		<!-- Required - Custom select -->
		<script src="js/fancySelect.js"></script>
		
		<script>
			$(document).ready(function() {
				$('.custom-select').fancySelect(); // Custom select
				$('[data-toggle="tooltip"]').tooltip() // Tooltip
			});
		</script>
	</body>
</html>
<?php
 } 
?>