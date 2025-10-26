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
$zone_name = $_POST['zone_name'];
$description = $_POST['description'];
$country   =  $_POST['country'];

$state = implode(',', $_POST['state']);

$city = implode(',', $_POST['city']);

$created_date = date('Y-m-d');
//$status = $_POST['estado'];
//// verificamos si esta marcado el check box activo
//if(isset($_POST['estado']))
//$estado = $_POST['estado'];
//else
//$estado = 1;

//$zone= "UPDATE zone SET zone_status = '0' WHERE zone_status = '1' ";
//$con->query($zone); 

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
	echo json_encode(array('msg' => 'country'));
	exit();
}
elseif(empty($state)){
	echo json_encode(array('msg' => 'telvacio'));
	exit();
}
elseif(empty($city)){
    echo json_encode(array('msg' => 'city'));
	exit();
}

// insertamos en la base de datos - hacemos una consulta SQL
$zone = "INSERT INTO zone (name, description, country, zone_status, created_date) VALUES('$zone_name','$description','$country', '0', '$created_date')";
#$con->query($zone); // enviamos la consulta al método query
if($con->query($zone)){
    $zoneId = $con->query("SELECT max(id) as id  FROM zone ORDER BY id DESC");
    $row=$zoneId->fetch_assoc();
    $zone_id = $row['id'];
    $states = explode(',', $state);
    $citys = explode(',', $city);
    $createdDate = date('Y-m-d');
    $country = $_POST['country'];
    foreach($_POST['state'] as $srow){
        $sres = "INSERT INTO zone_state (zone_id, country_id, state_id, created_date) VALUES('$zone_id', '$country', '$srow', '$createdDate')";
        if($con->query($sres)){
            $zonestatId = $con->query("SELECT max(id) as id  FROM zone_state ORDER BY id DESC");
            $zsrow=$zonestatId->fetch_assoc();
            foreach($_POST['city'] as $crow){
                    $cres = "INSERT INTO zone_city (zone_id, country_id, state_id, city_id, created_date) VALUES('$zone_id', '$country', '$srow', '$crow',  '$createdDate')";
                $con->query($cres);
            }
        }
    }
}
// retornamos un mensaje de confirmación
echo json_encode(array('msg' => 'ok'));

?>
