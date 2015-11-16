<body onLoad="show5()">
<span id="liveclock" style="position:absolute;left:0;top:0;">
</span>
<script type="text/javascript">
<!--
function show5(){
 if (!document.layers&&!document.all&&!document.getElementById)
 return
 var Digital=new Date()
 var hours=Digital.getHours()
 var minutes=Digital.getMinutes()
 var seconds=Digital.getSeconds()
 var dn="AM" 
 if (hours>12){
 dn="PM"
 hours=hours-12
 }
 if (hours==0)
 hours=12
 if (minutes<=9)
 minutes="0"+minutes
 if (seconds<=9)
 seconds="0"+seconds
//change font size here to your desire
myclock="<font size='5' face='Arial' ><b><font size='1'></font></br>"+hours+":"+minutes+":"
 +seconds+" "+dn+"</b></font>"
 //	alert(seconds);
 if(hours==6 & minutes==00 & seconds==00){
 location.reload();
 }
if (document.layers){
document.layers.liveclock.document.write(myclock)
document.layers.liveclock.document.close()
}
else if (document.all)
liveclock.innerHTML=myclock
else if (document.getElementById)
document.getElementById("liveclock").innerHTML=myclock
setTimeout("show5()",1000)
 }
//-->
</script>
</body>   
<?php 
$hora = date("H:i:s");
///echo $hora;
require_once("funciones.php");
include ("conexion.php");
$path_backup_db = "c:/backup_gestor_yanapti";
$dir = $path_backup_db;
if($hora == '18:00:00')
{		
	$fecha_hoy = date("d-m-Y");	
	$hora_hoy = date("H-i-s");
	$nombre = "copia_".$fecha_hoy."_".$hora_hoy.".sql";
	$path_copia = $dir."/".$nombre;
	exec("c:/mysql/bin/mysqldump -u $user --password=$pass -c $db > $path_copia ", $salida, $error);
	if($zip=="ok"){
		   $filenameIMAG=$path_copia; 
		   $filenameCOMP=$dir.'/'.$nombre.'.gz'; 
		   $fp = fopen($filenameIMAG, "rb"); 
		   $data = fread($fp, filesize($filenameIMAG)); 
		   fclose($fp); 
		   $fd = fopen ($filenameCOMP, "wb"); 
		   $gzdata = gzencode($data,9); 
		   fwrite($fd, $gzdata); 
		   fclose($fd); 
		  }
}
$correo = 'arodriguez@yanapti.com';					
							if (!(empty($correo)))
							{
								$asunto = "Backup de base de datos realizado con exito";	
								$mail = $correo;
								$mensaje = "
									<b>Mensaje Generado por el Gestor F1</b> <br>
									<b>-----------------------------------------------------</b>												
									<b>Se realizo correctamente el Backup 
									de la base de datos</b><br>
									<b>Hora:</b> 17:51:00 <br>
									Para mayores detalles, consulte el Sistema GesTor F1. <br>
									$systemData[nombre]";
									$tunombre = "Yanapti CORP";		
									$tuemail = "info@correo.com";
									$headers = "MIME-Version: 2.0\r\n"; 
									$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
									$headers .= "From: $tunombre <$tuemail>\r\n"; 
									if(!mail($mail,$asunto,$mensaje,$headers)){$msg ="Precaucion, no se ha podido enviar la orden por Correo Electronico.";}
									else
									{	$msg ="Mensaje enviado.";	}
							}
?>
