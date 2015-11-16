<?php if (isset($reg_form)) 
{	session_start();
	$login=$_SESSION["login"];
	include ("conexion.php");
	$sql8="SELECT * FROM users WHERE login_usr='$login'";
	$result8=mysql_db_query($db,$sql8,$link);
	$row8=mysql_fetch_array($result8);
	$nombre="$row8[nom_usr] $row8[apa_usr] $row8[ama_usr]";
	$sql6="SELECT tmp_conf FROM control_parametros";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	$tiemp=0;
	$sql7="SELECT * FROM ordenes WHERE cod_usr='$login'";
	$result7=mysql_db_query($db,$sql7,$link);
	while($row7=mysql_fetch_array($result7))
	{	$sql3="SELECT id_orden FROM conformidad WHERE id_orden='$row7[id_orden]'";
		$result3=mysql_db_query($db,$sql3,$link);
		$row3=mysql_fetch_array($result3);
		if (!$row3[id_orden])
		{$a1=substr($row7[fecha],0,4); $m1=substr($row7[fecha],5,2); $d1=substr($row7[fecha],8,2);
		$hoy=date("Y-m-d");
		$a2=substr($hoy,0,4); $m2=substr($hoy,5,2); $d2=substr($hoy,8,2);
		$d3=$d2-$d1; $m3=$m2-$m1; $a3=$a2-$a1;
		if ($a3 >= "0") 
		{if ($m3 >= "0")
	 		{if ($d3 >= "0")
			    {$a3=$a3; $m3=$m3; $d3=$d3;}
			 elseif ($d3<"0") 
			 	{$m3=$m3-1; $d3=30+$d3;
				 if ($m3 < "0"){$a3=$a3-1; $m3=12+$m3;}}}
		else {$a3=$a3-1; $m3=12+$m3;
				if ($d3 >= "0"){
				 $a3=$a3; $m3=$m3; $d3=$d3;}}}
		else
	 			{$a3="0"; $m3="0"; $d3="0";}

		if ($a3<>"0") {$a3=$a3*360;} else {$a3="";}
		if ($m3<>"0") {$m3=$m3*30;} else {$m3="";}
		$d4=$d3+$a3+$m3;
		if ($d4 > $row6[tmp_conf]) {$tiemp=tiemp+1;}
}}
if ($tiemp>="1")
{$desc="El usuario ".$nombre." no puede insertar mas ordenes de trabajo, debido a que tiene una orden que en ".$row6[tmp_conf]." dias no recibio conformidad ";
$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, tipo) ".
"VALUES('".date("Y-m-d")."','".date("H:i:s")."','SISTEMA','$desc','$tipo1')"; 
mysql_db_query($db,$sql,$link); 
$msg="USTED NO PUEDE INSERTAR MAS ORDENES DE TRABAJO, DEBIDO A QUE UNA DE ELLAS EXCEDIO\\n EN ".$row6[tmp_conf]." DIAS SIN CONFORMIDAD";}
else
{	$sql3="SELECT COUNT(id_orden) AS num1 FROM ordenes WHERE cod_usr='$login'";
	$result3=mysql_db_query($db,$sql3,$link);
	$row3=mysql_fetch_array($result3);
	$sql4="SELECT COUNT(id_orden) AS num2 FROM conformidad WHERE reg_conf='$login'";
	$result4=mysql_db_query($db,$sql4,$link);
	$row4=mysql_fetch_array($result4);
	$sql5="SELECT * FROM control_parametros";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
		
	if (($row3[num1]-$row4[num2])>=$row5[cant_ordenes])
	{
	$desc="El usuario ".$nombre." no puede insertar mas ordenes de trabajo, debido a que tiene ".$row5[cant_ordenes]." ordenes de trabajo sin conformidad ";
	$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, tipo) ".
	"VALUES('".date("Y-m-d")."','".date("H:i:s")."','SISTEMA','$desc','$tipo1')"; 
	mysql_db_query($db,$sql,$link); 
	$msg="USTED NO PUEDE INSERTAR MAS ORDENES DE TRABAJO, DEBIDO A QUE EXCEDIO EN ".$row5[cant_ordenes]."\\nORDENES SIN CONFORMIDAD";
	}
	else
	{
	if (strlen($desc_inc)<=10) {$msg="LA DESCRIPCION DEL INCIDENTE DEBE SER MAYOR A 10 CARACTERES";}
	else{
			if (!isset($login)) {  header("location: lista.php");}
			$tipo1=$tipo0.$tipo1;
			if ($archivo_name=="")				
				{	//echo "g";
				$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, tipo,ci_ruc) ".
				"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$desc_inc','$tipo1','$ci_ruc')"; 
				mysql_db_query($db,$sql,$link); 
				$systemData=$row5;
				if($systemData["conf_mail"]==1 || $systemData["conf_mail"]==3 || $systemData["conf_sms"]==1 || $systemData["conf_sms"]==3){
					//ENVIAR MSG
					$sql1="SELECT MAX(id_orden) AS id_or FROM ordenes"; 								
					$row1=mysql_fetch_array(mysql_db_query($db,$sql1,$link));
					if($row5["conf_sms"]==1 || $row5["conf_sms"]==3)
					{
								$sqlMovil="SELECT id_dat_tel_movil, direccion FROM dat_tel_movil";
								$movilRs=mysql_db_query($db, $sqlMovil, $link);
								while($tmp=mysql_fetch_array($movilRs)){
										$movilLst[$tmp[id_dat_tel_movil]]=$tmp[direccion];
								}
								$systemData[movilEmail]="591".$systemData[telefono_movil]."@".$movilLst[$systemData[id_dat_tel_movil]];												
								if (!mail($systemData[movilEmail],$systemData[mail],"Nro".$row1[id_or]."-Nuevo Requerimiento de Orden de Trabajo. $systemData[nombre]"))
								{$msg ="Precaucion, no se ha podido enviar la orden por correo electronico.\\n";}										
					}
					//Enviar mail al administrador de mesa de ayuda
					if($row5["conf_mail"]==1 || $row5["conf_mail"]==3)						
					{	$asunto = "Nro.$row1[id_or]. Nuevo Requerimiento de Trabajo de Mesa de Ayuda";	
						$mail = $systemData[mail];
						$mensaje = "
Nuevo Requerimiento de Mesa de Ayuda: Nro. $row1[id_or]
Cliente/Tecnico: $nombre
Descripcion: $desc_inc
Para mayores detalles, consulte el Sistema GesTor F1.\n\n$systemData[nombre]";						
						$tunombre = $row5[nombre];		
						$tuemail = $row5[mail_institucion];						
						$headers  = "From: $tunombre <$tuemail>\n";
						$headers .= "\n";						
						if(!mail($mail,$asunto,$mensaje,$headers)){$msg ="Precaucion, no se ha podido enviar la orden por correo electronico.\\n";}																
					}									
				}
				header("location: lista.php?msg=$msg");
				}		
			elseif ($archivo_name<>"")
				{	$extension = explode(".",$archivo_name); 
					$num = count($extension)-1; 
					//if($extension[$num]=="gif" OR $extension[$num]=="jpg" OR $extension[$num]=="doc") 
						//{
							$tam_max=1048576*$row5[tam_archivo];
							if($archivo_size < $tam_max)
							{
								$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, tipo,ci_ruc) ".
								"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$desc_inc','$tipo1','$ci_ruc')"; 
								mysql_db_query($db,$sql,$link); 
						
								$sql1="SELECT MAX(id_orden) AS id_or FROM ordenes"; 
								$result1=mysql_db_query($db,$sql1,$link);
								$row1=mysql_fetch_array($result1);
						
								$arch_nomb=$row1[id_or].".".$extension[$num];
								$sql2="UPDATE ordenes SET nomb_archivo='$arch_nomb' WHERE id_orden='$row1[id_or]'";
								mysql_db_query($db,$sql2,$link);	
								copy($archivo,"archivos adjuntos/".$arch_nomb);
								//Enviar mail y sms  al administrador de mesa de ayuda
								$systemData=$row5;
								if($systemData["conf_mail"]==2 || $systemData["conf_mail"]==3 || $systemData["conf_sms"]==2 || $systemData["conf_sms"]==3){
								//ENVIAR MSG
							if($row5["conf_sms"]==1 || $row5["conf_sms"]==3)
							{
											$sqlMovil="SELECT id_dat_tel_movil, direccion FROM dat_tel_movil";
											$movilRs=mysql_db_query($db, $sqlMovil, $link);
											while($tmp=mysql_fetch_array($movilRs)){
												$movilLst[$tmp[id_dat_tel_movil]]=$tmp[direccion];
											}
											$systemData[movilEmail]="591".$systemData[telefono_movil]."@".$movilLst[$systemData[id_dat_tel_movil]];												
											if (!mail($systemData[movilEmail],$systemData[mail],"Nro".$row1[id_or]."-Nuevo Requerimiento de Orden de Trabajo. $systemData[nombre]"))
											{$msg ="Precaucion, no se ha podido enviar la orden por correo electronico.\\n";}										
							}
							//Enviar mail al administrador de mesa de ayuda
							if($row5["conf_mail"]==1 || $row5["conf_mail"]==3)						
							{	$asunto = "Nro.$row1[id_or]. Nuevo Requerimiento de Trabajo de Mesa de Ayuda";	
								$mail = $systemData[mail];
								$mensaje = "
Nuevo Requerimiento de Mesa de Ayuda: Nro. $row1[id_or]
Cliente/Tecnico: $nombre
Descripcion: $desc_inc
Para mayores detalles, consulte el Sistema GesTor F1.\n\n$systemData[nombre]";

								$tunombre = $row5[nombre];		
								$tuemail = $row5[mail_institucion];						
								$headers  = "From: $tunombre <$tuemail>\n";
								$headers .= "\n";						
								if(!mail($mail,$asunto,$mensaje,$headers)){$msg ="Precaucion, no se ha podido enviar la orden por correo electronico.\\n";}																
							}																																						
						}
									header("location: lista.php");
							}
							else{$msg="EL TAMAÑO DEL ARCHIVO ADJUNTO NO DEBE SER MAYOR A ".$row5[tam_archivo]." Mb";}
				}
		}
	}
  }
}?>