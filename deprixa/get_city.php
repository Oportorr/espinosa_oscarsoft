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
	$city_id=$_POST['city_id'];
	$stmt = mysql_query("SELECT * FROM city WHERE state_id=$id");
	
	?><option value="">Select City</option>
	<?php while($row=mysql_fetch_array($stmt))
	{
		?>
		<option value="<?php echo $row['city_id']; ?>" <?php if($row['city_id'] == $city_id){ echo 'selected'; }?>><?php echo $row['city_name']; ?></option>
		<?php
	}
}
?>