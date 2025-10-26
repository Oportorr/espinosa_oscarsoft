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
	$stmt = mysql_query("SELECT zc.full_state,zc.city,c.country_name FROM zip_codes zc LEFT JOIN state s ON zc.full_state = s.state_name LEFT JOIN country c ON s.country_id = c.country_id WHERE zc.zip=$id");
	
	 while($row=mysql_fetch_array($stmt))
	{
            $json[] = array(
            "state_name" => $row['full_state'],
            "city_name" => $row['city'],
			"country_name" => $row['country_name']
               );
      
   
       echo json_encode($json);
       
	}
          
}


?>




