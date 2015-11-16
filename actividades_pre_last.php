<?php
if(isset($terminar)) header("location: planif_estrategica_last.php?varia2=$tip");
include("conexion.php");
if ($varia3=="creacion")
{	
	session_start();
	$login=$_SESSION['login'];
	$numplan=$variacua;
	$sql2 = "SELECT * FROM planif_estrategica WHERE TipoPlanifica='$tip' AND NumPlanif='$numplan'";
	$result2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($result2);
	
/*	$sql4="UPDATE planif_estrategica SET orden='SI' WHERE TipoPlanifica='$tip' AND NumPlanif='$numplan'"; 
	mysql_db_query($db,$sql4,$link); */
	
	$val = explode("|",$row2['Accion']);
	
/*	if (count($val)-1>0)
	{*/	
	$ord="NULL";
	for ($i=0; $i< count($val)-1; $i++)
		{	$accion_obj = $val[$i]." (Objetivo: $row2[ObjTi])";
			$sql3 = "INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, tipo,origen) ".
					"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$accion_obj','L','1.4')"; 
					mysql_db_query($db,$sql3,$link);
			$sql5 = "SELECT MAX(id_orden) AS Ord FROM ordenes";
			$result5 = mysql_db_query($db,$sql5,$link);
			$row5 = mysql_fetch_array($result5);
			$ord=$ord."|$row5[Ord]";
			$sql6="INSERT INTO ".
			"asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,fechaestsol_asig,reg_asig,diagnos,escal,date_esc,time_esc,fechasol_esc,area) ".
			"VALUES('$row5[Ord]','2','2','2','$row2[RespPlanifica]','".date("Y-m-d")."','".date("H:i:s")."','$row2[FechaPlanifica]','$login','Planificacion Estrategica - Actividad a Corto Plazo','0','".date("Y-m-d")."','".date("H:i:s")."','$row2[FechaPlanifica]','Mesa')";
			mysql_db_query($db,$sql6,$link);	
		}
	$ord=str_replace('NULL|','',$ord);
	$sql4="UPDATE planif_estrategica SET orden='$ord' WHERE TipoPlanifica='$tip' AND NumPlanif='$numplan' AND ObjTi='$objti'"; 
	mysql_db_query($db,$sql4,$link);	
}
if(isset($guardar)){
	$str = $ObjNegocio.":".$ObjTi.":".$Accion.":".$RespPlanifica.":".$Dia."/".$Mes."/".$Ano.":".$costo;
	$fila = explode(":", $str);
	$fecha = explode("/",$fila[4]);
	if ($fecha[1] < 10) $fecha[1]="0".$fecha[1];
	if ($fecha[0] < 10) $fecha[0]="0".$fecha[0];
	$FechaPlanifica = $fecha[2]."-".$fecha[1]."-".$fecha[0];
	if($flag=="ok")	$sql2= "UPDATE planif_estrategica SET ObjTi='$ObjTi',RespPlanifica='$RespPlanifica',FechaPlanifica='$FechaPlanifica' WHERE TipoPlanifica='$tip' AND NumPlanif='$numer' AND ObjTi='$ObjTi2'";
	else{
	//$Accion1 = $fila[2]."|";
	require_once('funciones.php');
	$tip=_clean($tip);
	$numer=_clean($numer);
	$fila[0]=_clean($fila[0]);
	$fila[1]=_clean($fila[1]);
	$ObjTi=_clean($ObjTi);
	$fila[3]=_clean($fila[3]);
	$FechaPlanifica=_clean($FechaPlanifica);
	
	$tip=SanitizeString($tip);
	$numer=SanitizeString($numer);
	$fila[0]=SanitizeString($fila[0]);
	$fila[1]=SanitizeString($fila[1]);
	$ObjTi=SanitizeString($ObjTi);
	$fila[3]=SanitizeString($fila[3]);
	$FechaPlanifica=SanitizeString($FechaPlanifica);
	$sql2= "INSERT INTO planif_estrategica (TipoPlanifica,NumPlanif,ObjNegocio,Accion,ObjTi,RespPlanifica,FechaPlanifica,orden,costo) ".
	"VALUES ('$tip','$numer','$fila[0]','$fila[1]','$ObjTi','$fila[3]','$FechaPlanifica','','')";}
	unset($ObjTi2);
	// =========MAIL
	if (mysql_db_query($db,$sql2,$link))
	{	$sql0="SELECT * FROM users WHERE login_usr='$RespPlanifica'";
		$result0=mysql_db_query($db,$sql0,$link);
		$row0=mysql_fetch_array($result0);				
		$sqlSystem="SELECT nombre, mail, conf_mail, conf_sms, web FROM control_parametros";
		$systemData=mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));				
		if($systemData["conf_mail"]==2 || $systemData["conf_mail"]==3 || $systemData["conf_sms"]==2 || $systemData["conf_sms"]==3)
		{	$userData=$row0;
			$userName=$userData['nom_usr'].' '.$userData['apa_usr'].' '.$userData['ama_usr'];
			include ('mail.inc.php');
			$mimemail = new nxs_mimemail();
			//envio de SMS
			if($systemData["conf_sms"]==2 || $systemData["conf_sms"]==3)
			{	$sqlMovil="SELECT id_dat_tel_movil, direccion FROM dat_tel_movil";
				$movilRs=mysql_db_query($db, $sqlMovil, $link);
				while($tmp=mysql_fetch_array($movilRs)){
					$movilLst[$tmp['id_dat_tel_movil']]=$tmp['direccion'];
				}
				$userData[movilEmail]="591".$userData['ext_usr']."@".$movilLst[$userData['id_dat_tel_movil']];
				if($mimemail->validate_mail($userData['movilEmail']))
				{	$mimemail->set_to($userData['movilEmail'], $userName);
					$mimemail->set_subject($userName);
					$mimemail->set_text("Nuevo objetivo en Planificacion Estrategica. $systemData[nombre]");
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
//	header("location: actividades_pre_last.php?tip=$tip&numer=$numer&ObjNegocio=$ObjNegocio");						
}
include("top.php");

require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTextNormal ( "ObjTi",  "Objetivo TI, $errorMsgJs[expresion]" );
$valid->addLength ( "ObjTi",  "Objetivo TI, $errorMsgJs[length]" );
$valid->addIsTextNormal ( "Accion",  "Accion, $errorMsgJs[expresion]" );
$valid->addLength ( "Accion",  "Accion, $errorMsgJs[length]" );
$valid->addIsNotEmpty ( "RespPlanifica",  "Responsable, $errorMsgJs[empty]" );
$valid->addIsDate   ( "Dia", "Mes", "Ano", "Fecha, $errorMsgJs[date]" );
$valid->addIsNumber ( "costo",  "Costo estimado, $errorMsgJs[number]" );
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
      <th colspan="8" >PLANIFICACION ESTRATEGICA - <?php echo $tip;?></th>
    </tr>
    <tr> 
      <td height="29" colspan="8"> <div align="center">
          <table width="100%" border="0">
            <tr> 
              <td width="18%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;Objetivo 
                del Negocio</strong></font><strong>:<font size="2" face="Arial, Helvetica, sans-serif"></font></strong></td>
              <td width="82%"><font size="2" face="Arial, Helvetica, sans-serif"> 
                <?php=$ObjNegocio?>
                </font></td>
            </tr>
          </table>
          
        </div></td>
    </tr>
    <tr> 
      <td width="18" bgcolor="#006699"> <div align="center"></div>
        <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nro,</font></div></td>
      <td width="150" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBJETIVO 
          TI</font></div></td>
      <td width="95" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NRO. 
          ACCIONES</font></div></td>
      <td width="160" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">RESPONSABLE</font></div></td>
      <td width="67" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font></div></td>
      <td width="81" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">COSTO 
          ($us)</font></div></td>
      <?php if ($tip=="CORTO PLAZO") {?>
      <td width="154" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">ORDEN 
          DE TRABAJO</font></div></td>
      <?php }?><?php $c=1;?>
    </tr>
    <?php
		$fechahoy=date("Y-m-d");
		$sql = "SELECT *, DATE_FORMAT(FechaPlanifica, '%d/%m/%Y') AS FechaPlanifica2 FROM planif_estrategica WHERE TipoPlanifica='$tip' AND NumPlanif='$numer' ORDER BY NumPlanif ASC";
		$result=mysql_db_query($db,$sql,$link);
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
      <td>&nbsp;<?php echo "<a href=\"actividades_pre_last.php?tip=$tip&numer=$numer&ObjNegocio=$ObjNegocio&ObjTi2=$row[ObjTi]\">".$c++."</a>";?></td>
      <td>&nbsp;<?php echo $row['ObjTi']?></td>
      <td>&nbsp; 
        <?php 
	  	$acciones = explode("|",$row['Accion']);	
	  	$nro_acciones = count($acciones)-1;
		if ( $nro_acciones == 0)
		{	if (!(empty($row['Accion'])))
			 $nro_acciones=1;
		}
		echo "<a href=\"lista_acciones_last.php?varia2=$tip&NumPlanif=$row[NumPlanif]&objti=$row[ObjTi]&objnegocioaux=$ObjNegocio\">$nro_acciones</a>";
	  ?>
      </td>
      <?php	 
	  	 $sql5 = "SELECT * FROM users WHERE login_usr='$row[RespPlanifica]'";
		 $result5 = mysql_db_query($db,$sql5,$link);
		 $row5 = mysql_fetch_array($result5);
		 echo "<td>&nbsp;$row5[apa_usr] $row5[ama_usr] $row5[nom_usr]</td>";?>
      <td>&nbsp;<?php echo $row['FechaPlanifica2']?></td>
      <td>&nbsp;<?php 
	  $costo_tot=explode("|",$row['costo']);
	  echo array_sum($costo_tot);
	  ?></td>
      <?php if ($tip=="CORTO PLAZO") { 
	  		if ($row['orden']=="" AND $nro_acciones>"0") 
		 		{echo "<td><a href=\"actividades_pre_last.php?tip=$tip&numer=$numer&ObjNegocio=$ObjNegocio&varia2=$tip&varia3=creacion&variacua=".$row[NumPlanif]."&objti=$row[ObjTi]&actividad=1\">CREAR ORDEN DE TRABAJO</a></td>";}
		 	elseif ($row['orden']!="")
		 		{//
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
				}//
		 	elseif ($nro_acciones=="0")
		 		{echo "<td>NO TIENE ACCIONES</td>";}
	  }?>
    </tr>
    <?php 
		 }
		 ?>
  </table><br>
  <table width="75%" border="1" align="center" background="images/fondo.jpg" >
    <tr> <?php
	$sql_up="SELECT * FROM planif_estrategica WHERE TipoPlanifica='$tip' AND NumPlanif='$numer' AND ObjTi='$ObjTi2'";
	$res_up=mysql_db_query($db,$sql_up,$link);
	$row_up=mysql_fetch_array($res_up);
	?>
      <td width="36%" bgcolor="#006699" align="center" colspan="3"><font color="#FFFFFF" size="1" face="Arial, Helvetica"> 
        OBJETIVO TI</font></td>
    </tr>
    <tr> 
      <td width="36%"  align="center" colspan="3"><font color="#FFFFFF" size="1" face="Arial, Helvetica"> 
        
		<textarea name="ObjTi" cols="100"><?php echo $row_up['ObjTi'];?></textarea>
        
		</font></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">RESPONSABLE</font></div></td>
	 </tr><tr>
	       <td colspan="2"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">
          <?php if(isset($ObjTi2)){?>   
          <input name="flag" type="hidden" id="ObjTi22" value="ok">
           <?php }?>
          <select name="RespPlanifica" id="select">
            <option value="0"></option>
            <?php 
			  $sql1 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear='0' ORDER BY apa_usr ASC";
			  $result1 = mysql_db_query($db,$sql1,$link);
			  while ($row1 = mysql_fetch_array($result1)) 
				{ $nombre = "$row1[apa_usr] $row1[ama_usr] $row1[nom_usr]";
					if ($row1['login_usr'] == $row_up['RespPlanifica'])
					echo "<option value=\"$row1[login_usr]\" selected>$nombre</option>";
					else
					echo "<option value=\"$row1[login_usr]\">$nombre</option>";
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
				if(isset($ObjTi2))
				{
					$fec = explode("-", $row_up['FechaPlanifica']);
					$a1 = $fec[0];
					$m1 = $fec[1];
					$d1 = $fec[2];
				}
				else
				{
					$fsist=date("Y-m-d");
					$a1=substr($fsist,0,4);
					$m1=substr($fsist,5,2);
					$d1=substr($fsist,8,2);
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
    <input name="tip" type="hidden" id="tip" value="<?php=$tip?>">
    <input name="numer" type="hidden" id="numer" value="<?php=$numer?>">
    <input name="ObjTi2" type="hidden" id="ObjTi2" value="<?php=$ObjTi2?>">
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
  <?php include("top_.php");?>
</div>
