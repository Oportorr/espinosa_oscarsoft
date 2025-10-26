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


include('database-settings.php');
// asignamos la función de conexion a una variable
$con = conexion();
// realizamos la consulta SQL para recuperar todos los registros de la tabla

//$sql = "SELECT t.cid , ts.name , ci.product_name , ci.ship_qty , c.container_number AS c_container_number, cc.container_number AS t_container_number  FROM transfer t LEFT JOIN courier_item ci ON t.courier_item_id = ci.courier_item_id LEFT JOIN type_shipments ts  ON (ci.product_type = ts.id) LEFT JOIN courier c ON ci.cid = c.cid LEFT JOIN courier_container cc ON t.container_id = cc.container_id";

$sql = "SELECT t.cid, ci.product_name , ci.ship_qty , c.container_number AS c_container_number, cc.container_number AS t_container_number  FROM transfer t LEFT JOIN courier_item ci ON t.courier_item_id = ci.courier_item_id LEFT JOIN courier c ON ci.cid = c.cid LEFT JOIN courier_container cc ON t.container_id = cc.container_id";

$resultado = $con->query($sql);
// creamo una variable del tipo array la cual almacena todos los registros
$datos = array();
// iteramos todos los registros devueltos y llenamos el array
while ($row = $resultado->fetch_assoc()) {
    $datos[] = $row;
}

// convertimos el array al formato json y mostramos para que el Plugin Data Tables pueda formatera la información
echo json_encode($datos);
?>