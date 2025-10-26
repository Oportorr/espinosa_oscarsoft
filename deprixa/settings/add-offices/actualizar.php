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
$off_name = $_POST['off_name'];
$address = $_POST['address'];
$city = $_POST['city'];
$ph_no = $_POST['ph_no'];
$office_time = $_POST['office_time'];
$contact_person = $_POST['contact_person'];
$status = $_POST['ship_status'];
// verificamos si esta marcado el check box activo

if (!isset($_POST['head_office'])) {
    $head_office = 0;
} else {
    if ($_POST['hid_head_office'] == $_POST['head_office']) {
        $head_office = $_POST['head_office'];                
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
}
if (isset($_POST['estado']))
{    $estado = $_POST['estado'];
} else{
    $estado = 0;
}

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
} else {
    // verificamos si esta cambiando el password
    if (empty($password)) // actualizamos la información del off_name hacemos una consulta SQL
        $consulta = "UPDATE offices SET  default_origin ='$head_office', off_name='$off_name', address='$address', city='$city', ph_no='$ph_no', office_time='$office_time', contact_person='$contact_person', estado='$estado', line_shipping_status_id='$status'  WHERE id='$id'";
    else {
        $password = md5($password); // encriptamos la nueva contraseña
        $consulta = "UPDATE offices SET default_origin ='$head_office', off_name='$off_name', address='$address', city='$city', ph_no='$ph_no', office_time='$office_time', contact_person='$contact_person', estado='$estado', line_shipping_status_id='$status'  WHERE id='$id'";
    }
}

// enviamos la consulta al método query
$con->query($consulta);
// retornamos un mensaje de confirmación
echo json_encode(array('msg' => 'ok'));
?>