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

require("conexion.php");
if ( isset($actividad) && $actividad == "1" )
{	$fila = explode(":", $str);
	$fecha = explode("/",$fila[4]);
	if ($fecha[1] < 10) $fecha[1]="0".$fecha[1];
	if ($fecha[0] < 10) $fecha[0]="0".$fecha[0];
	$FechaPlanifica = $fecha[2]."-".$fecha[1]."-".$fecha[0];	
	//$Accion1 = $fila[2]."|";
	$sql2= "INSERT INTO planif_estrategica (TipoPlanifica,NumPlanif,ObjNegocio,ObjTi,RespPlanifica,FechaPlanifica,costo) ".
	"VALUES ('$plan','$numer','$fila[0]','$fila[1]','$fila[3]','$FechaPlanifica','$fila[5]')";		
	// =========MAIL
	if (mysql_query($sql2))
	{	$sql0="SELECT * FROM users WHERE login_usr='$RespPlanifica'";
		$result0=mysql_query($sql0);
		$row0=mysql_fetch_array($result0);				
		$sqlSystem="SELECT nombre, mail, conf_mail, conf_sms, web FROM control_parametros";
		$systemData=mysql_fetch_array(mysql_query( $sqlSystem));				
		if($systemData["conf_mail"]==2 || $systemData["conf_mail"]==3 || $systemData["conf_sms"]==2 || $systemData["conf_sms"]==3)
		{	$userData=$row0;
			$userName=$userData['nom_usr'].' '.$userData['apa_usr'].' '.$userData['ama_usr'];
			include ('mail.inc.php');
			$mimemail = new nxs_mimemail(); 
			//envio de SMS
			if($systemData["conf_sms"]==2 || $systemData["conf_sms"]==3)
			{	$sqlMovil="SELECT id_dat_tel_movil, direccion FROM dat_tel_movil";
				$movilRs=mysql_query($sqlMovil);
				while($tmp=mysql_fetch_array($movilRs)){
					$movilLst[$tmp['id_dat_tel_movil']]=$tmp['direccion'];
				}
				$userData[movilEmail]="591".$userData['ext_usr']."@".$movilLst[$userData['id_dat_tel_movil']];
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
					$mimemail->set_text("Nuevo objetivo en Planificacion Estrategica\n\nObjetivo de Negocio: $ObjNegocio\nObjetivo TI: $ObjTi\nAccion: $Accion\nFecha: $FechaPlanifica\n\nPara mayores detalles, consulte el Sistema de Mesa de Ayuda.\n\n".$systemData['nombre']);
					if (!$mimemail->send())
					{	$msg.="Precaucion, no se ha podido enviar la orden por correo electronico al Usuario asignado.";}
				}	
				else 
				{	$msg.="Precaucion, no se ha podido enviar la orden por correo electronico al Usuario asignado. Posiblemente, su direccion de correo electronico sea incorrecto.";}
			}	  
		}	
	}//==============here mail						
}
if (isset($actividad) && $actividad == "0")
{	$fila = explode(":", $str);
	$fecha = explode("/",$fila[4]);
	if ($fecha[1] < 10) $fecha[1]="0".$fecha[1];
	if ($fecha[0] < 10) $fecha[0]="0".$fecha[0];
	$FechaPlanifica = $fecha[2]."-".$fecha[1]."-".$fecha[0];
	$sql4 = "UPDATE planif_estrategica SET ObjNegocio='$fila[0]', ObjTi='$fila[1]', Accion='$fila[2]', RespPlanifica='$fila[3]',FechaPlanifica='$FechaPlanifica',costo='$fila[5]'
			WHERE TipoPlanifica='$plan' AND NumPlanif='$numer'";
	mysql_query($sql4);
}
if (isset($fil1) && $fil == 1 )
{	$sql3 = "SELECT * FROM planif_estrategica WHERE TipoPlanifica='$plan' AND NumPlanif='$numer'";
	$res3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($res3);
	$val  = explode("|",$row3[Accion]);
	$action = $row3[Accion]."|";
	mysql_query("UPDATE planif_estrategica SET Accion='$action' WHERE TipoPlanifica='$plan' AND NumPlanif='$numer'");
}
unset($fil);
if (isset($Terminar))
{	if ($sw == 2)  header("location: lista_acciones.php?varia2=$plan&NumPlanif=$numer&objti=$objti&objnegocioaux=$objnegocioaux");
	else   header("location: planif_estrategica.php?varia2=$plan");
}
if (isset($reg_form))
{	$sql3 = "SELECT * FROM planif_estrategica WHERE TipoPlanifica='$plan' AND NumPlanif='$numer' AND ObjTi='$objti'";
	$res3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($res3);
	$action = $row3['Accion'].$accion."|";
	$costo1 = $row3['costo'].$costo."|";
	/*if(!$row3[costo]) $costo1=$costo;
	else{
		$costo1 = explode("|",$row3[costo]);
		array_push($costo1,$costo);
		$costo1=implode("|",$costo1);
	}*/
	$sql4 = "UPDATE planif_estrategica SET Accion='$action', costo='$costo1' WHERE TipoPlanifica='$plan' AND NumPlanif='$numer' AND ObjTi='$objti'";
	mysql_query($sql4);	
}

include("top.php");

require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "accion",  "Accion, $errorMsgJs[empty]" );
print $valid->toHtml ();
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
<SCRIPT LANGUAGE="JavaScript">
<!-- 
function textCounter(field, countfield, maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
	field.value = field.value.substring(0, maxlimit);
	// otherwise, update 'characters left' counter
	else 
	countfield.value = maxlimit - field.value.length;
	}
// End 
-->
</script>
<?php

$sql3 = "SELECT *, DATE_FORMAT(FechaPlanifica, '%d/%m/%Y') AS FechaPlanifica FROM planif_estrategica WHERE TipoPlanifica='$plan' AND NumPlanif='$numer' AND ObjTi='$objti'";
$res3 = mysql_query($sql3);
$row3 = mysql_fetch_array($res3);
$sql  = "SELECT * FROM users WHERE login_usr='".$row3['RespPlanifica']."'";
$res  = mysql_query($sql);
$row  = mysql_fetch_array($res);
$name = $row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'];

require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "accion",  "Accion, $errorMsgJs[expresion]" );
$valid->addLength ( "accion",  "Accion, $errorMsgJs[length]" );
$valid->addIsNumber ( "costo",  "Costo estimado, $errorMsgJs[number]" );
print $valid->toHtml ();
?>  
<form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
	<input name="plan" type="hidden" value="<?php echo $plan; ?>">
	<input name="str" type="hidden" value="<?php echo $str; ?>">
	<input name="numer" type="hidden" value="<?php echo $numer; ?>">
	<input name="NumPlanif" type="hidden" value="<?php echo $NumPlanif; ?>">
	<input name="sw" type="hidden" value="<?php echo $sw; ?>">
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="8" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
            <?php echo "PLANIFICACION ESTRATEGICA - ".$plan;?></font></th>
          </tr>
           <tr> 
            <th colspan="8" >
 		<table width="100%" background="images/fondo.jpg">
		<tr>
			<td width="126"><font face="arial, verdana" size="2"><b>&nbsp;Nro Planificacion:</b></font></td>							
			<td width="250"><?php echo $row3['NumPlanif']?></td>
			<td width="85"><font face="arial, verdana" size="2"><b>Responsable:</b></font></td>
			<td width="149"><?php echo $name;?></td>			
		</tr>
		<tr>
          <td width="126"><font face="arial, verdana" size="2"><b>&nbsp;Objetivo Negocio:</b></font></td>							
			<td width="250"><?php echo $row3['ObjNegocio'];?></td>
			<td width="85"><font face="arial, verdana" size="2"><b>Costo:</b></font></td>
			<td width="149"><?php 
			$costo_tot=explode("|",$row3['costo']);
			echo "$"."us ".array_sum($costo_tot);?></td>
		</tr>
		<tr>
          <td width="126"><font face="arial, verdana" size="2"><b>&nbsp;Objetivo TI:</b></font></td>							
		          <td width="250">
                    <?php=$objti;?>
                  </td>
          <td width="85"><font face="arial, verdana" size="2"><b>Fecha:</b></font></td>
		  <td width="149"><?php echo $row3['FechaPlanifica'];?></td>
		</tr>
		</table>
			</font>
			</th>
          </tr>
         
            <th width="45" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="449" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">ACCIONES</font></th>
			<th width="183" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">COSTO</font></th>
          </tr>
          <?php
		  	$sql3 = "SELECT * FROM planif_estrategica WHERE TipoPlanifica='$plan' AND NumPlanif='$numer' AND ObjTi='$objti'";
			$res3 = mysql_query($sql3);
			$row3 = mysql_fetch_array($res3);
			$val  = explode("|",$row3['Accion']);
			$val2 = explode("|",$row3['costo']);
			for ($i=0; $i< count($val)-1; $i++)
			{ 	$c = $i + 1	;
				echo "<tr> <td align=center>$c</td>";
				echo "<td>&nbsp;".$val[$i]."</td>";
				echo "<td align=center>&nbsp;".number_format($val2[$i],2)."</td>";
				echo "</tr>";
			}
		 ?>
          <tr> 
            <td colspan="8" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
          <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="45" height="7" nowrap bgcolor="#006699">
				<div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nuevo</font> 
                </strong></div></td>
            <td width="449" nowrap><div align="center"><strong> 
                <textarea name="accion" cols="60" onKeyDown="textCounter(form2.accion,form2.remLen,250);" onKeyUp="textCounter(form2.accion,form2.remLen,250);"></textarea>
				<input name="remLen" type="hidden" value="250">
                <input name="objti" type="hidden" id="objti" value="<?php=$objti?>">
                </strong></div></td>
			<td><div align="center">
                <input name="costo" type="text" id="costo" value="0.00">
              </div></td>
          </tr>				
        </table>
        
      </td>
    </tr>
  </table><br>
  <input name="objnegocioaux" type="hidden" id="objnegocioaux" value="<?php=$objnegocioaux?>">
  <table align="center" >
            <tr> 
            <td height="28" colspan="8" nowrap> <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR ACCION" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="RETORNAR">
              </div></td>
          </tr>

  </table>
  </form>