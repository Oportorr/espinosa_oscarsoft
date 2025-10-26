<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require_once('database.php');
require_once('library.php');
isUser();

?>
<?php

if($_POST['id'])
{
	$id=$_POST['id'];
		
	$stmt =  mysql_query("SELECT * FROM state WHERE country_id=$id");
	//$stmt->execute(array(':id' => $id));
	?><option value="">Select State</option><?php
	while($row=mysql_fetch_array($stmt))
	{
		?>
        	<option value="<?php echo $row['state_id']; ?>"><?php echo $row['state_name']; ?></option>
        <?php
	}
}
?>

 
