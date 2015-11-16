<?php
session_start();
$login_usr = $_SESSION["login"]; 
include("conexion.php");
//$sql = mysql_query("SELECT * FROM solucion WHERE solucion.id_orden NOT IN (SELECT conformidad.id_orden FROM conformidad)", $link);
$sql = "SELECT DISTINCT (a.id_orden) AS ordenes, b.email, a.fecha_asig, asig, diagnos FROM asignacion a, users b WHERE (a.asig = b.login_usr) AND id_orden NOT IN (SELECT id_orden FROM solucion)";

$cont = 0;
$movilRs = mysql_db_query($db, $sql, $link);
while($tmp = mysql_fetch_array($movilRs))
{
	$id_orden = $tmp["0"]; 
	$email = $tmp["1"];  
	email($id_orden, $email);
	$cont++;
	$filename="report1.txt";
	$handle = fopen($filename, 'a+');
	if ($handle)
	{
	fwrite($handle , "E-mail:");
	fwrite($handle , $email);
	fwrite($handle , ',');
	fwrite($handle , chr(13).chr(10));
	fwrite($handle , "Nro. Orden:");
	fwrite($handle , $tmp[3]);
	fwrite($handle , ',');
	fwrite($handle , chr(13).chr(10));
	fwrite($handle , "Fecha:");
	fwrite($handle , $tmp[5]);
	fwrite($handle , ',');
	fwrite($handle , chr(13).chr(10));
	fwrite($handle , "Hora:");
	fwrite($handle , $tmp[7]);
	fwrite($handle , ',');
	fwrite($handle , chr(13).chr(10));
	fwrite($handle , "-------------------");
	fwrite($handle , chr(13).chr(10));
	}
	fclose($handle);
}
//header("location: lista.php?Naveg=Ordenes de Trabajo");
									
/*
while($row = mysql_fetch_array($sql))
{ 
	//$id_orden = $row["1"]; 
	//$email = $row["2"];  
	//email($id_orden, $email);
	echo $row[0];
}*/
function email($id_orden,$email)
{ 
			include("conexion.php");
			$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
			$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
			$tunombre = $systemData[nombre];		
			$tuemail  = $systemData[mail_institucion];
			$mail = $email;
			$asunto = "Nro. $id_orden. Escalamiento de Orden de Trabajo\n";	
			$mensaje = "
			Escalamiento de Orden de Trabajo: \n Orden Nro. $id_orden, pendiente de conformidad<br>
			Detalles: Tiene ordenes de trabajo pendientes de solucion \n<br><br>
			Para mayores detalles, consulte el Sistema GesTor F1. <br>
			";
															
			$headers = "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			$headers .= "From: $tunombre <$tuemail>\r\n";			
			//mail($mail,$asunto,$mensaje,$headers);
			if(!mail($mail,$asunto,$mensaje,$headers))
			{ 
				echo "Precaución, no se ha podido enviar la orden por correo electrónico al Cliente.";
				echo "<br>";
			}																
												
}

?>
<!--<script language="javascript"> alert("\nMensajes envidos...\n\nMensaje generado por GesTor F1.\n\n");</script>-->
<?php
echo "<script>document.location.href='lista_ordenSin_solucion.php';</script>\n";  
?>





