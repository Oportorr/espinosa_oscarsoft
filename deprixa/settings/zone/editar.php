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
$id = $_POST['zone_id'];
// recuperamos los datos del usuario hacemos una consulta SQL
$q = "SELECT * FROM zone WHERE id=$id";
// enviamos la consulta al método query
$result = $con->query($q);
// creamos una variable del tipo array la cual almacena todos los datos del usuario
$datos = $stateSel = array();
$stateopt = $cityopt = $sselected = $state_id = '';

while ($row = $result->fetch_assoc()) {
    $zone = $row['name'];
    $description = $row['description'];
    $country = $row['country'];
    $zone_status = $row['zone_status'];
    $country_id = $row['country'];
    $zone_id = $row['id'];
    #selected cities
    $cresstmt = $con->query("SELECT city_id FROM zone_city WHERE zone_id = $zone_id ");
    while ($cresrow = $cresstmt->fetch_assoc()) {
        $citySel[] = $cresrow['city_id'];
    }
    #selected state
    $resstmt = $con->query("SELECT state_id FROM zone_state WHERE zone_id = $zone_id ");
    while ($resrow = $resstmt->fetch_assoc()) {
        $state_id = $resrow['state_id'];
        $stateSel[] = $resrow['state_id'];
        #city all
        $cityAll = $con->query("SELECT city_id, city_name FROM city WHERE state_id = $state_id ");

        while ($cityrow = $cityAll->fetch_assoc()) {
             $cselected = '';
            if (in_array($cityrow['city_id'], $citySel)) {
                $cselected = 'selected';
            }
            $cityopt .= '<option value="' . $cityrow['city_id'] . '" '.$cselected.'>' . $cityrow['city_name'] . '</option>';
        }
    }
    $stmt = $con->query("SELECT state_id, state_name FROM state WHERE country_id = $country_id ");
    while ($srow = $stmt->fetch_assoc()) {
        $sselected = '';
        if (in_array($srow['state_id'], $stateSel)) {
            $sselected = 'selected';
        }

        $stateopt .= '<option value="' . $srow['state_id'] . '" ' . $sselected . ' >' . $srow['state_name'] . '</option>';
    }
    
    
}
echo $stateopt . '###' . $cityopt . '###' . $zone . '###' . $description . '###' . $country.'###'.$id.'###'.$zone_status;
#
#print_r($datos); die;
// convertimos el array al formato json y mostramos
#echo json_encode($datos);
?>