<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require_once('database.php');
require_once('library.php');
isUser();
?>
<?php
if($_POST['info'][0] && $_POST['info'][1])
                { 
                $session = $_SESSION['user_name'];
                 $id=$_POST['info'][0];
                 $amount=$_POST['info'][1];
                $pid =$_POST['info'][2];
                $date = date("m/d/Y h:i");
					
                // Insert data onclick cancel button 
                $stmt=mysql_query("INSERT into courier_payment(amount,courier_id,date,username,iscancelled)values('-$amount','$id','$date','$session','1')");
				
               // cancel amount status is updeted by 1
                mysql_query("UPDATE courier_payment SET iscancelled='1' WHERE payment_id='$pid' ");
				echo "UPDATE courier_payment SET iscancelled='1' WHERE payment_id='$pid' ";
                // select shipping and paid amount by courier table
                $result = mysql_query("SELECT shipping_subtotal, paid_amount From courier WHERE cid='$id'");
                $row = mysql_fetch_array($result);
				
                $shipping_amount = $row['shipping_subtotal'] ;
                $paid_amount = $row['paid_amount'];	
                $belance_amount = $row['paid_amount'] - $amount;
                // updated paid amount in courier table
                $sql_1 = mysql_query("UPDATE courier SET paid_amount='$belance_amount' WHERE cid='$id' ");
                if($shipping_amount > 0 && $belance_amount == 0){
                    $sql1 = mysql_query("UPDATE courier SET book_mode='pending' WHERE cid='$id' ");
                }else
                {
                   $sql1 = mysql_query("UPDATE courier SET book_mode='partial' WHERE cid='$id' ");
                }                              
       
 }	
?>