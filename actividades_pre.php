<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require_once('funciones.php');
$ObjNegocio=$_REQUEST['ObjNegocio'];
$ObjNegocio=_clean($ObjNegocio);
$ObjNegocio=SanitizeString($ObjNegocio);
if(isset($terminar)) header("location: planif_estrategica.php?varia2=$planc");
include("conexion.php");
if (isset($varia) && $varia3=="creacion"){	
	$login=$_SESSION['login'];
	$tip=$varia2;
	$numplan=$variacua;
	$sql2 = "SELECT * FROM planif_estrategica WHERE TipoPlanifica='$tip' AND NumPlanif='$numplan'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	
	$val = explode("|",$row2['Accion']);
	
	$ord="NULL";
	for ($i=0; $i< count($val)-1; $i++)
		{	$accion_obj = $val[$i]." (Objetivo: ".$row2['ObjTi'].")";
			$sql3 = "INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, tipo,origen,nomb_archivo,area,dominio,objetivo,ci_ruc,id_anidacion,hash_archivo,observaciones) ".
					"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$accion_obj','L','1.4','','0','0','0','0','0','0','0')"; 
					mysql_query($sql3) or die("Error en consulta <br>MySQL dice: ".mysql_error()); 
			$sql5 = "SELECT MAX(id_orden) AS Ord FROM ordenes";
			$result5 = mysql_query($sql5);
			$row5 = mysql_fetch_array($result5);
			$ord=$ord."|$row5[Ord]";
			$sql6="INSERT INTO ".
			"asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,fechaestsol_asig,reg_asig,diagnos,escal,date_esc,time_esc,fechasol_esc,area) ".
			"VALUES('".$row5['Ord']."','2','2','2','".$row2['RespPlanifica']."','".date("Y-m-d")."','".date("H:i:s")."','".$row2['FechaPlanifica']."','$login','Planificacion Estrategica - Actividad a Corto Plazo','0','".date("Y-m-d")."','".date("H:i:s")."','".$row2['FechaPlanifica']."','Mesa')";
			mysql_query($sql6) or die("Error en consulta <br>MySQL dice: ".mysql_error());
		}
	$ord=str_replace('NULL|','',$ord);
	$sql4="UPDATE planif_estrategica SET orden='$ord' WHERE TipoPlanifica='$tip' AND NumPlanif='$numplan' AND ObjTi='$objti'"; 
	mysql_query($sql4);	
}
if(isset($guardar)){
	$str = $ObjNegocio.":".$ObjTi.":".$Accion.":".$RespPlanifica.":".$Dia."/".$Mes."/".$Ano.":".$costo;
	$fila = explode(":", $str);
	$fecha = explode("/",$fila[4]);
	if ($fecha[1] < 10) $fecha[1]="0".$fecha[1];
	if ($fecha[0] < 10) $fecha[0]="0".$fecha[0];
	$FechaPlanifica = $fecha[2]."-".$fecha[1]."-".$fecha[0];
	require_once('funciones.php');
	$plan=_clean($plan);
	$numer=_clean($numer);
	$fila[0]=_clean($fila[0]);
	$fila[1]=_clean($fila[1]);
	$fila[3]=_clean($fila[3]);
	$FechaPlanifica=_clean($FechaPlanifica);
	
	$plan=SanitizeString($plan);
	$numer=SanitizeString($numer);
	$fila[0]=SanitizeString($fila[0]);
	$fila[1]=SanitizeString($fila[1]);
	$fila[3]=SanitizeString($fila[3]);
	$FechaPlanifica=SanitizeString($FechaPlanifica);
	$sql2= "INSERT INTO planif_estrategica (TipoPlanifica,NumPlanif,ObjNegocio,ObjTi,Accion,RespPlanifica,FechaPlanifica,orden,costo) ".
	"VALUES ('$plan','$numer','$fila[0]','$fila[1]','','$fila[3]','$FechaPlanifica','','')";	
	//echo $sql2;
	//mysql_query($sql2) or die("Error en consulta <br>MySQL dice: ".mysql_error());
	// =========MAIL
	if (mysql_query($sql2))
	{	$sql0="SELECT * FROM users WHERE login_usr='$RespPlanifica'";
		$result0=mysql_query($sql0);
		$row0=mysql_fetch_array($result0);				
		$sqlSystem="SELECT nombre, mail, conf_mail, conf_sms, web FROM control_parametros";
		$systemData=mysql_fetch_array(mysql_query( $sqlSystem, $link));				
		if($systemData["conf_mail"]==2 || $systemData["conf_mail"]==3 || $systemData["conf_sms"]==2 || $systemData["conf_sms"]==3)
		{	$userData=$row0;
			$userName=$userData['nom_usr'].' '.$userData['apa_usr'].' '.$userData['ama_usr'];
			include ('mail.inc.php');
			$mimemail = new nxs_mimemail(); 
			//envio de SMS
			if($systemData["conf_sms"]==2 || $systemData["conf_sms"]==3)
			{	$sqlMovil="SELECT id_dat_tel_movil, direccion FROM dat_tel_movil";
				$movilRs=mysql_query( $sqlMovil, $link);
				while($tmp=mysql_fetch_array($movilRs)){
					$movilLst[$tmp['id_dat_tel_movil']]=$tmp['direccion'];
				}
				$userData['movilEmail']="591".$userData['ext_usr']."@".$movilLst[$userData['id_dat_tel_movil']];
				if($mimemail->validate_mail($userData['movilEmail']))
				{	$mimemail->set_to($userData['movilEmail'], $userName);
					$mimemail->set_subject($userName);
					$mimemail->set_text("Nuevo objetivo en Planificacion Estrategica. ".$systemData['nombre']);
					if (!$mimemail->send())
					{	$msg.="Precaucion, no se ha podido enviar la orden por SMS al Usuario asignado.\\n";}
				}
				else $msg.="Precaucion, no se ha podido enviar la orden por SMS al Usuario asignado.*\\n";
			}
			//envio de mail
			if($systemData["conf_mail"]==2 || $systemData["conf_mail"]==3)																				
			{	if($mimemail->validate_mail($userData['email']))
				{	$mimemail->set_from($systemData['mail'], $systemData['nombre']);
					$mimemail->set_to($userData['email'], "$userName");
					$mimemail->set_subject("Nuevo objetivo en Planificacion Estrategica");
					$mimemail->set_text("Nuevo objetivo en Planificacion Estrategica\n\nObjetivo de Negocio: $ObjNegocio\nObjetivo TI: $ObjTi\nAccion: $Accion\nFecha: $FechaPlanifica\n\nPara mayores detalles, consulte el Sistema de Mesa de Ayuda.\n\n$systemData[nombre]");
					if (!$mimemail->send())
					{	$msg.="Precaucion, no se ha podido enviar la orden por correo electronico al Usuario asignado.";}
				}	
				else 
				{	$msg.="Precaucion, no se ha podido enviar la orden por correo electronico al Usuario asignado. Posiblemente, su direccion de correo electronico sea incorrecto.";}
			}	  
		}	
	}//==============here mail						
}
include("top.php");
$tip=($_GET['varia2']);
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTextNormal ( "ObjTi",  "Objetivo TI, $errorMsgJs[expresion]" );
$valid->addLength ( "ObjTi",  "Objetivo TI, $errorMsgJs[length]" );
$valid->addIsNotEmpty ( "RespPlanifica",  "Responsable, $errorMsgJs[empty]" );
$valid->addIsDate   ( "Dia", "Mes", "Ano", "Fecha, $errorMsgJs[date]" );
print $valid->toHtml ();
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<script language="JavaScript" src="calendar.js"></script>
<body>
<form name="form1" method="post" action="" onKeyPress="return Form()">
  <input name="ObjNegocio" type="hidden" id="ObjNegocio" value="<?php=$ObjNegocio?>">
  <input name="planc" type="hidden" id="planc" value="<?php=$plan?>">
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <th colspan="8" >PLANIFICACION ESTRATEGICA - <?php echo $plan;?></th>
    </tr>
    <tr> 
      <td height="29" colspan="8"> <div align="left"> 
          <table width="100%" border="0">
            <tr>
              <td width="18%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;Objetivo 
                del Negocio</strong></font><strong>:<font size="2" face="Arial, Helvetica, sans-serif"></font></strong></td>
              <td width="82%"><font size="2" face="Arial, Helvetica, sans-serif">
                <?php=$ObjNegocio?>
                </font></td>
            </tr>
          </table>
          <font size="2" face="Arial, Helvetica, sans-serif"> </font> </div></td>
    </tr>
    <tr> 
      <td width="292" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBJETIVO 
          TI</font></div></td>
      <td width="93" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NRO. 
          ACCIONES</font></div></td>
      <td width="205" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">RESPONSABLE</font></div></td>
      <td width="65" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font></div></td>
      <td width="79" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">COSTO 
          ($us)</font></div></td>
      <?php if ($varia2=="CORTO PLAZO") {?>
      <td width="153" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">ORDEN 
          DE TRABAJO</font></div></td>
      <?php }?>
    </tr>
    <?php
		$fechahoy=date("Y-m-d");
		$sql = "SELECT *, DATE_FORMAT(FechaPlanifica, '%d/%m/%Y') AS FechaPlanifica2 FROM planif_estrategica WHERE TipoPlanifica='$tip' AND NumPlanif='$numer' ORDER BY NumPlanif ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
			if ($row['FechaPlanifica'] >= $fechahoy ) { //VIGENTE
				$color="bgcolor=\"#00CC00\"";
			}
			else {
				$color="bgcolor=\"#FF6666\""; //VENCIDO
			}
		 ?>
    <tr align="center"> 
      <td>&nbsp;<?php echo $row['ObjTi']?></td>
      <td>&nbsp; 
        <?php 
	  	$acciones = explode("|",$row['Accion']);	
	  	$nro_acciones = count($acciones)-1;

		if ( $nro_acciones == 0)
		{	if (!(empty($row['Accion'])))
			 $nro_acciones=1;
		}
		echo '<a href="lista_acciones.php?varia2='.$tip.'&NumPlanif='.$row['NumPlanif'].'&objti='.$row['ObjTi'].'&objnegocioaux='.$ObjNegocio.'">'.$nro_acciones.'</a>';
	  ?>
      </td>
      <?php	 
	  	 $sql5 = "SELECT * FROM users WHERE login_usr='".$row['RespPlanifica']."'";
		 $result5 = mysql_query($sql5);
		 $row5 = mysql_fetch_array($result5);
		 echo '<td>&nbsp;'.$row5['apa_usr'].' '.$row5['ama_usr'].' '.$row5['nom_usr'].'</td>';?>
      <td>&nbsp;<?php echo $row['FechaPlanifica2']?></td>
      <td>&nbsp;<?php 
	  $costo_tot=explode("|",$row['costo']);
	  echo array_sum($costo_tot);
	  ?></td>
      <?php 
		if ($varia2=="CORTO PLAZO") { 
	  		if ($row['orden']=="" AND $nro_acciones>"0") 
		 		{
				echo '<td><a href="actividades_pre.php?plan='.$tip.'&numer='.$numer.'&ObjNegocio='.$ObjNegocio.'&varia2='.$tip.'&varia3=creacion&variacua='.$row['NumPlanif'].'&objti='.$row['ObjTi'].'&actividad=1">CREAR ORDEN DE TRABAJO</a></td>';}
		 	elseif ($row['orden']!="")
			{
				$ordenes = explode("|",$row['orden']);
				$numero = count($ordenes)-1;
				$cont = 0;
				for ($i = 0; $i <= $numero; $i++)
				{
					if($ordenes[$i] <> ""){$cont++;}
				}
				$number = $nro_acciones - $cont;
					
				if($number == 0)echo "<td>CREADA</td>";
				else echo "<td>ORDENES NO CREADAS $number</td>";
			}
		 	elseif ($nro_acciones=="0"){echo "<td>NO TIENE ACCIONES</td>";}
	  }?>
    </tr>
    <?php 
		 }
		 ?>
  </table><br>
  <table width="75%" border="1" align="center" background="images/fondo.jpg" >
    <tr> 
      <td width="36%" bgcolor="#006699" align="center" colspan="3"><font color="#FFFFFF" size="1" face="Arial, Helvetica"> 
        OBJETIVO TI</font></td>
    </tr>
    <tr> 
      <td width="36%"  align="center" colspan="3"><font color="#FFFFFF" size="1" face="Arial, Helvetica"> 
        <textarea name="ObjTi" cols="100"><?php echo @$row9['ObjTi'];?></textarea>
        </font></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">RESPONSABLE</font></div></td>
	 </tr><tr>
	       <td colspan="2"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
          <select name="RespPlanifica" id="select">
            <option value="0"></option>
            <?php 
			  $sql1 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear='0' ORDER BY apa_usr ASC";
			  $result1 = mysql_query($sql1);
			  while ($row1 = mysql_fetch_array($result1)) 
				{ $nombre = "$row1[apa_usr] $row1[ama_usr] $row1[nom_usr]";
					if ($row1['login_usr'] == $row9['RespPlanifica'])
					echo '<option value="'.$row1['login_usr'].'" selected>'.$nombre.'</option>';
					else
					echo '<option value="'.$row1['login_usr'].'">'.$nombre.'</option>';
	            }
			   ?>
          </select>
          </font></div>
        <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
          </font></div></td></tr><tr>
      <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font>&nbsp;</div></td>
    </tr>
    <tr align="center"> 
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
        <select name="Dia" >
          <?php
				$fsist=date("Y-m-d");
  				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
				if (!(empty($nro)))
				{	$fec = explode("-", $row9['FechaPlanifica']);
					$a1 = substr($row9['FechaPlanifica'],0,4);
					$m1 = substr($row9['FechaPlanifica'],5,2);
					$d1 = substr($row9['FechaPlanifica'],8,2);
				}
				for($i=1;$i<=31;$i++)
				{
	              echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
				}
				?>
        </select>
        <select name="Mes">
          <?php
				for($i=1;$i<=12;$i++)
				{
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
				}
				?>
        </select>
        <select name="Ano">
          <?php
				for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
        </select>
        <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></td>
    </tr>
  </table>
  <p align="center"> 
    <input name="guardar" type="submit" id="guardar" value = "GUARDAR Y CONTINUAR" <?php print $valid->onSubmit() ?>>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="terminar" type="submit" id="terminar" value = "TERMINAR">
  </p>
</form>
<div align="center">
  <script language="JavaScript">
		<!-- 
		function Form () 
		{
			var key = window.event.keyCode;
			if (key==13) return false;
			else return true; 
		}
		var form="form1";
		var cal = new calendar1(document.forms[form].elements['Dia'], document.forms[form].elements['Mes'], document.forms[form].elements['Ano']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>
</div>
