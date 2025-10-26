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

    if(isset($_POST["cid"])){
	$cid=$_POST["cid"];
    }
    $json=array();
    require_once('database.php');
    $result = mysql_query("SELECT  shipping_subtotal, paid_amount From courier  WHERE cid='$cid'");
    $row = mysql_fetch_array($result);
    $balance_amount = $row['shipping_subtotal'] - $row['paid_amount'];
    $json['balance_amount'] = $balance_amount;
    echo json_encode($json); 
?>