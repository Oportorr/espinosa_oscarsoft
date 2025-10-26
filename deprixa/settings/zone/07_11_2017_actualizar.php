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
$zone_name = $_POST['zone_name'];
$description = $_POST['description'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];
// $container_status = $_POST['container_status'];
// verificamos si esta marcado el check box activo
//if(isset($_POST['container_status']))
//$estado = $_POST['container_status'];
//else
//$estado = 0;


// Cotroles Basicos, evitar campos vacios
if(empty($zone_name)){
	echo json_encode(array('msg' => 'nomvacio')); //retornamos mensaje de error
	exit(); // salimos de la ejecución
}
elseif(empty($description)){
	echo json_encode(array('msg' => 'apevacio'));
	exit();
}
elseif(empty($country)){
	echo json_encode(array('msg' => 'containerdate')); //retornamos mensaje de error
	exit(); // salimos de la ejecución
}
elseif(empty($state)){
	echo json_encode(array('msg' => 'telvacio'));
	exit();
}
elseif(empty($city)){
	echo json_encode(array('msg' => 'city'));
	exit();
} else{	
        $consulta = "UPDATE zone SET name='$zone_name', description='$description', country='$country', state='$state', city='$city' WHERE id='$id'";	
	

}

// enviamos la consulta al método query
$con->query($consulta);
// retornamos un mensaje de confirmación
echo json_encode(array('msg' => 'ok'));

?>