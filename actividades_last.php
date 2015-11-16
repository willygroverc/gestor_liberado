<?php 
include("conexion.php");
if ( $actividad == "1" )
{	$fila = explode(":", $str);
	$fecha = explode("/",$fila[4]);
	if ($fecha[1] < 10) $fecha[1]="0".$fecha[1];
	if ($fecha[0] < 10) $fecha[0]="0".$fecha[0];
	$FechaPlanifica = $fecha[2]."-".$fecha[1]."-".$fecha[0];	
	//$Accion1 = $fila[2]."|";
	require_once('funciones.php');
	$plan=_clean($plan);
	$numer=_clean($numer);
	$fila[0]=_clean($fila[0]);
	$fila[1]=_clean($fila[1]);
	$fila[3]=_clean($fila[3]);
	$FechaPlanifica=_clean($FechaPlanifica);
	$fila[5]=_clean($fila[5]);
	
	$plan=SanitizeString($plan);
	$numer=SanitizeString($numer);
	$fila[0]=SanitizeString($fila[0]);
	$fila[1]=SanitizeString($fila[1]);
	$fila[3]=SanitizeString($fila[3]);
	$FechaPlanifica=SanitizeString($FechaPlanifica);
	$fila[5]=SanitizeString($fila[5]);
	$sql2= "INSERT INTO planif_estrategica (TipoPlanifica,NumPlanif,ObjNegocio,ObjTi,RespPlanifica,FechaPlanifica,costo) ".
	"VALUES ('$plan','$numer','$fila[0]','$fila[1]','$fila[3]','$FechaPlanifica','$fila[5]')";		
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
				$userData['movilEmail']="591".$userData['ext_usr']."@".$movilLst[$userData['id_dat_tel_movil']];
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
}
if ($actividad == "0")
{	$fila = explode(":", $str);
	$fecha = explode("/",$fila[4]);
	if ($fecha[1] < 10) $fecha[1]="0".$fecha[1];
	if ($fecha[0] < 10) $fecha[0]="0".$fecha[0];
	$FechaPlanifica = $fecha[2]."-".$fecha[1]."-".$fecha[0];
	$sql4 = "UPDATE planif_estrategica SET ObjNegocio='$fila[0]', ObjTi='$fila[1]', Accion='$fila[2]', RespPlanifica='$fila[3]',FechaPlanifica='$FechaPlanifica',costo='$fila[5]'
			WHERE TipoPlanifica='$plan' AND NumPlanif='$numer'";
	mysql_db_query($db,$sql4,$link);
}
if ( $fil == 1 )
{	$sql3 = "SELECT * FROM planif_estrategica WHERE TipoPlanifica='$plan' AND NumPlanif='$numer'";
	$res3 = mysql_db_query($db,$sql3,$link);
	$row3 = mysql_fetch_array($res3);
	$val  = explode("|",$row3['Accion']);
	$action = $row3['Accion']."|";
	mysql_db_query($db,"UPDATE planif_estrategica SET Accion='$action' WHERE TipoPlanifica='$plan' AND NumPlanif='$numer'",$link);
}
unset($fil);
if ($Terminar)
{	if ($sw == 2)  header("location: lista_acciones_last.php?varia2=$plan&NumPlanif=$numer&objti=$objti&objnegocioaux=$objnegocioaux");
	else   header("location: planif_estrategica.php?varia2=$plan");
}
if ($reg_form)
{	$sql3 = "SELECT * FROM planif_estrategica WHERE TipoPlanifica='$plan' AND NumPlanif='$numer' AND ObjTi='$objti'";
	$res3 = mysql_db_query($db,$sql3,$link);
	$row3 = mysql_fetch_array($res3);
	if($regis=="Nuevo")
	{
		$action = $row3['Accion'].$accion."|";
		$costo1= $row3['costo'].$costo."|";
	}
	else
	{
		$val_ac = explode("|",$row3['Accion']);
		$val_co = explode("|",$row3['costo']);
		for ($i=0; $i< count($val_ac)-1; $i++)
		{
			if($regis==$i)
			{
				$action=$action.$accion."|";
				$costo1=$costo1.$costo."|";
			}
			else
			{
				$action=$action.$val_ac[$i]."|";
				$costo1=$costo1.$val_co[$i]."|";
			}			
		}
	}
	$sql4 = "UPDATE planif_estrategica SET Accion='$action', costo='$costo1' WHERE TipoPlanifica='$plan' AND NumPlanif='$numer' AND ObjTi='$objti'";
	mysql_db_query($db,$sql4,$link);	
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
$res3 = mysql_db_query($db,$sql3,$link);
$row3 = mysql_fetch_array($res3);
$sql  = "SELECT * FROM users WHERE login_usr='$row3[RespPlanifica]'";
$res  = mysql_db_query($db,$sql,$link);
$row  = mysql_fetch_array($res);
$name = "$row[apa_usr] $row[ama_usr] $row[nom_usr]";

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
            <?php echo "PLANIFICACION ESTRATEGICA -  ".$plan;?></font></th>
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
         
            <th width="67" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="494" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">ACCIONES</font></th>
			<th width="145" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">COSTO</font></th>
          </tr>
          <?php
		  	$sql3 = "SELECT * FROM planif_estrategica WHERE TipoPlanifica='$plan' AND NumPlanif='$numer' AND ObjTi='$objti'";
			$res3 = mysql_db_query($db,$sql3,$link);
			$row3 = mysql_fetch_array($res3);
			$val  = explode("|",$row3['Accion']);
			$val2 = explode("|",$row3['costo']);
			$val3 = explode("|",$row3['orden']);
			for ($i=0; $i< count($val)-1; $i++)
			{ 	$c = $i + 1	;
				echo "<tr>";
				//echo "<td align=center>$c</td>";
				if($val3[$i]==""){echo "<td align=center><a href=\"actividades_last.php?plan=$plan&numer=$numer&sw=$sw&objti=$objti&objnegocioaux=$objnegocioaux&modi=$c\">$c</td>";}
				else {echo "<td align=center>$c</td>";}
				echo "<td>&nbsp;".$val[$i]."</td>";
				echo "<td align=center>&nbsp;".$val2[$i]."</td>";
				echo "</tr>";
			}
		 ?>
          <tr> 
            <td colspan="8" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
          <div align="center"></div></td>
          </tr>
		  <?php 
		  if($modi)
		  {
		  	$x = $modi - 1;	
			$v_acc  = explode("|",$row3['Accion']);
			$v_cos = explode("|",$row3['costo']);
			for ($i=0; $i< count($v_acc)-1; $i++)
			{ 	
				if($x==$i)
				{	$acc_1=$v_acc[$i];
					$cos_1=$v_cos[$i];
				}
			}
		  }
		  ?>
          <tr> 
            <td width="67" height="7" nowrap>
				<div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">
				<select name="regis">
				<option value="Nuevo" <?php if(!$modi){echo "selected";}?>>Nuevo</option>
				<?php 	$val_2  = explode("|",$row3['Accion']);
					$val_3  = explode("|",$row3['orden']);
					for ($i=0; $i< count($val_2)-1; $i++)
					{
						if($val_3[$i]=="")
						{
							$z=$i+1;
							echo "<option value=\"$i\" ";
							if($z==$modi){echo "selected";}
							echo ">$z</option>";
						}
					}
						 
				?>
				</select>
                </font></strong></div></td>
            <td width="494" nowrap><div align="center"><strong> 
                <textarea name="accion" cols="60" onKeyDown="textCounter(form2.accion,form2.remLen,250);" onKeyUp="textCounter(form2.accion,form2.remLen,250);"><?php echo $acc_1;?></textarea>
				<input name="remLen" type="hidden" value="250">
                <input name="objti" type="hidden" id="objti" value="<?php=$objti?>">
                </strong></div></td>
			<td><div align="center">
                <input name="costo" type="text" id="costo" value="<?php if($modi){echo "$cos_1";}else{echo "0.00";}?>">
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
  
<?php include("top_.php");?>
