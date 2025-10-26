<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require_once('database.php');
require_once('library.php');
isUser();

?>
<?php

if($_GET['id'])
{
	$id=$_GET['id'];
	
	$stmt = mysql_query("SELECT * FROM type_shipments WHERE id=$id");

        while($row=mysql_fetch_array($stmt))
	{
            $json[] = array(
            "product_price" => $row['price']
                   );
      
   
       echo json_encode($json);
       
	}
          
}
?>



