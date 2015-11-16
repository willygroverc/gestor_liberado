<?php
session_start();
$login_usr = $_SESSION["login"]; 
include("conexion.php");
//$sql = mysql_query("SELECT * FROM solucion WHERE solucion.id_orden NOT IN (SELECT conformidad.id_orden FROM conformidad)", $link);
$sql = "SELECT users.email, fecha_sol, DATE_FORMAT(fecha_sol, '%d/%m/%Y') AS fechasol2, solucion.* FROM solucion, users WHERE (solucion.id_orden NOT IN (SELECT conformidad.id_orden FROM conformidad)) and (users.login_usr = solucion.login_sol)";

$cont = 0;
$movilRs = mysql_db_query($db, $sql, $link);
while($tmp = mysql_fetch_array($movilRs))
{
	$id_orden = $tmp["3"]; 
	$email = $tmp["0"];  
	email($id_orden, $email);
	$cont++;
	$filename="report.txt";
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
			$asunto = "Nro. $id_orden. Escalamiento de Orden de Trabajo";	
			$mensaje = "
			<b><h2>Escalamiento de Orden de Trabajo</h2></b> Orden Nro. <b><h2>$id_orden</h2></b>, pendiente de conformidad <br><br>
			<b><h2>Detalles: </h2></b>Tiene ordenes de trabajo pendientes de conformidad <br><br>
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
echo "<script>document.location.href='listaConformidadC.php';</script>\n";  
?>





