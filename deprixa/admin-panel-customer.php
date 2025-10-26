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
require_once('pagination/pagination-admin-credit-customer.php');

?>
<!doctype html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="en" class="no-js"> <![endif]-->
<html lang="en">

<head>

<title>DEPRIXA | ToPay list Shipping Tracking</title>
	
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
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/footer-basic-centered.css">
    
    <!-- responsive devices styles -->
	<link rel="stylesheet" media="screen" href="css/responsive-leyouts.css" type="text/css" />
	
	<link rel="stylesheet" href="css/colors/orange.css" />
    
	<!-- tabs -->
    <link rel="stylesheet" type="text/css" href="js/tabs/assets/css/responsive-tabs.css">
    <link rel="stylesheet" type="text/css" href="js/tabs/assets/css/responsive-tabs2.css">
    <link rel="stylesheet" type="text/css" href="js/tabs/assets/css/responsive-tabs3.css">
	
	<script src="js/jquery.js"></script>
	<script src="js/myjava.js"></script>
	<script src="js/credit.js"></script>
	
	
</head>
<body>
<?php
include("header.php");
?>
	</td>
  </tr>
<div class="container">	
<br>
<div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumbs-alt">
                        <li>
                            <a class="active-trail active" href="admin.php">Package List Paid</a>
                        </li>
                        <li>
                            <a  href="admin-credit.php">Package List ToPay</a>
                        </li>
                        <li>
                            <a   href="admin-on-delivery.php">Package List Cash on Delivery</a>
                        </li>
						<li>
                            <a  class="current" href="admin-panel-customer.php">Admin Panel Customer</a>
                        </li>
						<li>
						<span id=tick2></span>				
						<?php //echo date("g:i a"); ?>&nbsp;&nbsp;<font color="#2DB200"><?php echo date("l F d, Y"); ?></font></span>
						</li>
                    </ul>
                </div>
            </div>
			
    <tr>
      <td class="TrackTitle" valign="top"><div  align="center"><h3 class="classic-title"><span><strong>Customer list Shipping Tracking</strong></span></h3>
    </tr>
	<section>
    <table border="0" align="center">
    	<tr>
			<td width="335"><form action="search-courier.php" method="post" name="form" id="form" >				
				</div>
			      <input name="Consignment" class="gentxt1" id="Consignment"  type="text" placeholder="Here number Tracking"> 
                  <button  name="Submit" type="submit" class="btn btn-danger" onClick="MM_validateForm('Consignment','','R');return document.MM_returnValue">&nbsp;&nbsp;Search & Edit</button></form></td>
			<td><strong></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><i class="icon-append fa fa-calendar"></i>&nbsp;&nbsp;<input type="date" id="bd-desde"/></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;TO&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><i class="icon-append fa fa-calendar"></i>&nbsp;&nbsp;<input type="date" id="bd-hasta"/></td>
			
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" href="javascript:reportecreditPDF();" class="btn btn-danger">Export to <strong>PDF</strong></a></td>
        </tr>
    </table>
    </section>
  </tbody></table>
  <br>
  <div class="one_full">
			<div class="table-style">
                <table class="table-list">
				
                    <tr>
                        <th class="newtext"><font color="white">Update status</font></th>
						<th class="newtext"><font color="white">Deliver Package</font></th>
						<th class="newtext"><font color="white">Print Invoice</font></th>
						<th class="newtext"><font color="white">Generate Barcode</font></th>
                        <th class="newtext"><font color="white"># Tracking</font></th>
                        <th class="newtext"><font color="white">Origin</font></th>
                        <th class="newtext"><font color="white">Destination</font></th>
						<th class="newtext"><font color="white">Shipping Date / Time</font></th>
                        <th class="newtext"><font color="white">Shipment status</font></th>
                    </tr>
					</tbody>
						<?php
						$records = getPageData();
						if(count($records) > 0){
						$i = 0;
						foreach($records as $record){
						extract($record);	// extract array
						$i++; 				// increment i
						$even = $i%2; 		// getting MOD
						?>
					<tbody>
					  <tr onMouseOver="this.bgColor='gold';" onMouseOut="this.bgColor='#FFFFFF';" bgcolor="#FFFFFF"  >					
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
					  <a href="process.php?action=deliveredcredit&cid=<?php echo $cid; ?>">
					  <img src="images/delivery.png" border="0" height="15" width="15"></a></td>
					  <td  align="center">
					  <a target="_blank" href="print-invoice/invoice-credit-print.php?cid=<?php echo $cid; ?>">
					  <img src="images/print.png" border="0" height="15" width="15"></a></td>
					  <td class="gentxt" align="center">
					  <a target="_blank" href="barcode/html/BCGcode39.php?cons_no=<?php echo $cons_no; ?>">
					  <img src="images/barcode.png" border="0" height="16" width="20"></a></td>
					  <td class="gentxt"><font color="#000"><?php echo $cons_no; ?></font></td>
					  <td class="gentxt"><?php echo $invice_no; ?></td>
					  <td class="gentxt"><?php echo $pick_time; ?></td>
					  <td class="gentxt"><?php echo $pick_date; ?></td>
					  <td class="gentxt" ><?php echo $status; ?></td>					  
					</tr>				
			</tbody>
			<?php
			}//foreach
			}//if
			else {
				echo "<p><strong>Records Not Available.</strong></p>";
			}
			?>
	  </table> 
	<!-- Genearting pagw List -->
<?php 
echo generatePagination(); 
?>	  
    </div>	
</div>
<p></p>
<p></p>
	
	<!-- Start Footer Section -->
        
	<footer class="footer-basic-centered">

			<p class="footer-company-motto"></p>

			<p class="footer-company-name">Copyright © 2015 deprixa.com.  All rights reserved.</p>

		</footer>
		<script>
				function show2(){
				if (!document.all&&!document.getElementById)
				return
				thelement=document.getElementById? document.getElementById("tick2"): document.all.tick2
				var Digital=new Date()
				var hours=Digital.getHours()
				var minutes=Digital.getMinutes()
				var seconds=Digital.getSeconds()
				var dn="PM"
				if (hours<12)
				dn="AM"
				if (hours>12)
				hours=hours-12
				if (hours==0)
				hours=12
				if (minutes<=9)
				minutes="0"+minutes
				if (seconds<=9)
				seconds="0"+seconds
				var ctime=hours+":"+minutes+":"+seconds+" "+dn
				thelement.innerHTML=ctime
				setTimeout("show2()",1000)
				}
				window.onload=show2
				//-->
		</script>
		<script type="text/javascript">
			$(function()
			{
				// Regular datepicker
				$('#date').datepicker({
					dateFormat: 'dd.mm.yy',
					prevText: '<i class="fa fa-chevron-left"></i>',
					nextText: '<i class="fa fa-chevron-right"></i>'
				});
				
				// Date range
				$('#start').datepicker({
					dateFormat: 'dd.mm.yy',
					prevText: '<i class="fa fa-chevron-left"></i>',
					nextText: '<i class="fa fa-chevron-right"></i>',
					onSelect: function( selectedDate )
					{
						$('#finish').datepicker('option', 'minDate', selectedDate);
					}
				});
				$('#finish').datepicker({
					dateFormat: 'dd.mm.yy',
					prevText: '<i class="fa fa-chevron-left"></i>',
					nextText: '<i class="fa fa-chevron-right"></i>',
					onSelect: function( selectedDate )
					{
						$('#start').datepicker('option', 'maxDate', selectedDate);
					}
				});
				
				// Inline datepicker
				$('#inline').datepicker({
					dateFormat: 'dd.mm.yy',
					prevText: '<i class="fa fa-chevron-left"></i>',
					nextText: '<i class="fa fa-chevron-right"></i>'
				});
				
				// Inline date range
				$('#inline-start').datepicker({
					dateFormat: 'dd.mm.yy',
					prevText: '<i class="fa fa-chevron-left"></i>',
					nextText: '<i class="fa fa-chevron-right"></i>',
					onSelect: function( selectedDate )
					{
						$('#inline-finish').datepicker('option', 'minDate', selectedDate);
					}
				});
				$('#inline-finish').datepicker({
					dateFormat: 'dd.mm.yy',
					prevText: '<i class="fa fa-chevron-left"></i>',
					nextText: '<i class="fa fa-chevron-right"></i>',
					onSelect: function( selectedDate )
					{
						$('#inline-start').datepicker('option', 'maxDate', selectedDate);
					}
				});
			});			
		</script>	
</body>
</html>