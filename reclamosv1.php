<?php
session_start();
$sProceso = $des;
if(isset($adjunt)){

	$sProceso = $glosa;
	if($sProceso == ""){$sProceso = $proceso;}

	include("conexion.php");
	$sql5="SELECT * FROM control_parametros";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);

	$extension = explode(".",$archivo_name); 
	$num = count($extension)-1; 
	$tam_max=1048576*$row5[tam_archivo];

	if($archivo_size < $tam_max){
		$sql1="SELECT MAX(id_orden)+1 AS id_or FROM ordenes"; 
		$result1=mysql_db_query($db,$sql1,$link);
		$row1=mysql_fetch_array($result1);
		$var="ajuntos_bo_".$row1[nomb_archivo];
		$var_hash="ajuntos_bo_hash_".$row1[hash_archivo];//nuevo
		$var_obs="ajuntos_bo_obs_".$row1[observaciones];//nuevo
		$adjuntos_bo=$_SESSION[$var];
		$adjuntos_bo_hash=$_SESSION[$var_hash]; //nuevo
		$adjuntos_bo_obs=$_SESSION[$var_obs]; //nuevo
		$num1=array();
		$num1_hash=array();//nuevo
		$num1_obs=array();//nuevo
		if($adjuntos_bo=="") $alfa=1;
		else {
			$num1=explode("|",$adjuntos_bo);
			$alfa=count($num1)+1;
		}
		if($adjuntos_bo_hash=="") $alfa_hash=1;//desde aqui
		else {
			$num1_hash=explode("|",$adjuntos_bo_hash);
			$alfa_hash=count($num1_hash)+1;
		}
		//echo "<br>adjuntos obs : ".$adjuntos_obs;
		if($adjuntos_bo_obs=="") $alfa_obs=1;//desde aqui
		else {
			$num1_obs=explode("|",$adjuntos_bo_obs);
			$alfa_obs=count($num1_obs)+1;
		}
		//hasta aqui
		$arch_nomb=$row1[id_or]."[".$alfa."].".$extension[$num];
		//echo "<br>valor : ".$arch_nomb;
		copy($archivo,"archivos adjuntos/".$arch_nomb);
		//echo "<br>nuevo : ".$txtObservacion;
		$hash_nomb = md5_file($archivo);//nuevo
		array_push($num1,$arch_nomb);
		array_push($num1_hash,$hash_nomb);//nuevo
		//$tObservacion = $row1[id_or]."[".$alfa_obs."]";
		array_push($num1_obs,$txtObservacion);//nuevo
		$num=implode("|",$num1);
		$num_hash=implode("|",$num1_hash);
		$num_obs=implode("|",$num1_obs);
		//echo "<br>num  es : ".$num;
		//echo "<br>num hash es : ".$num_hash;
		//echo "<br>num obs es : ".$num_obs;
		
		$_SESSION[$var]=$num;
		$_SESSION[$var_hash]=$num_hash;
		$_SESSION[$var_obs]=$num_obs;
	}else{
	unset($msg);
	$msg="EL TAMAÑO DEL ARCHIVO ADJUNTO NO DEBE SER MAYOR A ".$row5[tam_archivo]." Mb";
	}
}
if ($lista) header("location: lista_titulares.php?desc=$glosa");
ini_set("error_reporting", "E_ALL & ~E_NOTICE & ~E_WARNING");
if(isset($otro))
{
	include ("conexion.php");	
	$sql="INSERT INTO titular (ci_ruc,ciudad,nombre,apaterno,amaterno,acasada,email,entidad,area,especialidad,cargo,telf,externo,direccion) ".
	"VALUES('$ci_ruc','$ciudad','$nombre','$apaterno','$amaterno','$acasada','$email','$entidad','$area','$especialidad','$cargo','$telf','$externo','$direccion')"; 
	if (mysql_db_query($db,$sql,$link)){
		$msg="Se creo correctamente el usuario";
	} 
	else {
		$msg="Ocurrio un error al conectarse con la base de datos.";
		if (mysql_errno()==1062) {	$msg=$msg . "Ya se tiene un usuario con ese CI o RUC";}
	}
}

if (isset($reg_form)) 
{	
	if($glosa == ""){$glosa = $proceso;}
	
	session_start();
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
	$sql7="SELECT * FROM ordenes WHERE reg_conf='$login'";
	//echo "<br>sql 7 es : ".$sql7;
	$result7=mysql_db_query($db,$sql7,$link);
	while($row7=mysql_fetch_array($result7))
	{	
		$sql3="SELECT id_orden FROM conformidad WHERE id_orden ='$row7[id_orden]'";
        //echo "<br><b>sql dentro del while : ".$sql3;  	
		$result3=mysql_db_query($db,$sql3,$link);
		$row3=mysql_fetch_array($result3);
		if (!$row3[id_orden])
		{
			$a1=substr($row7[fecha],0,4); $m1=substr($row7[fecha],5,2); $d1=substr($row7[fecha],8,2);
			$hoy=date("Y-m-d");
			$a2=substr($hoy,0,4); $m2=substr($hoy,5,2); $d2=substr($hoy,8,2);
			$d3=$d2-$d1; $m3=$m2-$m1; $a3=$a2-$a1;
			if ($a3 >= "0") 
			{
				if ($m3 >= "0")
	 			{
					if ($d3 >= "0")
			    	{	
						$a3=$a3; $m3=$m3; $d3=$d3; 
					}
			 		elseif ($d3<"0") 
			 		{
						$m3=$m3-1; $d3=30+$d3;
				 		if ($m3 < "0")
						{
							$a3=$a3-1; $m3=12+$m3;
						}
					}
				}
				else 
				{
					$a3=$a3-1; $m3=12+$m3;
					if ($d3 >= "0")
					{
				 		$a3=$a3; $m3=$m3; $d3=$d3;
					}
				}
			 }
			else
			{
				$a3="0"; $m3="0"; $d3="0";
			}

		if ($a3<>"0") {$a3=$a3*360;} else {$a3="";}
		if ($m3<>"0") {$m3=$m3*30;} else {$m3="";}
		$d4=$d3+$a3+$m3;
		if ($d4 > $row6[tmp_conf]) {$tiemp=tiemp+1;}
	}
}
//echo "<br>Tiempo es : ".$tiemp;
//----------------------------------------------------------------
	$sCad = "select *from conformidad where reg_conf='$login'";
	$rCad = mysql_db_query($db,$sCad,$link);
	$cadena = "yanapti";
	while($rowCad = mysql_fetch_array($rCad))
	{
		$cadena = $cadena.",$rowCad[id_orden]";
	}
	$cadena = str_replace("yanapti,","",$cadena);
	if($cadena <> "yanapti")
	{
		$sql = "select distinct(fecha_sol) from solucion where login_sol = '$login' and id_orden NOT IN ($cadena) ORDER BY fecha_sol ASC";
		//echo "<br>sql es  : ".$sql;
		$res = mysql_db_query($db,$sql,$link);
		$row = mysql_fetch_array($res);
		$fecha_inicial = $row[fecha_sol];
	}
	else
	{
		$sCad = "select distinct(fecha_sol) from solucion where login_sol = '$login' ORDER BY fecha_sol ASC";
		//echo "<br>s cad es : ".$sCad;
		$sRes = mysql_db_query($db,$sCad,$link);
		$sRow = mysql_fetch_array($sRes);
		$fecha_inicial = $sRow[fecha_sol];
	}
		
		$hoy=date("Y-m-d");
		//echo "<br>fecha de hoy es :  ".$hoy;
		//echo "<br>fecha inicial es :  ".$fecha_inicial;
		
		$sql = "SELECT DATEDIFF('$hoy','$fecha_inicial')as diferencia";
		$sql."<br>";
		$res = mysql_db_query($db,$sql,$link);
		$row = mysql_fetch_array($res);
		$resul = $row[diferencia];
		//echo "<br>resul es : ".$resul;
		//echo "<br>lim dias es : ".$row6[tmp_conf];
		//die();
//----------------------------------------------------------------
if ($resul >= $row6[tmp_conf])
{
	$desc="El usuario ".$nombre." no puede insertar mas ordenes de trabajo, debido a que tiene una orden que en ".$row6[tmp_conf]." dias no recibio conformidad ";
	$sql="INSERT INTO ordenes (fecha, time, cod_usr, glosa) ".
	"VALUES('".date("Y-m-d")."','".date("H:i:s")."','SISTEMA','$desc')"; 
	mysql_db_query($db,$sql,$link);
?> 
	<script language="JavaScript">
		ventana_secundaria=window.open('pru2.php','secundaria','location=no,menubar=no,status=no,toolbar=no,scrollbars=0,resizable=no,width=350,height=170,left=150,top=150'); 
		ventana_secundaria.close(); 
	</script>
<?php 	$msg="USTED NO PUEDE INSERTAR MAS ORDENES DE TRABAJO, DEBIDO A QUE UNA DE ELLAS EXCEDIO\\n EN ".$row6[tmp_conf]." DIAS SIN CONFORMIDAD";
}
else
{	
	$condicion = 0;
	$sql3="SELECT COUNT(id_orden) AS num1 FROM ordenes WHERE cod_usr='$login'";
	$result3=mysql_db_query($db,$sql3,$link);
	$row3=mysql_fetch_array($result3);
	
	$sql4="SELECT COUNT(id_orden) AS num2 FROM conformidad";
	$result4=mysql_db_query($db,$sql4,$link);
	$row4=mysql_fetch_array($result4);
	
	$sCad="SELECT count(id_orden) as numOrd FROM solucion WHERE login_sol='$login'";
	$rCad=mysql_db_query($db,$sCad,$link);
	$rowCad=mysql_fetch_array($rCad);
	
	$sql5="SELECT * FROM control_parametros";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
	//echo "<br>solucionados es : ".$rowCad[numOrd];
	//echo "<br>conformidad  es : ".$row4[num2];
	$condicion = ($rowCad[numOrd])-($row4[num2]);
	//echo "<br>condicion antes es : ".$condicion;
	//echo "<br>numero de registros solucionados : ".$rowCad[numOrd];
	if($rowCad[numOrd] == 0)
	{
		$condicion = $rowCad[numOrd];
	}
	
	//echo "<br>condicion es : ".$condicion;
	//echo "<br>limite  es : ".$row5[cant_ordenes];
	
	if( $condicion >= $row5[cant_ordenes] )
	{
	$desc="El usuario ".$nombre." no puede insertar mas ordenes de trabajo, debido a que tiene ".$row5[cant_ordenes]." ordenes de trabajo sin conformidad ";
	$sql="INSERT INTO ordenes (fecha, time, cod_usr, glosa) ".
	"VALUES('".date("Y-m-d")."','".date("H:i:s")."','SISTEMA','$desc')"; 
	mysql_db_query($db,$sql,$link); 
	?> 
			<script language="JavaScript">
			ventana_secundaria=window.open('pru2.php','secundaria','location=no,menubar=no,status=no,toolbar=no,scrollbars=0,resizable=no,width=350,height=170,left=150,top=150'); 
			ventana_secundaria.close(); 
		</script>
	<?php
	$msg="USTED NO PUEDE INSERTAR MAS ORDENES DE TRABAJO, DEBIDO A QUE EXCEDIO EN ".$row5[cant_ordenes]."\\nORDENES SIN CONFORMIDAD";
	}
	else
	{
	
	if (strlen($glosa)<=10) {$msg="LA DESCRIPCION DEL INCIDENTE DEBE SER MAYOR A 10 CARACTERES";}
	else{
			if (!isset($login)) {  header("location: index.php");}
			$tipo1=$tipo0.$tipo1;

/////////////////
		$sql1a="SELECT MAX(id_orden)+1 AS id_or FROM ordenes"; 
		$result1a=mysql_db_query($db,$sql1a,$link);
		$row1a=mysql_fetch_array($result1a);

		$var="ajuntos_bo_".$row1a[nomb_archivo];
		$adjuntos_bo=$_SESSION[$var];
		$var_hash="ajuntos_bo_hash_".$row1a[hash_archivo];
		$adjuntos_bo_hash=$_SESSION[$var_hash];
		$var_obs="ajuntos_bo_obs_".$row1a[observaciones];
		$adjuntos_bo_obs=$_SESSION[$var_obs];
		//echo "<br>archivo : ".$adjuntos_bo;
		//echo "<br>hash : ".$adjuntos_bo_hash;
		//echo "<br>obs : ".$adjuntos_bo_obs;
		$sql1="select * from sarc";
		$monto=0;
		$moneda=1;
		$monedaext=0;
		$result1=mysql_db_query($db,$sql1,$link);
		$row1=mysql_fetch_array($result1);
/////////////////
				$sql="INSERT INTO reclamos (CTipoEntidad, CCorrelativoEntidad, CReclamo, TGestion, TFechaReclamo, CTipoIdentificacion, CIDReclamante, TNombre, TApellido, CTipoOficina, CLocalidadOficina, CTipologia, CSubTipologia, TGlosa, NMontoComprometido, CMoneda, CMonedaExtranjera, NPlazoEstimadoSolucion, TPersonaDeContacto, DFechaReporte)".
				"VALUES('".$row1[CTipoEntidad]."','".$row1[CCorrelativoEntidad]."','$nro','".date("Y")."','".date("Y-m-d")."','$tipoid','$carnet','$nomb','".$apaterno." ".$amaterno." ".$acasada."','".$row1[CTipoOficina]."','".$row1[CLocalidadOficina]."','$tipologia','$subtipologia','$glosa','$monto','$moneda','$monedaext','$plazo','$eif','".date("Y-m-d")."')"; 
				//echo "<br>sql es : ".$sql;
				//die();
				mysql_db_query($db,$sql,$link);
				
				switch ($subtipologia) {
    			case 4:
		        $sqlo="INSERT INTO ordenes (fecha,time, cod_usr, desc_inc, origen, nomb_archivo, hash_archivo,observaciones, area, 	dominio, objetivo,sarc)". "VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$glosa','4','".$adjuntos_bo."','".$adjuntos_bo_hash."','".$adjuntos_bo_obs."','7','11','21','$nro')";
        		break;
			    case 39:
        		$sqlo="INSERT INTO ordenes (fecha,time, cod_usr, desc_inc, origen, nomb_archivo, hash_archivo,observaciones, area, 	dominio, objetivo,sarc)". "VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$glosa','4','".$adjuntos_bo."','".$adjuntos_bo_hash."','".$adjuntos_bo_obs."','7','11','20','$nro')";
        		break;
    			case 53:
        		$sqlo="INSERT INTO ordenes (fecha,time, cod_usr, desc_inc, origen, nomb_archivo, hash_archivo,observaciones, area, 	dominio, objetivo,sarc)". "VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$glosa','4','".$adjuntos_bo."','".$adjuntos_bo_hash."','".$adjuntos_bo_obs."','7','11','34','$nro')";
        		break;
				case 71:
        		$sqlo="INSERT INTO ordenes (fecha,time, cod_usr, desc_inc, origen, nomb_archivo, hash_archivo,observaciones, area, 	dominio, objetivo,sarc)". "VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$glosa','4','".$adjuntos_bo."','".$adjuntos_bo_hash."','".$adjuntos_bo_obs."','7','11','33','$nro')";
        		break;
				case 75:
        		$sqlo="INSERT INTO ordenes (fecha,time, cod_usr, desc_inc, origen, nomb_archivo, hash_archivo,observaciones, area, 	dominio, objetivo,sarc)". "VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$glosa','4','".$adjuntos_bo."','".$adjuntos_bo_hash."','".$adjuntos_bo_obs."','7','11','22','$nro')";
        		break;
				}
				mysql_db_query($db,$sqlo,$link);
				
				$sqlor="select * from ordenes where sarc = $nro and fecha > '2009-01-01'";
				$resultor=mysql_db_query($db,$sqlor,$link);
				$rowor=mysql_fetch_array($resultor);
				
				$sqla="INSERT INTO ".
					"asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,fechaestsol_asig,reg_asig,diagnos,escal,date_esc,time_esc,fechasol_esc,area,area_1) ".
"VALUES('".$rowor[id_orden]."','3','1','1','$asig','".date("Y-m-d")."','".date("H:i:s")."','".date("Y-m-d")."','$login','Reclamo Sarc','','0000-00-00','00:00:00','0000-00-00','','')";
					
				//mysql_db_query($db,$sqla,$link);
				 mysql_db_query($db,$sqla,$link);
				 $sqlcliente="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$login'";
		         $ordencliente=mysql_db_query($db,$sqlcliente,$link);
                 $rowcli=mysql_fetch_array($ordencliente);
                 $clienteNombre=$rowcli[nom_usr].' '.$rowcli[apa_usr].' '.$rowcli[ama_usr];
				 $sqlasignombre="SELECT nom_usr, apa_usr, ama_usr, email, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$asig'";
				 $asignombre=mysql_db_query($db,$sqlasignombre,$link);
		         $rowasign=mysql_fetch_array($asignombre);
				 $asignom=$rowasign[nom_usr].' '.$rowasign[apa_usr].' '.$rowasign[ama_usr];
				
				 $sqlaux1 = "SELECT * FROM ordenes where sarc='$nro'";
				 $resultaux = mysql_fetch_array(mysql_db_query($db, $sqlaux1, $link));
				 $sqlSystemaux= "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
				 $systemDataaux = mysql_fetch_array(mysql_db_query($db, $sqlSystemaux, $link));
		
				 
		if (!(empty($rowasign[email])))
		{
		$asunto = "Nro. $resultaux[id_orden]. Nuevo Orden de Trabajo - SARC";	
		$mail = $rowasign[email];
		//echo $rowcli[email];
		$mensaje = "
		<b>Mensaje Generado por el Gestor F1 </b><br>
		------------------------------------------------------------------ <br>
		<b>Nuevo Reclamo SARC: Nro. $resultaux[id_orden] registrado a horas ".date("H:i:s")." en fecha ".date("d-m-Y")." </b><br>
		------------------------------------------------------------------ <br>
		<b>Datos Generales</b> <br>
		------------------------------------------------------------------ <br>
		<b>Cliente/Tecnico:</b> $clienteNombre<br>
		<b>Descripcion Reclamo:</b> $glosa<br>
		<b>Asignado a:</b> $asignom <br><br>
		Para mayores detalles, consulte el Sistema GesTor F1. <br>
		$systemData[nombre]";
		$tunombre = $systemDataaux[nombre];		
		$tuemail  = $systemDataaux[mail_institucion];												
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: $tunombre <$tuemail>\r\n";
		mail($mail,$asunto,$mensaje,$headers);
		}
				
				session_unregister($var);
				session_unregister($var_hash);//nuevo
				session_unregister($var_obs);//nuevo
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
								//echo $systemData[movilEmail];
								//if (!mail($systemData[movilEmail],$systemData[mail],"Nro".$row1[id_or]."-Nuevo Requerimiento de Orden de Trabajo. $systemData[nombre]"))
								if(strlen($glosa)>150) $mail_sms=substr($glosa,0,150)." ...";
								else $mail_sms=$glosa;
								if (!mail($systemData[movilEmail],"Gestor TI","Nuevo Requerimiento: $mail_sms. $systemData[nombre]"))
								{$msg ="Precaucion, no se ha podido enviar la orden por SMS.";}										
					}
					//Enviar mail al administrador de mesa de ayuda
					if($row5["conf_mail"]==1 || $row5["conf_mail"]==3)						
					{	
						$tunombre = $row5[nombre];		
						$tuemail = $row5[mail_institucion];						
						$headers = "MIME-Version: 1.0\r\n"; 
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
						$headers .= "From: $tunombre <$tuemail>\r\n"; 
						$asunto = "Nro.$row1[id_or]. Nuevo Requerimiento de Trabajo de Mesa de Ayuda";	
						$mail = $systemData[mail];
						$mensaje = "
Nuevo Requerimiento de Mesa de Ayuda: Nro. $row1[id_or] <br>
Cliente/Tecnico: $nombre <br>
Descripcion: $glosa <br><br>
Para mayores detalles, consulte el Sistema GesTor F1. <br>
$systemData[nombre]";						
										
						if(!mail($mail,$asunto,$mensaje,$headers)){$msg ="Precaucion, no se ha podido enviar la orden por Correo Electronico.";}																
					}									
				}
				
				
				//Parámetros para asignación
				
				$id = mysql_insert_id($link);
				$sCon = "select *from users where login_usr='$login'";
				$sRes = mysql_query($sCon,$link);
				$sRow = mysql_fetch_array($sRes);
				
				if(($tipo == 'T') and ($sRow['asig_usr'] == 1))
				{
					header("location: asignacion.php?id_orden=$id&msg=$msg&vent=1");
				}
				else{
					header("location: lista_reclamos.php?msg=$msg&vent=1");
				}
				
				
				//fin de ingreso de parámetros
				//header("location: lista.php?msg=$msg&vent=1");
				
	}
  }

}}
include ("top.php");
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNumber ( "ci_ruc",  "CI/RUC, $errorMsgJs[number]" );
$valid->addEmail ( "email",  "" );
//$valid->addIsNotEmpty ( "archivo",  "Archivo Adjunto, $errorMsgJs[empty]" );
echo $valid->toHtml ();
if ($msg) {
	$row_ = $_POST;
	}
else {
	unset($glosa);
	unset($tipo1);
}

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
<?php
session_start();
$login_usr = $_SESSION["login"];
$SQL="SELECT visualizacion_1 FROM users WHERE login_usr='$login_usr'";
$result=mysql_db_query($db,$SQL,$link);
$row=mysql_fetch_array($result);
if(!$var){$var=0;};
?>
<style>
.link{
	font:Verdana;
	font-size:12px;
	text-decoration:none;
	color:#000066;
	font-weight: bold;
}
.link:hover{
	font:Verdana;
	font-size:12px;
	text-decoration:underline;
	color:#000066;
	font-weight: bold;
}
.Estilo3 {
	font-size: 12px;
	color: #000000;
}
.Estilo4 {
	font-size: 12px;
	font-weight: bold;
}
</style>
<form name="form1" method="post" enctype="multipart/form-data" onKeyPress="return Form()">

<table width="95%" border="1" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
  <!--DWLayoutTable-->
    <tr> 
      <th height="25" colspan="6" align="center" background="images/main-button-tileR2.jpg">DATOS DEL RECLAMO</th>
    </tr>
    <tr> 
      <td width="25%" align="right"> <div align="center">Nro Reclamo:</div></td>
      <td width="25%"><input name="nro" type="text" value="<?php 
	  $sqlaux1="select Max(CReclamo) as ultimo from reclamos";
	  $resultaux1=mysql_db_query($db,$sqlaux1,$link);
	  $rowaux1=mysql_fetch_array($resultaux1);
	  $numero = $rowaux1[ultimo] + 1;
	  echo $numero;
	  ?>" size="7" maxlength="20" readonly="" /></td>
      <td width="25%" align="right"> <div align="center">Oficina Reclamo:</div></td>
      <td width="25%" valign="middle"><select name="oficina">
        <option value="1" <?php if ($ofic==1) echo "selected"; ?>>Oficina Central</option>
        <option value="2" <?php if ($ofic==2) echo "selected"; ?>> Sucursal</option>
        <option value="3" <?php if ($ofic==3) echo "selected"; ?>>Agencia</option>
        <option value="4" <?php if ($ofic==4) echo "selected"; ?>>Ventanilla de Cobranza</option>
        <option value="5" <?php if ($ofic==5) echo "selected"; ?>>Caja Externa</option>
        <option value="6" <?php if ($ofic==6) echo "selected"; ?>>Mandato</option>
        <option value="7" <?php if ($ofic==7) echo "selected"; ?>>Oficina Ferial</option>
        <option value="9" <?php if ($ofic==9) echo "selected"; ?>>Cajero Automatico</option>
      </select></td>
    </tr>   
  </table>
<br>
  <table width="881" border="1" cellpadding="2" cellspacing="0" background="images/fondo.jpg" align="center">
    <!--DWLayoutTable-->
    <tr> 
      <th height="25" colspan="8" align="center" valign="top" background="images/main-button-tileR2.jpg">DATOS DEL CLIENTE/USUARIO</th>
    </tr>
    <tr> 
      <td height="30" colspan="8" align="center" valign="top">Tipo de Identificacion: 
      &nbsp;&nbsp;
      <select name="tipoid">
          <option value="01"> CI - Carnet de Identidad </option>
          <option value="02"> RUN - Registro Unico Nacional </option>
          <option value="03"> PE - Persona Extranjera </option>
          <option value="04"> CPN - Correlativo Persona Natural </option>
          <option value="05"> RUC - Registro Unico de Contribuyentes </option>
          <option value="06"> EE - Empresa Extranjera </option>
          <option value="07"> CPJ - Correlativo Persona Juridica</option>
          <option value="08"> PR - Por Resolucion </option>
          <option value="09"> NIT - Numero de Identificacion Tributaria </option>
        </select>
      Nro: 
      <input name="carnet" type="text" size="20" maxlength="20" value="<?php echo $carnet;?>"></td> 
    </tr>
    <tr> 
      <td width="12%" height="28" align="center">NOMBRES:</td>
      <td width="21%"> <input name="nomb" type="text"  size="20" maxlength="20" value="<?php echo $nomb;?>"></td>
      <td width="12%" align="center">AP.PATERNO:</td>
      <td width="22%" valign="top"><input name="apaterno" type="text" size="20" maxlength="50" value="<?php echo $apaterno;?>"></td>
      <td width="12%" align="center"> AP.MATERNO:</td>
      <td width="22%" valign="top"><input name="amaterno" type="text" size="20" maxlength="50" value="<?php echo $amaterno;?>"></td>
    </tr>
    <tr> 
      <td height="28" align="center">AP.CASADA:</td>
      <td><input name="acasada" type="text" size="20" maxlength="50" value="<?php echo $acasada;?>"/></td>
      <td colspan="2" align="right"><!--DWLayoutEmptyCell-->&nbsp;</td>
      <td align="center">EIF:</td>
      <td valign="top"><input name="eif" type="text"  size="20" maxlength="100" value="<?php if ($eif){echo $eif;} else {echo "No Definido";}?>" /></td>
    </tr>
  </table>
  <br>
<font color="#FF0000" face="Arial, Helvetica, sans-serif"><strong></strong></font>
<table border="1"  align="center" cellpadding="0" cellspacing="0" width="60%"><tr><td>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" >
    <tr> 
      <td> 
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
          <tr bgcolor="#006699"> 
            <th colspan="2" background="images/main-button-tileR1.jpg">INGRESE SU CONSULTA O RECLAMO</th>
          </tr>
		  
          <tr> 
            <td colspan="2" align="center"><span class="Estilo3"><strong>FECHA : <?php echo date("d/m/Y");?></strong><strong>&nbsp;&nbsp; 
              HORA : <?php echo date("H:i:s");?></strong></span></td>
          </tr>
		  <!------------------------------------------------------------------------------------------------------>
		   <!---->
		  <tr> 
		  	<td>&nbsp;</td>
			<td >
				<table width="718">
				  <tr>
					<td width="233" class="titulo" align="right">
					<font face="verdana" size="1"><b>Tipologia : </b></font>					</td>
					<td width="473">
                      <select name="tipologia">
					  	<option value="4" <?php if ($tipog==15) echo "selected"; ?>>  Buro Informacion Crediticia  </option>
					  </select>
					  &nbsp;&nbsp;&nbsp;&nbsp;<a href="impresion_niveles.php" class="link" target="_blank"></a>					</td>
				  </tr>
				  <tr>
					<td width="233" class="titulo" align="right">
					<font face="verdana" size="1"><b>Subtipologia : </b></font>					</td>
					<td>
                      <select name="subtipologia">
					  	<option value="4" <?php if ($subtipog==4) echo "selected"; ?>>  Actualizacion de Datos  </option>
						<option value="39" <?php if ($subtipog==39) echo "selected"; ?>>  Duplicidad de Documento de Identidad  </option>
						<option value="53" <?php if ($subtipog==53) echo "selected"; ?>>  Homonimo  </option>
						<option value="71" <?php if ($subtipog==71) echo "selected"; ?>>  Permanencia en Base de Datos  </option>
						<option value="75" <?php if ($subtipog==75) echo "selected"; ?>>  Registro de Procesos Judiciales  </option>
					  </select>	</td>
				  </tr>
				</table>			</td>
			<tr>			</tr>
			
          <tr>  
		  <!---->
		  <!------------------------------------------------------------------------------------------------------>
          <tr>
            <td colspan="2" class="normal">			</td>
          </tr>
          <tr> 
            <td colspan="2" class="normal"><div align="center"><strong>Descripcion del Reclamo :</strong> </div></td>
          </tr>
          <tr> 
            <td colspan="2"> <div align="center"><strong>
              <textarea name="glosa" cols="80" rows="4" id="glosa"><?php=$sProceso?></textarea>
              <textarea name="proceso" cols="90" style="display:none" rows="4" ><?php=$sProceso?></textarea>
                </strong> </div></td>
          </tr>
          <tr>
            <td colspan="2" align="center">Plazo Estimado de Solucion (dias): 
              <label><input name="plazo" value="1" type="text" size="5" value="<?php echo $plazo;?>"></label></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><span class="Estilo4">Asignar a: </span></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><span class="normal">
              <select name="asig" id="asig">
                <option value="0"></option>
                <?php 
			     $sql0 = "SELECT * FROM users WHERE bloquear=0 AND (tipo2_usr='T' OR tipo2_usr='A') ORDER BY apa_usr ASC";
			     $result0=mysql_db_query($db,$sql0,$link);
			     while ($row0=mysql_fetch_array($result0)) 
				 {
				  echo "<option value=\"$row0[login_usr]\" selected='selected'>$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
                 } 
			    ?>
              </select>
            </span></td>
          </tr>
          <br>
          <tr> 
            <td colspan="2"><div align="center"><br>
                <input name="reg_form" type="submit" value="   ENVIAR ORDEN   " onClick="return validateConsulta()">
                <br>
              </div></td>
          </tr>
          <!--
</form>
<form name="form2" method="post" enctype="multipart/form-data" onKeyPress="return Form()">
-->
          <?php
			$sql1="SELECT MAX(id_orden)+1 AS id_or FROM ordenes"; 
			$result1=mysql_db_query($db,$sql1,$link);
			$row1=mysql_fetch_array($result1);
			$var="ajuntos_bo_".$row1[nomb_archivo];
			$var_hash="ajuntos_bo_hash_".$row1[hash_archivo];//nuevo
			$var_obs="ajuntos_bo_obs_".$row1[observaciones];//nuevo
			if($_SESSION[$var]){
				$adjuntos_bo=$_SESSION[$var];
				$adjuntos_bo_hash=$_SESSION[$var_hash];//nuevo
				$adjuntos_bo_obs=$_SESSION[$var_obs];//nuevo
				$adjuntos_bo=explode("|",$adjuntos_bo);
				$adjuntos_bo_hash=explode("|",$adjuntos_bo_hash);
				$adjuntos_bo_obs=explode("|",$adjuntos_bo_obs);
		  ?>
		  <tr> 
			<td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
			<td colspan="2"><div align="center"><strong><font size="2">Archivos Adjuntos:</font></strong></div></td>
          </tr>
		  <tr> 
            <td width="7%">&nbsp;</td>
			<td width="93%" >
				<table width="687" border="1" cellpadding="0" cellspacing="0">
				<tr>
					<td width="318"><div align="center"><strong><font size="2">Nombre</font></strong></div></td>
					<td width="363" ><div align="center"><strong><font size="2">Observaciones</font></strong></div></td>
				</tr>
			 
          <?php 	$i=0;
				foreach($adjuntos_bo as $valor){
					echo "<tr>
							<td align='center'><a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor<br></a>&nbsp;MD5: $adjuntos_bo_hash[$i]</td>
							<td align='center'>$adjuntos_bo_obs[$i]</td>
						</tr>";
					$i++;
				}
			}?>
			 </table>			</td>
          </tr>
          <tr> 
            
            <?php 
	$sql5="SELECT * FROM control_parametros";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
			?>
            <td align="center" colspan="2"><div align="left"><b><font size="2" face="Arial, Helvetica, sans-serif"><br>
                &nbsp;&nbsp;&nbsp;&nbsp;Enviar Archivo Adjunto<br>
                </font></b><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;( 
                tipo : .gif &nbsp;&nbsp;.jpg&nbsp;&nbsp; .doc &nbsp;&nbsp;&nbsp;&nbsp;y 
                &nbsp;&nbsp;tamano maximo : <?php echo $row5[tam_archivo];?> Mb ) 
                : </font> </div>			</td>
          </tr>
          <tr> 
            <td colspan="2" align="center">
				<input name="archivo" type="file" size="60" value="<?php print $archivo ?>" onClick="msgFile()">            </td>
          </tr>
		 <!---->
		 <tr>
  		    <td colspan="2">
				<table width="578">
					<tr>
						<td width="185" align="right"><font size="2" face="Arial, Helvetica, sans-serif"><b>Observaciones</b></font></td>
						<td width="381"><textarea name="txtObservacion" cols="50" rows="2"></textarea></td>
					</tr>
			  </table>			</td>
	     </tr>
		 
		 <tr>
  		    <td colspan="2">
				<table width="512">
					<tr>
					   <td width="218">&nbsp;</td>
					   <td width="282"><input name="adjunt" type="submit" value=" ADJUNTAR " onClick="return validar();" ></td>
					</tr>
			  </table>			</td>
	     </tr>
		 
		 
  		 
   		 <tr>
  		    <td >&nbsp;</td>
			<td></td>
	     </tr>

		 <!---->
        </table>
		</td>
    </tr>
  </table>
  
  </td></tr></table>
</form>

<script language="JavaScript">
		<!-- 
		<?php
		 print "function msgFile () {\n
				alert (\"Atencion, solamente puede enviar archivos menor o igual a $row5[tam_archivo] Mb de tamano.\\n \\nMensaje generado por GesTor F1.\");\n
				}\n";
			if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
			
		} ?>
		function validateConsulta () {
			var form=document.form1;
			if (form.glosa.value.length < 10 || form.glosa.value.length > 500){
				alert ("Descripcion de la incidencia, debe ser mayor a 10 caracteres y menor a 500.\nSi la descripcion es demasiado extensa, adjunte en un archivo \n\nMensaje generado por GesTor F1.");
				return false;
			}
			if (form.asig.value == 0 ){
				alert ("Debe Asignar la Orden a un tecnico especialista.\nSi la descripcion es demasiado extensa, adjunte en un archivo \n\nMensaje generado por GesTor F1.");
				return false;
			}
			if (form.nomb.value == 0 ){
				alert ("El Campo Nombre no puede ser vacio.\nMensaje generado por GesTor F1.");
				return false;
			}
			if (form.apaterno.value == 0 ){
				alert ("El Campo Apellido Paterno no puede ser vacio.\nMensaje generado por GesTor F1.");
				return false;
			}
			if (form.carnet.value == 0 ){
				alert ("El Numero de Tipo de Identificacion no puede ser vacio.\nMensaje generado por GesTor F1.");
				return false;
			}
			if (form.direccion.value == 0 ){
				alert ("El campo Direccion no puede ser vacio.\nMensaje generado por GesTor F1.");
				return false;
			}
			ventana_secundaria=window.open('pru2.php','secundaria','location=no,menubar=no,status=no,toolbar=no,scrollbars=0,resizable=no,width=350,height=170,left=150,top=150'); 
			//ventana_secundaria.close();
			return true;
		}


function validar()
{
	msg1 = "\nMensaje generado por GesTor F1.";
	sCad = "";
	if(document.form1.archivo.value == ""){sCad = sCad + "Debe adjuntar un archivo\n";}
	if(document.form1.txtObservacion.value == ""){sCad = sCad + "Debe llenar el campo de Observaciones\n";}
	if(sCad == ""){return true;}
	else{
		sCad = sCad + msg1;
		alert(sCad);
		return false;
	}
}
// Funciones adicionales 
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function tipo(men){
			des = document.form1.glosa.value;
			nombre = document.form1.nomb.value;
			apaterno = document.form1.apaterno.value;
			amaterno = document.form1.amaterno.value;
			acasada = document.form1.acasada.value;
			email = document.form1.email.value;
			telefono = document.form1.telefono.value;
			eif = document.form1.eif.value;
			direccion = document.form1.direccion.value;
			canal = document.form1.canal.value;
			tipop = document.form1.tipop.value;
			tipor = document.form1.tipor.value;
			oficina = document.form1.oficina.value;
			plazo = document.form1.plazo.value;
			lciudad = document.form1.lciudad.value;
			lzona = document.form1.lzona.value;
			carnet = document.form1.carnet.value;
			tipologia = document.form1.tipologia.value;
			subtipologia = document.form1.subtipologia.value;
		 	irapagina("reclamosv1.php?menu="+men+"&Naveg=Registrar Proceso&des="+des+"&nomb="+nombre+"&apaterno="+apaterno+"&amaterno="+amaterno+"&acasada="+acasada+"&email="+email+"&telefono="+telefono+"&eif="+eif+"&direccion="+direccion+"&can="+canal+"&tipp="+tipop+"&tipr="+tipor+"&ofic="+oficina+"&plazo="+plazo+"&lciuda="+lciudad+"&lzon="+lzona+"&carnet="+carnet+"&tipog="+tipologia+"&subtipog="+subtipologia);
		 }
function tipo1(men,va1){
			des = document.form1.glosa.value;
		 	irapagina("opt_clien.php?menu="+men+"&obco="+va1+"&Naveg=Registrar Proceso&des="+des);
		 }
//Fin
//-->
</script>
<?php include("top_.php");?> 