<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	validacion de variables para evitar algun ataque 
// Fecha: 		08/NOV/2013
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}	

if (isset($GENERAR) && $GENERAR=="ok"){
	require ("conexion.php");
	$sql8="SELECT * FROM users WHERE login_usr='$login'";
	$result8=mysql_query($sql8);
	$row8=mysql_fetch_array($result8);
	$nombre="$row8[nom_usr] $row8[apa_usr] $row8[ama_usr]";
			if (!isset($login)) {  header("location: lista.php");}
			if (isset($tipo1))
				$tipo1=$tipo0.$tipo1;
			else
				$tipo1='';
			$descripcion=$estado." ".$obs;
			$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc,tipo,nomb_archivo,area,dominio,objetivo,ci_ruc, origen,hash_archivo,observaciones) VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$descripcion','','','0','0','0','','3','','')"; 
			mysql_query($sql); 
			////////
			$sql_v="SELECT max(id_orden) as maxi FROM ordenes";
			$res=mysql_query($sql_v);
			$row_aux=mysql_fetch_array($res);
			$id_orden_aux=$row_aux['maxi'];
			$diag_nos="Desarrollar Etapa: $estado, $obs";
			require_once('funciones.php');
			$resp_tit=SanitizeString($resp_tit);
			$id_orden_aux=SanitizeString($id_orden_aux);
			$diag_nos=SanitizeString($diag_nos);
			$sql3a="INSERT INTO ".
			"asignacion (nivel_asig,criticidad_asig,prioridad_asig,fecha_asig,hora_asig,asig,escal,area,id_orden,diagnos,date_esc,time_esc,fechaestsol_asig,fechasol_esc) ".
			"VALUES('3','1','1','".date("Y-m-d")."','".date("H:i:s")."','$resp_tit','$resp_tit','Contingencia','$id_orden_aux','$diag_nos','".date("Y-m-d")."','".date("H:i:s")."','".$fecha."','".date("Y-m-d")."')";
			mysql_query($sql3a);
			
			$id_orden_aux=SanitizeString($id_orden_aux);
			$sql_pre="UPDATE cronograma SET estado='$id_orden_aux' WHERE OrdAyuda=$IdOrden AND TareCrono='$estado'";
			mysql_query($sql_pre);
			if (isset($id_proceso)){
				$sql3b="UPDATE procesos SET orden='1' WHERE id_proceso='$id_proceso'";
				mysql_query($sql3b);
			}
				/////
				@$systemData=$row5;
				if($systemData["conf_mail"]==1 || $systemData["conf_mail"]==3 || $systemData["conf_sms"]==1 || $systemData["conf_sms"]==3){
					//ENVIAR MSG
					$sql1="SELECT MAX(id_orden) AS id_or FROM ordenes"; 								
					$row1=mysql_fetch_array(mysql_query($sql1));
					if($row5["conf_sms"]==1 || $row5["conf_sms"]==3)
					{
								$sqlMovil="SELECT id_dat_tel_movil, direccion FROM dat_tel_movil";
								$movilRs=mysql_query( $sqlMovil, $link);
								while($tmp=mysql_fetch_array($movilRs)){
										$movilLst[$tmp['id_dat_tel_movil']]=$tmp['direccion'];
								}
								$systemData['movilEmail']="591".$systemData['telefono_movil']."@".$movilLst[$systemData['id_dat_tel_movil']];
								if (!mail($systemData['movilEmail'],$systemData['mail'],"Nro".$row1['id_or']."-Nuevo Requerimiento de Orden de Trabajo. $systemData[nombre]"))
								{$msg ="Precaucion, no se ha podido enviar la orden por SMS.\\n";}										
					}
					//Enviar mail al administrador de mesa de ayuda
					if($row5["conf_mail"]==1 || $row5["conf_mail"]==3)						
					{	$asunto = "Nro.$row1[id_or]. Nuevo Requerimiento de Trabajo de Mesa de Ayuda";	
						$mail = $systemData['mail'];
						$mensaje = "
Nuevo Requerimiento de Mesa de Ayuda: Nro. $row1[id_or]
Cliente/Tecnico: $nombre
Descripcion: $descripcion
Para mayores detalles, consulte el Sistema GesTor F1.\n\n$systemData[nombre]";						
						$tunombre = $row5['nombre'];		
						$tuemail = $row5['mail_institucion'];						
						$headers  = "From: $tunombre <$tuemail>\n";
						$headers .= "\n";						
						if(!mail($mail,$asunto,$mensaje,$headers)){$msg ="Precaucion, no se ha podido enviar la orden por correo electronico.\\n";}																
					}									
				}
//		header("location: lista.php?msg=$msg&vent=1");
}
if (isset($RETORNAR)){header("location: lista_mantenimiento.php");}
if (isset($GUARDAR)){header("location: llenadoUS_1_last.php?var=$var");}
include("top.php");
require_once('funciones.php');
$OrdAyuda=SanitizeString($_GET['IdOrden']);

$sql = "SELECT *, DATE_FORMAT(Fecha, '%d/%m/%Y') AS Fecha FROM solicitud WHERE OrdAyuda='$OrdAyuda'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTime ( "horas", "minutos", "Hora de Recepcion, $errorMsgJs[time]" );
$valid->addIsNotEmpty ( "AsignA",  "Asignado a, $errorMsgJs[empty]" );
$valid->addIsNumber ( "Tiempo",  "Tiempo, $errorMsgJs[number]" );
$valid->addIsNumber ( "Costo10",  "Costo, $errorMsgJs[number]" ); //mantener un control para validar numeros  para validar el campo Otros Costos
$valid->addFunction ( "validateForm1",  "" );
$valid->addIsDate ( "dia2", "mes2", "ano2", "Fecha de Entrega, $errorMsgJs[date]" );
$valid->addIsDate ( "dia3", "mes3", "ano3", "Fecha de Asignacion, $errorMsgJs[date]" );
$valid->addLength ( "OR16",  "Observaciones-Especificaciones, $errorMsgJs[length]" );
$valid->addLength( "OR26",  "Observaciones-Aprobacion Usuario, $errorMsgJs[length]" );
$valid->addLength ( "OR36",  "Observaciones-Analisis, $errorMsgJs[length]" );
$valid->addLength( "OR46",  "Observaciones-Diseno, $errorMsgJs[length]" );
$valid->addLength ( "OR56",  "Observaciones-Programacion, $errorMsgJs[length]" );
$valid->addLength ( "OR66",  "Observaciones-Pruebas, $errorMsgJs[length]" );
$valid->addLength ( "OR76",  "Observaciones-Documentacion, $errorMsgJs[length]" );
$valid->addLength ( "OR86",  "Observaciones-Pase a Produccion, $errorMsgJs[length]" );
$valid->addLength ( "OR96",  "Observaciones-Capacitacion, $errorMsgJs[length]" );
$valid->addLength ( "OR106",  "Observaciones-Implantacion, $errorMsgJs[length]" );
$valid->addLength ( "OR116",  "Observaciones-Explotacion, $errorMsgJs[length]" );
$valid->addLength ( "OR126",  "Observaciones-Satisfaccion Usuaria, $errorMsgJs[length]" );
print $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function validateForm1 () {
	var form=document.form1;
	if (form.Costo20.value.length > 0) {
		if (!isNumber(form.Costo20.value)) {
			alert ("Otros Costos, debe ser un valor numerico.\n \nMensaje generado por GesTor F1.");
			return false;
		}
	else return true;	
	}
	return true;
}
-->
</script>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
</div>
<div align="right"></div>
<form name="form1" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
<input name="var" type="hidden" value="<?php echo $OrdAyuda;?>">  

  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
    <tr> 
      <td background="windowsvista-assets1/main-button-tile.jpg" height="30"><div align="center"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>LLENADO 
          POR SISTEMAS</strong></font></div></td>
    </tr>
  </table>
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
	<tr>
      <td><table width="90%" align="center">
          <tr> 
            <td width="64%" height="32"><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
              y hora de recepcion :</font> <font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['Fecha']?>&nbsp;&nbsp;&nbsp;<?php echo $row['Hora'] ?></font></td>
            <td width="36%"><font size="2" face="Arial, Helvetica, sans-serif">Orden 
              Mesa de Ayuda N&deg; : <?php echo $OrdAyuda?></font></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="64%"><font size="2" face="Arial, Helvetica, sans-serif">Asignado 
              a :</font><strong> 
              <select name="AsignA">
                <option value="0"></option>
              <?php 
			  $sql2 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  $result2 = mysql_query($sql2);
			  while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row['AsignA']==$row2['login_usr'])
							echo "<option value=\"$row2[login_usr]\" selected> $row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
						else
							echo "<option value=\"$row2[login_usr]\"> $row2[apa_usr] $row2[ama_usr] $row2[nom_usr] </option>";
	            }
			   ?>
              </select>
              </strong></td>
            <td width="36%"><font size="2" face="Arial, Helvetica, sans-serif">Viabilidad 
              :</font><strong> <font size="2" face="Arial, Helvetica, sans-serif">SI</font> 
              <input type="radio" name="Viabilidad" value="SI" <?php if ($row['Viabilidad']=="SI") echo "checked";?>>
              &nbsp;<font size="2" face="Arial, Helvetica, sans-serif">NO</font> 
              <input type="radio" name="Viabilidad" value="NO" <?php if ($row['Viabilidad']=="NO") echo "checked";?>>
              </strong></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="35%"><font size="2" face="Arial, Helvetica, sans-serif">Tiempo&nbsp;&nbsp; 
              :</font><strong>&nbsp;&nbsp;&nbsp; 
              <input name="Tiempo" type="text" value="<?php echo $row['Tiempo'];?>" size="4" maxlength="3">
              <select name="Tiempo1">
                  <option value="HORAS" <?php if ($row['Tiempo1']=="HORAS") echo "selected";?>>HORAS</option>
				  <option value="DIAS" <?php if ($row['Tiempo1']=="DIAS") echo "selected";?>>DIAS</option>
        		  <option value="SEMANAS" <?php if ($row['Tiempo']=="SEMANAS") echo "selected";?>>SEMANAS</option>
		      </select>
              </strong></td>
            <td width="29%"><font size="2" face="Arial, Helvetica, sans-serif">Costo :</font> 
              <input name="Costo10" type="text" value="<?php echo $row['CostoI']?>" size="10" maxlength="5"> 
              <select name="Costo11">
			  	<option value="Bs" <?php if ($row['MonedaI']=="Bs") echo "selected";?>>Bs</option>
				<option value="Sus" <?php if ($row['MonedaI']=="Sus") echo "selected";?>>$us</option>
              </select> </td>
            <td width="36%"><font size="2" face="Arial, Helvetica, sans-serif">Otros 
              Costos:</font> 
              <input name="Costo20" type="text" value="<?php echo $row['CostoII'];?>" size="10" maxlength="5"> 
              <select name="Costo21">
				<option value="Bs" <?php if ($row['MonedaII']=="Bs") echo "selected";?>>Bs</option>
				<option value="Sus" <?php if ($row['MonedaII']=="Sus") echo "selected";?>>$us</option>              
			 </select></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="51%"><font size="2" face="Arial, Helvetica, sans-serif">Prioridad 
              :</font> <strong><font size="2" face="Arial, Helvetica, sans-serif">Alta</font></strong> 
              <input type="radio" name="Prioridad" value="1" <?php if ($row['Prioridad']=="1") echo "checked";?>> 
              &nbsp;&nbsp;&nbsp;&nbsp; <font size="2" face="Arial, Helvetica, sans-serif"><strong>Media</strong></font> 
              <input type="radio" name="Prioridad" value="2" <?php if ($row['Prioridad']=="2") echo "checked";?>>
              <strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;Baja</font></strong> 
              <input type="radio" name="Prioridad" value="3" <?php if ($row['Prioridad']=="3") echo "checked";?>></td>
            <td width="49%"><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
              Estimada de Entrega :</font><strong> 
              <select name="dia2" >
                <?php
  				$a2=substr($row['FechEstEnt'],0,4);
				$m2=substr($row['FechEstEnt'],5,2);
				$d2=substr($row['FechEstEnt'],8,2);
				for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d2=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select>
              <select name="mes2">
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m2=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="ano2">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a2=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal2.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
              </strong></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="56%"><font size="2" face="Arial, Helvetica, sans-serif">Aceptacion 
              del usuario responsable :</font><strong> </strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>SI</strong> 
              </font> 
              <input type="radio" name="Aceptac" value="SI" <?php if ($row['Aceptac']=="SI") echo "checked";?>>
              <font size="2" face="Arial, Helvetica, sans-serif"><strong>NO</strong></font> 
              <input type="radio" name="Aceptac" value="NO" <?php if ($row['Aceptac']=="NO") echo "checked";?>> 
            </td>
            <td width="44%"><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
              de Asignacion:</font><strong> </strong> 
              <select name="dia3" >
                <?php
  				$a3=substr($row['FechAcep'],0,4);
				$m3=substr($row['FechAcep'],5,2);
				$d3=substr($row['FechAcep'],8,2);
				for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d3=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select> <select name="mes3">
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m3=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select> <select name="ano3">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a3=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal3.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong> 
            </td>
          </tr>
        </table>
        
      </td>
    </tr>
  </table>
  <p></p>
  <table width="85%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <td colspan="9" bgcolor="#006699" background="windowsvista-assets1/main-button-tile.jpg" height="30"> <div align="center"><font color="#FFFFFF" size="3"><strong>CRONOGRAMA</strong></font></div></td>
    </tr>
    <tr> 
      <td width="3%" rowspan="2" bgcolor="#006699">&nbsp;</td>
      <td width="18%" rowspan="2" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tarea 
          / Fase</font></strong></div></td>
      <td height="23" colspan="2" bgcolor="#006699"> <div align="center"> 
          <p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Fechas 
            Program.</strong></font></p>
        </div></td>
      <td colspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Fechas 
          Reales</strong></font></div></td>
      <td width="15%" rowspan="2" bgcolor="#006699"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">Nombre</font></strong></font></div>
        <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Responsable</strong></font></div></td>
      <td width="29%" rowspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Observaciones</strong></font></div></td>
      <td width="29%" rowspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Orden 
          de Trabajo</strong></font></div></td>
    </tr>
    <tr> 
      <td width="8%" height="25" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Inicio</strong></font></div></td>
      <td width="10%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Termino 
          </strong></font></div></td>
      <td width="7%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Inicio</strong></font></div></td>
      <td width="10%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Termino</strong></font></div></td>
    </tr>
    <?php  
//modificado desde aqui------------>
		$c=1;
		$IdOrden=SanitizeString($IdOrden);
		$sql = "SELECT * FROM cronograma WHERE OrdAyuda='$IdOrden'";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{?>
    <tr align="center"> 
      <td nowrap>&nbsp;<?php echo $c++;?></td>
      <td nowrap>&nbsp; 
        <?phpecho $row['TareCrono'];?>
      </td>
      <td nowrap>&nbsp; 
        <?phpecho $row['FeProIni'];?>
      </td>
      <td align="center">&nbsp; 
        <?phpecho $row['FeProTer'];?>
      </td>
      <td nowrap> 
        <?phpecho $row['FeRealIni'];?>
      </td>
      <td nowrap> 
        <?phpecho $row['FeRealTer'];?>
      </td>
      <td nowrap> 
        <?php
			 $sql2="SELECT * FROM users WHERE login_usr='$row[RubricaR]'";
			 $result2=mysql_query($sql2);
		  	 $row2=mysql_fetch_array($result2);
			 echo $row2['nom_usr']." ".$row2['apa_usr']." ".$row2['ama_usr'];
			?>
        &nbsp; </td>
      <td nowrap> 
        <?phpecho $row['Observ'];?>
        &nbsp; </td>
      <?php 
	  if($row['estado']!="0"){?>
      <td nowrap><a href="ver_orden.php?id_orden=<?php=$row['estado'];?>" target=\"_blank\"><?php echo "Orden Nro.$row[estado]"?></a></td>
      <?php }else{?>
      <td nowrap><div style="cursor:hand" onClick="generar('<?php=$row[TareCrono]?>','<?php=$row[Observ]?>','<?php=$login?>','<?php=$row[RubricaR]?>','<?php=$row[FeProIni]?>','<?php=$OrdAyuda?>')"><font face="Arial, Helvetica, sans-serif" color="#0000FF"><u>CREAR 
          ORDEN</u></font></div></td>
      <?php }?>
    </tr>
    <?php
		 }
		  ?>
  </table>
  <div align="center"><br>
    <input name="GUARDAR" type="submit" id="GUARDAR" value="   MODIFICAR   ">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input name="RETORNAR" type="submit" id="RETORNAR" value="   RETORNAR   ">
  </div>
</form>
<script language="JavaScript">
<!-- 
		var form = "form1";
		var cal2 = new calendar1(document.forms[form].elements['dia2'], document.forms[form].elements['mes2'], document.forms[form].elements['ano2']);
		 	cal2.year_scroll = true;
			cal2.time_comp = false;
		var cal3 = new calendar1(document.forms[form].elements['dia3'], document.forms[form].elements['mes3'], document.forms[form].elements['ano3']);
		 	cal3.year_scroll = true;
			cal3.time_comp = false;
		function generar(estado,obs,login,asig,fecha,id_etapa){
			var dir="llenadoUS_last.php?GENERAR=ok&login="+login+"&estado="+estado+"&obs="+obs+"&resp_tit="+asig+"&fecha="+fecha+"&IdOrden="+id_etapa
			self.location=dir
		}
-->
</script>