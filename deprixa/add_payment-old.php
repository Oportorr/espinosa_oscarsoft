<?php

print_r($_POST);
    $cid      = $_POST['cid'];
    $date      = $_POST['date'];
    $amount    = $_POST['amount'];
    $paying_by =    $_POST['paying_by'];
    $cid =    $_POST['cid'];
    $sql = "INSERT INTO courier_online (courier_id,date, amount,paying_by,iscancelled)
		VALUES('$cid', $date', '$amount','$paying_by','0')";
	dbQuery($sql);
        
        echo "<script type=\"text/javascript\">
			alert(\"Amount added succefully\");
			window.location = \"online-bookings.php\"
		</script>";
       