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
  
  $sql = "SELECT z.*, c.country_name FROM zone as z 
            LEFT JOIN country as c ON c.country_id = z.country";
  #echo $sql; die;
  // realizamos la consulta SQL para recuperar todos los registros de la tabla
  $resultado = $con->query($sql);
  // creamo una variable del tipo array la cual almacena todos los registros
  $datos = array();
  // iteramos todos los registros devueltos y llenamos el array
  while ($row = $resultado->fetch_assoc()){
     $datos[] = $row;
   
  }

  // convertimos el array al formato json y mostramos para que el Plugin Data Tables pueda formatera la información
  echo json_encode($datos);
  
?>