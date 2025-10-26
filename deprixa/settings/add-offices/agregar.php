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

// recuperamos y asignamos a variables los campos enviados por ajax metodo POST
$off_name = $_POST['off_name'];
$address = $_POST['address'];

if (!isset($_POST['head_office'])) {
    $head_office = 0;
} else {
    $head_office = $_POST['head_office'];
    $sql_head = "SELECT id FROM offices WHERE default_origin = '1' AND estado = '1' ";
    $rows = $con->query($sql_head);
    $result = $rows->fetch_assoc();
    if (count($result) > 0) {
        echo json_encode(array('msg' => 'defaultorigin'));
        exit();
    }
}

$city = $_POST['city'];
$ph_no = $_POST['ph_no'];
$office_time = $_POST['office_time'];
$contact_person = $_POST['contact_person'];
 $status = $_POST['ship_status'];
// verificamos si esta marcado el check box activo
if (isset($_POST['estado']))
    $estado = $_POST['estado'];
else
    $estado = 0;


// Cotroles Basicos, evitar campos vacios
if (empty($off_name)) {
    echo json_encode(array('msg' => 'nomvacio')); //retornamos mensaje de error
    exit(); // salimos de la ejecución
} elseif (empty($address)) {
    echo json_encode(array('msg' => 'apevacio'));
    exit();
} elseif (empty($city)) {
    echo json_encode(array('msg' => 'telvacio'));
    exit();
} elseif (empty($ph_no)) {
    echo json_encode(array('msg' => 'emavacio'));
    exit();
} elseif (empty($office_time)) {
    echo json_encode(array('msg' => 'usuvacio'));
    exit();
} elseif (empty($contact_person)) {
    echo json_encode(array('msg' => 'pasvacio'));
    exit();
}




// insertamos en la base de datos - hacemos una consulta SQL
$consulta = "INSERT INTO offices (default_origin, off_name,address,city,ph_no,office_time,contact_person,estado,line_shipping_status_id) VALUES('$head_office','$off_name','$address','$city','$ph_no','$office_time','$contact_person', '$estado','$status')";
$con->query($consulta); // enviamos la consulta al método query
// retornamos un mensaje de confirmación
echo json_encode(array('msg' => 'ok'));
?>