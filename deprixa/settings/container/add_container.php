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
//$id = $_POST['id'];
// recuperamos y asignamos a variables los campos enviados por ajax metodo POST

 	$Containernumber = $_POST['Containernumber'];
	$Containerdescription = $_POST['Containerdescription'];
    $Containerdate   =  date('Y-m-d', strtotime($_POST['containerdate']));
	$note = $_POST['notes'];
	$status = $_POST['estado'];
// verificamos si esta marcado el check box activo
if(isset($_POST['estado']))
$estado = $_POST['estado'];
else
$estado = 1;
$consulta1= "UPDATE courier_container SET container_status = '0' WHERE container_status = '1' ";
$con->query($consulta1); 

// Cotroles Basicos, evitar campos vacios
if(empty($Containernumber)){
	echo json_encode(array('msg' => 'nomvacio')); //retornamos mensaje de error
	exit(); // salimos de la ejecución
}
elseif(empty($Containerdescription)){
	echo json_encode(array('msg' => 'apevacio'));
	exit();
}
elseif(empty($Containerdate)){
	echo json_encode(array('msg' => 'containerdate'));
	exit();
}
elseif(empty($note)){
	echo json_encode(array('msg' => 'telvacio'));
	exit();
}




// insertamos en la base de datos - hacemos una consulta SQL
$consulta = "INSERT INTO courier_container (container_number,container_description,container_date,container_notes,container_status) VALUES('$Containernumber','$Containerdescription','$Containerdate','$note','$estado')";
$con->query($consulta); // enviamos la consulta al método query
// retornamos un mensaje de confirmación
echo json_encode(array('msg' => 'ok'));

?>
