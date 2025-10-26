<?php 
// *************************************************************************
// *                                                                       *
// * CARGO v10.0 -  logistics Worldwide Software                           *
// * Copyright (c) CNSWARE INC. All Rights Reserved                        *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: INFO@CNSWARE.COM                                               *
// * Website: http://www.cnsware.com                                       *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// *                                                                       *
// *                                                                       *
// *                                                                       *
// *************************************************************************
 
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once('database.php');
require_once('funciones.php');
function verify_users($user,$pwd, $estado) {	
		
			$sql = "SELECT *	FROM manager_admin WHERE name = '$user' AND pwd = '$pwd' AND estado = '1'";
			$result = dbQuery($sql);		
			$no = dbNumRows($result);		
			if($no >= 1) {
					$_SESSION['user_name']= $user;	
					$_SESSION['user_type']= 'Administrator';
					echo '<div class="alert alert-succes" role="alert" align="center">
					<strong>Welcome<br><br>'.$user.'</strong></div>';
					echo '<center><img src="deprixa/images/balls.gif"></center><br>';
					echo '<meta http-equiv="refresh"  content="2;url=deprixa/admin.php">';
					
			} else {				
			$sql = "SELECT name_parson	FROM manager_user WHERE name = '$user' AND pwd = '$pwd' AND estado = '1'";
			$result = dbQuery($sql);		
			$no = dbNumRows($result);		
			if($no >= 1) {

					$_SESSION['user_name']= $user;	
					$_SESSION['user_type']= 'Employee';
					echo '<div class="alert alert-succes" role="alert" align="center">
					<strong>Welcome<br><br>'.$user.'</strong></div>';
					echo '<center><img src="deprixa/images/balls.gif"></center><br>';
					echo '<meta http-equiv="refresh"  content="2;url=deprixa/admin.php">';
		
			
			} else {
				
				$sql = "SELECT name	FROM tbl_clients WHERE email = '$user' AND password = '$pwd' AND estado = '1'";
				$result = dbQuery($sql);
				$no = dbNumRows($result);
			if($no >= 1) {
					$_SESSION['user_name']= $user;
					$_SESSION['user_type']= 'client';	
					echo '<div class="alert alert-succes" role="alert" align="center">
					<strong>Welcome<br><br>'.$user.'</strong></div>';
					echo '<center><img src="deprixa/images/balls.gif"></center><br>';
					echo '<meta http-equiv="refresh"  content="2;url=deprixa/panel-customer/customer.php">';
			}	else {
				echo mensajes('Username and password incorrect<br>','rojo'); 
				echo '<center><a href="login.php" class="btn btn-success"><strong>Try again</strong></a></center>';
			}		
		}//else
	}

}

function isUser(){
	if(!isset($_SESSION['user_name'])){
		header('Location: deprixa/admin.php');
	}
	
}
?>