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
// ***
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
require_once('../database.php');
$cid= (int)$_GET['cid'];

$sql = "SELECT *
		FROM courier
		WHERE cid = $cid";	
$result = dbQuery($sql);		
while($row = dbFetchAssoc($result)) {
extract($row);
}

$company=mysql_fetch_array(mysql_query("SELECT * FROM company"));
$fecha=date('Y-m-d');

$sql2 = mysql_query("SELECT user,officename FROM courier WHERE cid = $cid");	
 while ($created_by = mysql_fetch_array($sql2)) {
        $user = $created_by['user'];
         $officename = $created_by['officename'];
    }
 if($user == 'Administrator' || $user == 'ADMINISTRATOR') {
   $sql3 = mysql_query("SELECT name_parson,name FROM manager_admin WHERE name = '$officename'");	
 while ($created_by2 = mysql_fetch_array($sql3)) {
        $created_user = $created_by2['name'];
           }  
 } else {
       $sql3 = mysql_query("SELECT name_parson,name FROM manager_user WHERE name = '$officename'");	
 while ($created_by2 = mysql_fetch_array($sql3)) {
        $created_user = $created_by2['name'];
           }  
 }

$city1 = mysql_query("SELECT city_name FROM city WHERE city_id = '$s_city'");
    while ($city_name1 = mysql_fetch_array($city1)) {
        $s_city = $city_name1['city_name'];
    }      
                    
$state1 = mysql_query("SELECT state_name FROM state WHERE state_id = '$s_state'");
    while ($state_name1 = mysql_fetch_array($state1)) {
        $s_state = $state_name1['state_name'];
    } 
$country1 = mysql_query("SELECT country_name FROM country WHERE country_id = '$s_country'");
    while ($country_name1 = mysql_fetch_array($country1)) {
        $s_country = $country_name1['country_name'];
    }     
    
$city2 = mysql_query("SELECT city_name FROM city WHERE city_id = '$r_city'");
    while ($city_name2 = mysql_fetch_array($city2)) {
        $r_city = $city_name2['city_name'];
    }      
                    
$state2 = mysql_query("SELECT state_name FROM state WHERE state_id = '$r_state'");
    while ($state_name2 = mysql_fetch_array($state2)) {
        $r_state = $state_name2['state_name'];
    }
$country2 = mysql_query("SELECT country_name FROM country WHERE country_id = '$r_country'");
    while ($country_name2 = mysql_fetch_array($country2)) {
        $r_country = $country_name2['country_name'];
    }     

  $sql5 = mysql_query("SELECT mu.flag, mu.phone, mu.name, c.officename FROM manager_user mu LEFT JOIN courier c ON (mu.name = c.officename) WHERE c.cid = $cid ");	
 while ($created_by5 = mysql_fetch_array($sql5)) {
         $flag = $created_by5['flag']; 
         $e_phone = $created_by5['phone']; 
           }  
?>

<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
        
 <style media="print">
@media print {
  @page { margin: 0; }
  body { margin: 1.6cm; }
}
@media print 
{
   @page
   {
    size: 8.5in 5.5in;
    size: portrait;
  }
}
</style>  

</head>
<body style="margin: 0px;" onload="window.print();">
<table style="width: 196px; margin-left:10px; margin-top:10px;  vertical-align: top; font-family: arial; font-size: 10px;">
	<tr>
		<td style="vertical-align: top; border:solid 1px #000; padding: 5px 10px;">
			<table style=" width: 100%; text-align: center; vertical-align: top;">
                             <h2 class="page-header">
			  <span><img src="../image_logo.php?id=1"></span>
            </h2> 
			       	<tr>
				        <td> <?php echo nl2br($company['caddress']);  ?></td>
			        </tr>
			        
				<tr>
					<td><?php echo $created_user;  ?></td>
				</tr>
				<tr>
					<td>Tel:<?php  if($flag==1){ echo $e_phone;} else { echo $company['cphone']; } ?></td>
				</tr>
			</table>
		</td>

	</tr>
	<tr>
		<td style="font-size: 18px; font-weight: bold; padding: 15px 0px 5px; ">
			Sender
		</td>
	</tr>

<tr>
	<td style="vertical-align: top; border:solid 1px #000; padding: 5px 10px;">

	<table style=" width: 100%; text-align: center; vertical-align: top;">
                <tr>
			<td> <?php echo $ship_name; ?> </td>
		</tr>
                <tr>
			<td>  <?php echo $phone; ?> </td>
		</tr>
		<tr>
			<td>  <?php echo $s_add; ?> </td>
		</tr>
		<tr>
			<td> <?php echo $s_city; ?>,
			 <?php echo $s_state; ?>, 
			 <?php echo $s_country; ?> </td>
		</tr>                 
		<tr>
			<td> <?php echo $s_zipcode; ?> </td>
		</tr>                
		<tr>
			<td></td>
		</tr>
	 </table>
	</td>
 </tr>
<tr>
	<td style="font-size: 18px; font-weight: bold; padding: 15px 0px 5px; ">
		Receiver
	</td>
</tr>

<tr>
	<td style="vertical-align: top; border:solid 1px #000; padding: 5px 10px;">
		<table style=" width: 100%; text-align: center; vertical-align: top;">
			<tr>
				<td> <?php echo $rev_name; ?>  </td>
			</tr>
			<tr>
				<td> <?php echo $r_phone; ?></td>
			</tr>
			<tr>
				<td> <?php echo $r_add; ?></td>
			</tr>
			<tr>
				<td> <?php echo $r_city; ?>,			
				 <?php echo $r_state; ?>,			
				 <?php echo $r_country; ?></td>
			</tr> 			
		 </table>
	</td>
 </tr>
 
<tr>
	<td style="padding: 25px 0px 6px; ">
		<table style=" width: 100%; text-align: center; vertical-align: top;">
		 <tr>
		 	<td> QTY <br> </td>
		 	<td style="padding: 0 10px">  Description <br></td>
		 	<td style="padding: 0 10px;">Price <br></td>

		 </tr>
  <?php 
// $csql = mysql_query("SELECT ci.ship_qty, ci.product_price, ts.name FROM  courier_item ci LEFT JOIN type_shipments ts ON ci.product_type = ts.id where ci.cid = '$cid'");
// 
  $csql = mysql_query("SELECT * FROM  courier_item where cid = '$cid'");
  
 while ($courieritem = mysql_fetch_array($csql)) {
      
  ?>                 
                 <tr>
		 	<td> <?php echo $courieritem['ship_qty']; ?></td>
		 	<td style="padding: 0 10px"> <?php echo $courieritem['product_name']; ?></td>
                        <td style="text-align:right;"> <?php echo $courieritem['product_price']; ?></td>

		 </tr>
         <?php } ?>            
		</table>
	</td>
</tr>

<?php
$psql="SELECT SUM(amount) AS payby_cash FROM courier_payment WHERE paying_by = 'cash' AND courier_id = '$cid'"; 
$myresult=  mysql_query($psql);
$rs_row = mysql_fetch_row($myresult);
$psql1="SELECT SUM(amount) AS payby_credit FROM courier_payment WHERE paying_by = 'credit_card' AND courier_id = '$cid'"; 
$myresult1=  mysql_query($psql1);
$rs_row1 = mysql_fetch_row($myresult1);
?>

<tr>
	<td style="padding: 15px 0px 5px; ">
		<table style=" width: 100%; text-align: left; vertical-align: middle;">
		 <tr>
		 	<td> Total</td>
		 	<td style="padding: 0 0 5px 10px; border: 1px dotted #000;"> <?php echo $shipping_subtotal ?></td>		 	
		 </tr>
		 <tr>
		 	<td> Paid </td>
		 	<td style="padding: 0 0 5px 10px; border: 1px dotted #000;"> <?php echo $paid_amount; ?></td>		 	
		 </tr>                 
<!--		 <tr>
		 	<td> Cash </td>
                        <td style="padding: 0 0 5px 10px; border: 1px dotted #000;"><?php //if($rs_row['0']=="") { echo "0.00"; } else{ echo $rs_row['0']; } ?></td>		 	
		 </tr>	             
		  <tr>
		 	<td style="width: 90px"> Store Credit </td>
		 	<td style="padding: 0 0 5px 10px; border: 1px dotted #000;"><?php //if($rs_row1['0']=="") { echo "0.00"; } else{ echo $rs_row1['0']; } ?></td>		 	
		 </tr>-->
		 <tr>
		 	<td> Balance </td>
		 	<td style="padding: 0 0 5px 10px; border: 1px dotted #000;"><?php echo $balancers=$shipping_subtotal-$paid_amount; ?></td>		 	
		 </tr>

		</table>
	</td>
</tr>

<tr>
	<td style="font-size: 18px; font-weight: bold; padding: 15px 0px 5px; ">
<!--		Billing Signature-->
	</td>
</tr>
<tr>
	<td style="padding: 0px 0px 5px; ">
		<table style=" width: 100%; text-align: left; vertical-align: top;">
		 <tr>
		 	<td> Invoice# </td>
		 	<td style="padding: 0 0 5px 10px"> <?php echo $invice_no; ?></td>		 	
		 </tr>
		 <tr>
		 	<td> Truck </td>
		 	<td style="padding: 0 0 5px 10px"> <?php echo $container_number; ?></td>		 	
		 </tr>
		 <tr>
		 	<td> Date</td>
		 	<td style="padding: 0 0 5px 10px"> <?php echo $book_date; ?></td>		 	
		 </tr>		  
		</table>
	</td>
</tr>


<tr>
	<td style="font-size: 18px; font-weight: bold; padding:15px 0 0px 0px; text-align: left; ">
                                                    <center>
                                                        <img src="barcode.php?text=testing" alt="testing" /><br>
                                                        <?php echo $cons_no; ?><br><br>
                                                        
<!--                                                        <img src="barcode.php?text=<?php //$cid ?>" alt="testing" /><br>-->
														 </center>
														</td>
														</tr>
														<tr>
<!--														<td style="font-size: 18px;  padding:3px 0 5px 0px; text-align: center; ">
								<p style="font-wight:noraml;font-size: 10px;text-transform: capitalize;">Created by:&nbsp;<?php// echo $created_user; ?>&nbsp;<br/>
                                                   
        </td>           -->
                       
<!--<td style="font-size: 18px; font-weight: bold; padding:15px 0 5px 0px; text-align: left; ">
		<img src="barcodes.png">
	</td> -->
    
</tr>


<!--<tr>
	<td style="font-size: 18px; font-weight: bold; padding:15px 0 5px 0px; text-align: center; ">
		TERMS AND CONDATION 
	</td>
</tr>
<tr>
	<td style=" padding:5px 0 5px 0px; text-align: left; ">
		Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
	</td>
</tr>

<tr>
	<td style=" padding:5px 0 5px 0px; text-align: left; ">
	<ol style="padding: 0 0 0 25px; list-style: ">
		<li style=" margin-bottom: 10px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</li>
		<li style=" margin-bottom: 10px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</li>
		<li style=" margin-bottom: 10px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</li>
		<li style=" margin-bottom: 10px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</li>
		<li style=" margin-bottom: 10px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</li>
		<li style=" margin-bottom: 10px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</li>
		<li style=" margin-bottom: 10px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</li>
		<li style=" margin-bottom: 10px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</li>
		<li style=" margin-bottom: 10px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</li>

	</ol>
		
	</td>
</tr>-->

</table>


</body>
</html>