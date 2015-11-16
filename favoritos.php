<?php
  session_start();
	echo $login=$_SESSION["login"];
	echo $tipo=$_SESSION["tipo"];
if (isset($_REQUEST['RETORNAR'])){header("location: pagina_inicio.php?Naveg=Inicio");}
if (isset($_REQUEST['GUARDAR'])) {
   session_start();
	echo $login=$_SESSION["login"];
	echo $tipo=$_SESSION["tipo"];

	if (!isset($login)) {header("location: index.php");}
	include ("conexion.php");
	$cont_num=0;
	if (!isset($_REQUEST['Contratos'])) $_REQUEST['Contratos']="_"; else $cont_num=$cont_num+1;
 	if (!isset($_REQUEST['Proyectos'])) $_REQUEST['Proyectos']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Proveedores'])) $_REQUEST['Proveedores']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['PlanifEstrat'])) $_REQUEST['PlanifEstrat']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Ans'])) $_REQUEST['Ans']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Clasificacion'])) $_REQUEST['Clasificacion']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Actas'])) $_REQUEST['Actas']="_"; else $cont_num=$cont_num+1;	
	if (!isset($_REQUEST['Vacaciones'])) $_REQUEST['Vacaciones']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['FichasTecnicas'])) $_REQUEST['FichasTecnicas']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['MantFuera'])) $_REQUEST['MantFuera']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Cronograma'])) $_REQUEST['Cronograma']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['DyM'])) $_REQUEST['DyM']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['PropyResp'])) $_REQUEST['PropyResp']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['ControlTyH'])) $_REQUEST['ControlTyH']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['ControlInvent'])) $_REQUEST['ControlInvent']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['UbicacRespal'])) $_REQUEST['UbicacRespal']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Calendariza'])) $_REQUEST['Calendariza']="_"; else $cont_num=$cont_num+1;	
	if (!isset($_REQUEST['Produccion'])) $_REQUEST['Produccion']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['DesaMante'])) $_REQUEST['DesaMante']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Planificacion'])) $_REQUEST['Planificacion']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Ejecucion'])) $_REQUEST['Ejecucion']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Evaluacion'])) $_REQUEST['Evaluacion']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Calen_cont'])) $_REQUEST['Calen_cont']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Usuarios'])) $_REQUEST['Usuarios']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Backup_bd'])) $_REQUEST['Backup_bd']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Hash'])) $_REQUEST['Hash']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Riesgo'])) $_REQUEST['Riesgo']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Repositorio'])) $_REQUEST['Repositorio']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['CopiaTrabajo'])) $_REQUEST['CopiaTrabajo']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Replica'])) $_REQUEST['Replica']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Revision'])) $_REQUEST['Revision']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Modulos'])) $_REQUEST['Modulos']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Archivos'])) $_REQUEST['Archivos']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Backups_Fuentes'])) $_REQUEST['Backups_Fuentes']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Pistas_Auditoria_Fuentes'])) $_REQUEST['Pistas_Auditoria_Fuentes']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Pruebas'])) $_REQUEST['Pruebas']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Maestro'])) $_REQUEST['Maestro']="_"; else $cont_num=$cont_num+1;
	if (!isset($_REQUEST['Parametros'])) $_REQUEST['Parametros']="_"; else {if ($tipo=="A") {$cont_num=$cont_num+1;}}
		
if ($cont_num>"6")
{ $msg="USTED SOLO PUEDE ELEGIR 6 SITIOS FAVORITOS";}
else
{	$sql = "SELECT * FROM favoritos WHERE login_usr='$login'";
	$result=mysql_db_query($db,$sql,$link);
	$row=mysql_fetch_array($result);
	if(mysql_num_rows($result)>0){
		$sql="UPDATE favoritos SET Contratos='".$_REQUEST['Contratos']."',Proyectos='".$_REQUEST['Proyectos']."',Proveedores='".$_REQUEST['Proveedores']."',".
		"Planificacion_Estrategica='".$_REQUEST['PlanifEstrat']."',ANS='".$_REQUEST['Ans']."',Clasificacion_Informacion='".$_REQUEST['Clasificacion']."',Actas_Minutas='".$_REQUEST['Actas']."',".
		"Vacaciones='".$_REQUEST['Vacaciones']."',Riesgos='".$_REQUEST['Riesgo']."',Fichas_Tecnicas='".$_REQUEST['FichasTecnicas']."',Mantenimiento_Fuera='".$_REQUEST['MantFuera']."',Cronograma_PROAST='".$_REQUEST['Cronograma']."',".
		"DyM='".$_REQUEST['DyM']."',Propietarios_Responsables='".$_REQUEST['PropyResp']."',Control_TyH='".$_REQUEST['ControlTyH']."',Inventario_Medios='".$_REQUEST['ControlInvent']."',Ubicacion_Respaldos='".$_REQUEST['UbicacRespal']."',Calendarizacion_PROAPD='".$_REQUEST['Calendariza']."',Produccion_PROAPI='".$_REQUEST['Produccion']."',".
		"DyM_PROAPI='".$_REQUEST['DesaMante']."',Planificacion='".$_REQUEST['Planificacion']."',Ejecucion='".$_REQUEST['Ejecucion']."',Evaluacion='".$_REQUEST['Evaluacion']."',Calendarizacion_PROAPC='".$_REQUEST['Calen_cont']."',Usuarios='".$_REQUEST['Usuarios']."',".
		"Backup_BD='".$_REQUEST['Backup_bd']."',Calculadora_Hash='".$_REQUEST['Hash']."',Menu_de_Parametros='".$_REQUEST['Parametros']."',".
		"Repositorio='".$_REQUEST['Repositorio']."',Copia_de_Trabajo='".$_REQUEST['CopiaTrabajo']."',Replica='".$_REQUEST['Replica']."',Revision='".$_REQUEST['Revision']."',Modulos='".$_REQUEST['Modulos']."',".
		"Archivos='".$_REQUEST['Archivos']."',Backups_Fuentes='".$_REQUEST['Backups_Fuentes']."',Pistas_Auditoria_Fuentes='".$_REQUEST['Pistas_Auditoria_Fuentes']."',Prueba_de_Cambios='".$_REQUEST['Pruebas']."',Maestro_de_Cambios='".$_REQUEST['Maestro']."'".
		" WHERE login_usr='$login'";
		if (mysql_db_query($db,$sql,$link) ){
			header("location: pagina_inicio.php?Naveg=Inicio");
                  
                        $msg='Actualizado correctamente';
		}
		else {
			$msg="OCURRIO UN ERROR EN LA MIENTRAS CONECTABA".mysql_errno().": ".mysql_error();
		}
	}
	else {
		$sql="INSERT INTO favoritos (login_usr,Contratos,".
		"Proyectos,Proveedores,Planificacion_Estrategica,ANS,Clasificacion_Informacion,Actas_Minutas,Vacaciones,Riesgos,Fichas_Tecnicas,".	
		"Mantenimiento_Fuera,Cronograma_PROAST,DyM,Propietarios_Responsables,Control_TyH,Inventario_Medios,Ubicacion_Respaldos,Calendarizacion_PROAPD,Produccion_PROAPI,".
		"DyM_PROAPI,Planificacion,Ejecucion,Evaluacion,Calendarizacion_PROAPC,Usuarios,Backup_BD,Calculadora_Hash,Menu_de_Parametros,".
		"Repositorio,Copia_de_Trabajo,".
		"Replica,Revision,Modulos,Archivos,Backups_Fuentes,Pistas_Auditoria_Fuentes,Prueba_de_Cambios,Maestro_de_Cambios) VALUES(".
		"'$login','".$_REQUEST['Contratos']."','".$_REQUEST['Proyectos']."','".$_REQUEST['Proveedores']."','".$_REQUEST['PlanifEstrat']."','".$_REQUEST['Ans']."',".
		"'".$_REQUEST['Clasificacion']."','".$_REQUEST['Actas']."','".$_REQUEST['Vacaciones']."','".$_REQUEST['Riesgo']."','".$_REQUEST['FichasTecnicas']."',".
		"'".$_REQUEST['MantFuera']."','".$_REQUEST['Cronograma']."','".$_REQUEST['DyM']."','".$_REQUEST['PropyResp']."','".$_REQUEST['ControlTyH']."','".$_REQUEST['ControlInvent']."','".$_REQUEST['UbicacRespal']."','".$_REQUEST['Calendariza']."','".$_REQUEST['Produccion']."',".
		"'".$_REQUEST['DesaMante']."','".$_REQUEST['Planificacion']."','".$_REQUEST['Ejecucion']."','".$_REQUEST['Evaluacion']."','".$_REQUEST['Calen_cont']."','".$_REQUEST['Usuarios']."','".$_REQUEST['Backup_bd']."','".$_REQUEST['Hash']."','".$_REQUEST['Parametros']."',".
		"'".$_REQUEST['Repositorio']."','".$_REQUEST['CopiaTrabajo']."','".$_REQUEST['Replica']."','".$_REQUEST['Revision']."','".$_REQUEST['Modulos']."','".$_REQUEST['Archivos']."','".$_REQUEST['Backups_Fuentes']."','".$_REQUEST['Pistas_Auditoria_Fuentes']."','".$_REQUEST['Pruebas']."','".$_REQUEST['Maestro']."')";
	
		if(mysql_db_query($db,$sql,$link)){
			header("location: pagina_inicio.php?Naveg=Inicio");
                        $msg='Insertado correctamente';
		}
		else {
			$msg="OCURRIO UN ERROR EN LA MIENTRAS CONECTABA ".mysql_errno().": ".mysql_error();
		}
	}
  } 
}
include ("top.php");
//include ("conexion.php");
$sql = "SELECT * FROM roles WHERE login_usr='$login'";

$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);

$sql1 = "SELECT * FROM favoritos WHERE login_usr='$login'";
$result1=mysql_db_query($db,$sql1,$link);
$row1=mysql_fetch_array($result1);
?>
 <script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
//-->
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

<p>
<font color="#FF0000" face="Arial, Helvetica, sans-serif"><strong><?php //echo $msg;?></strong></font>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
  <table width="95%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#F4F2EA" >
    <tr> 
    <td>
	   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
        <tr> 
            <th colspan="9">MIS FAVORITOS</th>
        </tr>

        <tr align="center"> 
            <th width="10%" class="menu">GESTION- PRODAT</th>
            <th width="10%" class="menu">SOPORTE TECNICO - PROAST</th>
            <th width="10%" class="menu">D & M-PROADM </th>
            <th width="10%" class="menu">PRODUCCION -PROAPD</th>
            <th width="10%" class="menu">PROBLEMAS-PROAPI </th>
            <th width="10%" class="menu">CONTINGENCIA-PROAPC </th>
            <th width="10%" class="menu">SEGURIDAD-PROASI</th>
			<th width="10%" class="menu">CAMBIOS-PROACP</th>
        </tr>
		
        <tr align="center"> 
         <td width="12%" valign="top"> 
        <?php  
		  print "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">";
		  if ($row['Contratos']=="r")
		    { print "<tr>";
			  print "<td align=\"center\">";?>
              CONTRATOS-PROACT<br>
              <input name="Contratos" type="checkbox" value="lista_contratos.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Contratos']<>"_") echo "checked";}?>>
		 <?php    print "</td>";
		      print "</tr>";
		    }?>
	      <?php  if ($row['Proyectos']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>PROYECTOS<br>
		      <input name="Proyectos" type="checkbox" value="lista_proyectos.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Proyectos']<>"_") echo "checked";}?> >
		 <?php   print "</td>";
		     print "</tr>";}
		  if ($row['Proveedores']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>PROVEEDORES<br>
              <input name="Proveedores" type="checkbox" value="lista_proveed.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Proveedores']<>"_") echo "checked";}?>>
	     <?php   print "</td>";
		     print "</tr>";}
		  if ($row['PlanifEstrat']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>PLANIFICACION ESTRATEGICA<br> 
		  <input name="PlanifEstrat" type="checkbox" value="lista_planifes.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Planificacion_Estrategica']<>"_") echo "checked";}?>> 
		 <?php   print "</td>";
		     print "</tr>";}
		  if ($row['Ans']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>ANS<br> 
		  <input name="Ans" type="checkbox" value="nservicio.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['ANS']<>"_") echo "checked";}?>> 
		 <?php   print "</td>";
		     print "</tr>";}
		  if ($row['Clasificacion']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>CLASIFICACION DE LA INFORMACION<br> 
		  <input name="Clasificacion" type="checkbox" value="ast11.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Clasificacion_Informacion']<>"_") echo "checked";}?>> 
		 <?php   print "</td>";
		     print "</tr>";}
		  if ($row['Actas']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>ACTAS Y MINUTAS<br> 
		  <input name="Actas" type="checkbox" value="lista_agenda.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Actas_Minutas']<>"_") echo "checked";}?>> 
		 <?php   print "</td>";
		     print "</tr>";}
		  if ($row['Vacaciones']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>AUSENCIA PROGRAMADA<br>
		  <input name="Vacaciones" type="checkbox" value="lista_vacaciones.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Vacaciones']<>"_") echo "checked";}?>> 
		 <?php   print "</td>";
		     print "</tr>";}
		  if ($row['Riesgo']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>RIESGOS<br>
		  <input name="Riesgo" type="checkbox" value="riesgo-opciones.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Riesgos']<>"_") echo "checked";}?>> 
		 <?php   print "</td>";
		     print "</tr>";}
		  print "</table>";
		  ?>
		  </td>
		  
          <td width="12%" valign="top"> 
              <?php  
		  print "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">";
		  if ($row['FichasTecnicas']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>FICHAS TECNICAS<br>
		  <input name="FichasTecnicas" type="checkbox" value="lista_ficha.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Fichas_Tecnicas']<>"_") {echo "checked";}}?>> 
		 <?php   print "</td>";
		     print "</tr>"; }
		  if ($row['MantFuera']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>MANTENIMIENTO FUERA<br>
		  <input name="MantFuera" type="checkbox" value="controlmantenprincipal.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Mantenimiento_Fuera']<>"_") echo "checked";}?> >
              <?php   print "</td>";
		     print "</tr>"; }
		  if ($row['Cronograma']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>
              CRONOGRAMA<br>
			 <input name="Cronograma" type="checkbox" value="lista_calen.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Cronograma_PROAST']<>"_") echo "checked";}?>>
		 <?php   print "</td>";
		     print "</tr>"; }
		     print "</table>";?>
		 </td>
         
		 <td width="12%" valign="top">
		  <?php  
		  print "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">";
		  if ($row['DyM']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>D &amp; M<br>
			 <input name="DyM" type="checkbox" value="lista_mantenimiento.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['DyM']<>"_") {echo "checked";}}?>>
	     <?php   print "</td>";
		     print "</tr>"; }
		     print "</table>";?> 
		 </td>
		 
         <td width="12%" valign="top">
		 <?php  
		  print "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">";
		  if ($row['PropyResp']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>PROPIETARIOS Y RESPONSABLES<br>
             <input name="PropyResp" type="checkbox" value="lista_sistemas.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Propietarios_Responsables']<>"_") echo "checked";}?>>
		 <?php   print "</td>";
		     print "</tr>"; }
		  if ($row['ControlTyH']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>CONTROL DE TEMP &amp; HUMEDAD<br>
			 <input name="ControlTyH" type="checkbox" value="lista_controltemp.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Control_TyH']<>"_") echo "checked";}?> >
		 <?php   print "</td>";
		     print "</tr>"; }
		  if ($row['ControlInvent']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>INVENTARIOS DE MEDIOS<br>
             <input name="ControlInvent" type="checkbox" value="lista_controlinvent.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Inventario_Medios']<>"_") echo "checked";}?>>
		 <?php   print "</td>";
		     print "</tr>"; }
		  if ($row['UbicacRespal']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>UBICACION DE RESPALDOS<br>
			 <input name="UbicacRespal" type="checkbox" value="lista_ubicacionr.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Ubicacion_Respaldos']<>"_") echo "checked";}?>>
		 <?php   print "</td>";
		     print "</tr>"; }
		  if ($row['Calendariza']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>CALENDARIZACION<br>
             <input type="checkbox" name="Calendariza" value="lista_progtareas.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Calendarizacion_PROAPD']<>"_") echo "checked";}?>>
		 <?php   print "</td>";
		     print "</tr>"; }
		     print "</table>";?>
		 </td>
        
		<td width="12%" valign="top">
		<?php  
		  print "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">";
		  if ($row['Produccion']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>PRODUCCION<br>
			 <input name="Produccion" type="checkbox" value="lista_ordenrev1.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Produccion_PROAPI']<>"_") {echo "checked";}}?>> 
		 <?php   print "</td>";
		     print "</tr>"; }
		  if ($row['DesaMante']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>D &amp; M<br>
			 <input name="DesaMante" type="checkbox" value="lista_ordenrev1_1.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['DyM_PROAPI']<>"_") echo "checked";}?> >
		 <?php   print "</td>";
		     print "</tr>"; }
		     print "</table>";?>
		</td>
          <td width="12%" valign="top">
		  <?php  
		  print "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">";
		  if ($row['Planificacion']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>PLANIFICACION<br>
			 <input name="Planificacion" type="checkbox" value="lista_planifpru1.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Planificacion']<>"_") {echo "checked";}}?>>
		 <?php   print "</td>";
		     print "</tr>"; }
		  if ($row['Ejecucion']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>EJECUCION<br>
			 <input name="Ejecucion" type="checkbox" value="lista_pruebrecup.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Ejecucion']<>"_") echo "checked";}?>>
		 <?php   print "</td>";
		     print "</tr>"; }
		  if ($row['Evaluacion']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>EVALUACION<br>
			 <input name="Evaluacion" type="checkbox"  value="lista_planifpru2.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Evaluacion']<>"_") echo "checked";}?>>
		 <?php   print "</td>";
		     print "</tr>"; }
		  if ($row['Calen_cont']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>CALENDARIZACION<br>
             <input name="Calen_cont" type="checkbox"  value="lista_calen_cont.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Calendarizacion_PROAPC']<>"_") echo "checked";}?>>
		 <?php   print "</td>";
		     print "</tr>"; }
		     print "</table>";?>
		  </td>
		  
          <td width="12%" valign="top">
		  <?php  
		  print "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">";
		  if ($row['Usuarios']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>USUARIOS<br>
			 <input name="Usuarios" type="checkbox" value="lista_control_usr.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Usuarios']<>"_") {echo "checked";}}?>>
         <?php   print "</td>";
		     print "</tr>"; }
		  if ($row['PistasAudi']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>BACKUP BD<br>
			 <input name="Backup_bd" type="checkbox" value="auditoria.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Backup_BD']<>"_") echo "checked";}?>>
	     <?php   print "</td>";
		     print "</tr>"; }
		  if ($row['Hash']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>CALCULADORA HASH <br>
			 <input name="Hash" type="checkbox" value="calcula_hash.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Calculadora_Hash']<>"_") echo "checked";}?>>
              <?php   print "</td>";
		     print "</tr>"; }
			 if ($tipo=="A" OR $tipo=="B")
		   { 
		   	 print "<tr>";
		     print "<td align=\"center\">";?>
              MENU DE PARAMETROS<br>
			 <input name="Parametros" type="checkbox" value="menu_parametros.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Menu_de_Parametros']<>"_") {echo "checked";}}?>>
         <?php   print "</td>";
		     print "</tr>";
			 }
		     print "</table>";?>
		  </td>
            <td width="12%" align="left" valign="top"> 
              <?php  
		  print "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">";
		  if ($row['Modulos']=="r" OR $row['Archivos']=="r" OR $row['Repositorio']=="r" OR $row['Copia_trabajo']=="r" OR $row['Replica']=="r" OR $row['Revision']=="r" OR $row['Backups']=="r" OR $row['Pistas_fuentes']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";
			 print "ADMINISTRACI�N DE FUENTES<br><br>";
			if ($row['Repositorio']=="r"){?>
              <div align="center">
                REPOSITORIO<BR><input name="Repositorio" type="checkbox" value="lista_carpetas.php?id=repositorio" <?php  if(!empty($row1['login_usr'])) {if ($row1['Repositorio']<>"_") {echo "checked";}}?>>
                
                <?php  }
		    if ($row['Copia_trabajo']=="r"){?>
			<div align="center">
               COPIA DE TRABAJO<br> <input name="CopiaTrabajo" type="checkbox" value="lista_carpetas.php?id=ctrabajo" <?php  if(!empty($row1['login_usr'])) {if ($row1['Copia_de_Trabajo']<>"_") echo "checked";}?>>
                
                <?php  }
	        if ($row['Replica']=="r"){?>
			<div align="center">
            REPLICA<br>  <input name="Replica" type="checkbox" value="lista_carpetas.php?id=replica" <?php  if(!empty($row1['login_usr'])) {if ($row1['Replica']<>"_") echo "checked";}?>>
                
                <?php  }
  		    if ($row['Revision']=="r"){?>
			<div align="center">
             REVISION<br> <input name="Revision" type="checkbox" value="lista_carpetas.php?id=revision" <?php  if(!empty($row1['login_usr'])) {if ($row1['Revision']<>"_") echo "checked";}?>>
                
                <?php  }
	 	    if ($row['Modulos']=="r"){?>
			<div align="center">
               MODULOS<br>  <input name="Modulos" type="checkbox" value="modulos.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Modulos']<>"_") echo "checked";}?>>
               
                <?php  }
 		    if ($row['Archivos']=="r"){?>
			<div align="center">
               ARCHIVOS<br> <input name="Archivos" type="checkbox" value="lista_archivos.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Archivos']<>"_") echo "checked";}?>>
                
                <?php  }
			if ($row['Backups']=="r"){?>
			<div align="center">
               BACKUPS<br> <input name="Backups_Fuentes" type="checkbox" value="lista_backups.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Backups_Fuentes']<>"_") echo "checked";}?>>
                
                <?php  }
			if ($row['Pistas_fuentes']=="r"){?>
			<div align="CENTER">
             PISTAS DE AUDITORIA<br><input name="Pistas_Auditoria_Fuentes" type="checkbox" value="pistas_auditoria.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Pistas_Auditoria_Fuentes']<>"_") echo "checked";}?>>
                <?php  }	
		     print "</td>";
		     print "</tr>"; }
			 if ($row['Pruebas']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>PRUEBAS<br>
			 <input name="Pruebas" type="checkbox" value="lista_prueba_tipo.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Prueba_de_Cambios']<>"_") echo "checked";}?>>
		 <?php   print "</td>";
		     print "</tr>"; }
			 if ($row['Maestro']=="r")
		   { print "<tr>";
		     print "<td align=\"center\">";?>MAESTRO<br>
			 <input name="Maestro" type="checkbox" value="lista_maestro.php" <?php  if(!empty($row1['login_usr'])) {if ($row1['Maestro_de_Cambios']<>"_") echo "checked";}?>>
		 <?php   print "</td>";
		     print "</tr>"; }
		     print "</table>";?>
              </div></td>		
      </table></td>
  </tr>
</table>
  <div align="center"><BR>
    <input name="login" type="hidden" value="<?php echo $login; ?>">
    <input name="GUARDAR" type="submit" value="GUARDAR">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input name="RETORNAR" type="submit" value="RETORNAR">
  </div>
</form>
<?php 
include("top_.php");
?> 
