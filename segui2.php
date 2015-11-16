<?php 
/////DESCRIPCION: ESTE ARCHIVO HA SIDO  MODIFICADO PARA SANEAR LA ENTRADA DE DE DATOS PARA ARAQUES XSS  DE TIPO ALERT
/////AUTOR: ALVARO RODRIGUEZ
/////FECHA: 12'09'2012
//	 $archivo_size= $_FILES['archivo']['size'];
//	 $archivo_size= $HTTP_POST_FILES['archivo']['size'];


/*	if (strlen($obs_seg)>0)
	{
		$msg = $obs_seg;
	}*/
	if (isset($Enviar))
	{
		header("location: select_forma.php?sel=$select&obs=$obs_seg&id_orden=$id_orden&lug=0");
	}
		
	if (isset($RETORNAR))
	{
		
		if ($var2=="0")
		{
			header("location: lista.php");
		}
		if ($var2=="1")
		{
			header("location: lista_asig.php");
		}
		if ( $var2=="2" ) 
		{
			header("location: lista.php");
		}
		else
			if ( $var3=="3" ) 
			{
					header("location: listans.php");
			}
//		header("location: lista.php");
		
	}
include("top.php");
?>
<style type="text/css">
table.imagetable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #999999;
	border-collapse: collapse;
}
table.imagetable th {
	background:#b5cfd2 url('cell-blue.jpg');
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #999999;
}
table.imagetable td {
	background:#dcddc0 url('cell-grey.jpg');
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #999999;
}
</style>
<?php
$sql_5="SELECT * FROM control_parametros";
		$result_5=mysql_query($sql_5);
		$row_5=mysql_fetch_array($result_5);

if (isset($reg_form))
{
	if($estado_seg=="1 (Cumplida en fecha)")
	{$es=1;}
	if($estado_seg=="2 (Cumplida retrasada)")
	{$es=2;}
	if($estado_seg=="3 (Pendiente en fecha)")
	{$es=3;}
	if($estado_seg=="4 (Pendiente retrasada)")
	{$es=4;}
	if($estado_seg=="5 (Desestimada)")
	{$es=5;}
	$obs_seg = strip_tags($obs_seg);
	$sql_cont="SELECT n_seg FROM seguimiento WHERE id_orden='$id_orden'";
	$result_cont=mysql_query($sql_cont);
	$fila_cont=mysql_fetch_array($result_cont);
	$verif=$fila_cont['n_seg']+1;
    $sql3="INSERT INTO ".
	"seguimiento(id_orden,estado_seg,obs_seg,fecha_seg,hora_seg,login_usr,fecha_rea,usr_archivos,archivos,hash_archi,observ_arch,n_seg)".
	"VALUES('$id_orden','$es','$obs_seg','".date("Y-m-d")."','".date("H:i:s")."','$login','0000-00-00','','','','','$verif')";
	mysql_query($sql3);
	
	$sqlx = "UPDATE datos_archivos SET replicar='1' WHERE nombre_arch='$NombreUsr'";
	$resultx=mysql_query($sqlx);

	if ($archivo_name<>"")
	{
		$extension = explode(".",$archivo_name); 
		$num = count($extension)-1; 
		
		$sql_6="SELECT max(id_seg) as max_segui FROM seguimiento";
		$result_6=mysql_query($sql_6);
		$row_6=mysql_fetch_array($result_6);
		
		$tam_max=1048576*$row_5['tam_archivo'];
		$arch_nomb=$row_6['max_segui'].".".$extension[$num];
		if($archivo_size < $tam_max)
		{
			$sql_2="UPDATE seguimiento SET nomb_archivo='$arch_nomb' WHERE id_orden=$id_orden and id_seg=$row_6[max_segui]";
			mysql_query($sql_2);
			//copy($archivo,"archivos_segui/".$arch_nomb);
			
			$data = file_get_contents($archivo);
			$handle = fopen("archivos_segui/".$arch_nomb, "w");
			fwrite($handle, $data);
			fclose($handle);
		}
		else
			$msg="EL TAMA�O DEL ARCHIVO ADJUNTO NO DEBE SER MAYOR A ".$row_5['tam_archivo']." Mb";
	}
	$sqlaux="select * from control_parametros";
		$resultaux=mysql_query($sqlaux);
		$rowaux=mysql_fetch_array($resultaux);
		if ($rowaux['seguimiento']==1 or $rowaux['seguimiento']==5)
		{
		$sqlaux1="SELECT * FROM ordenes WHERE id_orden=$id_orden";
		$resultaux1=mysql_query($sqlaux1);
		$rowaux1=mysql_fetch_array($resultaux1);
		$sqlcliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='admin'";
		$ordencliente=mysql_query($sqlcliente);
		$rowcli=mysql_fetch_array($ordencliente);
		$clienteNombre=$rowcli['nom_usr'].' '.$rowcli['apa_usr'].' '.$rowcli['ama_usr'];
		$sqlcliente1="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowaux1[cod_usr]'";
		$ordencliente1=mysql_query($sqlcliente1);
		$rowcli1=mysql_fetch_array($ordencliente1);
		$clienteNombre1=$rowcli1['nom_usr'].' '.$rowcli1['apa_usr'].' '.$rowcli1['ama_usr'];
		//echo $clienteNombre;
		$sqlasig="select * from asignacion where id_orden=$id_orden";
		$resultasig=mysql_query($sqlasig);
		$rowasig=mysql_fetch_array($resultasig);
		$sqlasignombre="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowasig[asig]'";
		$asignombre=mysql_query($sqlasignombre);
		$rowasign=mysql_fetch_array($asignombre);
		$asignom=$rowasign['nom_usr'].' '.$rowasign['apa_usr'].' '.$rowasign['ama_usr'];
		$sqlw="SELECT * FROM users WHERE login_usr='".$row['login_usr']."'";
			 $resultw=mysql_query($sqlw);
		  	 $roww=mysql_fetch_array($resultw);
			 $usuario=$roww['nom_usr']." ".$roww['apa_usr']." ".$roww['ama_usr'];
		$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
		$systemData = mysql_fetch_array(mysql_query( $sqlSystem));
		if (!(empty($rowcli['email'])))
		{
		$asunto = "Nro. $id_orden. Nuevo Seguimiento de Orden de Trabajo";	
		$mail = $rowcli['email'];
		//echo $rowcli[email];
		$mensaje = "
		<b>Mensaje Generado por el Gestor F1 </b><br>
		------------------------------------------------------------------ <br>
		<b>Nuevo Seguimiento de Orden de Trabajo: Nro. $id_orden registrado a horas ".date("H:i:s")." en fecha ".date("d-m-Y")." </b><br>
		------------------------------------------------------------------ <br>
		<b>Datos Generales</b> <br>
		------------------------------------------------------------------ <br>
		<b> Cliente/Tecnico: </b> $clienteNombre1<br>
		<b>Descripcion:</b> $rowaux1[desc_inc]<br>
		<b>Asignado a:</b> $asignom <br>
		<b>Fecha Estimada de Solucion:</b> $rowasig[fechaestsol_asig] <br>";
		$sql_seg="select * from seguimiento where id_orden='$id_orden' ORDER BY hora_seg DESC LIMIT 3;";
		$result_seg=mysql_query($sql_seg);
		$mensaje.="------------------------------------------------------------------ <br>
				<b>Datos de Seguimiento</b> <br>
				------------------------------------------------------------------ <br>";
		while($fila_seg=mysql_fetch_array($result_seg)){
		$sqlt="SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$fila_seg[login_usr]'";
			 $resultt=mysql_query($sqlt); 
		  	 $rowt=mysql_fetch_array($resultt);
			 
			 if ($fila_seg['estado_seg']=="1")
			{$fila_seg['estado_seg']= "Cumplida en fecha";}
			if ($fila_seg['estado_seg']=="2")
			{$fila_seg['estado_seg']= "Cumplida retrasada";}
			if ($fila_seg['estado_seg']=="3")
			{$fila_seg['estado_seg']= "Pendiente en fecha";}
			if ($fila_seg['estado_seg']=="4")
			{$fila_seg['estado_seg']= "Pendiente retrasada";}
			if ($fila_seg['estado_seg']=="5")
			{$fila_seg['estado_seg']= "Desestimada";}
			$mensaje.="<br><table class=\"imagetable\"><tr>"; 
			$mensaje.="<th><b>Nro. Seg por orden:</b></th><td> $fila_seg[n_seg]</td><br></tr><tr>";
			$mensaje.="<th><b>Realizado por:</b></th><td>$rowt[nom_usr] $rowt[apa_usr] $rowt[ama_usr]</td><br></tr>
		<tr><th><b>Obs de Seguimiento:</b></th><td>$fila_seg[obs_seg]</td> <br></tr>
		<tr><th><b>Estado:</b></th><td>$fila_seg[estado_seg]</td><br></tr>
		<tr><th><b>Fecha Realizacion:</b></th><td>$fila_seg[fecha_seg]</td></tr><br><br>";
		}
		$mensaje.="<b>Para mayores detalles, consulte el Sistema GesTor F1.</b> <br>";
		echo "$systemData[nombre]";
		$tunombre = $systemData['nombre'];		
		$tuemail  = $systemData['mail_institucion'];	
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: $tunombre <$tuemail>\r\n"; 
		if(!mail($mail,$asunto,$mensaje,$headers))
		{ 
		echo"<script language='javascript'>alert('Precaucion, no se ha podido enviar la orden por correo electronico al Cliente. \\n Mensaje generado por GesTor F1.');						</script>";
		}
		else{
		echo "<script language='javascript'>alert('Mensaje enviado exitosamente a ".$clienteNombre." \\n Mensaje generado por GesTor F1.');</script>";
		}
		}
		else {	
		echo"<script language='javascript'>alert('Precaucion, no se ha podido enviar la orden por correo electronico al Cliente. El Usuario no tiene registrado su cuenta de correo \\n Mensaje generado por GesTor F1.');</script>";
		}
		}
		//Adm de area
if ($rowaux[seguimiento]==2 or $rowaux[seguimiento]==5)
		{
		$sqlaux1="SELECT * FROM ordenes WHERE id_orden=$id_orden";
		$resultaux1=mysql_query($sqlaux1);
		$rowaux1=mysql_fetch_array($resultaux1);
		$sqlcliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE tipo2_usr='D'";
		$ordencliente=mysql_query($sqlcliente);
		
		$clienteNombre=$rowcli['nom_usr'].' '.$rowcli['apa_usr'].' '.$rowcli['ama_usr'];
		$sqlcliente1="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowaux1[cod_usr]'";
		$ordencliente1=mysql_query($sqlcliente1);
		$rowcli1=mysql_fetch_array($ordencliente1);
		$clienteNombre1=$rowcli1['nom_usr'].' '.$rowcli1['apa_usr'].' '.$rowcli1['ama_usr'];
		//echo $clienteNombre;
		$sqlasig="select * from asignacion where id_orden=$id_orden";
		$resultasig=mysql_query($sqlasig);
		$rowasig=mysql_fetch_array($resultasig);
		$sqlasignombre="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowasig[asig]'";
		$asignombre=mysql_query($sqlasignombre);
		$rowasign=mysql_fetch_array($asignombre);
		$asignom=$rowasign['nom_usr'].' '.$rowasign['apa_usr'].' '.$rowasign['ama_usr'];
		$sqlw="SELECT * FROM users WHERE login_usr='".$row['login_usr']."'";
			 $resultw=mysql_query($sqlw);
		  	 $roww=mysql_fetch_array($resultw);
			 $usuario=$roww['nom_usr']." ".$roww['apa_usr']." ".$roww['ama_usr'];
		$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
		$systemData = mysql_fetch_array(mysql_query( $sqlSystem));
		if (!(empty($rowcli['email'])))
		{
		$asunto = "Nro. $id_orden. Nuevo Seguimiento de Orden de Trabajo";
		$mensaje = "
		<b>Mensaje Generado por el Gestor F1 </b><br>
		------------------------------------------------------------------ <br>
		<b>Nuevo Seguimiento de Orden de Trabajo: Nro. $id_orden registrado a horas ".date("H:i:s")." en fecha ".date("d-m-Y")." </b><br>
		------------------------------------------------------------------ <br>
		<b>Datos Generales</b> <br>
		------------------------------------------------------------------ <br>
		<b> Cliente/Tecnico: </b> $clienteNombre1<br>
		<b>Descripcion:</b> $rowaux1[desc_inc]<br>
		<b>Asignado a:</b> $asignom <br>
		<b>Fecha Estimada de Solucion:</b> $rowasig[fechaestsol_asig] <br>";
		$sql_seg="select * from seguimiento where id_orden='$id_orden' ORDER BY hora_seg DESC LIMIT 3;"; 
		$result_seg=mysql_query($sql_seg);
		$mensaje.="------------------------------------------------------------------ <br>
				<b>Datos de Seguimiento</b> <br>
				------------------------------------------------------------------ <br>";
		while($fila_seg=mysql_fetch_array($result_seg)){
		$sqlt="SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$fila_seg[login_usr]'";
			 $resultt=mysql_query($sqlt);
		  	 $rowt=mysql_fetch_array($resultt);
			if ($fila_seg['estado_seg']=="1")
			{$fila_seg['estado_seg']= "Cumplida en fecha";}
			if ($fila_seg['estado_seg']=="2")
			{$fila_seg['estado_seg']= "Cumplida retrasada";}
			if ($fila_seg['estado_seg']=="3")
			{$fila_seg['estado_seg']= "Pendiente en fecha";}
			if ($fila_seg['estado_seg']=="4")
			{$fila_seg['estado_seg']= "Pendiente retrasada";}
			if ($fila_seg['estado_seg']=="5")
			{$fila_seg['estado_seg']= "Desestimada";}
			$mensaje.="<br><table class=\"imagetable\"><tr>"; 
			$mensaje.="<th><b>Nro. Seg por orden:</b></th><td> $fila_seg[n_seg]</td><br></tr><tr>";
			$mensaje.="<th><b>Realizado por:</b></th><td>$rowt[nom_usr] $rowt[apa_usr] $rowt[ama_usr]</td><br></tr>
		<tr><th><b>Obs de Seguimiento:</b></th><td>$fila_seg[obs_seg]</td> <br></tr>
		<tr><th><b>Estado:</b></th><td>$fila_seg[estado_seg]</td><br></tr>
		<tr><th><b>Fecha Realizacion:</b></th><td>$fila_seg[fecha_seg]</td></tr><br><br>";
		}
		$mensaje.="<b>Para mayores detalles, consulte el Sistema GesTor F1.</b> <br>";
		echo "$systemData[nombre]";
		$tunombre = $systemData['nombre'];		
		$tuemail  = $systemData['mail_institucion'];
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: $tunombre <$tuemail>\r\n";
		while($rowcli=mysql_fetch_array($ordencliente)){ 
			if(!mail($rowcli['email'],$asunto,$mensaje,$headers))
			{ 
			echo"<script language='javascript'>alert('Precaucion, no se ha podido enviar la orden por correo electronico al Cliente. \\n Mensaje generado por GesTor F1.');						</script>";
			}
			else{
			echo "<script language='javascript'>alert('Mensaje enviado exitosamente a ".$clienteNombre." \\n Mensaje generado por GesTor F1.');</script>";
			}
		}
		}
		else {	
		echo"<script language='javascript'>alert('Precaucion, no se ha podido enviar la orden por correo electronico al Cliente. El Usuario no tiene registrado su cuenta de correo \\n Mensaje generado por GesTor F1.');</script>";
		}
		}
//Cliente
		if ($rowaux['seguimiento']==3 or $rowaux['seguimiento']==5)
		{
		$sqlaux1="SELECT * FROM ordenes WHERE id_orden=$id_orden";
		$resultaux1=mysql_query($sqlaux1);
		$rowaux1=mysql_fetch_array($resultaux1);
		$sqlcliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowaux1[cod_usr]'";
		$ordencliente=mysql_query($sqlcliente);
		$rowcli=mysql_fetch_array($ordencliente);
		$clienteNombre=$rowcli['nom_usr'].' '.$rowcli['apa_usr'].' '.$rowcli['ama_usr'];
		//echo $clienteNombre;
		$sqlasig="select * from asignacion where id_orden=$id_orden";
		$resultasig=mysql_query($sqlasig);
		$rowasig=mysql_fetch_array($resultasig);
		$sqlasignombre="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowasig[asig]'";
		$asignombre=mysql_query($sqlasignombre);
		$rowasign=mysql_fetch_array($asignombre);
		$asignom=$rowasign['nom_usr'].' '.$rowasign['apa_usr'].' '.$rowasign['ama_usr'];
		$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
		$systemData = mysql_fetch_array(mysql_query( $sqlSystem));
		$sqlw="SELECT * FROM users WHERE login_usr='$row[login_usr]'";
			 $resultw=mysql_query($sqlw);
		  	 $roww=mysql_fetch_array($resultw);
			 $usuario=$roww['nom_usr']." ".$roww['apa_usr']." ".$roww['ama_usr'];
		if (!(empty($rowcli['email'])))
		{
		$asunto = "Nro. $id_orden. Nuevo Seguimiento de Orden de Trabajo";	
		$mail = $rowcli[email];
		//echo $rowcli[email];
		$mensaje = "
		<b>Mensaje Generado por el Gestor F1 </b><br>
		------------------------------------------------------------------ <br>
		<b>Nuevo Seguimiento de Orden de Trabajo: Nro. $id_orden registrado a horas ".date("H:i:s")." en fecha ".date("d-m-Y")." </b><br>
		------------------------------------------------------------------ <br>
		<b>Datos Generales</b> <br>
		------------------------------------------------------------------ <br>
		<b>Cliente/Tecnico:</b> $clienteNombre<br>
		<b>Descripcion:</b> $rowaux1[desc_inc]<br>
		<b>Asignado a:</b> $asignom <br>
		<b>Fecha Estimada de Solucion:</b> $rowasig[fechaestsol_asig] <br>";
		$sql_seg="select * from seguimiento where id_orden='$id_orden' ORDER BY hora_seg DESC LIMIT 3;";
		$result_seg=mysql_query($sql_seg);
		$mensaje.="------------------------------------------------------------------ <br>
				<b>Datos de Seguimiento</b> <br>
				------------------------------------------------------------------ <br>";
		while($fila_seg=mysql_fetch_array($result_seg)){
		$sqlt="SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$fila_seg[login_usr]'";
			 $resultt=mysql_query($sqlt);
		  	 $rowt=mysql_fetch_array($resultt);
			if ($fila_seg['estado_seg']=="1")
			{$fila_seg['estado_seg']= "Cumplida en fecha";}
			if ($fila_seg['estado_seg']=="2")
			{$fila_seg['estado_seg']= "Cumplida retrasada";}
			if ($fila_seg['estado_seg']=="3")
			{$fila_seg['estado_seg']= "Pendiente en fecha";}
			if ($fila_seg['estado_seg']=="4")
			{$fila_seg['estado_seg']= "Pendiente retrasada";}
			if ($fila_seg['estado_seg']=="5")
			{$fila_seg['estado_seg']= "Desestimada";}
			$mensaje.="<br><table class=\"imagetable\"><tr>"; 
			$mensaje.="<th><b>Nro. Seg por orden:</b></th><td> $fila_seg[n_seg]</td><br></tr><tr>";
			$mensaje.="<th><b>Realizado por:</b></th><td>$rowt[nom_usr] $rowt[apa_usr] $rowt[ama_usr]</td><br></tr>
		<tr><th><b>Obs de Seguimiento:</b></th><td>$fila_seg[obs_seg]</td> <br></tr>
		<tr><th><b>Estado:</b></th><td>$fila_seg[estado_seg]</td><br></tr>
		<tr><th><b>Fecha Realizacion:</b></th><td>$fila_seg[fecha_seg]</td></tr><br><br>";
		}
		$mensaje.="<b>Para mayores detalles, consulte el Sistema GesTor F1.</b> <br>";
		echo "$systemData[nombre]";
		$tunombre = $systemData['nombre'];		
		$tuemail  = $systemData['mail_institucion'];			
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: $tunombre <$tuemail>\r\n";
		if(!mail($mail,$asunto,$mensaje,$headers))
		{ 
		echo"<script language='javascript'>alert('Precauci�n, no se ha podido enviar la orden por correo electr�nico al Cliente. \\n Mensaje generado por GesTor F1.');</script>";
		}
		else{
		echo "<script language='javascript'>alert('Mensaje enviado exitosamente a ".$clienteNombre." \\n Mensaje generado por GesTor F1.');</script>";
		}
		}
		else {	
		echo"<script language='javascript'>alert('Precauci�n, no se ha podido enviar la orden por correo electr�nico al Cliente. El Usuario no tiene registrado su cuenta de correo \\n Mensaje generado por GesTor F1.');</script>";
		}
		}
		if ($rowaux['seguimiento']==4 or $rowaux['seguimiento']==5)
		{
		$sqlaux1="SELECT * FROM ordenes WHERE id_orden=$id_orden";
		$resultaux1=mysql_query($sqlaux1);
		$rowaux1=mysql_fetch_array($resultaux1);
		$sqlcliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowaux1[cod_usr]'";
		$ordencliente=mysql_query($sqlcliente);
		$rowcli=mysql_fetch_array($ordencliente);
		$clienteNombre=$rowcli['nom_usr'].' '.$rowcli['apa_usr'].' '.$rowcli['ama_usr'];
		//echo $clienteNombre;
		$sqlasig="select * from asignacion where id_orden=$id_orden";
		$resultasig=mysql_query($sqlasig);
		$rowasig=mysql_fetch_array($resultasig);
		
		$sqlasignombre="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$rowasig[asig]'";
		$asignombre=mysql_query($sqlasignombre);
		$rowasign=mysql_fetch_array($asignombre);
		$asignom=$rowasign[nom_usr].' '.$rowasign[apa_usr].' '.$rowasign[ama_usr];
		$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
		$systemData = mysql_fetch_array(mysql_query( $sqlSystem));
			$sqlw="SELECT * FROM users WHERE login_usr='$row[login_usr]'";
			 $resultw=mysql_query($sqlw);
		  	 $roww=mysql_fetch_array($resultw);
			 $usuario=$roww[nom_usr]." ".$roww[apa_usr]." ".$roww[ama_usr];
		if ($rowasig[asig]!="")
		{
		if (!(empty($rowasign[email])) )
		{
		$asunto = "Nro. $id_orden. Nuevo Seguimiento de Orden de Trabajo";	
		$mail = $rowasign[email];
		//echo $rowcli[email];
		$mensaje = "
		<b>Mensaje Generado por el Gestor F1 </b><br>
		------------------------------------------------------------------ <br>
		<b>Nuevo Seguimiento de Orden de Trabajo: Nro. $id_orden registrado a horas ".date("H:i:s")." en fecha ".date("d-m-Y")." </b><br>
		------------------------------------------------------------------ <br>
		<b>Datos Generales</b> <br>
		------------------------------------------------------------------ <br>
		<b>Cliente/Tecnico:</b> $clienteNombre<br>
		<b>Descripcion:</b> $rowaux1[desc_inc]<br>
		<b>Asignado a:</b> $asignom <br>
		<b>Fecha Estimada de Solucion:</b> $rowasig[fechaestsol_asig] <br>";
		$sql_seg="select * from seguimiento where id_orden='$id_orden' ORDER BY hora_seg DESC LIMIT 3;";
		$result_seg=mysql_query($sql_seg);
		$mensaje.="------------------------------------------------------------------ <br>
				<b>Datos de Seguimiento</b> <br>
				------------------------------------------------------------------ <br>";
		while($fila_seg=mysql_fetch_array($result_seg)){
		$sqlt="SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$fila_seg[login_usr]'";
			 $resultt=mysql_query($sqlt);
		  	 $rowt=mysql_fetch_array($resultt);
			if ($fila_seg['estado_seg']=="1")
			{$fila_seg['estado_seg']= "Cumplida en fecha";}
			if ($fila_seg['estado_seg']=="2")
			{$fila_seg['estado_seg']= "Cumplida retrasada";}
			if ($fila_seg['estado_seg']=="3")
			{$fila_seg['estado_seg']= "Pendiente en fecha";}
			if ($fila_seg['estado_seg']=="4")
			{$fila_seg['estado_seg']= "Pendiente retrasada";}
			if ($fila_seg['estado_seg']=="5")
			{$fila_seg['estado_seg']= "Desestimada";}
			$mensaje.="<br><table class=\"imagetable\"><tr>"; 
			$mensaje.="<th><b>Nro. Seg por orden:</b></th><td> $fila_seg[n_seg]</td><br></tr><tr>";
			$mensaje.="<th><b>Realizado por:</b></th><td>$rowt[nom_usr] $rowt[apa_usr] $rowt[ama_usr]</td><br></tr>
		<tr><th><b>Obs de Seguimiento:</b></th><td>$fila_seg[obs_seg]</td> <br></tr>
		<tr><th><b>Estado:</b></th><td>$fila_seg[estado_seg]</td><br></tr>
		<tr><th><b>Fecha Realizacion:</b></th><td>$fila_seg[fecha_seg]</td></tr><br><br>";
		}
		$mensaje.="<b>Para mayores detalles, consulte el Sistema GesTor F1.</b> <br>";
		echo "$systemData[nombre]";
		$tunombre = $systemData['nombre'];		
		$tuemail  = $systemData['mail_institucion'];												
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: $tunombre <$tuemail>\r\n";
		if(!mail($mail,$asunto,$mensaje,$headers))
		{ 
		echo"<script language='javascript'>alert('Precauci�n, no se ha podido enviar la orden por correo electr�nico al Cliente. \\n Mensaje generado por GesTor F1.');</script>";
		}
		else{
		echo "<script language='javascript'>alert('Mensaje enviado exitosamente a ".$asignom." \\n Mensaje generado por GesTor F1.');</script>";
		}
		}
		else {	
		echo"<script language='javascript'>alert('Precauci�n, no se ha podido enviar la orden por correo electr�nico al Cliente. El Usuario no tiene registrado su cuenta de correo \\n Mensaje generado por GesTor F1.');</script>";
		}
		
		}
		else
		{	
		echo"<script language='javascript'>alert('Precauci�n, no se ha podido enviar la orden por correo electr�nico al Tecnico. Por que la orden no ha sido asignada \\n Mensaje generado por GesTor F1.');</script>";
		}
		}
}
	
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
print $valid->toHtml ();
?>
<script language="JavaScript">
<?php 
		print "function msgFile () {\n
				alert (\"Atencion, solamente puede enviar archivos menor o igual a $row_5[tam_archivo] Mb de tama�o.\\n \\nMensaje generado por YanapTI.\");\n
				}\n";
		if (isset($msg))
		{
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por YanapTI.\");\n";
		} ?>

function Form () 
{
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
function retornar(){
	alert('volver');
}
function chequea(form) 
{
	var max=255;
	if (form.obs_seg.value.length > max) 
	{
		alert("No puede ingresar mas de 255 caracteres.  Por favor no sea mas breve. (" + form.obs_seg.value.length+")");
		return false;
   	}
	else 
		return true;
}
function rellenar(llenar) 
{
 	form.obs_seg.value = llenar;
}
function contador (campo, cuentacampo, limite) 
{
	if (campo.value.length > limite) 
		campo.value = campo.value.substring(0, limite);
	else 
		cuentacampo.value = limite - campo.value.length;
}
function contador_(campo) 
{
	if (campo.value == "%") 
	{
		alert("No puede ingresar solo el caracter %");
		return false;
	}
	return true;
}

</script>

<form name="form2" method="post" enctype="multipart/form-data" onsubmit="return chequea(this)" action="<?php=$PHP_SELF?>" onKeyPress="return Form()" >
 <input name="var2" type="hidden" value="<?php=$var2?>">
 <input name="id" type="hidden" value="Ninguno">
  <input name="op" type="hidden" value="<?php echo @$op;?>">
  <table width="760" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" background="images/fondo.jpg">
    <tr> 
      <td width="710"> 
        <table width="735" border="1" align="center" cellpadding="2" cellspacing="1">
          <tr> 	
            <th colspan="7">SEGUIMIENTO</th>
          </tr>
          <tr align="center"> 
            <td colspan="8"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Nro 
              :</strong></font> 
              <input name="id_orden" type="text" value="<?php echo $id_orden;?>" size="3" readonly=""><br>
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Descripcion: 
              </strong>
              <?php $sqlTmp="SELECT desc_inc FROM ordenes WHERE id_orden=$id_orden";
				$ordenTmp=mysql_fetch_array(mysql_query( $sqlTmp));
				print $ordenTmp['desc_inc'];
				?>
              </font> 
              <hr></td>
          </tr>
          <tr align="center"> 
            <td width="28" class="menu">Nro</td>
            <td width="128" class="menu">REALIZADO POR</td>
            <td width="75" class="menu">ESTADO</td>
            <td width="183" class="menu">OBSERVACIONES</td>
            
            <td width="58" class="menu">ARCH. ADJ.</td>
            <td width="88" class="menu">FECHA</td>
            <td width="124" class="menu">HORA</td>
          </tr>
          <?php
		$sql = "SELECT *, DATE_FORMAT(fecha_seg, '%d/%m/%Y') AS fecha_seg FROM seguimiento WHERE id_orden='$id_orden' ORDER BY id_seg ASC, fecha_seg ASC, hora_seg ASC";
		$result=mysql_query($sql);
		$c=1;
		while($row=mysql_fetch_array($result)) 
  		{?>
          <tr align="center"> 
            <td nowrap>&nbsp;<?php echo $c++;?><input type="hidden" name="ce" id="ce" value="<?php echo $c;?>" /></td>
            <td nowrap>&nbsp;
			<?php 
			 $sql2="SELECT * FROM users WHERE login_usr='$row[login_usr]'";
			 $result2=mysql_query($sql2);
		  	 $row2=mysql_fetch_array($result2);
			 echo $row2['nom_usr']." ".$row2['apa_usr']." ".$row2['ama_usr'];
			?>			</td>
            <td nowrap>&nbsp; 
              <?php 
			if ($row['estado_seg']=="1")
			{echo "Cumplida en fecha";}
			if ($row['estado_seg']=="2")
			{echo "Cumplida retrasada";}
			if ($row['estado_seg']=="3")
			{echo "Pendiente en fecha";}
			if ($row['estado_seg']=="4")
			{echo "Pendiente retrasada";}
			if ($row['estado_seg']=="5")
			{echo "Desestimada";}
			?>            </td>
            <td align="center">&nbsp;<?php echo $row['obs_seg'];?></td>
			
			
			<?php 
				if (!isset($row['nomb_archivo']))
				{
					echo "<td>Ninguno</td>";
				}
				else 
				{
					echo"<td><a href=\"archivos_segui/".$row['nomb_archivo']."\" target=\"_blank\">$row[nomb_archivo]</a></td>";
				}
			?>
			
            <td nowrap><?php echo $row['fecha_seg'];?> </td>
            <td nowrap><?php echo $row['hora_seg'];?> </td>
          </tr>
          <?php
		 }

	  	  $sql = "SELECT * FROM solucion WHERE id_orden='$id_orden'";
		  $result=mysql_query($sql);
		  if ($row=mysql_fetch_array($result)){
			  echo '<tr align="center"> <td colspan="7"><input type="submit" name="RETORNAR" value="RETORNAR"></td></tr>';
		  }
		  else {
		  ?>
          <tr align="center"> 
            <td height="25" colspan="8">&nbsp;</td>
          </tr>
        </table>
        <table width="733" border="1" cellpadding="2" cellspacing="1">
          <tr> 
            <td width="7%" class="menu">Nro.</td>
            <td width="24%" class="menu">ESTADO</td>
            <td width="40%" class="menu">OBSERVACIONES </td>
			<td width="9%" class="menu"><div align="center">FECHA</div></td>
            <td width="9%" class="menu"><div align="center">HORA</div></td>
          </tr>
          <tr> 
            <td height="40">Nuevo</td>
            <td><select name="estado_seg" id="estado_seg">
              <option>1 (Cumplida en fecha)</option>
              <option>2 (Cumplida retrasada)</option>
              <option>3 (Pendiente en fecha)</option>
              <option>4 (Pendiente retrasada)</option>
              <option>5 (Desestimada)</option>
            </select></td>
            
			<td><textarea name="obs_seg" cols="50" rows="5" id="obs_seg2" onKeyDown="contador(this.form.obs_seg,this.form.remLen,255);"	onKeyUp="contador(this.form.obs_seg,this.form.remLen,255);"><?php echo @$obs?></textarea>
			  <input type="text" name="remLen" size="3" maxlength="3" value="255" readonly>
			  <br>
</td>
			
			<td class="menu"><div align="center"><strong><?php echo date("d/m/Y");?></strong></div></td>
            <td class="menu"><div align="center"><strong><?php echo date("H:i:s");?></strong></div></td>
          </tr>
		  
		  <tr> 
		  </tr> 
		  <td colspan="6">
		    <div align="center">
	        Archivo Adjunto              </div></td>
          <tr> 
		  <td colspan="6">
		    <div align="center">
			  <input name="archivo" type="file" size="60" value="<?php print @$archivo ?>" onClick="msgFile()">
            </div></td>
          <tr> 
            <td colspan="6"><div align="center"><br>
                <input name="reg_form" type="submit" value="GUARDAR"  <?php print $valid->onSubmit() ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<input type="submit" name="RETORNAR" value="RETORNAR">
</div></td>
          </tr>
		  <?php } ?>
        </table>
      
      </td>
    </tr>
	
  </table>
</form>  
