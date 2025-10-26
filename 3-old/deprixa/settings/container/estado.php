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
$id = $_POST['id'];
// recuperamos el estado del usuario hacemos una consulta SQL
$q = "SELECT container_status FROM courier_container WHERE container_id='$id'";
// asignamos a una variable la consulta devuelta por el método query
$resultado = $con->query($q);
// camvertimos en array la consulta utilizando el método fetch_assoc
$estado = $resultado->fetch_assoc();
// verificamos si esta activo o inactivo
if($estado['container_status'] == '1'){
	// Cambiamos el estado a inactivo
	$q = "UPDATE courier_container SET container_status='0' WHERE container_id='$id'";
}
else{
	// Cambiamos el estado a activo
	$q = "UPDATE courier_container SET container_status='1' WHERE container_id='$id'";
}
// pasamos la consulta según el resultado de la verificación
$con->query($q);
// retornamos un mensaje de confirmación
echo json_encode(array('msg' => 'ok'));

?>