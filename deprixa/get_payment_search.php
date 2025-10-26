<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    session_start();
    require_once('database.php');
    $username =$_SESSION['user_name'];
    $cid = $_POST['cid'];
    $date = date('Y-m-d h:i:s', strtotime($_POST['date']));
    $data = $_POST['payment_note'];
    $amount = $_POST['amount'];
    $search_param = $_POST['search_param'];
    $paying_by = $_POST['paying'];
    $sql = "INSERT INTO courier_payment (courier_id ,date, amount, paying_by,note,username)
                    VALUES('$cid', '$date', '$amount','$paying_by','$data','$username')";
    dbQuery($sql);
    $amount = mysql_query("SELECT sum(amount) FROM `courier_payment` WHERE courier_id = '$cid'");
    $paid_amount = mysql_fetch_array($amount);
    $payment = $paid_amount['sum(amount)'];
                if (!empty($payment)) {
                    $paid = $payment;
                } else {
                    $paid = 0;
                }
    $balance = mysql_query("SELECT shipping_subtotal FROM `courier` WHERE cid = '$cid'");
    $balance = mysql_fetch_array($balance);
    $order_balance = $balance['shipping_subtotal'];
    $rem_balance = $order_balance - $paid;
                if ($rem_balance < 1) {
                    $status = 'Paid';
                } else {
                    $status = 'Partial';
                }
    $sql = "UPDATE courier SET paid_amount='$paid', order_balance='$rem_balance', book_mode = '$status' WHERE cid = '$cid'";
    dbQuery($sql);

            if($search_param == 1){
             echo json_encode(true);
             } else {

           echo "<script type=\"text/javascript\">
    			window.location = \"admin.php\"
    		</script>";
           }