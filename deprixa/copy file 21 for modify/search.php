
<?php
// *************************************************************************
// *                                                                       *
// * DEPRIXA -  logistics Worldwide Software                               *
// * Copyright (c) JAOMWEB. All Rights Reserved                            *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: osorio2380@yahoo.es                                            *
// * Website: http://www.jaom.info                                         *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// * If you Purchased from Codecanyon, Please read the full License from   *
// * here- http://codecanyon.net/licenses/standard                         *
// *                                                                       *
// *************************************************************************
 
include('database.php');

// recuperamos el id del usuario enviado por ajax
$order_id = $_POST['order_id'];
$phone = $_POST['phone'];
$sender_name = $_POST['Sender_name'];
$receiver_name = $_POST['receiver_name'];
$search = "";
if(!empty($order_id)) {
    $search .= " AND  c.invoice_number = '$order_id' ";
}
if(!empty($phone)) {
    $search .= " AND  c.phone = '$phone' ";
}
if(!empty($sender_name)) {
    $search .= " AND  c.ship_name LIKE '%$sender_name%' ";
}
if(!empty($receiver_name)) {
    $search .= " AND  c.rev_name LIKE '%$receiver_name%' ";
}

// recuperamos los datos del usuario hacemos una consulta SQL
$sql = "SELECT c.cid, c.ship_name, ts.name, ci.product_name, ci.ship_qty, (c.shipping_subtotal - c.paid_amount) as balance, o.off_name  FROM  `courier_item` ci 
       LEFT JOIN type_shipments ts ON (ci.product_type = ts.id) 
       LEFT JOIN offices o ON (ci.line_shipping_status = o.id) 
       LEFT JOIN courier c ON (ci.cid = c.cid) 
       WHERE c.cid > 0 $search ";
//echo $sql;
// enviamos la consulta al método query
$result = mysql_query($sql);
// creamos una variable del tipo array la cual almacena todos los datos del usuario
$datos = array();
while ($row = mysql_fetch_assoc($result)) {
	$datos[]=$row; 
}
// convertimos el array al formato json y mostramos
echo json_encode($datos);

?>