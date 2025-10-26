<?php


require_once('database.php');
if(isset($_POST['payment_date'])){
 $payment_date = $_POST['payment_date'];

 echo date('m-d-Y h:i', strtotime($payment_date. ' + 10 days'));

	
}
else
{
	echo '';
}

if(isset($_POST['amount'])){
 echo $amount = $_POST['amount'];
}

?>