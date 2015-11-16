<?php	
//=== SI op=0 ENTONCES ES GENERAL, SI op=1 entonces es NoSolucionado	
	if (isset($_GET['op']))
		$op = $_GET['op']; 
	if (isset($_GET['op1']))
		$op1 = $_GET['op1']; 
	//echo $op;
	$sql3 = "SELECT * FROM users WHERE login_usr='$login_usr'";
	$res3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($res3);
	if (isset($op)){
		$sql2 = "UPDATE users SET visualizacion=$op WHERE login_usr='$login_usr'"; 
		mysql_query($sql2);
	}
	else $op = $row3['visualizacion'];
	if (isset($op1))
	{	$sql2 = "UPDATE users SET visualizacion_1=$op1 WHERE login_usr='$login_usr'"; 
		mysql_query($sql2);
	}
	else $op1 = $row3['visualizacion'];
	?>