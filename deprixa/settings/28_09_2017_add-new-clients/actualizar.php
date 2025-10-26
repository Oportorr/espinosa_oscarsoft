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
 

include('../../database-settings.php');

$con = conexion();

$rs = "SELECT bemail FROM company WHERE  id='1' ";
$rs1 = $con->query($rs);
while($rr = $rs1->fetch_array())
{
 $bemail = $rr['bemail'];
}


// asignamos la función de conexion a una variable
// recuperamos el cid del off_name enviado por ajax
$id = $_POST['id'];
// recuperamos y asignamos a variables los campos enviados por ajax metodo POST
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = (!empty($_POST['email'])) ? $_POST['email']  : $bemail ;
$password = $_POST['password'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];
$zipcode = $_POST['zipcode'];
// verificamos si esta marcado el check box activo
if(isset($_POST['estado']))
$estado = $_POST['estado'];
else
$estado = 0;


// Cotroles Basicos, evitar campos vacios
if(empty($name)){
	echo json_encode(array('msg' => 'nomvacio')); //retornamos mensaje de error
	exit(); // salimos de la ejecución
}
elseif(empty($address)){
	echo json_encode(array('msg' => 'telvacio'));
	exit();
}
elseif(empty($phone)){
	echo json_encode(array('msg' => 'usuvacio'));
	exit();
}
//elseif(empty($email)){
//	echo json_encode(array('msg' => 'emavacio'));
//	exit();
//}
//elseif(empty($password)){
//	echo json_encode(array('msg' => 'apevacio'));
//	exit();
// }

else{	
	// verificamos si esta cambiando el password
	//if(empty($password)) // actualizamos la información del off_name hacemos una consulta SQL
	//$consulta = "UPDATE tbl_clients SET name='$name',  address='$address', email='$email', phone='$phone', password='$password', estado='$estado' WHERE id='$id'";
	//else{
	//$consulta = "UPDATE tbl_clients SET name='$name',  address='$address', email='$email', phone='$phone', password='$password', estado='$estado' WHERE id='$id'";	
	//}
	$consulta = "UPDATE tbl_clients SET name='$name',  address='$address', email='$email', phone='$phone', password='$password', country='$country', state='$state', city='$city', zipcode='$zipcode', estado='$estado' WHERE id='$id'";
  }

// enviamos la consulta al método query
$con->query($consulta);
// retornamos un mensaje de confirmación
echo json_encode(array('msg' => 'ok'));

?>