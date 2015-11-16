<?php 
if ($RETORNAR){header("location: lista_reclamos.php");}
session_start();
ini_set("error_reporting", "E_ALL & ~E_NOTICE & ~E_WARNING");
include ("conexion.php");


//****************************************
$sql5="SELECT * FROM control_parametros";
$result5=mysql_db_query($db,$sql5,$link);
$row5=mysql_fetch_array($result5);
if (isset($reg_form))
{
	$login=$_SESSION["login"];
	if (!isset($login)) {header("location: index.php");}
	$sql1="SELECT * FROM solicitud WHERE OrdAyuda='$id_orden'";
	$result1=mysql_db_query($db,$sql1,$link);
	$row1=mysql_fetch_array($result1);

	$sql2="SELECT * FROM aprobus WHERE OrdAyuda='$id_orden'";
	$result2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($result2);

	$sql4="SELECT * FROM asignacion WHERE id_orden='$id_orden' ORDER BY id_asig desc";
	$result4=mysql_db_query($db,$sql4,$link);
	$row4=mysql_fetch_array($result4);

	$f_sol_e="$AnoD-$MesD-$DiaD";
	//////////////
		$var1="ajuntos_bosol_".$id_orden;
		$adjuntos_bo=$_SESSION[$var1];
		$var1_hash="ajuntos_bosol_hash_".$id_orden;
		$adjuntos_bo_hash=$_SESSION[$var1_hash];
		$var1_obs="ajuntos_bosol_obs_".$id_orden;
		$adjuntos_bo_obs=$_SESSION[$var1_obs];
//////////////////
		$sql1="select * from sarc";
		$result1=mysql_db_query($db,$sql1,$link);
		$row1=mysql_fetch_array($result1);
		
	$sql3="INSERT INTO ".
	"solucion_reclamos (CTipoEntidad,CCorrelativoEntidad,CReclamo,TGestion,TFechaSolucion,TCiteRespuesta,TGlosaRespuesta,TResultado,DFechaReporte) ".
	"VALUES('".$row1[CTipoEntidad]."','".$row1[CCorrelativoEntidad]."','$creclamo','".date("Y")."','".date("Y-m-d")."','$tciterespuesta','$tglosarespuesta','$tresultado','".date("Y-m-d")."')";
	
	session_unregister($var1);
	session_unregister($var1_hash);//nuevo
	session_unregister($var1_obs);//nuevo
	
	
	$sqlsol="INSERT INTO ".
	"solucion (id_orden,detalles_sol,fecha_sol_e,fecha_sol,hora_sol,medprev_sol,login_sol,nomb_archivo,hash_archivo,observaciones) ".
	"VALUES('$id_rec','$tglosarespuesta','".date("Y-m-d")."','".date("Y-m-d")."','".date("H:i:s")."','','$login','$adjuntos_bo','$adjuntos_bo_hash','$adjuntos_bo_obs')";
	
	mysql_db_query($db,$sqlsol,$link);
	if ($row4[area]=="DyM")
	{	if (!$row1[OrdAyuda] or !$row2[OrdAyuda])
			{$msg = "LLENAR LOS DATOS DE LA SOLICITUD Y APROBACION EN DESARROLLO Y MANTENIMIENTO";}
		else
		{ 	mysql_db_query($db,$sql3,$link);
			
		
			if($conf=="1")
			{
			  $sql_conf="INSERT INTO ".
			  "conformidad (id_orden,fecha_conf,hora_conf,tiemposol_conf,calidaten_conf,obscli_conf,reg_conf, tipo_conf)".
			  "VALUES('$id_orden','".date("Y-m-d")."','".date("H:i:s")."','2','2','El cliente y el tecnico son los mismos','$login','1')";
			  mysql_db_query($db,$sql_conf,$link);
			}
			
			//sendMail();
			header("location: lista_reclamos.php?msg=$msg");
			exit;
		}
	}
	else
	{
		if (mysql_db_query($db,$sql3,$link)) 
		{	
			if($conf=="1")
			{
			  $sql_conf="INSERT INTO ".
			  "conformidad (id_orden,fecha_conf,hora_conf,tiemposol_conf,calidaten_conf,obscli_conf,reg_conf, tipo_conf)".
			  "VALUES('$id_orden','".date("Y-m-d")."','".date("H:i:s")."','2','2','El cliente y el tecnico son los mismos','$login','1')";				mysql_db_query($db,$sql_conf,$link);
			}else{
			    //sendMail(); 
			}
			
			//sendMail(); 
			header("location: lista_reclamos.php?msg=$msg&aaaa=asdfg");
			exit;
		}
	}
}
else
{$id_orden=($_GET['id_orden']);}
include("top.php");
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addCompareDates ("DiaD","MesD","AnoD","d1","m1","a1", "Fecha de Ejecucion y Fecha de Registro, $errorMsgJs[compareDates2]");
$valid->addExists( "detalles_sol",  "Detalles de la Solucion, $errorMsgJs[empty]" );
$valid->addLength ( "detalles_sol",  "Detalles de la Solucion, $errorMsgJs[length]" );
$valid->addExists( "medprev_sol",  "Medidas Preventivas Recomendadas, $errorMsgJs[empty]" );
$valid->addLength ( "medprev_sol",  "Medidas Preventivas Recomendadas, $errorMsgJs[length]" );
print $valid->toHtml ();
?> 
<script language="JavaScript">
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}

</script>
<strong><font face="Verdana, Arial, Helvetica, sans-serif" color='#FF0000'><?php //echo $msg;?></font></strong> 
<form name="form2" method="post" enctype="multipart/form-data" onKeyPress="return Form()">
<input name="id_orden" type="hidden" value="<?php echo $id_orden;?>">
<?php $hoy=date("Y-m-d");
$a1=substr($hoy,0,4);
$m1=substr($hoy,5,2);
$d1=substr($hoy,8,2);?>
<input name="a1" type="hidden" value="<?php echo $a1;?>">
<input name="m1" type="hidden" value="<?php echo $m1;?>">
<input name="d1" type="hidden" value="<?php echo $d1;?>">
  
 <table width="600" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" background="images/fondo.jpg">
 <tr><td>
  <table >
    <tr> 
      <td width="100%" colspan="1"><table width="600" border="0" align="center" cellpadding="0" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" bgcolor="#006699"><font color="#FFFFFF">SOLUCION RECLAMO</font></th>
          </tr>
          <tr align="center"> 
            <td colspan="2"><div align="left"><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Reclamo 
                Nro :</font> 
                    <input name="creclamo" type="text" value="<?php echo $id_orden?>" size="4" readonly="">
                </strong></font></div></td>
          </tr>
          <tr> 
            <td colspan="2" align="center"><div align="left"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Descripcion:</font> 
                </b> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <?php $sqlTmp="SELECT * FROM reclamos WHERE CReclamo=$id_orden";
				$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
				print $ordenTmp[TGlosa];
				?>
                </font> </div>            </td>
          </tr>
          <tr>
            <td height="40" colspan="2" align="left"><table width="100%" border="0">
                <tr>
                  <td width="99%" valign="top"><div align="left"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Archivos 
                      Adjuntos: </font></b></div></td>
                  <td width="1%">				</tr>
				<tr>
				 <td>
					<?php
					if($ordenTmp[nomb_archivo])
					{
						echo"
						<table width='100%' border='1' cellpadding='0' cellspacing='0'>
						<tr>
						 <td width='50%' align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>Nombre</b></font></td>
						 <td width='50%' align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>Observaciones</b></font></td>
						</tr>";
						
						$adj=explode("|",$ordenTmp[nomb_archivo]);
						$adj_hash=explode("|",$ordenTmp[hash_archivo]);
						$adj_obs=explode("|",$ordenTmp[observaciones]);
						//echo "<br>archivo : ".$adj[0];
						//echo "<br>hash : ".$adj_hash[0];
						//echo "<br>observa : ".$adj_obs[0];
						$i=0;
						foreach($adj as $valor)
						{
							echo "<tr><td align=\"center\"><a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor</a><br>&nbsp;$adj_hash[$i]</td><td>&nbsp;&nbsp;$adj_obs[$i]</td></tr>";
							$i++;
						}
					}
					else
					{
						echo "
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
						<tr><td align=\"center\" colspan='2'>NINGUNO</td></tr>
						";
					}
					echo "</table>";
					?>                    </td>
                </tr>
              </table>
              <hr></td>
          </tr>
          <?php
		  	$sql = "SELECT * FROM solucion_reclamos WHERE CReclamo='$id_orden'";
			$result=mysql_db_query($db,$sql,$link);
			$row=mysql_fetch_array($result);
		  ?>
          <tr> 
            <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Fecha 
              de registro de solucion:</strong> </font><font size="2"> 
              <?php  if (!$row[CReclamo]) { echo date("d/m/Y");}else{echo $row[TAnioSolucion]."-".$row[TMesSolucion]."-".$row[TDiaSolucion];}?>
              </font></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Detalles 
                de la Solucion</strong></font></div></td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <?php if (!$row[CReclamo]) {?>
                <textarea name="tglosarespuesta" cols="80" rows="4" id="textarea"><?php=$sDetail?></textarea>
                <textarea name="detalles" cols="80" rows="4" id="textarea" style="display:none"><?php=$sDetail?></textarea>
                <?php } else
				{echo $row[TGlosaRespuesta];}
				?>
                </font></div></td>
          </tr>
          <tr> 
            <td height="16" colspan="2"><div align="center"></div>
              <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><br>
                </strong></font></div></td>
          </tr>
          <tr> 
            <td height="16" colspan="2"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Cite de la Respuesta al Reclamante</font></strong> </div></td>
          </tr>
          <tr> 
            <td colspan="2"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <?php if (!$row[CReclamo]) {?>
                <textarea name="tciterespuesta" cols="80" rows="4" id="textarea2"><?php=$sMedidas?></textarea>
                <textarea name="medidas" cols="80" rows="4" id="textarea2" style="display:none"><?php=$sMedidas?></textarea>
                <?php } else
				{echo $row[TCiteRespuesta];}?>
                </font></div></td>
          </tr>
          <tr align="center"> 
            <td height="26" colspan="2" align="center"><strong><font size="2">Codigo de Solucion del Reclamo</font></strong></td>
          </tr>
          <tr align="center">
            <td height="26" colspan="2" align="center"><label>
			<?php if (!$row[CReclamo]) {?>
              <select name="tresultado">
			  <option value="1" <?php if ($lzon==01) echo "selected"; ?>>A Favor del Cliente</option>
			  <option value="2" <?php if ($lzon==01) echo "selected"; ?>>A Favor de la Entidad</option>
              </select>
			<?php } else 
			{switch ($row[TResultado]) {
			case "1":
			echo "A Favor de la Entidad";
			break;
			case "2":
			echo "A Favor de la Entidad";
			break;
			}
			}?>
            </label></td>
          </tr>
          <?php if (!$row[id_orden]) {?>
          <?php 
		 	$sql_a="SELECT asig FROM asignacion WHERE id_orden='$id_orden' ORDER BY id_asig desc";
			$result_a=mysql_db_query($db,$sql_a,$link);
			$row_a=mysql_fetch_array($result_a);
			 if ($row_a[asig]==$ordenTmp[cod_usr]){?>
          <?php }}
		  else
		  {
			echo "<tr>";
		//	echo "<td width=\"5%\"></td>";
			if (!$row[nomb_archivo]){
			echo "<td width=\"5%\"></td>";
			echo "<td width=\"95%\"><div align=\"center\"><font face=\"arial,helvetica\" size=\"2\"><strong>ARCHIVO ADJUNTO : </strong>Ninguno</font></div></td></tr>";}
			else {
				$adjuntos_bo=explode("|",$row[nomb_archivo]);
				$adjuntos_bo_hash=explode("|",$row[hash_archivo]);
				$adjuntos_bo_obs=explode("|",$row[observaciones]);
				echo "<td width=\"95%\"><div align=\"center\"><font face=\"arial,helvetica\" size=\"2\"><strong>Archivos Adjuntos :</strong></font></div></td></tr>";
				$i=0;
				
				echo"
				<tr> 
					<td width='93%' >
						<table width='591' cellpadding='0' cellspacing='0' border='1'>
						<tr>
							<td width='293'><div align='center'><strong><font size='2'>Nombre</font></strong></div></td>
							<td width='292'><div align='center'><strong><font size='2'>Observaciones</font></strong></div></td>
						</tr>
				
				";
				foreach($adjuntos_bo as $valor){
					echo "<tr><td align='center'><a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor</a><br>MD5: $adjuntos_bo_hash[$i]<td>&nbsp;&nbsp;$adjuntos_bo_obs[$i]</td></tr>";
					$i++;
				}
				//echo "<td width=\"95%\"><div align=\"center\"><font face=\"arial,helvetica\" size=\"2\"><strong>Archivo Adjunto : </strong><a href=\"archivos adjuntos/".$row[nomb_archivo]."\" target=\"_blank\">$row[nomb_archivo]</a></font></div></td>";
				}
		    echo "
				</table>
				</td>
			  </tr>
			";
		  }
		  ?>
          <tr align="center"> 
            <td height="30" colspan="2"><br> 
              
              <input name="reg_form" type="submit" id="reg_form" value="GUARDAR" <?php print $valid->onSubmit() ?>> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              
              <input type="submit" name="RETORNAR" value="RETORNAR"></td>
          </tr>
          <tr> 
            <td height="19" colspan="2">&nbsp;</td>
          </tr>
             <!---->
         
          <tr>
           <td>&nbsp;</td>
          </tr>
          
        </table></td>
    </tr>
  </table>
  </td>
 </tr>
</table>
</form>
<script language="JavaScript">
		<!-- 
		
		<?php 		print "function msgFile () {\n
				alert (\"Atencion, solamente puede enviar archivos menor o igual a $row5[tam_archivo] Mb de tamano.\\n \\nMensaje generado por GesTor F1.\");\n
				}\n";
		if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
</script>
<script language="javascript1.2">
function validar()
{
	msg1 = "\nMensaje generado por GesTor F1.";
	sCad = "";
	if(document.form2.archivo.value == ""){sCad = sCad + "Debe adjuntar un archivo\n";}
	if(document.form2.txtObservacion.value == ""){sCad = sCad + "Debe llenar el campo de Observaciones\n";}
	if(sCad == ""){return true;}
	else{
		sCad = sCad + msg1;
		alert(sCad);
		return false;
	}
}
</script>
<?php include("top_.php");?>
