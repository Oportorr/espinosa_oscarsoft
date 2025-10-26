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
$id = $_POST['container_id'];
// recuperamos y asignamos a variables los campos enviados por ajax metodo POST
$container_number = $_POST['container_number'];
$container_description = $_POST['container_description'];

$container_date = date('Y-m-d', strtotime($_POST['container_date']));
$container_notes = $_POST['container_notes'];
// $container_status = $_POST['container_status'];
// verificamos si esta marcado el check box activo
//if(isset($_POST['container_status']))
//$estado = $_POST['container_status'];
//else
//$estado = 0;


// Cotroles Basicos, evitar campos vacios
if(empty($container_number)){
	echo json_encode(array('msg' => 'nomvacio')); //retornamos mensaje de error
	exit(); // salimos de la ejecución
}
elseif(empty($container_description)){
	echo json_encode(array('msg' => 'apevacio'));
	exit();
}
elseif(empty($container_date)){
	echo json_encode(array('msg' => 'containerdate')); //retornamos mensaje de error
	exit(); // salimos de la ejecución
}
elseif(empty($container_notes)){
	echo json_encode(array('msg' => 'telvacio'));
	exit();
}


else{	

	
	
	$consulta = "UPDATE courier_container SET container_number='$container_number', container_description='$container_description', container_date='$container_date', container_notes='$container_notes' WHERE container_id='$id'";	
	

}

// enviamos la consulta al método query
$con->query($consulta);
// retornamos un mensaje de confirmación
echo json_encode(array('msg' => 'ok'));

?>