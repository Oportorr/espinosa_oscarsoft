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

include('../../database-settings.php');
// asignamos la función de conexion a una variable
$con = conexion();
// recuperamos el id del off_name enviado por ajax
$id = $_POST['id'];
// recuperamos y asignamos a variables los campos enviados por ajax metodo POST
$name = $_POST['name'];
$packaging = $_POST['packaging'];
$dimensions = $_POST['dimensions'];
$price=$_POST['price'];
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
elseif(empty($packaging)){
	echo json_encode(array('msg' => 'apevacio'));
	exit();
}
elseif(empty($dimensions)){
	echo json_encode(array('msg' => 'telvacio'));
	exit();
}
elseif(empty($price)){
	echo json_encode(array('msg' => 'priceval'));
	exit();
}

else{	
	// verificamos si esta cambiando el password
	if(empty($password)) // actualizamos la información del off_name hacemos una consulta SQL
	$consulta = "UPDATE type_shipments SET name='$name', packaging='$packaging', dimensions='$dimensions', estado='$estado', price='$price' WHERE id='$id'";
	else{
	$password = md5($password); // encriptamos la nueva contraseña
	$consulta = "UPDATE type_shipments SET name='$name', packaging='$packaging', dimensions='$dimensions', estado='$estado', price='$price' WHERE id='$id'";	
	}

}

// enviamos la consulta al método query
$con->query($consulta);
// retornamos un mensaje de confirmación
echo json_encode(array('msg' => 'ok'));

?>