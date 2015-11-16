<?php
####### db config ##########
include("conexion.php");
@session_start();
$login_usr = $_SESSION["login"];
####### db config end ##########
if($_POST)
{
	/*$sql="SELECT login_usr FROM users";
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		if(session_is_registered('login'))
		 {echo "<span style=\"color:#6A6565\">$row[login_usr]</span>"; echo "<br />";}
	}*/
	if(session_is_registered('login')=='admin'){
		echo "<span style=\"color:#6A6565\">admin</span>";
	}
	if(session_is_registered('login')=='sdfsdfsdfsdf'){
		echo "<span style=\"color:#6A6565\">tecnico</span>";
	}
	
	//unset($_SESSION["login"]);
}
?>