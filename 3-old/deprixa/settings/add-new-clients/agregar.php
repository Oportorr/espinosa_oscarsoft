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

require_once('../../database.php');

$result4 = mysql_query("SELECT bemail FROM company WHERE  id='1' ");
while($rr = mysql_fetch_array($result4)) {
   $bemail = $rr['bemail'];
}

	$name = $_POST['name'];
	$company = $_POST['company'];
	$email = (!empty($_POST['email'])) ? $_POST['email']  : $bemail ;
	$phone = $_POST['phone'];
	$address=$_POST['address'];
	$country = $_POST['country'];
	$state = $_POST['state'];
	$zipcode = $_POST['zipcode'];
	$password = $_POST['password'];
	$city = $_POST['city'];
	
	// verificamos si esta marcado el check box activo
	if(isset($_POST['estado']))
	$estado = $_POST['estado'];
	else
	$estado = 0;

	$sql1 =mysql_query("SELECT email FROM tbl_clients WHERE email='$email' AND name='$name'");
			if($row=mysql_fetch_array($sql1)){							
				 echo "<script type=\"text/javascript\">
						alert(\"The email $email already is are registered in the database, by Please enter data different, thank you.\");
						window.location = \"../../customer.php\";
					</script>"; 							
			}else{
				$sql1="INSERT INTO tbl_clients (name, address,email, phone, password, company, country, state, city, zipcode, estado,date) VALUES 	
				('$name','$address', '$email', '$phone', '$password', '$company', '$country', '$state', '$city', '$zipcode',  '$estado',curdate())";
			}
	dbQuery($sql1);
	
	echo "<script type=\"text/javascript\">
						alert(\"Thank you very much for registering.\");
						window.location = \"../../customer.php\";
					</script>"; 




// insertamos en la base de datos - hacemos una consulta SQL
$consulta = "INSERT INTO tbl_clients (name, password, address, email, phone, estado)
			VALUES ('$name','$password', '$address', '$email', '$phone', '$estado')";
$con->query($consulta); // enviamos la consulta al método query
// retornamos un mensaje de confirmación
echo json_encode(array('msg' => 'ok'));

?>