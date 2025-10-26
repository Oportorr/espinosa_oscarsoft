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
session_start();
require_once('database.php');
	
$action = $_GET['action'];

switch($action) {
	case 'add-pickup-date':
		addPickupDate();
	break;
	case 'add-cons':
		addCons();
	break;
	case 'approve-courier':
	
	approveCourier();
	
	break;
	
	 case 'update-booking':	
	updateBooking();	
	break;
	
	case 'add-customer':
		addCustomer();
	break;
	
	case 'add-client':
		addclient();
	break;
	
	case 'shipping-charges':
		shippingcharges();
	break;
	
	case 'update-admin':
		updateadmin();
	break;
	
	case 'update-courier':
		updatecourier();
	break;
	
	case 'update-addcourier':
		addcourier_update();
	break;

	case 'change-profile':
		changeProfile();
	break;

	case 'change-pass':
		changePass();
	break;
	
	case 'company':
		changeCompany();
	break;
	
	case 'change-logo':
		changelogo();
	break;
	
	case 'send-msg':
		sendMsg();
	break;

	case 'edit-user':
		edituser();
	break;
	
	case 'update-client':
		updateclient();
	break;

	case 'delivered':
		markDelivered();
	break;
	
	case 'deliveredcredit':
		markDeliveredcredit();
	break;	
	
	case 'deliveredondelivery':
		Deliveredondelivery();
	break;
	
	case 'add-office':
		addNewOffice();
	break;
	
	case 'add-customer':
		addNewCustomer();
	break;
	
	case 'add-manager':
		addManager();
	break;
	
	case 'add-managers':
		addManagers();
	break;
	
	case 'update-status':
		updateStatus();
	break;
	
	case 'update-paid':
		updatePaid();
	break;
	
	case 'change-pass':
		changePass();
	break;
			
	case 'logOut':
		logOut();
	break;	
        case 'add-pay':
		addpay();
	break;
    case 'add-pay2':
		addpay2();
	break;
	
}//switch
//start function addPickupDate
function addPickupDate(){  
    $from_date = date_format(date_create($_POST['from_date']),"Y-m-d");
    $to_date = date_format(date_create($_POST['to_date']),"Y-m-d");
    $from_coutry = $_POST['from_coutry'];
    $to_country = $_POST['to_country'];
    $from_state = $_POST['from_state'];
    $to_state = $_POST['to_state'];
    $from_city = $_POST['from_city'];
    $to_city = $_POST['to_city'];
    $s_address = $_POST['s_address'];
    $s_name = $_POST['s_name'];
    $s_state = $_POST['s_state'];
    $s_city = $_POST['s_city'];
    $s_zip_code = $_POST['s_zip_code'];
    $s_phone = $_POST['s_phone'];
    $s_email = $_POST['s_email'];
    if(isset($_POST['sid'])){ // check for insert or update
        $sid = $_POST['sid'];
        //delete data from scheduledpickup_date table
        $delete = "DELETE FROM schedule_items WHERE scheduledpickup_date_id= '".$sid."' ";
        $delete_data = dbQuery($delete);
        if($delete_data){
            // update data from scheduledpickup_date table
            $sql_update = "UPDATE scheduledpickup_date SET from_date = '$from_date', to_date = '$to_date',from_coutry = '" . (int)$from_coutry."',to_country = '" . (int)$to_country."',from_state = '" . (int)$from_state."',to_state = '" . (int)$to_state."',from_city = '" . (int)$from_city."',to_city = '" . (int)$to_city."', s_address = '$s_address', s_name = '$s_name',s_state = '" . (int)$s_state."',s_city = '" . (int)$s_city."',s_zip_code = '" . (int)$s_zip_code."',s_phone = '" . (int)$s_phone."',s_email = '$s_email', date_modified = NOW() WHERE id = '".$sid."'";
            $update_sql = dbQuery($sql_update);
            if($update_sql){
                foreach ($_POST['product'] as $value) {
                    $product_name = $value; 
                    $sql_product = "INSERT INTO schedule_items SET scheduledpickup_date_id = '" . (int)$sid."', product_name = '$product_name' ";
                    dbQuery($sql_product);
                }
                echo "<script type=\"text/javascript\">
                        window.location = \"schedule.php\"
                    </script>";
            }
        }
    } else{
        $sql = "INSERT INTO scheduledpickup_date SET from_date = '$from_date', to_date = '$to_date',from_coutry = '" . (int)$from_coutry."',to_country = '" . (int)$to_country."',from_state = '" . (int)$from_state."',to_state = '" . (int)$to_state."',from_city = '" . (int)$from_city."',to_city = '" . (int)$to_city."', s_address = '$s_address', s_name = '$s_name',s_state = '" . (int)$s_state."',s_city = '" . (int)$s_city."',s_zip_code = '" . (int)$s_zip_code."',s_phone = '" . (int)$s_phone."',s_email = '$s_email', date_added = NOW(), date_modified = NOW()";
        $insert_sql = dbQuery($sql);
        if($insert_sql){
            $last_id=  dbInsertId();
            foreach ($_POST['product'] as $value) {
                $product_name = $value; 
                $sql_product = "INSERT INTO schedule_items SET scheduledpickup_date_id = '" . (int)$last_id."', product_name = '$product_name' ";
                dbQuery($sql_product);
            }
            echo "<script type=\"text/javascript\">
                    window.location = \"schedule.php\"
                </script>";
        }
    }
}
//End function addPickupDate
function addCons(){
  
     $qname = $_SESSION['user_name'];        
        $modified_by = $qname ; 
		
		

	$Shippername = $_POST['Shippername'];
	$Shipperphone = $_POST['Shipperphone'];
	$Shipperaddress = $_POST['Shipperaddress'];
	$Shippercc = $_POST['Shippercc'];
	$Shippercity = $_POST['city'];
	$Shipperstate = $_POST['state'];
	$Shippercountry = $_POST['country'];
	$Shipperzip_code = $_POST['zip_code'];
	
	 $Receivername = $_POST['Receivername'];
	 if(!empty($Receivername)){
		$Receivername=$Receivername;
	 }
	
	 $Receivername_select =$_POST['Receivername_select'];
	  if(!empty($Receivername_select) && $Receivername_select > 0){

		 $reciever_name = mysql_fetch_array(mysql_query("SELECT name FROM tbl_clients WHERE id ='$Receivername_select'"));
		 $Receivername=$reciever_name['name'];
	 }
	
	$Receiverphone = $_POST['Receiverphone'];
	$Receiveraddress = $_POST['Receiveraddress'];
	$Receivercc_r = $_POST['Receivercc_r'];
	$Receiveremail = $_POST['Receiveremail'];
	$Receivercity = $_POST['city1'];
	$Receiverstate = $_POST['state1'];
	$Receivercountry = $_POST['country1'];
	$Receicedulanumber = $_POST['cedula_number'];
	
	
	$ConsignmentNo = $_POST['ConsignmentNo'];
	$Shiptype = $_POST['Shiptype'];
	$Weight = $_POST['Weight'];
	$variable = $_POST['variable'];
	$shipping_subtotal = $_POST['shipping_subtotal'];
	$Invoiceno = "";
        $office_origin=$_POST['office_origin'];
	$Qnty = $_POST['Qnty'];

	$Bookingmode = $_POST['Bookingmode'];
	$Totalfreight = $_POST['Totalfreight'];
	$Totaldeclarate = $_POST['Totaldeclarate'];
	$Mode = $_POST['Mode'];
	
	$Packupdate = $_POST['Packupdate'];
    $Payment_Due = $_POST['Payment_Due'];
	$Schedule = $_POST['Schedule'];
	$Pickuptime = ''; //$_POST['Pickuptime'];
	$status = $_POST['status'];
	$Comments = $_POST['Comments'];
	$officename = $_POST['officename'];
	$user = $_POST['user'];
	$grand_total = $_POST['grand_total'];
    $container_number = $_POST['container_number'];
    $container_id1 = $_POST['conid'];
        
	$res_i = mysql_query("SELECT invoice_number FROM `courier` where container_id = '$container_id1' ORDER BY invoice_number DESC LIMIT 1 ");
	$num_rows = mysql_num_rows($res_i);

	if ($num_rows > 0) {
	    $row_i = mysql_fetch_array($res_i);
	    $last_two_digit = substr($row_i['invoice_number'], -2);
	    if($last_two_digit == 99){
	        $newNumber = $last_two_digit + 1;
	        $container_last_digit = substr($container_number, -1);
	        if ($container_last_digit > 0) {
	            $invoice_number = $container_last_digit .$newNumber;
                } else {
                    $invoice_number = $newNumber;
                }
	    } else{
	        $invoice_number = $row_i['invoice_number'] + 1;
	    }
	} else {
	    $container_last_digit = substr($container_number, -1);
	    if ($container_last_digit > 0) {
	        $invoice_number = $container_last_digit * 100;
	    } else {
	        $invoice_number = $container_last_digit . '01';
	    }
	}
	// if($num_rows > 0) {
	// 	$row_i = mysql_fetch_array($res_i);
	// 	$invoice_number = $row_i['invoice_number'] + 1;
	// } else {
	// 	$container_last_digit = substr($container_number, -1);
	// 	if($container_last_digit > 0) {
	// 		$invoice_number = $container_last_digit * 100;
	// 	} else {
	// 		$invoice_number = $container_last_digit .'01';
	// 	}
	// }
        
        
        $sql = "INSERT INTO courier (cons_no, ship_name, phone, s_add, s_city, s_state, s_country, s_zipcode, cc, rev_name, r_phone, r_add, r_city, r_state ,r_country, r_cedula_number, cc_r, email, type, weight, variable, shipping_subtotal, invice_no, invoice_number, qty, book_mode, freight, declarate, mode, pick_date, payment_due, schedule, pick_time, status, comments, officename, user, book_date, container_id, container_number, office_origin)
			VALUES('$ConsignmentNo', '$Shippername','$Shipperphone', '$Shipperaddress', '$Shippercity', '$Shipperstate', '$Shippercountry', '$Shipperzip_code', '$Shippercc', '$Receivername','$Receiverphone','$Receiveraddress', '$Receivercity', '$Receiverstate', '$Receivercountry', '$Receicedulanumber', '$Receivercc_r', '$Receiveremail', '$Shiptype',$Weight , '$variable', $grand_total, '$Invoiceno', $invoice_number, $Qnty, '$Bookingmode', '$Totalfreight',  '$Totaldeclarate', '$Mode', '$Packupdate', '$Payment_Due', '$Schedule', '$Pickuptime', '$status', '$Comments', '$officename', '$user', curdate(), '$container_id1', '$container_number', '$office_origin')";	
		
		
	    dbQuery($sql);
        
        //UPDATE INVOICE NO. BY LAST courier INSERT ID
        $last_id=  dbInsertId();
		
		$sql_22 = "UPDATE courier SET invice_no='$last_id' where cid='$last_id'";
        dbQuery($sql_22);
        
    $cid = mysql_query("SELECT cid FROM `courier` ORDER BY `cid` DESC LIMIT 1");
	$id = mysql_fetch_array($cid);
	$cid = $id['cid'];
       
	foreach ($_POST['product'] as $value) {
	 // $product_type = $value['product_type'];
	  $product_price = $value['product_price'];
	  $ship_qty = $value['ship_qty'];
	  $discount = $value['discount'];
	  $sub_total = $value['sub_total'];
	  $product_type1 = $value['product_type1'];
           
	  $sql_product = "INSERT INTO courier_item (cid, product_type, product_price, ship_qty, discount, sub_total,line_shipping_status,product_name)
			VALUES('$cid', '0', '$product_price', '$ship_qty', '$discount', '$sub_total','$office_origin','$product_type1')";
	    dbQuery($sql_product);
	}
	
    $result1 =  mysql_query("SELECT * FROM company");
	while($row = mysql_fetch_array($result1)) {
	
	$to  = $row["bemail"];
	$address  = $row["caddress"];
	$namecompany  = $row["cname"];

    // subject

    $subject = 'SHIPPING SENT YOUR DESTINATION | '.$row["cname"].'';
	$from = $row["bemail"];
    // message
	$text_message    = "Hi ".$Receivername." this is our address, <br /><br /> <strong> ".$address." Please consider your environmental responsibility. Before printing this e-mail message, ask yourself whether you really need a hard copy.</strong><br /><br /> IMPORTANT:</strong> The contents of this email and any attachments are confidential. They are intended for the named recipient(s) only. If you have received this email by mistake, please notify the sender immediately and do not disclose the contents to anyone or make copies thereof.";			   	
	
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
						<p style='font-size:16px;'><strong>".$Receivername."</strong>, the Lord <strong>".$Shippername."</strong>, has sent you a package to your address with the following details: </p>
						<hr />
						<p style='font-size:14px;'>Email: <strong> ".$Receiveremail."</strong></p>					
						<p style='font-size:14px;'>Tracking: <strong> ".$ConsignmentNo."</strong></p>
						<p style='font-size:14px;'>Destination: <strong> ".$Pickuptime."</strong></p>
						<p style='font-size:14px;'>Details: <strong> ".$Shiptype."</strong></p>
						<br><br>
						<p style='font-size:14px;'>Tracking Details URL:<a style='background:#eee;color:#333;padding:10px;' href='".$row["website"]."tracking.php' >See shipping</a></p>
						<br>
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
	mail($Receiveremail, $subject, $message, $headers); //This method sends the mail.
 
        
   echo "<script type=\"text/javascript\">
			alert(\"Order number - '$invoice_number' shipping satisfactory to the client, will be notified by mail.\");
			window.location = \"edit-courier.php?cid=$last_id\";
		</script>";			
   
	//echo $Ship;
}//addCons

function addcourier_update(){

	$cid = (int)$_POST['cid'];
	$Shippername = $_POST['Shippername'];
	$Shipperphone = $_POST['Shipperphone'];
	$Shipperaddress = $_POST['Shipperaddress'];
	$Shippercc = $_POST['Shippercc'];
	$Shippercity = $_POST['city'];
	$Shipperstate = $_POST['state'];
	$Shippercountry = $_POST['country'];
	$Shipperzip_code = $_POST['zip_code'];
	
    $Receivername = $_POST['Receivername'];
	 if(!empty($Receivername)){
		$Receivername=$Receivername;
	 }
	
	 $Receivername_select =$_POST['Receivername_select'];
	 if(!empty($Receivername_select) && $Receivername_select > 0){

		 $reciever_name = mysql_fetch_array(mysql_query("SELECT name FROM tbl_clients WHERE id ='$Receivername_select'"));
		 $Receivername=$reciever_name['name'];
	 }
	
	$Receiverphone = $_POST['Receiverphone'];
	$Receiveraddress = $_POST['Receiveraddress'];
	$Receivercc_r = $_POST['Receivercc_r'];
	$Receiveremail = $_POST['Receiveremail'];
	$Receivercity = $_POST['city1'];
	$Receiverstate = $_POST['state1'];
	$Receivercountry = $_POST['country1'];
	$Receicedulanumber = $_POST['cedula_number'];
	
	$ConsignmentNo = $_POST['ConsignmentNo'];
	$Shiptype = $_POST['Shiptype'];
	$Weight = $_POST['Weight'];
	$variable = $_POST['variable'];
	$shipping_subtotal = $_POST['shipping_subtotal'];
	$Invoiceno = $_POST['shipping_number'];
        $office_origin = $_POST['office_origin'];
	$Qnty = $_POST['Qnty'];

	$Bookingmode = $_POST['Bookingmode'];
	$Totalfreight = $_POST['Totalfreight'];
	$Totaldeclarate = $_POST['Totaldeclarate'];
	$Mode = $_POST['Mode'];
	
	$Packupdate = $_POST['Packupdate'];
	$Payment_Due = $_POST['Payment_Due'];
	$Schedule = $_POST['Schedule'];
	$Pickuptime = $_POST['Pickuptime'];
	$status = $_POST['status'];
	$Comments = $_POST['Comments'];
	$officename = $_POST['officename'];
	$container_number_get = $_POST['container_number'];
        $exdata = explode( ',', $container_number_get );
         $container_number =$exdata['0']; 
         $container_id =$exdata['1'];
	
	$grand_total = $_POST['grand_total'];
        $modified_date = date('Y-m-d h:i:s');

	$sql = "UPDATE courier
                       SET cons_no='$ConsignmentNo', ship_name='$Shippername',phone='$Shipperphone',s_add='$Shipperaddress',s_city='$Shippercity',s_state='$Shipperstate',s_country='$Shippercountry',s_zipcode='$Shipperzip_code', cc='$Shippercc', rev_name='$Receivername',r_phone='$Receiverphone',r_add='$Receiveraddress',r_city='$Receivercity',r_state='$Receiverstate',r_country='$Receivercountry', r_cedula_number='$Receicedulanumber', cc_r='$Receivercc_r', email='$Receiveremail', type='$Shiptype', weight='$Weight', variable='$variable', invice_no='$Invoiceno',declarate='$Totaldeclarate', mode ='$Mode', pick_date='$Packupdate' , schedule='$Schedule',pick_time='$Pickuptime',payment_due='$Payment_Due',book_mode='$Bookingmode',freight='$Totalfreight', qty='$Qnty', shipping_subtotal='$grand_total', status='$status', comments='$Comments', modified_by='$officename', modified_date='$modified_date', container_id='$container_id', container_number='$container_number' WHERE cid = '$cid'";	
		
	dbQuery($sql);	
	$old_product = "DELETE FROM `courier_item` WHERE `cid` ='$cid'";
	dbQuery($old_product);
        
	foreach ($_POST['product'] as $value) {
	//  $product_type = $value['product_type'];
	  $product_price = $value['product_price'];
	  $ship_qty = $value['ship_qty'];
	  $discount = $value['discount'];
	  $sub_total = $value['sub_total'];
	  $status = $value['ship_status'];
	  $product_type1 = $value['product_type1'];
          
	  $sql_product = "INSERT INTO courier_item (cid, product_price, ship_qty, discount, sub_total , line_shipping_status, product_name)
			VALUES('$cid', '$product_price', '$ship_qty', '$discount', '$sub_total','$status','$product_type1')";
	    dbQuery($sql_product);
	} 
       
	echo "<script type=\"text/javascript\">
						alert(\"Updates applied successfuly.\");
						window.location = \"admin.php\"
					</script>";

	//echo $Ship;
}//addcourier_update


function shippingcharges(){

    $name_courier = $_POST['name_courier'];
	$services = $_POST['services'];
	$rate = $_POST['rate'];
	$Length = $_POST['Length'];
	$Width = $_POST['Width'];
	$Height	 = $_POST['Height'];
	$Weight = $_POST['Weight'];
	$WeightType = $_POST['WeightType'];

	
	$sql = "INSERT INTO scheduledpickup (name_courier, services, rate, Length, Width, Height, Weight, WeightType)
			VALUES ('$name_courier', '$services', '$rate', '$Length', '$Width', '$Height', '$Weight', '$WeightType')";
	dbQuery($sql);
	echo "<script type=\"text/javascript\">
						alert(\"$name_courier has been added to the Scheduled Pickup.\");
						window.location = \"shipping-charge.php\"
					</script>";	
 
}

function approveCourier(){

   	$cid = (int)$_POST['cid'];
    $sname = $_POST['sname'];
	$sphone = $_POST['sphone'];
	$sadd = $_POST['sadd'];
	$rname = $_POST['rname'];
	$rphone = $_POST['rphone'];
	$radd = $_POST['radd'];
    $weight = $_POST['weight'];
	$freight = $_POST['freight'];
	$Qnty = $_POST['Qnty'];
	$variable = $_POST['variable'];
	$shipping_subtotal = $_POST['shipping_subtotal'];
	$service = $_POST['service'];
	$no = $_POST['no'];
	$office = $_POST['office'];
	$type = $_POST['type'];
	$note = $_POST['note'];
	$status = $_POST['status'];
	$payment = $_POST['payment'];
    $fcity = $_POST['fcity'];
	$tcity = $_POST['tcity'];
    $date = $_POST['bdate'];
    $ddate = $_POST['ddate'];
	$user = $_POST['user'];
	
	$sql = "INSERT INTO courier_online (cons_no, ship_name,s_add,s_phone,r_phone,r_add,type,note,time,status,payment,book_mode,rev_name,weight,date,fromcity, tocity , deliverydate,freight, Qnty, variable, 	shipping_subtotal, office, user)
		VALUES('$no', '$sname','$sadd','$sphone','$rphone','$radd','$type','$note', NOW(),'$status','Pending','$service','$rname','$weight','$date','$fcity','$tcity','$ddate','$freight','$Qnty', 
		'$variable', '$shipping_subtotal', '$office', '$user')";
	dbQuery($sql);
	
	$sql_1 = "UPDATE online_booking SET status='Approved' , tracking='$no' WHERE id='$cid'";
    dbQuery($sql_1);	 
	
	$result1 =  mysql_query("SELECT * FROM company");
	while($row = mysql_fetch_array($result1)) {
	
	$to  = $row["bemail"];
	$address  = $row["caddress"];
	$namecompany  = $row["cname"];

    // subject

    $subject = 'SHIPPING APPROVED | '.$row["cname"].'';
	$from = $row["bemail"];
    // message
	$text_message    = "Hi ".$sname." this is our address, <br /><br /> <strong> ".$address." Please consider your environmental responsibility. Before printing this e-mail message, ask yourself whether you really need a hard copy.</strong><br /><br /> IMPORTANT:</strong> The contents of this email and any attachments are confidential. They are intended for the named recipient(s) only. If you have received this email by mistake, please notify the sender immediately and do not disclose the contents to anyone or make copies thereof.";			   	
	
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
						<p style='font-size:14px;'>Customer Name: <strong>".$sname."</strong></p>
						<hr />
						<p style='font-size:14px;'> Your booking has been approved and ready to ship. Shipping respresentative will be in touch with soon regarding shipping details.</p>
						<p style='font-size:14px;'>You can start tracking your shipment status with this unique Airwaybill no :<strong> ".$no."</strong></p>											
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
	mail($sadd, $subject, $message, $headers); //This method sends the mail.
   
   echo "<script type=\"text/javascript\">
			alert(\"'$_POST[sname]' Shipping approved satisfactorily.\");
			window.location = \"online-bookings.php\"
		</script>";																			


}

function updatecourier() {
	
    $sname = $_POST['sname'];
	$sphone = $_POST['sphone'];
	$sadd = $_POST['sadd'];
	$rname = $_POST['rname'];
	$rphone = $_POST['rphone'];
	$radd = $_POST['radd'];
	$no= $_POST['no'];
    $weight = $_POST['weight'];
	$freight = $_POST['freight'];
	$Qnty = $_POST['Qnty'];
	$variable = $_POST['variable'];
	$shipping_subtotal = $_POST['shipping_subtotal'];
	$mode = $_POST['mode'];
	$type = $_POST['type'];
    $fcity = $_POST['fcity'];
	$tcity = $_POST['tcity'];
	$time = $_POST['btime'];
    $date = $_POST['bdate'];
    $ddate = $_POST['ddate'];
	$status = $_POST['status'];
	$user = $_POST['user'];
	$cid = (int)$_POST['cid'];
	
             $sql_1 = "UPDATE courier_online
                       SET cons_no='$no', ship_name='$sname',s_phone='$sphone',s_add='$sadd', rev_name='$rname',r_phone='$rphone',r_add='$radd',weight='$weight',date='$date',fromcity='$fcity', tocity ='$tcity', deliverydate='$ddate' , time='$time',type='$type',book_mode='$mode',freight='$freight',
					   Qnty='$Qnty', variable='$variable', shipping_subtotal='$shipping_subtotal', status='$status', user='$user'
                       WHERE cid = '$cid'";
					   
	$result1 =  mysql_query("SELECT * FROM company");
	while($row = mysql_fetch_array($result1)) {
	
	$to  = $row["bemail"];
	$address  = $row["caddress"];
	$namecompany  = $row["cname"];

    // subject

    $subject = 'SHIPPING ONLINE BOOKING UPDATE | '.$row["cname"].'';
	$from = $row["bemail"];
    // message
	$text_message    = "Hi ".$sname." this is our address, <br /><br /> <strong> ".$address." Please consider your environmental responsibility. Before printing this e-mail message, ask yourself whether you really need a hard copy.</strong><br /><br /> IMPORTANT:</strong> The contents of this email and any attachments are confidential. They are intended for the named recipient(s) only. If you have received this email by mistake, please notify the sender immediately and do not disclose the contents to anyone or make copies thereof.";			   	
	
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
						<p style='font-size:14px;'>Customer Name: <strong>".$sname."</strong></p>
						<hr />
						<p style='font-size:14px;'> Your shipment was updated and following your shipping State is: <strong> ".$status."</strong></p>											
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
	mail($sadd, $subject, $message, $headers); //This method sends the mail.				   

	         dbQuery($sql_1);
             echo "<script type=\"text/javascript\">
						alert(\"your shipment was updated and following your shipping State is: <strong> ".$status."</strong>\");
                        window.location = \"admin.php\"
					</script>";
}

function updateBooking(){
  	    
	$name = $_POST['name'];
	$cid = (int)$_POST['cid'];
	$reasons = $_POST['reasons'];
	 
	$sql_1 = "UPDATE online_booking SET status='Cancelled',reasons='$reasons' WHERE id='$cid'";
    dbQuery($sql_1);
	$to  = $_POST['email'];	 
	
	$result1 =  mysql_query("SELECT * FROM company");
	while($row = mysql_fetch_array($result1)) {
	
	$to  = $row["bemail"];
	$address  = $row["caddress"];
	$namecompany  = $row["cname"];

    // subject

    $subject = 'SHIPPING CANCELLED | '.$row["cname"].'';
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
						<p style='font-size:14px;'>Your booking has been cancelled, due to :<strong> ".$reasons."</strong></p>
						<p style='font-size:14px;'> Kindly call.<strong> ".$reasons."</strong> for further information.</p>
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
			alert(\"'$_POST[name]' cancelled-online booking.\");
			window.location = \"online-bookings.php\"
		</script>";				
					

}


function updateclient() {
	
	$pwd = $_POST['pwd'];
    $name = $_POST['user'];
	$email = $_POST['email'];
	$add= $_POST['add'];
	$phone = $_POST['phone'];
	$id = $_POST['cid'];

	$sql_1 = "UPDATE tbl_clients
				SET name='$name',password = '$pwd' , phone='$phone', email='$email',address='$add' WHERE id= '$cid'";
	dbQuery($sql_1);
	echo "<script type=\"text/javascript\">
						alert(\"Changes applied successfuly\");
						window.location = \"client?id=$cid\"
					</script>";
}

function changeProfile() {

	$pwd = $_POST['password'];
    $name = $_POST['name'];
	$email = $_POST['email'];
	$add= $_POST['address'];
	$phone = $_POST['phone'];
	$id = $_POST['id'];
	
	$sql_1 = "UPDATE tbl_clients
				SET name='$name',password = '$pwd' , phone='$phone', email='$email',address='$add' WHERE id= '$id'";
	dbQuery($sql_1);
	echo "<script type=\"text/javascript\">
						alert(\"Changes applied successfuly\");
						window.location = \"panel-customer/profile_customer.php\"
					</script>";
}


function markDelivered() {
	$cid = (int)$_GET['cid'];
	$sql = "UPDATE courier SET status = 'Delivered', status_delivered = 'Delivered' WHERE cid= $cid";
	dbQuery($sql);
	
	echo "<script type=\"text/javascript\">
						alert(\"Shipping has changed the State successfully.\");
						window.location = \"admin.php\"
					</script>"; 
	
			
}//markDelivered();


function Deliveredondelivery() {
	
	$cid = (int)$_POST['cid'];
	$dboy = $_POST['deliveryboy'];
	$rby = $_POST['receivedby'];
	$drs = $_POST['drs'];
	
	$sql = "UPDATE courier_online SET status = 'Delivered', deliveryboy='$dboy', receivedby='$rby', drs='$drs' WHERE cid= $cid";
	dbQuery($sql);

	echo "<script type=\"text/javascript\">
						alert(\"Their shipping is has delivered successfully.\");
						window.location = \"admin.php\"
					</script>"; 
			
}//markDeliveredondelivery();



function addNewOffice() {
	
	$OfficeName = $_POST['OfficeName'];
	$OfficeAddress = $_POST['OfficeAddress'];
	$City = $_POST['City'];
	$PhoneNo = $_POST['PhoneNo'];
	$OfficeTiming = $_POST['OfficeTiming'];
	$ContactPerson = $_POST['ContactPerson'];
	
	$sql = "INSERT INTO offices (off_name, address, city, ph_no, office_time, contact_person)
			VALUES ('$OfficeName', '$OfficeAddress', '$City', '$PhoneNo', '$OfficeTiming', '$ContactPerson')";
	dbQuery($sql);
	header('Location: office-add-success.php');
}//addNewOffice

function addNewCustomer() {
	
	$Shippername = $_POST['Shippername'];
	$Shipperaddress = $_POST['Shipperaddress'];
	$Shipperphone = $_POST['Shipperphone'];
	$Shippercc = $_POST['Shippercc'];
	
	$sql = "INSERT INTO customer (Shippername, Shipperaddress, Shipperphone, Shippercc)
			VALUES ('$Shippername', '$Shipperaddress', '$Shipperphone', '$Shippercc')";
	dbQuery($sql);
	header('Location: customer.php');
}//addNewCustomer

function addManager() {
	
	$ManagerName = $_POST['ManagerName'];
	$Password = $_POST['Password'];
	$Address = $_POST['Address'];
	$Email = $_POST['Email'];
	$PhoneNo = $_POST['PhoneNo'];
	$OfficeName = $_POST['OfficeName'];
	
	$sql = "INSERT INTO courier_officers (officer_name, off_pwd, address, email, ph_no, office, reg_date)
			VALUES ('$ManagerName', '$Password', '$Address', '$Email', '$PhoneNo', '$OfficeName', NOW())";
	dbQuery($sql);
	header('Location: manager-add-success.php');

}//addManager

function addManagers() {
	$customer = $_POST['customer'];
	$ManagerName = $_POST['ManagerName'];
	$Password = $_POST['Password'];
	$Address = $_POST['Address'];
	$Email = $_POST['Email'];
	$PhoneNo = $_POST['PhoneNo'];
	$OfficeName = $_POST['OfficeName'];
	
	$sql = "INSERT INTO courier_customer (id_customer,officer_name, off_pwd, address, email, ph_no, office, reg_date)
			VALUES ('$customer', $ManagerName', '$Password', '$Address', '$Email', '$PhoneNo', '$OfficeName', NOW())";
	dbQuery($sql);
	header('Location: manager-add-success.php');

}//addManagers

function updateStatus() {
	
	$pick_time = $_POST['pick_time'];
	$status = $_POST['status'];
	$comments = $_POST['comments'];
	$cid = (int)$_POST['cid'];
	$cons_no = $_POST['cons_no'];
	//$OfficeName = $_POST['OfficeName'];
	
	$sql = "INSERT INTO courier_track (cid, cons_no, pick_time, status, comments, bk_time)
			VALUES ($cid, '$cons_no', '$pick_time', '$status', '$comments', NOW())";
	dbQuery($sql);
	
	$sql_1 = "UPDATE courier SET status='$status', pick_time='$pick_time' WHERE cid = $cid AND cons_no = '$cons_no'";
	dbQuery($sql_1);

	header("Location: edit-courier.php?cid=$cid");

}//updateStatus

function updatePaid() {
	
	$book_mode = $_POST['book_mode'];
	$on_delivery = $_POST['on_delivery'];
	$cid = (int)$_POST['cid'];
	$cons_no = $_POST['cons_no'];
	
	$sql = "INSERT INTO courier_paid (cid, cons_no, book_mode, on_delivery, date)
			VALUES ($cid, '$cons_no', '$book_mode', '$on_delivery', NOW())";
	dbQuery($sql);
	
	$sql_1 = "UPDATE courier SET book_mode = '$book_mode' WHERE cid = $cid AND cons_no = '$cons_no'";
	dbQuery($sql_1);

	header('Location: admin-on-delivery.php');

}//updatePaid

function changePass() {

	$pwd = $_POST['pwd'];
	$cid = $_POST['cid'];

	$sql_1 = "UPDATE manager_user SET pwd = '$pwd'	WHERE cid= '$cid'";
		dbQuery($sql_1);

	echo "<script type=\"text/javascript\">
				alert(\"Changes applied successfuly\");
				window.location = \"preferences_user.php\"
		  </script>";

}
function changeCompany() {

	$cname = $_POST['cname'];
	$cemail = $_POST['cemail'];
	$bemail = $_POST['bemail'];
	$cphone = $_POST['cphone'];
	$caddress = $_POST['caddress'];
	$website = $_POST['website'];
	$nit = $_POST['nit'];
	$country = $_POST['country'];
	$city = $_POST['city'];
	$currency = $_POST['currency'];
	$date = $_POST['date'];
	$footer_website = $_POST['footer_website'];

	$sql_2 = "UPDATE company SET cname='$cname', nit='$nit', cemail='$cemail', cphone='$cphone', caddress='$caddress', country='$country', 
	city='$city', website='$website', footer_website='$footer_website', currency='$currency', bemail='$bemail', date='$date' ";
	dbQuery($sql_2);

	echo "<script type=\"text/javascript\">
			alert(\"Changes applied successfuly\");
			window.location = \"preferences.php\"
		</script>";		
	

}


function logOut(){
	if(isset($_SESSION['user_name'])){
		unset($_SESSION['user_name']);
	}
	if(isset($_SESSION['user_type'])){
		unset($_SESSION['user_type']);
	}
	if(isset($_SESSION['user_customer'])){
		unset($_SESSION['user_customer']);
	}
	session_destroy();
	header('Location: ../login.php');
}//logOut

function addpay(){
	$username =$_SESSION['user_name'];
    $cid = $_POST['cid'];
    $date = date('Y-m-d h:i:s', strtotime($_POST['date']));
    $data = $_POST['payment_note'];
    $amount = $_POST['amount'];
    $search_param = $_POST['search_param'];
    $paying_by = $_POST['paying'];
    $sql = "INSERT INTO courier_payment (courier_id ,date, amount, paying_by,note,username)
                    VALUES('$cid', '$date', '$amount','$paying_by','$data','$username')";
    dbQuery($sql);
    $amount = mysql_query("SELECT sum(amount) FROM `courier_payment` WHERE courier_id = '$cid'");
    $paid_amount = mysql_fetch_array($amount);
    $payment = $paid_amount['sum(amount)'];
                if (!empty($payment)) {
                    $paid = $payment;
                } else {
                    $paid = 0;
                }
    $balance = mysql_query("SELECT shipping_subtotal FROM `courier` WHERE cid = '$cid'");
    $balance = mysql_fetch_array($balance);
    $order_balance = $balance['shipping_subtotal'];
    $rem_balance = $order_balance - $paid;
                if ($rem_balance < 1) {
                    $status = 'Paid';
                } else {
                    $status = 'Partial';
                }
    $sql = "UPDATE courier SET paid_amount='$paid', order_balance='$rem_balance', book_mode = '$status' WHERE cid = '$cid'";
    dbQuery($sql);

            if($search_param == 1){
             echo json_encode(true);
             } else {

           echo "<script type=\"text/javascript\">
    			window.location = \"admin.php\"
    		</script>";
           }
   /* $data= $_SESSION['user_name'];
    $cid      = $_POST['cid'];
    $date      = date('Y-m-d h:i:s', strtotime($_POST['date']));
    $amount    = $_POST['amount'];
    $paying_by =    $_POST['paying_by'];
    $sql = "INSERT INTO courier_payment (courier_id ,date, amount, paying_by,username)
		VALUES('$cid', '$date', '$amount','$paying_by','$data')";
		
	dbQuery($sql);
        $amount = mysql_query("SELECT sum(amount) FROM `courier_payment` WHERE courier_id = '$cid'");
        $paid_amount = mysql_fetch_array($amount);
        $payment = $paid_amount['sum(amount)'];
        if(!empty($payment)){
            $paid = $payment;
        }
        else{
           $paid = 0; 
        }
        $balance = mysql_query("SELECT shipping_subtotal FROM `courier` WHERE cid = '$cid'");
        $balance = mysql_fetch_array($balance);
        $order_balance = $balance['shipping_subtotal'];
        $rem_balance = $order_balance - $paid;   
        if($rem_balance < 1){
            $status = 'Paid';
        }else{
            $status = 'Partial';
        }
        $sql = "UPDATE courier SET paid_amount='$paid', order_balance='$rem_balance', book_mode = '$status' WHERE cid = '$cid'";
        dbQuery($sql);
        

        echo "<script type=\"text/javascript\">
			window.location = \"admin.php\"
		</script>"; */
}

function addpay2(){
    $data= $_SESSION['user_name'];
    $cid      = $_POST['cid'];
    $date      = date('Y-m-d h:i:s', strtotime($_POST['date']));
    $amount    = $_POST['amount'];
    $paying_by =    $_POST['paying_by'];
    $sql = "INSERT INTO courier_payment (courier_id ,date, amount, paying_by,username)
		VALUES('$cid', '$date', '$amount','$paying_by','$data')";
		if($sql==1){
			echo "Thanks you for Amount-". $amount. "Submitted";

		}
    
	dbQuery($sql);
        $amount = mysql_query("SELECT sum(amount) FROM `courier_payment` WHERE courier_id = '$cid'");
        $paid_amount = mysql_fetch_array($amount);
        $payment = $paid_amount['sum(amount)'];
        if(!empty($payment)){
            $paid = $payment;
        }
        else{
           $paid = 0; 
        }
        $balance = mysql_query("SELECT shipping_subtotal FROM `courier` WHERE cid = '$cid'");
        $balance = mysql_fetch_array($balance);
        $order_balance = $balance['shipping_subtotal'];
        $rem_balance = $order_balance - $paid;   
        if($rem_balance < 1){
            $status = 'Paid';
        }else{
            $status = 'Partial';
        }
        $sql = "UPDATE courier SET paid_amount='$paid', order_balance='$rem_balance', book_mode = '$status' WHERE cid = '$cid'";
        dbQuery($sql);
        echo "<script type=\"text/javascript\">
			window.location = \"edit-courier.php?cid=$cid\"
		</script>";
}

?>