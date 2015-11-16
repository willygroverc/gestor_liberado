<?php
####### db config ##########
include("conexion.php");
@session_start();
$_SESSION['modulo']='lista';
$login_usr = $_SESSION["login"];
####### db config end ##########

if($_POST)
{
	//connect to mysql db
	//$sql_con = mysqli_connect($db_host, $db_username, $db_password,$db_name)or die('could not connect to database');
	
	//check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        die();
    } 
	
	if(isset($_POST["message"]) &&  strlen($_POST["message"])>0)
	{
		//sanitize user name and message received from chat box
		//You can replace username with registerd username, if only registered users are allowed.
		$username = filter_var(trim($_POST["username"]),FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		$message = filter_var(trim($_POST["message"]),FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		$user_ip = $_SERVER['REMOTE_ADDR'];
		

		//insert new message in db
		$sql="INSERT INTO shout_box(user, message, ip_address) value('$login_usr','$message','$user_ip')";
		
		if(mysql_query($sql))
		{
			$msg_time = date('h:i A M d',time()); // current time
			echo '<div class="shout_msg"><time>'.$msg_time.'</time><span class="username">'.$login_usr.'</span><span class="message">'.$message.'</span></div>';
		}
		
		// delete all records except last 10, if you don't want to grow your db size!
		$sql_del="DELETE FROM shout_box WHERE id NOT IN (SELECT * FROM (SELECT id FROM shout_box ORDER BY id DESC LIMIT 0, 10) as sb)";
		//mysqli_query($sql_con,"DELETE FROM shout_box WHERE id NOT IN (SELECT * FROM (SELECT id FROM shout_box ORDER BY id DESC LIMIT 0, 10) as sb)");
		mysql_query($sql_del);
	}
	elseif($_POST["fetch"]==1)
	{
		$sql_show="SELECT user, message, date_time FROM (select * from shout_box ORDER BY id DESC LIMIT 10) shout_box ORDER BY shout_box.id ASC";
		//echo $sql_show;
		$results = mysql_query($sql_show);
		while($row = mysql_fetch_array($results))
		{	include("conexion.php");
			$msg_time = date('h:i A M d',strtotime($row["date_time"])); //message posted time
			echo '<div class="shout_msg"><time>'.$msg_time.'</time><span class="username">'.$row["user"].'</span> <span class="message">'.$row["message"].'</span></div>';
		}
	}
	else
	{
		header('HTTP/1.1 500 El mensaje no puede ser vacio');
    	exit();
	}
}