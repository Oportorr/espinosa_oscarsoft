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
require_once('deprixa/database.php');

$cons= $_POST['Consignment'];

$sql = "SELECT * FROM courier WHERE cons_no = '$cons'";
$result = dbQuery($sql);
$no = dbNumRows($result);
if($no == 1){
				
while($data = dbFetchAssoc($result)) {
extract($data);

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />	    
    <title>Track My Parcel  | CARGO v10.1</title>
        <meta name="description" content="Cargo V10.1"/>
        <meta name="keywords" content="Cargo Web System" />
        <meta name="author" content="CNSWARE INC"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--html5 ie include-->
    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--[if lt IE 9]><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
    
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
    <!--[if IE]>
        <link rel="stylesheet" type="text/css" href="/Styles/ie-fixes.css" />
    <![endif]-->
	    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="deprixa/asset1/css/font-awesome.min.css" type="text/css" media="screen">  
    <link rel="canonical" href="tracking.php" />
    
    <!-- style -->
    <link href="deprixa_components/content/cssefe4.css" rel="stylesheet"/>
	<link rel="stylesheet" href="deprixa/css/tracking.css" type="text/css" />   
    <link href="deprixa_components/styles/track-order.css" rel="stylesheet" />
	<link href="deprixa/css/style.css" rel="stylesheet" media="all">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
	
	  <style> .Finished { background: #363C56; } .Delayed { background: #F76063; } .On-Hold { background: #4ECCDB; } .Landed { background: #FF8A4B; } .label{padding: 6px;} .In-Transit { background:#00D96D; } .Delivered { background:#FFBF00; }</style>
	
</head>

   <!-- Menu -->
<?php include_once "menu.php"; ?>
    <!-- /Menu -->

<div class="slide">
</div>
<main class="slide">
    <div class="fw">
            <section class="title">
                <header>
                    <h1><img src="deprixa_components/images/global/tracking-search.png" />Parcel Tracking</h1>					                   
                </header>
				<div class="media-left">
                    
                    </div>
            </section>
    </div>  

<div class="container">


 <div>


<table border="0" align="center" width="100%">

	<div class="row">
		 <div class="col-md-6">
			  
				<h3><i class="fa fa-barcode" style="width: 25px; font-size: 35px; float: left;" ></i>&nbsp;<font color="#FF4000"><strong><?php echo $cons_no; ?></strong></font></span></h3>
			 
		</div>
		<div class="col-md-6">
			  <h3><font  color="Black" face="arial,verdana"><strong>Current Status</strong></font>:&nbsp;<span class="label <?php echo $status; ?> label-large"><font size=2 color="White" face="arial,verdana"><?php echo $status; ?></font></span>&nbsp;&nbsp;&nbsp;
			  <font  color="Black" face="arial,verdana"><strong>Booking Mode</strong></font>:&nbsp;<span class="label label-danger"><i class="fa fa-money"></i><font size=2 color="White" face="arial,verdana"> <?php echo $book_mode; ?></font></span></h3>
			  
		</div>
	</div>
    <div class="col-md-6">
      <table class="table table-striped">
        <tr>  </tr>
      </table>
    </div>
   <hr />
	<div class="row">
		<div class="col-md-4"> <font size=3 color="Black" face="arial,verdana"><strong>Schedule Delivery</strong></font><br />
		<?php echo $schedule; ?>, By End Of Day 
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-md-12">
			<h2>Additional Information</h2>
		</div>
		<br/>
		<div class="col-md-4"> <font size=2 color="Black" face="arial,verdana"><strong>Origin:</strong></font> <?php echo $invice_no; ?><br />
			<font size=2 color="Black" face="arial,verdana"><strong>Destination:</strong></font> <?php echo $pick_time; ?><br />
			<font size=2 color="Black" face="arial,verdana"><strong>Services:</strong></font> <?php echo $mode; ?><br />
			<font size=2 color="Black" face="arial,verdana"><strong>Type:</strong></font> <?php echo $type; ?><br />
			<font size=2 color="Black" face="arial,verdana"><strong>Weight:</strong></font> <?php echo $weight; ?>&nbsp;kg<br />
			<font size=2 color="Black" face="arial,verdana"><strong>Pickup Date/Time:</strong></font> <?php echo $pick_date; ?><br/>   
			<font size=2 color="Black" face="arial,verdana"><strong>Descripcion:</strong></font> <?php echo $comments; ?>
		</div>
		<div class="col-md-4"> <font size=3 color="Black" face="arial,verdana"><strong>Shipper info</strong></font><br />
			<font size=2 color="Black" face="arial,verdana"><strong>Name:</strong></font> <?php echo $ship_name; ?><br />
			<font size=2 color="Black" face="arial,verdana"><strong>Phone:</strong></font> <?php echo $phone; ?><br />
			<font size=2 color="Black" face="arial,verdana"><strong>Address:</strong></font>  <?php echo $s_add; ?> 
		</div>
		<div class="col-md-4"> <font size=3 color="Black" face="arial,verdana"><strong>Consignee Information</strong></font><br />
			<font size=2 color="Black" face="arial,verdana"><strong>Name:</strong></font> <?php echo $rev_name; ?><br />
			<font size=2 color="Black" face="arial,verdana"><strong>Phone:</strong></font> <?php echo $r_phone; ?><br />
			<font size=2 color="Black" face="arial,verdana"><strong>Address:</strong></font>  <?php echo $r_add; ?>
		</div>

	</div>
  <hr />
	<div class="row">
	  <div class="col-md-12">
		<h2>Travel History</h2>
		<br/>
			<?php
				require_once('deprixa/database.php');
				

				//EJECUTAMOS LA CONSULTA DE BUSQUEDA

				$result = mysql_query("SELECT * FROM courier_track WHERE cid = $cid	AND cons_no = '$cons_no' ORDER BY bk_time");

				//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

				echo ' <table class="table table-bordered table-striped table-hover" >
							<tr class="car_bold col_dark_bold" align="center">
								<td><font color="Black" face="arial,verdana"><strong>Tracking No</strong></font></td>
								<td><font color="Black" face="arial,verdana"><strong>Last Location </strong></font></td>
								<td><font color="Black" face="arial,verdana"><strong>Status</strong></font></td>
								<td><font color="Black" face="arial,verdana"><strong>Date / Time</strong></font></td>
								<td><font color="Black" face="arial,verdana"><strong>Remarks</strong></font></td>																							
							</tr>';
				if(mysql_num_rows($result)>0){
					while($row = mysql_fetch_array($result)){
						echo '<tr align="center">
								<td>'.$row['cons_no'].'</td>
								<td>'.$row['pick_time'].'</td>
								<td>'.$row['status'].'</td>
								<td>'.$row['bk_time'].'</td>				
								<td>'.$row['comments'].'</td>
								</tr>';
					}
				}else{
					echo '<tr>
								<td colspan="5" >No results found</td>
							</tr>';
				}
				echo '</table>';
				?>
		</div>
	</div><!-- .container -->
</div>

</div> 

 </main>

   <!-- Footer -->
 <?php include_once "footer.php"; ?>
    <!-- /Footer -->
    </div>

    <script src="deprixa_components/bundles/jquery"></script>
    <script src="deprixa_components/bundles/bootstrap"></script>
    <script src="deprixa_components/bundles/modernizr"></script>
    <script src="deprixa_components/Scripts/CookieManager.js"></script>
    <script src="deprixa_components/Scripts/MPD/Common/ga-events.js"></script>   
    <script src="deprixa_components/bundles/jqueryval"></script>
    <script src="deprixa_components/Scripts/tracking.js"></script>

</body>
</html>

<?php 
		
}//while

}//if
else {
		
echo '';
?>

<!doctype html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="en" class="no-js"> <![endif]-->
<html>

<head>
    <meta charset="utf-8" />	    
    <title>Track My Parcel  | DEPRIXA</title>
	<meta name="description" content="Courier Deprixa V3.2 "/>
	<meta name="keywords" content="Courier DEPRIXA-Integral Web System" />
	<meta name="author" content="Jaomweb">	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<link rel="stylesheet" href="deprixa/asset1/css/font-awesome.min.css" type="text/css" media="screen">  
    <link rel="canonical" href="tracking.php" />
    
    <!-- style -->
    <link href="deprixa_components/content/cssefe4.css" rel="stylesheet"/>
	<link rel="stylesheet" href="deprixa/css/tracking.css" type="text/css" />   
    <link href="deprixa_components/styles/track-order.css" rel="stylesheet" />
	<link href="deprixa/css/style.css" rel="stylesheet" media="all">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>

</head>

   <!-- Menu -->
<?php include_once "menu.php"; ?>
    <!-- /Menu -->
	
<div class="slide">    
    </div>
        <main class="slide">
        <div class="fw">
            <section class="title">
                <header>
                    <h1><img src="deprixa_components/images/global/tracking-search.png" />Parcel Tracking</h1>					                   
                </header>
				<div class="media-left">
                    
                    </div>
            </section>
        </div>  
		<div class="container">
				<div class="page-content">					
					
					<div class="text-center">
						<h1><img src="deprixa_components/images/error.png" /></h1>
						<h3>Tracking number not found,</h3>
						<p><font color="#FF0000"><?php echo $cons; ?></font> check the number or Contact Us.</p>
						<div class="text-center"><a href="index.php" class="btn-system btn-small">Back To Home</a></div>
					</div>					
				</div>
		</div>
		</div>
		<!-- End Content -->

   <!-- Footer -->
 <?php include_once "footer.php"; ?>
    <!-- /Footer -->
    </div>

    <script src="deprixa_components/bundles/jquery"></script>
    <script src="deprixa_components/bundles/bootstrap"></script>
    <script src="deprixa_components/bundles/modernizr"></script>
    <script src="deprixa_components/scripts/CookieManager.js"></script>
    <script src="deprixa_components/scripts/MPD/Common/ga-events.js"></script>    
    <script src="deprixa_components/bundles/jqueryval"></script>
    <script src="deprixa_components/scripts/tracking.js"></script>
	 <script>
	function myFunction() {
		window.print();
	}
	</script>
</body>
<?php 
}//else	

?>
</html>
