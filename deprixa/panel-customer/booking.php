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

require_once('../database.php');

	$scountry = $_POST['scountry'];
	$sstate = $_POST['sstate'];
	$dcountry = $_POST['dcountry'];
	$dstate = $_POST['dstate'];
	$Qnty = $_POST['Qnty'];
	$weight = $_POST['weight'];
	$height = $_POST['height'];
	$width = $_POST['width'];
	$length = $_POST['length'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$address=$_POST['address'];
	$name_delivery = $_POST['name_delivery'];
	$address_delivery = $_POST['address_delivery'];
	$phone_delivery=$_POST['phone_delivery'];
	$note = $_POST['note'];
	$type = $_POST['type'];
	$service = $_POST['service'];
	$officename = $_POST['officename'];

	//$OfficeName = $_POST['OfficeName'];	

	$sql = "INSERT INTO online_booking (scountry,sstate,dcountry,dstate,type,service,Qnty,weight,length,width,height,name,status,email,phone,address,name_delivery,address_delivery,phone_delivery,note,officename,booking_date)

			VALUES ('$scountry','$sstate','$dcountry','$dstate','$type','$service','$Qnty','$weight','$length','$width','$height','$name','Pending','$email','$phone','$address','$name_delivery','$address_delivery','$phone_delivery','$note','$officename',NOW())";						

	dbQuery($sql);
	
	
	$result1 =  mysql_query("SELECT * FROM company");
	while($row = mysql_fetch_array($result1)) {
	
	$to  = $row["bemail"];
	$address  = $row["caddress"];
	$namecompany  = $row["cname"];

    // subject

    $subject = 'ONLINE BOOKING NOTIFICATION | '.$row["cname"].'';
	$from = $row["bemail"];
    // message
	$text_message    = "Hi ".$name." this is our address, <br /><br /> <strong> ".$address." Please consider your environmental responsibility. Before printing this e-mail message, ask yourself whether you really need a hard copy.</strong><br /><br /> IMPORTANT:</strong> The contents of this email and any attachments are confidential. They are intended for the named recipient(s) only. If you have received this email by mistake, please notify the sender immediately and do not disclose the contents to anyone or make copies thereof.";			   
	
	// HTML email starts here
	
	$message  = "<html><body>";	
	$message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";	
	$message .= "<tr><td>";	
	$message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:800px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";		
	$message .= "<thead>
				<tr height='80'>
					<th colspan='4' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#333; font-size:34px;' >".$namecompany."</th>
				</tr>
				</thead>";
		
	$message .= "<tbody>
				
				<tr>
					<td colspan='4' style='padding:15px;'>
						<p><img src='".$row['website']."deprixa/image_logo.php?id=1'></p>
						<br><br>
						<p style='font-size:14px;'>Customer Name: <strong>".$name."</strong></p>
						<hr />
						<p style='font-size:14px;'>Email: <strong> ".$email."</strong></p>					
						<p style='font-size:14px;'>From: <strong> ".$scountry." / ".$sstate."</strong></p>
						<p style='font-size:14px;'>To: <strong> ".$dcountry." / ".$dstate."</strong></p>
						<p style='font-size:14px;'>Type: <strong> ".$type."</strong></p>
						<p style='font-size:14px;'>Shipping details: <strong> ".$note."</strong></p>
						<p style='font-size:14px;'>Quantity: <strong> ".$Qnty."</strong>&nbsp;&nbsp;Weight: <strong> ".$weight."</strong></p>
						<br>
						<p style='font-size:16px;'><strong>Shipment status online booking:</strong> <strong> ".$status."</strong></p>
						<br>
						<p style='font-size:14px;'>Tracking Details URL:<a style='background:#eee;color:#333;padding:10px;' href='".$row["website"]."tracking.php' >See shipping</a></p>
						<br><br>
						<p><a style='background:#eee;color:#333;padding:10px;' href='".$row["website"]."login.php' >Customer Login</a></p>
						<br><br>
						<p style='font-size:13px; font-family:Verdana, Geneva, sans-serif;'>".$text_message.".</p>
					</td>
				</tr>												
				</tbody>";				
	$message .= "</table>";	
	$message .= "</td></tr>";
	$message .= "</table>";	
	$message .= "</body></html>";

	}

   // To send HTML mail, the Content-type header must be set

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
   // Additional headers
    $headers .= 'From: '.$from."\r\n";	
    // this line checks that we have a valid email address
	mail($to, $subject, $message, $headers); //This method sends the mail.
	mail($email, $subject, $message, $headers); //This method sends the mail.

   
   echo "<script type=\"text/javascript\">
			alert(\"'$_POST[name]' Thank you for booking with us, your booking has been submitted for approval\");
			window.location = \"add-courier-customer.php\"
		</script>";	 
   
   ?>