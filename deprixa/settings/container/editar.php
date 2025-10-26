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
// recuperamos el id del usuario enviado por ajax
$id = $_POST['container_id'];
// recuperamos los datos del usuario hacemos una consulta SQL
$q = "SELECT * FROM courier_container WHERE container_id=$id";
// enviamos la consulta al método query
$result = $con->query($q);
// creamos una variable del tipo array la cual almacena todos los datos del usuario
$datos = array();
while ($row=$result->fetch_assoc()) {
	
    $datos[]=$row; 
}

// convertimos el array al formato json y mostramos
echo json_encode($datos);

?>