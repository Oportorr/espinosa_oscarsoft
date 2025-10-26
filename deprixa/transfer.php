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

error_reporting(E_ERROR | E_WARNING | E_PARSE);


include('database.php');
// asignamos la funciÃ³n de conexion a una variable
//$id = $_POST['cid'];
$f_id = $_POST['f_id'];
$t_id = $_POST['t_id'];
$container_id = $_POST['container_id'];
$order_id = $_POST['order_id'];
$line_item1 = $_POST['line_item'];
$line_item = $line_item1 - 1;

$stmt1 = mysql_query("SELECT * FROM courier_item WHERE cid ='$order_id' LIMIT 1 OFFSET $line_item");
$row = mysql_fetch_row($stmt1);
$item_result = mysql_num_rows($stmt1);

if($item_result > 0){
$item_id = $row[0];
$product_id = $row[2];

// for insert line_shipping_status
$select_id = mysql_query("SELECT * FROM offices  WHERE id = '$t_id'");
$select_res = mysql_fetch_row($select_id);
$select_res_id = $select_res[8];

$sql = mysql_query("SELECT * FROM transfer WHERE from_location_id = '$f_id' AND to_location_id = '$t_id' AND cid = '$order_id' AND courier_item_id = '$item_id'");
$result = mysql_num_rows($sql);

}else{
    $result = 1;
}

if ($result < 1) {

    mysql_query("INSERT INTO transfer(cid, courier_item_id, product_id, from_location_id, to_location_id, container_id) VALUES ('$order_id','$item_id','$product_id','$f_id','$t_id','$container_id')");

   mysql_query("UPDATE courier_item SET line_shipping_status = '$t_id' WHERE courier_item_id = '$item_id' ");
 
    
    mysql_query("UPDATE transfer SET line_shipping_status_id = '$select_res_id' WHERE courier_item_id = '$item_id' ");
    echo json_encode(array("msg" => "ok"));
    
} else {
    echo json_encode(array("msg" => "err"));
   
}
die();
?>
