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
// eliminamos de la tabla hacemos una consulta SQL
$q = "DELETE FROM zone WHERE id=$id";
// enviamos la consulta al método query
if($con->query($q)){
    $con->query("DELETE FROM zone_state WHERE zone_id=$id");
    $con->query("DELETE FROM zone_city WHERE zone_id=$id");
}
// retornamos un mensaje de confirmación
echo json_encode(array('msg' => 'ok'));

?>