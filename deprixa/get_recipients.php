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
    $str='';
	$id=$_GET['id'];
	$ids=array();
	$json = array();
	 $stmt1 = mysql_query("SELECT cc_r FROM courier where cc=$id");
	    while($row1=mysql_fetch_array($stmt1))
	          {
				  $ids[] =$row1['cc_r'];
			    }
		     }
             foreach($ids as $id){
					   $sql=mysql_query("SELECT id,name FROM tbl_clients where id=$id");
					   $row=mysql_fetch_array($sql);
					   {
                           $json[] = array(
                                   "value" => $row['id'],
                                   "name" => $row['name']
                            );
					   }
        }
  //echo '["Woodland Hills", "none", "Los Angeles", "Laguna Hills"]';
echo json_encode($json);
?>




