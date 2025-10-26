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
require_once('pagination/pagination-courier-list.php');
isUser();	
?>
<!doctype html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="en" class="no-js"> <![endif]-->
<html lang="en">
<head>

	<title>DEPRIXA Update Shipment </title>
	
	<!-- Define Charset -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<!-- Page Description and Author -->
        <meta name="description" content="Cargo V10.1"/>
        <meta name="keywords" content="Cargo Web System" />
        <meta name="author" content="CNSWARE INC">
    
    <!-- Favicon --> 
	<link rel="shortcut icon" href="images/favicon.ico">
    
    <!-- this styles only adds some repairs on idevices  -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google fonts - witch you want to use - (rest you can just remove) -->
   	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
    
    <!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
    
    <!-- ######### CSS STYLES ######### -->
	
    <link rel="stylesheet" href="css/reset.css" type="text/css" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<link rel="stylesheet" href="css/colors/orange.css" />
	<link rel="stylesheet" href="css/footer-basic-centered.css">
    
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    
    <!-- responsive devices styles -->
	<link rel="stylesheet" media="screen" href="css/responsive-leyouts.css" type="text/css" />
    
	<!-- tabs -->
    <link rel="stylesheet" type="text/css" href="js/tabs/assets/css/responsive-tabs.css">
    <link rel="stylesheet" type="text/css" href="js/tabs/assets/css/responsive-tabs2.css">
    <link rel="stylesheet" type="text/css" href="js/tabs/assets/css/responsive-tabs3.css">
	
	<!-- Required - Form style -->
		<link rel="stylesheet" href="css/flat-form.css" /> 
		
		<!-- NOT required - Page style -->
		<link rel="stylesheet" href="css/page-style.css" />
		
  
</head>
<body>

<?php include("header.php"); ?>
	</td>
  </tr>  
 <tr>
<td bgcolor="#FFFFFF">	
<div class="container">
<table border="0" align="center" width="100%">
    <tr>
      <td class="TrackTitle" valign="top"><div  align="center"><h3 class="classic-title"><span><strong>Update Shipment </strong></h3></div></td>
    </tr>
  </tbody></table> 
  <div class="one_full">
			<div class="table-style">
                <table class="table-list">
                    <tr>
                        <th class="newtext">Update Status</th>
						<th class="newtext">Deliver Package</th>
						<th class="newtext">Generate Barcode</th>
                        <th class="newtext"># Tracking</th>
                        <th class="newtext">Shipper</th>
                        <th class="newtext">Receiver</th>
						<th class="newtext">Shipping Date/Time</th>
                        <th class="newtext">Status Shipping</th>
                    </tr>
					<?php
						$records = getPageData();
						if(count($records) > 0){
						$i = 0;
						foreach($records as $record){
						extract($record);	// extract array
						$i++; 				// increment i
						$even = $i%2; 		// getting MOD
						?>
					  <tr onMouseOver="this.bgColor='gold';" onMouseOut="this.bgColor='#FFFFFF';" bgcolor="#FFFFFF">
					
					  <td class="gentxt" align="center">
					  <?php
						if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
						?>
					  <a href="edit-courier.php?cid=<?php echo $cid; ?>">
					  <img src="images/edit.png" border="0" height="15" width="15"></a></td>
					  <?php 
						}
						?>
					  <td class="gentxt" align="center">
					  <a href="process.php?action=delivered&cid=<?php echo $cid; ?>">
					  <img src="images/delivery.png" border="0" height="15" width="15"></a></td>
					  <td class="gentxt" align="center">
					  <a target="_blank" href="barcode/html/BCGcode39.php?cons_no=<?php echo $cons_no; ?>">
					  <img src="images/barcode.png" border="0" height="16" width="20"></a></td>
					  <td class="gentxt"><?php echo $cons_no; ?></td>
					  <td class="gentxt"><?php echo $ship_name; ?></td>
					  <td class="gentxt"><?php echo $rev_name; ?></td>
					  <td class="gentxt"><?php echo $pick_date; ?> </td>
					  <td class="gentxt"><?php echo $status; ?></td>
					</tr>
					<?php
			}//foreach
			}//if
			else {
				echo "<p><strong>Records Not Available.</strong></p>";
			}
			?>
	  </table> 
    </div>	
</div>
<!-- Genearting pagw List -->
<?php 
echo generatePagination(); 
?>		
	<!-- Start Footer Section -->
        
	<footer class="footer-basic-centered">

			<p class="footer-company-motto"></p>

			<p class="footer-company-name">Copyright © 2016 deprixa.com.  All rights reserved.</p>

		</footer>	
</body>
</html>