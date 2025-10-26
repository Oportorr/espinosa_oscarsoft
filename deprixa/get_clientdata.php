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
                "email" => $row['email'],
                "cedula" => $row['cedula_no']
                
               );
      
       
       echo json_encode($json);
       
	}
          
}

    //get search term
    $searchTerm = $_GET['term'];
    $country =$_GET['country'];
   if($searchTerm){ 
    //get matched data from skills table
    if($country == 'usa'){
        $query = mysql_query("SELECT id, name FROM tbl_clients WHERE country='231' AND name LIKE '".$searchTerm."%' ORDER BY name ASC");
    }elseif ($country == 'other') {
        $query = mysql_query("SELECT id, name FROM tbl_clients WHERE country='61' AND name LIKE '".$searchTerm."%' ORDER BY name ASC");
    }    
    $json = array();
    $i=0;
    while ($row = mysql_fetch_array($query)) {
        $json[] = array( id => $row['id'], name => $row['name'] );
    }
    
    //return json data
    echo json_encode($json);

    }
?>




