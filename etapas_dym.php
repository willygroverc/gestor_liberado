<?php 
if ($RETORNAR){
	header("location: lista_mantenimiento.php");
}
if ($GENERAR=="ok"){
	include ("conexion.php");
	$sql8="SELECT * FROM users WHERE login_usr='$login'";
	$result8=mysql_db_query($db,$sql8,$link);
	$row8=mysql_fetch_array($result8);
	$nombre="$row8[nom_usr] $row8[apa_usr] $row8[ama_usr]";
			if (!isset($login)) {  header("location: lista.php");}
			$tipo1=$tipo0.$tipo1;
			$descripcion=$estado." ".$obs;
			$sql_pre="UPDATE etapas_dym SET estado='1' WHERE id_etapa=$id_etapa";
			mysql_db_query($db,$sql_pre,$link);
			$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, origen) ".
			"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$descripcion','3')"; 
			mysql_db_query($db,$sql,$link); 
			////////
			$sql_v="SELECT max(id_orden) as maxi FROM ordenes";
			$res=mysql_db_query($db,$sql_v,$link);
			$row_aux=mysql_fetch_array($res);
			$id_orden_aux=$row_aux[maxi];
			$diag_nos="Desarrollar Etapa: $estado, $obs";
			$sql3a="INSERT INTO ".
			"asignacion (nivel_asig,criticidad_asig,prioridad_asig,fecha_asig,hora_asig,asig,escal,area,id_orden,diagnos,date_esc,time_esc,fechaestsol_asig,fechasol_esc) ".
			"VALUES('3','1','1','".date("Y-m-d")."','".date("H:i:s")."','$resp_tit','$resp_tit','Contingencia','$id_orden_aux','$diag_nos','".date("Y-m-d")."','".date("H:i:s")."','".$fecha."','".date("Y-m-d")."')";
			mysql_db_query($db,$sql3a,$link);
			$sql3b="UPDATE procesos SET orden='1' WHERE id_proceso='$id_proceso'";
			mysql_db_query($db,$sql3b,$link);
				/////
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
								{$msg ="Precaucion, no se ha podido enviar la orden por SMS.\\n";}										
					}
					//Enviar mail al administrador de mesa de ayuda
					if($row5["conf_mail"]==1 || $row5["conf_mail"]==3)						
					{	$asunto = "Nro.$row1[id_or]. Nuevo Requerimiento de Trabajo de Mesa de Ayuda";	
						$mail = $systemData[mail];
						$mensaje = "
Nuevo Requerimiento de Mesa de Ayuda: Nro. $row1[id_or]
Cliente/Tecnico: $nombre
Descripcion: $descripcion
Para mayores detalles, consulte el Sistema GesTor F1.\n\n$systemData[nombre]";						
						$tunombre = $row5[nombre];		
						$tuemail = $row5[mail_institucion];						
						$headers  = "From: $tunombre <$tuemail>\n";
						$headers .= "\n";						
						if(!mail($mail,$asunto,$mensaje,$headers)){$msg ="Precaucion, no se ha podido enviar la orden por correo electronico.\\n";}																
					}									
				}
		header("location: lista.php?msg=$msg&vent=1");
}
include("top.php");
if (isset($reg_form))
{
	//////
	$i=$estado_seg;
	$sql_et="SELECT * FROM parametros_dym";
	$res_et=mysql_db_query($db,$sql_et,$link);
	$row_et=mysql_fetch_row($res_et);
	if (strlen($DA) == 1){ $DA = "0".$DA; }
	if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
    $fecha = $AA."-".$MA."-".$DA;   
	/////////
    $sql3="INSERT INTO ".
	"etapas_dym (id_orden,estado_etapa,obs_etapa,fecha_etapa,asig_usr) ".
	"VALUES('$id_orden','$row_et[$i]','$obs_etapa','".$fecha."','$asig_usr')";
	mysql_db_query($db,$sql3,$link);
$lug=$var2;
}
session_start();
$login=$_SESSION["login"];
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
//$valid->addExists ( "estado_seg",  "Estado, $errorMsgJs[empty]" );
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
<script language="JavaScript" src="calendar.js"></script>
<form name="form2" method="post" action="<?php=$PHP_SELF?>" onKeyPress="return Form()">
 <input name="var2" type="hidden" value="<?php echo $lug;?>">
  <input name="op" type="hidden" value="<?php echo $op;?>">
  <table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" background="images/fondo.jpg">
    <tr> 
      <td> 
        <table width="752" border="1" align="center" cellpadding="2" cellspacing="1">
          <tr> 	
            <th colspan="6">ETAPAS</th>
          </tr>
          <tr align="center"> 
            <td colspan="6"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Nro 
              :</strong></font> 
              <input name="id_orden" type="text" value="<?php echo $id_orden;?>" size="3" readonly=""><br>
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Descripcion: 
              </strong>
              <?php $sqlTmp="SELECT desc_inc FROM ordenes WHERE id_orden=$id_orden";
				$ordenTmp=mysql_fetch_array(mysql_db_query($db, $sqlTmp, $link));
				print $ordenTmp[desc_inc];
				$sql_et="SELECT * FROM parametros_dym WHERE id_etapa='1'";
				$res_et=mysql_db_query($db,$sql_et,$link);
				$row_et=mysql_fetch_array($res_et);
				?>
              </font> 
              <hr></td>
          </tr>
          <tr align="center"> 
            <td width="25" class="menu">Nro</td>
            <td width="143" class="menu">ASIGNADO A </td>
            <td width="92" class="menu">ETAPA</td>
            <td width="258" class="menu">OBSERVACIONES</td>
            <td width="72" class="menu">FECHA</td>
			<td width="72" class="menu">ORDEN DE TRABAJO</td>
          </tr>
		<?php  
		$c=1;
		$sql = "SELECT *, DATE_FORMAT(fecha_etapa, '%d/%m/%Y') AS fecha_etapa FROM etapas_dym WHERE id_orden='$id_orden' ORDER BY fecha_etapa ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{?>
          <tr align="center"> 
            <td nowrap>&nbsp;<?php echo $c++;?></td>
            <td nowrap>&nbsp;
			<?php 
			 $sql2="SELECT * FROM users WHERE login_usr='$row[asig_usr]'";
			 $result2=mysql_db_query($db,$sql2,$link);
		  	 $row2=mysql_fetch_array($result2);
			 echo $row2[nom_usr]." ".$row2[apa_usr]." ".$row2[ama_usr];
			?>
			</td>
            <td nowrap>&nbsp; 
              <?php 
				echo $row[estado_etapa];
			?>
            </td>
            <td align="center">&nbsp;<?php echo $row[obs_etapa];?></td>
            <td nowrap><?php echo $row[fecha_etapa];?> </td>
			<?php if($row[estado]=="1"){?>
			<td nowrap>ORDEN GENERADA</td>
			<?php }else{?>
			<td nowrap><div style="cursor:hand" onClick="generar('<?php=$row[estado_etapa]?>','<?php=$row[obs_etapa]?>','<?php=$login?>','<?php=$row[asig_usr]?>','<?php=$row[fecha_etapa]?>','<?php=$row[id_etapa]?>')"><font face="Arial, Helvetica, sans-serif" color="#0000FF"><u>GENERAR</u></fon></div></td>
			<?php }?>
          </tr>
          <?php
		 }

	  	  $sql = "SELECT * FROM solucion WHERE id_orden='$id_orden'";
		  $result=mysql_db_query($db,$sql,$link);
		  if ($row=mysql_fetch_array($result)){
			  echo "<tr align=\"center\"> <td colspan=\"7\"> <input type=\"submit\" name=\"RETORNAR\" value=\"RETORNAR\"> </td></tr>";
		  }
		  else {
		  ?>
          <tr align="center"> 
            <td height="25" colspan="8">&nbsp;</td>
          </tr>
        </table>
        <table width="773" border="1" cellpadding="2" cellspacing="1">
          <tr> 
            <td width="9%" class="menu">Nro.</td>
            <td width="24%" class="menu">ETAPA</td>
			<td width="14%" class="menu">ASIGNACION</td>
            <td width="26%" class="menu">OBSERVACIONES</td>
            <td width="27%" class="menu"><div align="center">FECHA</div></td>
          </tr>
          <tr> 
            <td>Nuevo</td>
            <td><select name="estado_seg" id="estado_seg">
                <option value="1">1 <?php echo $row_et[etapa_1]?></option>
                <option value="2">2 <?php echo $row_et[etapa_2]?></option>
                <option value="3">3 <?php echo $row_et[etapa_3]?></option>
                <option value="4">4 <?php echo $row_et[etapa_4]?></option>
                <option value="5">5 <?php echo $row_et[etapa_5]?></option>
				<option value="6">6 <?php echo $row_et[etapa_6]?></option>
				<option value="7">7 <?php echo $row_et[etapa_7]?></option>
				<option value="8">8 <?php echo $row_et[etapa_8]?></option>
				<option value="9">9 <?php echo $row_et[etapa_9]?></option>
				<option value="10">10 <?php echo $row_et[etapa_10]?></option>
				<option value="11">11 <?php echo $row_et[etapa_11]?></option>
				<option value="12">12 <?php echo $row_et[etapa_12]?></option>
              </select></td>
			  <td><select name="asig_usr" id="asig_usr">
                <option value="0"></option>
                <?php 
			  $sql0 = "SELECT * FROM users WHERE bloquear=0 AND (tipo2_usr='T' OR tipo2_usr='A') ORDER BY apa_usr ASC";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) {
				echo "<option value=\"$row0[login_usr]\">$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
              }
			   ?>
              </select></td>
            <td><textarea name="obs_etapa" cols="23" id="obs_seg2"></textarea></td>
            <td class="menu"><div align="center">
              <select name="DA" id="select">
                <?php		  		
				$fsist=date("Y-m-d");				
  				$ano=substr($fsist,0,4);
				$mes=substr($fsist,5,2);
				$dia=substr($fsist,8,2);
				for($i=1;$i<=31;$i++)
				{	if ( isset ($DA) ){echo "<option value=\"$i\""; if($DA=="$i") echo "selected"; echo">$i</option>";}						
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
              </select>
              <select name="MA" id="select9">
                <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) )  {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else  {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
					}
				}
				?>
              </select>
              <select name="AA" id="select6">
                <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($AA) ) {echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
              </select>
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></div></td>
			  			<script language="JavaScript">
			<!--
			 var form="form2";
			 var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
				cal.year_scroll = true;
				cal.time_comp = false;
			-->
			</script>		
          </tr>
          <tr> 
            <td colspan="5"><div align="center"><br>
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
<?php include("top_.php");?> 
<script language="JavaScript" type="text/JavaScript">
<!--
function generar(estado,obs,login,asig,fecha,id_etapa){
	var dir="etapas_dym.php?GENERAR=ok&login="+login+"&estado="+estado+"&obs="+obs+"&resp_tit="+asig+"&fecha="+fecha+"&id_etapa="+id_etapa
	self.location=dir
}
-->
</script>