<?php
if(isset($send_mail))
{
		//******************************************
		include("conexion.php");
		$sqlTmp="SELECT * FROM ordenes WHERE id_orden='$id_orden'";
		$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
		$sqlCliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$escal'";
		$ordenCliente=mysql_fetch_array(mysql_db_query($db, $sqlCliente, $link));
		$clienteNombre=$ordenCliente[nom_usr].' '.$ordenCliente[apa_usr].' '.$ordenCliente[ama_usr];
		$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
		$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
	
		if (!(empty($ordenCliente[email])))
		{
			$asunto = "Nro. $id_orden. Escalamiento de Orden de Trabajo";	
			$mail = $ordenCliente[email];
			$mensaje = "
			Escalamiento de Orden de Trabajo: Nro. $id_orden <br>
			Cliente/Tecnico: $clienteNombre<br>
			Descripcion: $ordenTmp[desc_inc]<br>
			Complejidad: $nivel_asig <br>
			Criticidad: $criticidad_asig <br>
			Prioridad: $prioridad_asig <br>
			Fecha Estimada de Solucion: $DE/$ME/$AE <br><br>
			Para mayores detalles, consulte el Sistema GesTor F1. <br>
			$systemData[nombre]";
			$tunombre = $systemData[nombre];		
			$tuemail  = $systemData[mail_institucion];												
			$headers = "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
			$headers .= "From: $tunombre <$tuemail>\r\n"; 						
			if(!mail($mail,$asunto,$mensaje,$headers))
			{ $msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente.";}																
			else{$msg="Mensaje enviado exitosamente $mail $asunto $mensaje $headers";}
		}//end isset si correo no es vacio
		else {	$msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente. El Usuario no tiene registrado su cuenta de correo";  }

	//**************************************************	
		//header("location: lista.php?msg=$msg"); 
}
if ($RETORNAR)
{ 	if ($op == 2) header("location: listae.php");
	else
		if ( $op == 3 )  header("location: listans.php");
		else
		{ 
			//
			if($tipificacion == 1)
			{
				header("location: lista_tipos.php?pg=$pg");
			}else
			{
				header("location: lista.php?pg=$pg");
			}
			//
		}
}	
	
if (isset($reg_form))
{
	ini_set("error_reporting", "E_ALL & ~E_NOTICE & ~E_WARNING");
	session_start();
	$login = $_SESSION["login"];
	include ("conexion.php");
	$sql0 = "SELECT * FROM asignacion WHERE id_orden='$var' ORDER BY id_asig DESC limit 1";
	$result0=mysql_db_query($db,$sql0,$link);
	$row0=mysql_fetch_array($result0);
	$sql5="SELECT * FROM users WHERE login_usr='$asig'";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
	$nombre="$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]";
	$sql6="SELECT * FROM control_parametros";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	$tiemp=0;
	$sql9 = "SELECT * FROM asignacion GROUP BY id_orden";
	$result9 = mysql_db_query($db,$sql9,$link);
	while($row9 = mysql_fetch_array($result9))
	{
		$sql7 = "SELECT * FROM asignacion WHERE id_orden='$row9[id_orden]' ORDER BY id_asig DESC limit 1";
		$result7 = mysql_db_query($db,$sql7,$link);
		$row7=mysql_fetch_array($result7);
		if ($row7[asig]=='$asig')
		{
		$sql8="SELECT id_orden FROM solucion WHERE id_orden='$row7[id_orden]'";
		$result8=mysql_db_query($db,$sql8,$link);
		$row8=mysql_fetch_array($result8);
		if (!$row8[id_orden])
		{$a1=substr($row7[fecha_asig],0,4); $m1=substr($row7[fecha_asig],5,2); $d1=substr($row7[fecha_asig],8,2);
		$hoy=date("Y-m-d");	$a2=substr($hoy,0,4); $m2=substr($hoy,5,2); $d2=substr($hoy,8,2);
		$d3=$d2-$d1; $m3=$m2-$m1; $a3=$a2-$a1;
		if ($a3 >= "0") 
		{if ($m3 >= "0")
	 		{if ($d3 >= "0")
			    {$a3=$a3; $m3=$m3; $d3=$d3;}
			 elseif ($d3<"0") 
			 	{$m3=$m3-1; $d3=30+$d3;
				 if ( $m3 < "0" ){$a3=$a3-1; $m3=12+$m3;}}}
		else {$a3=$a3-1; $m3=12+$m3;
				if ($d3 >= "0"){
				 $a3=$a3; $m3=$m3; $d3=$d3;}}}
		else
	 			{$a3="0"; $m3="0"; $d3="0";}

		if ($a3=="0") {$a3="";} else {$a3=$a3*360;}
		if ($m3=="0") {$m3="";} else {$m3=$m3*30;}
		$d4=$d3+$a3+$m3;
		if ($d4 > $row6[tmp_ord_abier]) {$tiemp=tiemp+1; $d5=$d4;} 
	}}}

//------------------------------------INICIO DE LA CONDICION DE COMPARACION-----------------------------------------------------/
// Adición del control de CONFORMIDAD
	$ordAbiertas = 1;
	$sCad = "select *from solucion	where login_sol='$asig'";
	$rCad = mysql_db_query($db,$sCad,$link);
	$cadena = "yanapti";
	$cont = 1;
	while($rowCad = mysql_fetch_array($rCad))
	{
		$cadena = $cadena.",$rowCad[id_orden]";
	}
	$cadena = str_replace("yanapti,","",$cadena);

    if($cadena <> "yanapti")
	{
		$sql = "select distinct(id_orden) from asignacion where area='$area' and asig='$asig' and id_orden NOT IN ($cadena) group by id_orden";
		$res = mysql_db_query($db,$sql,$link);
		while($row = mysql_fetch_array($res))
		{
			$ordAbiertas ++; 
		}
	}
	else{
	
		$sCad = "select distinct(id_orden) as numreg from asignacion where asig='$asig'";
		$sRes = mysql_db_query($db,$sCad,$link);
		while($sRow = mysql_fetch_array($sRes))
		{
			$cont = $cont +1;
		}
		$ordAbiertas = $cont;
	}
	//echo "<br>numero de registros  es : ".$ordAbiertas;
  if($ordAbiertas <= $row6[ord_abiertas])
  {

//---------------------------------------------------------------------------------------------------------------------------

if ($row0[asig]<>$asig)
{	
	
		/////
		$sqls1="SELECT max(id_asig) AS MAXIMO FROM asignacion WHERE id_orden='$id_orden' GROUP BY id_orden";
		$ress1=mysql_db_query($db,$sqls1,$link);
		$rows1=mysql_fetch_array($ress1);
		$sqls="SELECT * FROM asignacion WHERE id_asig='$rows1[MAXIMO]'";
		$ress=mysql_db_query($db,$sqls,$link);
		$rows=mysql_fetch_array($ress);
		
		if($rows[reg_asig])
		{
			if($area=="Cambios")
			{	
				//Si el control check esta activo
				if(isset($chkEscalar))
		  	    {
				$sql3="INSERT INTO asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,fechaestsol_asig,reg_asig,".
				"diagnos,escal,date_esc,time_esc,fechasol_esc,area,area_1) ".
				"VALUES ('$id_orden','$nivel_asig','$criticidad_asig','$prioridad_asig','$asig','".date("Y-m-d")."','".date("H:i:s")."',"."'".$AA."-".$MA."-".$DA."','$login','$diagnos','$escal','".date("Y-m-d")."','".date("H:i:s")."','".$AE."-".$ME."-".$DE."','$area','$pru1|$pru2|$pru3')";
				}
				else//en caso contrario
				{
				$sql3="INSERT INTO asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,fechaestsol_asig,reg_asig,".
				"diagnos,escal,date_esc,time_esc,fechasol_esc,area,area_1) ".
				"VALUES ('$id_orden','$nivel_asig','$criticidad_asig','$prioridad_asig','$asig','".date("Y-m-d")."','".date("H:i:s")."',"."'".$AA."-".$MA."-".$DA."','$login','$diagnos','0','','','','$area','$pru1|$pru2|$pru3')";
				}//fin de control check
			}
			else
			{
				//Si el check esta activo
				if(isset($chkEscalar))
		  	    {
				$sql3="INSERT INTO asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,fechaestsol_asig,reg_asig,".
				"diagnos,escal,date_esc,time_esc,fechasol_esc,area) ".
				"VALUES ('$id_orden','$nivel_asig','$criticidad_asig','$prioridad_asig','$asig','".date("Y-m-d")."','".date("H:i:s")."',".
				"'".$AA."-".$MA."-".$DA."','$login','$diagnos','$escal','".date("Y-m-d")."','".date("H:i:s")."','".$AE."-".$ME."-".$DE."','$area')";
				}
				else//En caso contrario
				{
				$sql3="INSERT INTO asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,fechaestsol_asig,reg_asig,".
				"diagnos,escal,date_esc,time_esc,fechasol_esc,area) ".
				"VALUES ('$id_orden','$nivel_asig','$criticidad_asig','$prioridad_asig','$asig','".date("Y-m-d")."','".date("H:i:s")."',"."'".$AA."-".$MA."-".$DA."','$login','$diagnos','0','','','','$area')";
				}//Fin de check
			}
		}
		else
		{
			if($area=="Cambios")
			{
				//Si el check esta activo
				if(isset($chkEscalar))
		  	    {
				$sql3="UPDATE asignacion SET id_orden='$id_orden',nivel_asig='$nivel_asig',criticidad_asig='$criticidad_asig',prioridad_asig='$prioridad_asig',asig='$asig',fecha_asig='".date("Y-m-d")."',hora_asig='".date("H:i:s")."',fechaestsol_asig='".$AA."-".$MA."-".$DA."',reg_asig='$login',".
				"diagnos='$diagnos',escal='$escal',date_esc='".date("Y-m-d")."',time_esc='".date("H:i:s")."',fechasol_esc='".$AE."-".$ME."-".$DE."',area='$area',area_1='$pru1|$pru2|$pru3' WHERE id_asig='$rows[id_asig]'";
				
//************************************Envio de Email**********************************************************************************	
					include("conexion.php");
					$sqlTmp="SELECT * FROM ordenes WHERE id_orden='$id_orden'";
					$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
					$sqlCliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$escal'";
					$ordenCliente=mysql_fetch_array(mysql_db_query($db, $sqlCliente, $link));
					$clienteNombre=$ordenCliente[nom_usr].' '.$ordenCliente[apa_usr].' '.$ordenCliente[ama_usr];
					$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
					$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
				
					if (!(empty($ordenCliente[email])))
					{
						$asunto = "Nro. $id_orden. Escalamiento de Orden de Trabajo";	
						$mail = $ordenCliente[email];
						$mensaje = "
						Escalamiento de Orden de Trabajo: Nro. $id_orden <br>
						Cliente/Tecnico: $clienteNombre<br>
						Descripcion: $ordenTmp[desc_inc]<br>
						Complejidad: $nivel_asig <br>
						Criticidad: $criticidad_asig <br>
						Prioridad: $prioridad_asig <br>
						Fecha Estimada de Solucion: $DE/$ME/$AE <br><br>
						Para mayores detalles, consulte el Sistema GesTor F1. <br>
						$systemData[nombre]";
						$tunombre = $systemData[nombre];		
						$tuemail  = $systemData[mail_institucion];												
						$headers = "MIME-Version: 1.0\r\n"; 
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
						$headers .= "From: $tunombre <$tuemail>\r\n"; 						
						if(!mail($mail,$asunto,$mensaje,$headers))
						{ $msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente.";}																
						else{$msg="Mensaje enviado exitosamente $mail $asunto $mensaje $headers";}
					}//end isset si correo no es vacio
					else {	$msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente. El Usuario no tiene registrado su cuenta de correo";  }

//************************************************************************************************************************************	

				}
				else//caso contrario
				{
				$sql3="UPDATE asignacion SET id_orden='$id_orden',nivel_asig='$nivel_asig',criticidad_asig='$criticidad_asig',prioridad_asig='$prioridad_asig',asig='$asig',fecha_asig='".date("Y-m-d")."',hora_asig='".date("H:i:s")."',fechaestsol_asig='".$AA."-".$MA."-".$DA."',reg_asig='$login',".
				"diagnos='$diagnos',escal='0',date_esc='',time_esc='',fechasol_esc='',area='$area',area_1='$pru1|$pru2|$pru3' WHERE id_asig='$rows[id_asig]'";
				}//fin de check
			}
			else
			{
				//Si el control check esta activo
				if(isset($chkEscalar))
		  	    {
				$sql3="UPDATE asignacion SET id_orden='$id_orden',nivel_asig='$nivel_asig',criticidad_asig='$criticidad_asig',prioridad_asig='$prioridad_asig',asig='$asig',fecha_asig='".date("Y-m-d")."',hora_asig='".date("H:i:s")."',fechaestsol_asig='".$AA."-".$MA."-".$DA."',reg_asig='$login',".
				"diagnos='$diagnos',escal='$escal',date_esc='".date("Y-m-d")."',time_esc='".date("H:i:s")."',fechasol_esc='".$AE."-".$ME."-".$DE."',area='$area' WHERE id_asig='$rows[id_asig]'";
				
//****************************************Envio de Email*****************************************************************************	
					include("conexion.php");
					$sqlTmp="SELECT * FROM ordenes WHERE id_orden='$id_orden'";
					$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
				$sqlCliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$escal'";
					$ordenCliente=mysql_fetch_array(mysql_db_query($db, $sqlCliente, $link));
					$clienteNombre=$ordenCliente[nom_usr].' '.$ordenCliente[apa_usr].' '.$ordenCliente[ama_usr];
					$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
					$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
				
					if (!(empty($ordenCliente[email])))
					{
						$asunto = "Nro. $id_orden. Escalamiento de Orden de Trabajo";	
						$mail = $ordenCliente[email];
						$mensaje = "
						Escalamiento de Orden de Trabajo: Nro. $id_orden <br>
						Cliente/Tecnico: $clienteNombre<br>
						Descripcion: $ordenTmp[desc_inc]<br>
						Complejidad: $nivel_asig <br>
						Criticidad: $criticidad_asig <br>
						Prioridad: $prioridad_asig <br>
						Fecha Estimada de Solucion: $DE/$ME/$AE <br><br>
						Para mayores detalles, consulte el Sistema GesTor F1. <br>
						$systemData[nombre]";
						$tunombre = $systemData[nombre];		
						$tuemail  = $systemData[mail_institucion];												
						$headers = "MIME-Version: 1.0\r\n"; 
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
						$headers .= "From: $tunombre <$tuemail>\r\n"; 						
						if(!mail($mail,$asunto,$mensaje,$headers))
						{ $msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente.";}																
						else{$msg="Mensaje enviado exitosamente $mail $asunto $mensaje $headers";}
					}//end isset si correo no es vacio
					else {	$msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente. El Usuario no tiene registrado su cuenta de correo";  }

//************************************************************************************************************************************	
			
				}
				else//en otro caso
				{
				$sql3="UPDATE asignacion SET id_orden='$id_orden',nivel_asig='$nivel_asig',criticidad_asig='$criticidad_asig',prioridad_asig='$prioridad_asig',asig='$asig',fecha_asig='".date("Y-m-d")."',hora_asig='".date("H:i:s")."',fechaestsol_asig='".$AA."-".$MA."-".$DA."',reg_asig='$login',".
				"diagnos='$diagnos',escal='0',date_esc='',time_esc='',fechasol_esc='',area='$area' WHERE id_asig='$rows[id_asig]'";
				}//fin de check
			}
		}
		if (mysql_db_query($db,$sql3,$link))
		{
			$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
			$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
				
				if($systemData["conf_mail"]==2 || $systemData["conf_mail"]==3 || $systemData["conf_sms"]==2 || $systemData["conf_sms"]==3)
				{	$userData = $row5;
					$userName = $userData[nom_usr]." ".$userData[apa_usr]." ".$userData[ama_usr];
					$sqlTmp = "SELECT cod_usr, desc_inc FROM ordenes WHERE id_orden='$id_orden'";
					$ordenTmp = mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
					if($ordenTmp[cod_usr]!="SISTEMA") {
						$sqlCliente = "SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$ordenTmp[cod_usr]'";
						$ordenCliente  = mysql_fetch_array(mysql_db_query($db, $sqlCliente, $link));
						$clienteNombre = $ordenCliente[nom_usr]." ".$ordenCliente[apa_usr]." ".$ordenCliente[ama_usr];
					}
					else $clienteNombre="SISTEMA";
					$sqls = "SELECT ext_usr,  id_dat_tel_movil  FROM users WHERE login_usr='$asig'";
					$ress = mysql_db_query($db, $sqls, $link);
					$fila = mysql_fetch_array($ress);
					$sqls2 = "SELECT * FROM users WHERE login_usr='$asig'";
					$ress2 = mysql_db_query($db, $sqls2, $link);
					$fila2 = mysql_fetch_array($ress2);
					
					//envio de SMS
					include ("conexion.php");
					if (!(empty($fila[ext_usr])))
					{	
					//*************
						if($systemData["conf_sms"]==2 || $systemData["conf_sms"]==3)
						{	$sqlMovil="SELECT id_dat_tel_movil, direccion FROM dat_tel_movil";
									$movilRs=mysql_db_query($db, $sqlMovil, $link);
									while($tmp=mysql_fetch_array($movilRs)){
										$movilLst[$tmp[id_dat_tel_movil]]=$tmp[direccion];
									}
									$userData[movilEmail]=$userData[ext_usr]."@".$movilLst[$userData[id_dat_tel_movil]];									
								if(strlen($ordenTmp[desc_inc])>150) $mail_sms=substr($ordenTmp[desc_inc],0,150)." ...";
								else $mail_sms=$ordenTmp[desc_inc];
								if (!mail($userData[movilEmail],"Gestor TI","Nueva Asignacion: $mail_sms. $systemData[nombre]"))
								{$msg ="Precaucion, no se ha podido enviar la orden por SMS al Usuario asignado.\n";}										
							}					
					//***********	
					}
					else{ $msg = "Precaucion, no se ha podido enviar la orden por SMS. El usuario no tiene registrado su numero de celular";}	
					//envio de mail
					if($systemData["conf_mail"]==2 || $systemData["conf_mail"]==3)																				
					{	$tmpComplejidad=array(1=>"1 - Baja", 2=>"2 - Media", 3=>"3 - Alta");
						$tmpPrioridad = array(3=>"3 - Baja", 2=>"2 - Media", 1=>"1 - Alta");					
						
						if (!(empty($fila2[email])))
						{	
						//***********************
						$asunto = "Nro. $id_orden. Nueva Asignacion de Orden de Trabajo";	
						$mail = $userData[email];
						$mensaje = "
						Nueva Asignacion de Orden de Trabajo: Nro. $id_orden <br>							
						Cliente/Tecnico: $clienteNombre <br>
						Descripcion: $ordenTmp[desc_inc] <br>
						Complejidad: $tmpComplejidad[$nivel_asig] <br>
						Criticidad: $tmpPrioridad[$criticidad_asig] <br>
						Prioridad: $tmpPrioridad[$prioridad_asig] <br>
						Diagnostico Inicial: $diagnos <br>
						Fecha Estimada de Solucion: $DA/$MA/$AA <br><br>
						Para mayores detalles, consulte el Sistema GesTor F1. <br>
						$systemData[nombre]";
						$tunombre = $systemData[nombre];		
						$tuemail  = $systemData[mail_institucion];
						$headers = "MIME-Version: 1.0\r\n"; 
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
						$headers .= "From: $tunombre <$tuemail>\r\n"; 												
						
						if(!mail($mail,$asunto,$mensaje, $headers))
						{ $msg ="Precaucion, no se ha podido enviar la orden por correo electronico al Usuario asignado.";}																
				
						//*******************
						}//if them si correo no es vacio
					else 
					{	$msg="Precaucion, no se ha podido enviar la orden por correo electronico. El usuario no tiene registrado su cuenta de correo";  
					}
				}
			}
			if ($op == 2)  
				header("location: listae.php?msg=$msg"); 
			else 
			{	if ( $op == 3)header("location: listans.php?msg=$msg");
				else
				{ 
					//
					if($tipificacion == 1)
					{
						header("location: lista_tipos.php?msg=$msg&pg=$pg"); 	
					}else{
						header("location: lista.php?msg=$msg&pg=$pg"); 	
					}
					//
				}	
			}	
			//exit;
			}
			else{$msg="OCURRIO UN ERROR EN LA MIENTRAS SE ACTUALIZABA".mysql_errno().": ".mysql_error();}
		}
	//}
//}
///------------------------------------ROW0[ASIG] ES IGUAL A ASIG DEL LIST-----------------------------------------------------/
//------------------------------------------------------------------------------------------------------------------------------
else     
{
		//echo "<br>INGRESA POR ELSE DONDE ASIG ES IGUAL ASIG DEL LIST";

		$sqls1="SELECT max(id_asig) AS MAXIMO FROM asignacion WHERE id_orden='$id_orden' GROUP BY id_orden";
		$ress1=mysql_db_query($db,$sqls1,$link);
		$rows1=mysql_fetch_array($ress1);
		$sqls="SELECT * FROM asignacion WHERE id_asig='$rows1[MAXIMO]'";
		$ress=mysql_db_query($db,$sqls,$link);
		$rows=mysql_fetch_array($ress);
		//echo "<br>row es : ".$rows[reg_asig];
		if($rows[reg_asig])
		{
			//echo "<br>(ELSE) Pero ingresa por IF en rows[reg_asig]";
			//echo "<br>Escalado a  es igual a : ".$chkEscalar;
		    //echo "<br>ingresa";
			if($area=="Cambios")
			{	
			    if(isset($chkEscalar))
		  	    {
				$sql3="INSERT INTO asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,fechaestsol_asig,reg_asig,".
				"diagnos,escal,date_esc,time_esc,fechasol_esc,area,area_1) ".
				"VALUES ('$var','$nivel_asig','$criticidad_asig','$prioridad_asig','$asig','".date("Y-m-d")."','".date("H:i:s")."',".
				"'".$AA."-".$MA."-".$DA."','$login','$diagnos','$escal','".date("Y-m-d")."','".date("H:i:s")."','".$AE."-".$ME."-".$DE."','$area','$pru1|$pru2|$pru3')";
				
//****************************************Envio de Email*****************************************************************************	
					include("conexion.php");
					$sqlTmp="SELECT * FROM ordenes WHERE id_orden='$id_orden'";
					$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
				$sqlCliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$escal'";
					$ordenCliente=mysql_fetch_array(mysql_db_query($db, $sqlCliente, $link));
					$clienteNombre=$ordenCliente[nom_usr].' '.$ordenCliente[apa_usr].' '.$ordenCliente[ama_usr];
					$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
					$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
				
					if (!(empty($ordenCliente[email])))
					{
						$asunto = "Nro. $id_orden. Escalamiento de Orden de Trabajo";	
						$mail = $ordenCliente[email];
						$mensaje = "
						Escalamiento de Orden de Trabajo: Nro. $id_orden <br>
						Cliente/Tecnico: $clienteNombre<br>
						Descripcion: $ordenTmp[desc_inc]<br>
						Complejidad: $nivel_asig <br>
						Criticidad: $criticidad_asig <br>
						Prioridad: $prioridad_asig <br>
						Fecha Estimada de Solucion: $DE/$ME/$AE <br><br>
						Para mayores detalles, consulte el Sistema GesTor F1. <br>
						$systemData[nombre]";
						$tunombre = $systemData[nombre];		
						$tuemail  = $systemData[mail_institucion];												
						$headers = "MIME-Version: 1.0\r\n"; 
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
						$headers .= "From: $tunombre <$tuemail>\r\n"; 						
						if(!mail($mail,$asunto,$mensaje,$headers))
						{ $msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente.";}																
						else{$msg="Mensaje enviado exitosamente $mail $asunto $mensaje $headers";}
					}//end isset si correo no es vacio
					else {	$msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente. El Usuario no tiene registrado su cuenta de correo";  }

//************************************************************************************************************************************	
		    }
				else
				{
				$sql3="INSERT INTO asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,fechaestsol_asig,reg_asig,".
				"diagnos,escal,date_esc,time_esc,fechasol_esc,area,area_1) ".
				"VALUES ('$var','$nivel_asig','$criticidad_asig','$prioridad_asig','$asig','".date("Y-m-d")."','".date("H:i:s")."',".
				"'".$AA."-".$MA."-".$DA."','$login','$diagnos','0','','','','$area','$pru1|$pru2|$pru3')";
				}
			}
			else
			{
				// Si el control checked esta activado
				if(isset($chkEscalar))
		  	    {
				$sql3="INSERT INTO asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,fechaestsol_asig,reg_asig,".
				"diagnos,escal,date_esc,time_esc,fechasol_esc,area) ".
				"VALUES ('$var','$nivel_asig','$criticidad_asig','$prioridad_asig','$asig','".date("Y-m-d")."','".date("H:i:s")."',".
				"'".$AA."-".$MA."-".$DA."','$login','$diagnos','$escal','".date("Y-m-d")."','".date("H:i:s")."','".$AE."-".$ME."-".$DE."','$area')";
//****************************************Envio de Email*****************************************************************************	
					include("conexion.php");
					$sqlTmp="SELECT * FROM ordenes WHERE id_orden='$id_orden'";
					$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
					$sqlCliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$escal'";
					$ordenCliente=mysql_fetch_array(mysql_db_query($db, $sqlCliente, $link));
					$clienteNombre=$ordenCliente[nom_usr].' '.$ordenCliente[apa_usr].' '.$ordenCliente[ama_usr];
					$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
					$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
				
					if (!(empty($ordenCliente[email])))
					{
						$asunto = "Nro. $id_orden. Escalamiento de Orden de Trabajo";	
						$mail = $ordenCliente[email];
						$mensaje = "
						Escalamiento de Orden de Trabajo: Nro. $id_orden <br>
						Cliente/Tecnico: $clienteNombre<br>
						Descripcion: $ordenTmp[desc_inc]<br>
						Complejidad: $nivel_asig <br>
						Criticidad: $criticidad_asig <br>
						Prioridad: $prioridad_asig <br>
						Fecha Estimada de Solucion: $DE/$ME/$AE <br><br>
						Para mayores detalles, consulte el Sistema GesTor F1. <br>
						$systemData[nombre]";
						$tunombre = $systemData[nombre];		
						$tuemail  = $systemData[mail_institucion];												
						$headers = "MIME-Version: 1.0\r\n"; 
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
						$headers .= "From: $tunombre <$tuemail>\r\n"; 						
						if(!mail($mail,$asunto,$mensaje,$headers))
						{ $msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente.";}																
						else{$msg="Mensaje enviado exitosamente $mail $asunto $mensaje $headers";}
					}//end isset si correo no es vacio
					else {	$msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente. El Usuario no tiene registrado su cuenta de correo";  }

//************************************************************************************************************************************	

				
				}//Caso contrario
				else
				{
				$sql3="INSERT INTO asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,fechaestsol_asig,reg_asig,".
				"diagnos,escal,date_esc,time_esc,fechasol_esc,area) ".
				"VALUES ('900','2','2','2','$asig','".date("Y-m-d")."','".date("H:i:s")."',".
				"'".$AA."-".$MA."-".$DA."','$login','$diagnos','0','','','','$area')";
				}
				//Fin del control checked

			}
		}
		else
		{
			//echo "<br>(ELSE) Pero ingresa por else en rows[reg_asig]";
			//echo "<br>Escalado a  es igual a : ".$chkEscalar;
			if($area=="Cambios")
			{
				//Si el control checked esta activo
				if(isset($chkEscalar))
		  	    {
				$sql3="UPDATE asignacion SET id_orden='$id_orden',nivel_asig='$nivel_asig',criticidad_asig='$criticidad_asig',prioridad_asig='$prioridad_asig',asig='$asig',fecha_asig='".date("Y-m-d")."',hora_asig='".date("H:i:s")."',fechaestsol_asig='".$AA."-".$MA."-".$DA."',reg_asig='$login',".
				"diagnos='$diagnos',escal='$escal',date_esc='".date("Y-m-d")."',time_esc='".date("H:i:s")."',fechasol_esc='".$AE."-".$ME."-".$DE."',area='$area',area_1='$pru1|$pru2|$pru3' WHERE id_asig='$rows[id_asig]'";
//****************************************Envio de Email*****************************************************************************	
					include("conexion.php");
					$sqlTmp="SELECT * FROM ordenes WHERE id_orden='$id_orden'";
					$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
					$sqlCliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$escal'";
					$ordenCliente=mysql_fetch_array(mysql_db_query($db, $sqlCliente, $link));
					$clienteNombre=$ordenCliente[nom_usr].' '.$ordenCliente[apa_usr].' '.$ordenCliente[ama_usr];
					$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
					$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
				
					if (!(empty($ordenCliente[email])))
					{
						$asunto = "Nro. $id_orden. Escalamiento de Orden de Trabajo";	
						$mail = $ordenCliente[email];
						$mensaje = "
						Escalamiento de Orden de Trabajo: Nro. $id_orden <br>
						Cliente/Tecnico: $clienteNombre<br>
						Descripcion: $ordenTmp[desc_inc]<br>
						Complejidad: $nivel_asig <br>
						Criticidad: $criticidad_asig <br>
						Prioridad: $prioridad_asig <br>
						Fecha Estimada de Solucion: $DE/$ME/$AE <br><br>
						Para mayores detalles, consulte el Sistema GesTor F1. <br>
						$systemData[nombre]";
						$tunombre = $systemData[nombre];		
						$tuemail  = $systemData[mail_institucion];												
						$headers = "MIME-Version: 1.0\r\n"; 
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
						$headers .= "From: $tunombre <$tuemail>\r\n"; 						
						if(!mail($mail,$asunto,$mensaje,$headers))
						{ $msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente.";}																
						else{$msg="Mensaje enviado exitosamente $mail $asunto $mensaje $headers";}
					}//end isset si correo no es vacio
					else {	$msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente. El Usuario no tiene registrado su cuenta de correo";  }

//************************************************************************************************************************************	

				}//En caso contrario
				else
				{
				$sql3="UPDATE asignacion SET id_orden='$id_orden',nivel_asig='$nivel_asig',criticidad_asig='$criticidad_asig',prioridad_asig='$prioridad_asig',asig='$asig',fecha_asig='".date("Y-m-d")."',hora_asig='".date("H:i:s")."',fechaestsol_asig='".$AA."-".$MA."-".$DA."',reg_asig='$login',".
				"diagnos='$diagnos',escal='0',date_esc='',time_esc='',fechasol_esc='',area='$area',area_1='$pru1|$pru2|$pru3' WHERE id_asig='$rows[id_asig]'";
				}//Fin de Control Check
			}
			else
			{
				//Si el control check esta activo
				if(isset($chkEscalar))
		  	    {
				$sql3="UPDATE asignacion SET id_orden='$id_orden',nivel_asig='$nivel_asig',criticidad_asig='$criticidad_asig',prioridad_asig='$prioridad_asig',asig='$asig',fecha_asig='".date("Y-m-d")."',hora_asig='".date("H:i:s")."',fechaestsol_asig='".$AA."-".$MA."-".$DA."',reg_asig='$login',".
				"diagnos='$diagnos',escal='$escal',date_esc='".date("Y-m-d")."',time_esc='".date("H:i:s")."',fechasol_esc='".$AE."-".$ME."-".$DE."',area='$area' WHERE id_asig='$rows[id_asig]'";
//****************************************Envio de Email*****************************************************************************	
					include("conexion.php");
					$sqlTmp="SELECT * FROM ordenes WHERE id_orden='$id_orden'";
					$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
				$sqlCliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$escal'";
					$ordenCliente=mysql_fetch_array(mysql_db_query($db, $sqlCliente, $link));
					$clienteNombre=$ordenCliente[nom_usr].' '.$ordenCliente[apa_usr].' '.$ordenCliente[ama_usr];
					$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
					$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
				
					if (!(empty($ordenCliente[email])))
					{
						$asunto = "Nro. $id_orden. Escalamiento de Orden de Trabajo";	
						$mail = $ordenCliente[email];
						$mensaje = "
						Escalamiento de Orden de Trabajo: Nro. $id_orden <br>
						Cliente/Tecnico: $clienteNombre<br>
						Descripcion: $ordenTmp[desc_inc]<br>
						Complejidad: $nivel_asig <br>
						Criticidad: $criticidad_asig <br>
						Prioridad: $prioridad_asig <br>
						Fecha Estimada de Solucion: $DE/$ME/$AE <br><br>
						Para mayores detalles, consulte el Sistema GesTor F1. <br>
						$systemData[nombre]";
						$tunombre = $systemData[nombre];		
						$tuemail  = $systemData[mail_institucion];												
						$headers = "MIME-Version: 1.0\r\n"; 
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
						$headers .= "From: $tunombre <$tuemail>\r\n"; 						
						if(!mail($mail,$asunto,$mensaje,$headers))
						{ $msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente.";}																
						else{$msg="Mensaje enviado exitosamente $mail $asunto $mensaje $headers";}
					}//end isset si correo no es vacio
					else {	$msg ="Precaución, no se ha podido enviar la orden por correo electrónico al Cliente. El Usuario no tiene registrado su cuenta de correo";  }

//************************************************************************************************************************************	

				}
				else//En caso contrario
				{
				$sql3="UPDATE asignacion SET id_orden='$id_orden',nivel_asig='$nivel_asig',criticidad_asig='$criticidad_asig',prioridad_asig='$prioridad_asig',asig='$asig',fecha_asig='".date("Y-m-d")."',hora_asig='".date("H:i:s")."',fechaestsol_asig='".$AA."-".$MA."-".$DA."',reg_asig='$login',".
				"diagnos='$diagnos',escal='0',date_esc='',time_esc='',fechasol_esc='',area='$area' WHERE id_asig='$rows[id_asig]'";
				}//Fin de control check
			}
		}
				//echo "<br>sql es : ".$sql3;
				//die();
				mysql_db_query($db,$sql3,$link);
			
				$sqlSystem="SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
				$systemData=mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
				
				if($systemData["conf_mail"]==2 || $systemData["conf_mail"]==3 || $systemData["conf_sms"]==2 || $systemData["conf_sms"]==3){				
				$sql5="SELECT * FROM users WHERE login_usr='$asig'";
				$result5=mysql_db_query($db,$sql5,$link);
				$row5=mysql_fetch_array($result5);
					$userData=$row5;
					$userName=$userData[nom_usr].' '.$userData[apa_usr].' '.$userData[ama_usr];
					$sqlTmp="SELECT cod_usr, desc_inc FROM ordenes WHERE id_orden=$var";
					$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
					if($ordenTmp[cod_usr]!="SISTEMA") {
						$sqlCliente="SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$ordenTmp[cod_usr]'";
						$ordenCliente=mysql_fetch_array(mysql_db_query($db, $sqlCliente, $link));
						$clienteNombre=$ordenCliente[nom_usr].' '.$ordenCliente[apa_usr].' '.$ordenCliente[ama_usr];
						}
					else $clienteNombre="SISTEMA";
					//envio de SMS
					$sqls = "SELECT ext_usr,  id_dat_tel_movil  FROM users WHERE login_usr='$asig'";
					$ress = mysql_db_query($db, $sqls, $link);
					$fila = mysql_fetch_array($ress);
					$sqls2 = "SELECT * FROM users WHERE login_usr='$asig'";
					$ress2 = mysql_db_query($db, $sqls2, $link);
					$fila2 = mysql_fetch_array($ress2);						
					if (!(empty($fila[ext_usr])))
					{
					//*************
							if($systemData["conf_sms"]==2 || $systemData["conf_sms"]==3)
								{	$sqlMovil="SELECT id_dat_tel_movil, direccion FROM dat_tel_movil";
									$movilRs=mysql_db_query($db, $sqlMovil, $link);
									while($tmp=mysql_fetch_array($movilRs)){
										$movilLst[$tmp[id_dat_tel_movil]]=$tmp[direccion];
									}
									$userData[movilEmail]=$userData[ext_usr]."@".$movilLst[$userData[id_dat_tel_movil]];									
								if(strlen($ordenTmp[desc_inc])>150) $mail_sms=substr($ordenTmp[desc_inc],0,150)." ...";
								else $mail_sms=$ordenTmp[desc_inc];
								if (!(mail($userData[movilEmail],"Gestor TI","Recordatorio de Asignacion: $mail_sms. $systemData[nombre]")))								
								{ $msg ="Precaucion, no se ha podido enviar la orden por SMS al Usuario asignado.\n";}										
							}					
					//***********	
					}
					else { $msg="Precaucion, no se ha podido enviar la orden por SMS. El usuario no tiene registrado su numero de celular.\n";}
					//envio de mail
					if($systemData["conf_mail"]==2 || $systemData["conf_mail"]==3){																				
						$tmpComplejidad=array(1=>"1 - Baja", 2=>"2 - Media", 3=>"3 - Alta");
						$tmpPrioridad=array(3=>"3 - Baja", 2=>"2 - Media", 1=>"1 - Alta");
						
					}
				}

				if ($op == 2)  
					header("location: listae.php?msg=$msg"); 
				else 
				{	if ( $op == 3)	 header("location: listans.php?msg=$msg");
					else
					{ 
						//
						if($tipificacion == 1)
						{
							header("location: lista_tipos.php?msg=$msg&pg=$pg"); 	
						}else{
							header("location: lista.php?msg=$msg&pg=$pg"); 	
						}
						//
					}
				}	
				exit;
 }
 
//------------------------------------------------------------------------------------------------------------------------------
 
   }
   else{
				$nombre = mostrar($asig);
				$nombre = strtoupper($nombre);
				$desc = "NO PUEDE RE ASIGNAR MAS ORDENES AL USUARIO ".$nombre." , DEBIDO A QUE SUPERO LA CANTIDAD DE ORDENES ABIERTAS SIN SOLUCION.";
				$sqlIns="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc) ".
				"VALUES('".date("Y-m-d")."','".date("H:i:s")."','SISTEMA','$desc')"; 
				mysql_db_query($db,$sqlIns,$link);
				$msg="NO PUEDE RE ASIGNAR MAS ORDENES AL USUARIO ".$nombre." , DEBIDO A QUE SUPERO LA CANTIDAD DE ORDENES ABIERTAS SIN SOLUCION.";
				
		}	
 
//------------------------------------FIN DE LA CONDICION DE COMPARACION---------------------------------------------------------/
}
include("top.php");

$id_orden=($_GET['id_orden']);

?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTextNormal ( "id_orden",  "Numero de Orden $errorMsgJs[expresion]" );
$valid->addFunction ( "autocompleteprueba",  "" );
$valid->addFunction ( "verifEscal",  "" );
$valid->addIsNotEmpty ( "NombResp",  "Nombre del Responsable, $errorMsgJs[empty]" );
$valid->addIsDate   ( "DA", "MA", "AA", "Fecha de Asignacion, $errorMsgJs[date]" );
$valid->addExists ( "diagnos",  "Diagnostico Inicial, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "asig", "Asignado a, $errorMsgJs[empty]" );
$valid->addIsDate   ( "DE", "ME	", "AE", "Fecha de Escalamiento, $errorMsgJs[date]" );
$valid->addFunction ( "autocompleteDate",  "" );
echo $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<script language="JavaScript">
<!--
function autocompleteDate () {
	var form=document.form1;
	
	var da=form.DA.value;
	var ma=form.MA.value
	var de=form.DE.value;
	var me=form.ME.value
	
	if (da.length==1) da='0'+da;
	if (ma.length==1) ma='0'+ma;
	if (de.length==1) de='0'+de;
	if (me.length==1) me='0'+me;
	
	var from = ma + '/' + da + '/' + form.AA.value;
	var to = me + '/' +  de + '/' +  form.AE.value;
	
	if (Date.parse(to) < Date.parse(from)) {		
		form.DE.value=form.DA.value;
		form.ME.value=form.MA.value;
		form.AE.value=form.AA.value;
		return true;
	}
	return true;
}
function autocompleteprueba () 
{	
	var form=document.form1;
	if(form.area[4].checked==1)
	{
		if(form.pru1.checked==0 && form.pru2.checked==0 && form.pru3.checked==0)
		{ 	alert ("Debe seleccionar un Tipo de Riesgo.\n\nMensaje generado por GesTor F1.");
			return (false);
		}	
		return true;	
	}
	return true;
}
-->
</script>
<?php 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("fechae","Fecha estimada de solucion");
	print $help->ToHtml();
 ?>
<?php
	if($id_orden == "")
	{  $id_orden = $id_orden2;}
?>
<font color="#FF0000" face="Arial, Helvetica, sans-serif"><strong><?php //echo $msg;?></strong></font>
<form action="asignacion_last.php" method="post" name="form1" onKeyPress="return Form()">
<input name="var" type="hidden" value="<?php echo $id_orden;?>">
<input name="id_orden2" type="hidden" value="<?php echo $id_orden;?>">
<input name="tipificacion" type="hidden" value="<?php=$tipificacion?>">
<input name="pg" type="hidden" value="<?php=$pg?>">


  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
      <td colspan="9"> <div align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>HISTORIAL 
          DE ASIGNACIONES DE LA ORDEN DE TRABAJO Nro. </strong>
          <?php echo $id_orden;?></font></div></td>
    </tr>
    <tr bgcolor="#006699"> 
      <td width="8%"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
          y Hora</font></div></td>
      <td width="15%"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Asignado 
          por</font></div></td>
      <td width="15%"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Asignado 
          a</font></div></td>
      <td width="12%"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Diagnostico</font></div></td>
      <td width="8%"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha de Solucion </font></div></td>
      <td width="13%"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Area</font></div></td>
      <td width="10%"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Complejidad</font></div></td>
      <td width="10%"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Criticidad</font></div></td>
      <td width="10%"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Prioridad</font></div></td>
    </tr>
    <?php  $sql7 = "SELECT *, DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig , '%d/%m/%Y') AS fechaestsol_asig 
				FROM asignacion WHERE id_orden='$id_orden' OR id_orden='$id_ord'";
		$result7=mysql_db_query($db,$sql7,$link);
		while($row7=mysql_fetch_array($result7))
	{?>
    <tr align="center"> 
      <td height="23"><?php echo $row7[fecha_asig];?>&nbsp; <?php echo $row7[hora_asig];?> 
        <div align="center"></div></td>
      <td>&nbsp; 
        <?php 
	  $sql2 = "SELECT * FROM users WHERE login_usr='$row7[reg_asig]'";
 	  $result2=mysql_db_query($db,$sql2,$link);
	  $row2=mysql_fetch_array($result2);
	  echo "$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]";?>
      </td>
      <td>&nbsp; 
        <?php 
	  $sql2 = "SELECT * FROM users WHERE login_usr='$row7[asig]'";
 	  $result2=mysql_db_query($db,$sql2,$link);
	  $row2=mysql_fetch_array($result2);
	  echo "$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]";?>
      </td>
      <td>&nbsp;<?php echo $row7[diagnos];?></td>
      <td>&nbsp;<?php echo $row7[fechaestsol_asig];?></td>
      <td>&nbsp; 
        <?php if ($row7[area]=="Mesa") print ("Mesa de Ayuda"); 
	     if ($row7[area]=="DyM") print ("D & M");
		 if ($row7[area]=="Problemas") echo $row7[area];
		 if ($row7[area]=="Contingencia") echo $row7[area];
		 if ($row7[area]=="Cambios") echo $row7[area];?>
      </td>
	  <td>
        <?php if ($row7[nivel_asig]=="3") echo "Alta"; 
              if ($row7[nivel_asig]=="2") echo "Media";
              if ($row7[nivel_asig]=="1") echo "Baja";?>
	  </td>
	  <td>
        <?php if ($row7[criticidad_asig]=="1") echo "Alta";
              if ($row7[criticidad_asig]=="2") echo "Media";
              if ($row7[criticidad_asig]=="3") echo "Baja";?>
	  </td>
	  <td>
        <?php if ($row7[prioridad_asig]=="1") echo "Alta";
              if ($row7[prioridad_asig]=="2") echo "Media";
              if ($row7[prioridad_asig]=="3") echo "Baja";?>
	  </td>
    </tr>
    <?php }?>
  </table>
  <br>
  <table width="80%" border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#F4F2EA" style="border-collapse:collapse;" background="images/fondo.jpg">
    <tr> 
      <td width="100%"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
          <tr> 
            <th>ASIGNACION</th>
          </tr>
          <?php  $sql7 = "SELECT *, DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig FROM asignacion WHERE id_orden='$id_orden' ORDER BY id_asig DESC limit 1";
		$result7=mysql_db_query($db,$sql7,$link);
		$row7=mysql_fetch_array($result7);
	?>
          <tr align="center"> 
            <td class="normal"><div align="left"><strong>Orden Nro:</strong> 
                <input name="id_orden" type="text" value="<?php echo $id_orden;?>" size="11" readonly="">
                <strong><br>
                Descripcion: </strong> 
                <?php $sqlTmp="SELECT desc_inc FROM ordenes WHERE id_orden=$_GET[id_orden]";
				$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
				print $ordenTmp[desc_inc];
				?>
              </div>
              <hr> </td>
          </tr>
          <tr align="center"> 
            <td height="29" class="normal"> <strong>Fecha:</strong>&nbsp;&nbsp;<?php echo $row7[fecha_asig];?>&nbsp;&nbsp;&nbsp;<strong>Hora:</strong>&nbsp;&nbsp;<?php echo $row7[hora_asig];?> 
            </td>
          </tr>
          <tr align="center" > 
            <td class="normal">Complejidad: 
              <select name="nivel_asig" id="select2">
                <option value="3" <?php if ($row7[nivel_asig]=="3") echo "selected";?>>3 
                (Alta)</option>
                <option value="2" <?php if ($row7[nivel_asig]=="2") echo "selected";?>>2 
                (Media)</option>
                <option value="1" <?php if ($row7[nivel_asig]=="1") echo "selected";?>>1 
                (Baja)</option>
              </select> &nbsp;&nbsp;Criticidad: 
              <select name="criticidad_asig" id="select3">
                <option value="1" <?php if ($row7[criticidad_asig]=="1") echo "selected";?>>1 
                (Alta) </option>
                <option value="2" <?php if ($row7[criticidad_asig]=="2") echo "selected";?>>2 
                (Media) </option>
                <option value="3" <?php if ($row7[criticidad_asig]=="3") echo "selected";?>>3 
                (Baja) </option>
              </select> &nbsp;&nbsp;Prioridad: 
              <select name="prioridad_asig" id="select7">
                <option value="1" <?php if ($row7[prioridad_asig]=="1") echo "selected";?>>1 
                (Alta) </option>
                <option value="2" <?php if ($row7[prioridad_asig]=="2") echo "selected";?>>2 
                (Media) </option>
                <option value="3" <?php if ($row7[prioridad_asig]=="3") echo "selected";?>>3 
                (Baja) </option>
              </select> </td>
          </tr>
          <tr align="center"> 
            <td class="normal"><strong>Asignado a:</strong> <br> <select name="asig" id="asig">
                <?php
					
					$sql2 = "SELECT * FROM `asig_auto`";	
					$result2 = mysql_db_query($db,$sql2,$link);
					$row2 = mysql_fetch_array($result2);
					$sqll = "SELECT * FROM users WHERE login_usr='$login'";	
					$resultl = mysql_db_query($db,$sqll,$link);
					$rowl = mysql_fetch_array($resultl);
					$ubcacion = $row1[ciu_usr];
					$comp = $row2[login_usr];
					//echo "<option value=\"0\"></option>";
						if ($rowl[tipo2_usr] == "X" || $rowl[tipo2_usr] == "T")
						{
							$sql2 = "SELECT * FROM users WHERE bloquear=0 AND (tipo2_usr='T' OR tipo2_usr='A') AND `login_usr` <> '$comp' AND ciu_usr = '$rowl[ciu_usr]' ORDER BY apa_usr ASC";
						}
						else
						{
							$sql2 = "SELECT * FROM users WHERE bloquear=0 AND (tipo2_usr='T' OR tipo2_usr='A') AND `login_usr` <> '$comp' ORDER BY apa_usr ASC";
						}
					
 			  		$result2=mysql_db_query($db,$sql2,$link);
			  		while ($row2=mysql_fetch_array($result2)) {
						if ($row7[asig]==$row2[login_usr])
							echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
						else
							echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
					}
			   ?>
              </select></td>
          </tr>
          <tr align="center"> 
            <td class="normal">Fecha estimada de solucion: 
              <select name="DA" id="select8">
                <?php
  				$ano=substr($row7[fechaestsol_asig],0,4);
				$mes=substr($row7[fechaestsol_asig],5,2);
				$dia=substr($row7[fechaestsol_asig],8,2);
				for($i=1;$i<=31;$i++)
				{
	                echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select> <select name="MA" id="select9">
                <?php
				for($i=1;$i<=12;$i++)
				{
    	            echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select> <select name="AA" id="select">
                <?php
				for($i=2003;$i<=2020;$i++)
				{
        	        echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong> 
            </td>
          </tr>
          <tr align="center"> 
            <td class="normal"><strong>Diagnostico:</strong><br> <input name="diagnos" type="text" size="89" maxlength="100" value="<?php echo $row7[diagnos];?>"> 
            </td>
          </tr>
          <tr align="center"> 
            <td class="normal"><strong>Area:</strong><br> <input type="radio" name="area" value="Mesa" <?php if ($row7[area]=="Mesa") echo "checked"; ?> onClick="disabled1(document.form1);">
              MESA DE AYUDA&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="area" value="DyM" <?php if ($row7[area]=="DyM") echo "checked"; ?> onClick="disabled1(document.form1);">
              D y M&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="area" value="Problemas" <?php if ($row7[area]=="Problemas") echo "checked"; ?> onClick="disabled1(document.form1);">
              PROBLEMAS&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="area" value="Contingencia" <?php if ($row7[area]=="Contingencia") echo "checked"; ?> onClick="disabled1(document.form1);">
              CONTINGENCIA &nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="area" value="Cambios" <?php if ($row7[area]=="Cambios") echo "checked"; ?> onClick="enabled1(document.form1);">
              CAMBIOS</td>
          </tr>
          <tr align="center">
            <td class="normal"><table width="70%" border="1" align="center">
                <tr class="normal"> 
                  <td height="29"><table width="100%" border="0">
                      <tr>
					    <?php 
						if ($row7[area]=="Cambios"){$tp=explode("|",$row7[area_1]);}
						?>
                        <td width="25%" class="normal"><strong>Tipo de Prueba:</strong></td>
                        <td width="22%">
                          <input type="checkbox" name="pru1" value="pru1" <?php if($row7[area]!="Cambios"){echo "disabled";} if($tp[0]=="pru1"){echo "checked";}?>>
                          Prueba Usuaria</strong></td>
                        <td width="28%">
                          <input type="checkbox" name="pru2" value="pru2" <?php if($row7[area]!="Cambios"){echo "disabled";} if($tp[1]=="pru2"){echo "checked";}?>>
                          Prueba de Sistemas</td>
                        <td width="25%">
                          <input type="checkbox" name="pru3" value="pru3" <?php if($row7[area]!="Cambios"){echo "disabled";} if($tp[2]=="pru3"){echo "checked";}?>>
                          Prueba de Seguridad</td>
                      </tr>
                    </table>
                    
                  </td>
                </tr>
              </table></td>
          </tr>
          <tr align="center">
            <td class="normal">&nbsp;</td>
          </tr>
			 <?php //echo "<br><h3>display : ".$row7[escal]."</h3>";
				 if($row7[escal] == '0'){$display="style=display:none";}
				 else{$display="style=display:";}
			  ?>
		   <br>
		  <tr>
		   <td align="center" colspan="2" class="normal"><b>Asignar escalamiento</b>
		   <input type="checkbox" name="chkEscalar" onclick="visualizar('frm1')" <?php if($row7[escal] <> '0'){echo "checked";}?>></td>
		  </tr>
		  <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
<!--------------------------------------------Escalamiento------------------------------------------------------------------------>
          
		  <tr align="center" id="frm1" <?php=$display?> > 
            <td class="normal"><strong>Escalamiento a:</strong> <br> <select name="escal" id="escal">
                <?php 
					echo "<option value=\"0\"></option>";
			  		$sql1 = "SELECT * FROM users WHERE bloquear=0 AND (tipo2_usr='T' OR tipo2_usr='A') ORDER BY apa_usr ASC";
			  		$result1=mysql_db_query($db,$sql1,$link);
			  		while ($row1=mysql_fetch_array($result1)) 
					{
						if ($row7[escal]==$row1[login_usr])
							echo "<option value=\"$row1[login_usr]\" selected>$row1[apa_usr] $row1[ama_usr] $row1[nom_usr]</option>";
						else
							echo "<option value=\"$row1[login_usr]\" ".$sel.">$row1[apa_usr] $row1[ama_usr] $row1[nom_usr]</option>";
					}
			   ?>
              </select><br>
			  <?php //if($row7[escal]<>'0'){?>
			   <!--input name="send_mail" type="submit" value="ENVIAR MAIL"-->
			  <?php //}?>
			   
              <select name="DE" id="select8">
                <?php
				if($row7[fechasol_esc] <> '0000-00-00')
				{
					$ano=substr($row7[fechasol_esc],0,4);
					$mes=substr($row7[fechasol_esc],5,2);
					$dia=substr($row7[fechasol_esc],8,2);
	
					for($i=1;$i<=31;$i++)
					{
						echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";
					}
				}
				else{
					$fsist=date("Y-m-d");
					$a1=substr($fsist,0,4);
					$m1=substr($fsist,5,2);
					$d1=substr($fsist,8,2);
					for($i=1;$i<=31;$i++)
					{
	                	echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
				}
				?>
              </select> <select name="ME" id="select9">
                <?php
				if($row7[fechasol_esc] <> '0000-00-00')
				{
					for($i=1;$i<=12;$i++)
					{
						echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
					}
				}
				else{
					for($i=1;$i<=12;$i++)
					{
    	              	echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					}
				}
				?>
              </select> <select name="AE" id="select10">
                <?php
				if($row7[fechasol_esc] <> '0000-00-00')
				{
					for($i=2003;$i<=2020;$i++)
					{
						echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";
					}
				}
				else{
					for($i=2003;$i<=2020;$i++)
				    {
        	          	echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				    }
				}
				?>
              </select> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong> 
            </td>
          </tr>
<!------------------------------------------Fin Escalamiento------------------------------------------------------------------------->
          <tr valign="middle"> 
            <td height="44" align="center"> <input name="reg_form" type="submit" value="GUARDAR" <?php echo $valid->onSubmit(); ?>> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <input type="submit" name="RETORNAR" value="RETORNAR"> </td>
          </tr>
        </table>
    </tr>
  </table>
</form>
  <script language="JavaScript">
		<!--   
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
			
		function enabled1(lugar)
		{	
			lugar.pru1.disabled = 0;
		 	lugar.pru2.disabled = 0;
		 	lugar.pru3.disabled = 0;
		}
		function disabled1(lugar)
		{	
			lugar.pru1.disabled = 1;
		 	lugar.pru2.disabled = 1;
		 	lugar.pru3.disabled = 1;
			lugar.pru1.checked = 0;
		 	lugar.pru2.checked = 0;
		 	lugar.pru3.checked = 0;
		}
//-->
</script>
<script language="javascript1.2">
function visualizar(id)
{
	fila = document.getElementById(id);
	if(document.form1.chkEscalar.checked)
	{
		fila.style.display = "";
		//document.form1.all.frmdos.style.display = "";
	}
	else{
		fila.style.display = "none";
		//document.form1.all.frmdos.style.display = "none";
	}
}


function verifEscal()
{	
		escal = document.form1.escal.value;
		asig = document.form1.asig.value;
		check = document.form1.chkEscalar.checked;
		if(escal == 0 || escal == asig)
		{
		  if(check)
		  {
			msg = "Debe elegir una persona distinta de vacío o distinta del usuario asignado para realizar el escalamiento.\n";
			msg = msg + "\nMensaje generado por GesTor F1.";
			alert(msg);
			return false;
		  }
		}
		return true;
}
</script>
<?php include("top_.php");?>

<?php
	function mostrar($login)
	{
		include("conexion.php");	
		$sql = "select *from users where login_usr='$login'";
		$res = mysql_db_query($db,$sql,$link);
		$row = mysql_fetch_array($res);
		$nombre = $row[apa_usr]." ".$row[ama_usr]." ".$row[nom_usr];
		return $nombre;
	}

?>
