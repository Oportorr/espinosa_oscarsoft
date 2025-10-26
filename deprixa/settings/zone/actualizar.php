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
$zone_name = $_POST['name'];
$description = $_POST['description'];
$country = $_POST['country'];

$state = $_POST['state'];
$city = $_POST['city'];

$estado = $_POST['estado'];
if(isset($estado)){
    $estado = 1;
}else{
    $estado = 0;
}
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
        $consulta = "UPDATE zone SET name='$zone_name', description='$description', country='$country', zone_status='$estado' WHERE id='$id'";	
	

}

// enviamos la consulta al método query
if($con->query($consulta)){
    $createdDate = date('Y-m-d');
    $con->query("DELETE FROM zone_state WHERE zone_id = '$id'");
    foreach($_POST['state'] as $srow){
        $sres = "INSERT INTO zone_state (zone_id, state_id, created_date) VALUES('$id', '$srow', '$createdDate')";
        $con->query($sres);
    }
    $con->query("DELETE FROM zone_city WHERE zone_id = '$id'");
    foreach($_POST['city'] as $crow){
        $cres = "INSERT INTO zone_city (zone_id, city_id, created_date) VALUES('$id', '$crow',  '$createdDate')";
        $con->query($cres);
    }
}
// retornamos un mensaje de confirmación
echo json_encode(array('msg' => 'ok'));

?>