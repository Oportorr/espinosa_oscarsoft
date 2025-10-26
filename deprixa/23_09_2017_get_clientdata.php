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
	$json = array();
	$stmt = mysql_query("SELECT * FROM tbl_clients where id=$id");
	
	 while($row=mysql_fetch_array($stmt))
	{
            $json[] = array(
            "id" => $row['id'],
                 "address" => $row['address'],
                "phone" => $row['phone'],
                "country" => $row['country'],
                "state" => $row['state'],
                "city_name" => $row['city'],
                "zipcode" => $row['zipcode'],
                "email" => $row['email']
                
               );
      
   
       echo json_encode($json);
       
	}
          
}


?>




