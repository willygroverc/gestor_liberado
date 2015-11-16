<?php
//Descripcion:		Archivo modificado para el acceso a los usuarios mediante roles para las opciones: Menu de 
//					parametros y Telkeys
//Autor: 			Alvaro Rodriuguez
//Fecha: 			30/08/2012
//________________________________________________________

// Version:		1.0
// Tipo:		Perfectivo, Correctivo;
// Objetivo:	Control acceso directo No autorizado.
//				Modificacion funciones php obsoletas para version 5.3
// Fecha:		27/DIC/2012 
// Autor:		Cesar Cuenca
//______________________________________________________________________
session_start();
$login_usr=$_REQUEST['login_usr'];

if (isset($_REQUEST['RETORNAR'])){header("location: usuarios_lista.php");}
if (isset($_POST['GUARDAR'])) {
	require ("conexion.php");
	if (!isset($_REQUEST['Contratos'])) $_REQUEST['Contratos']="_";
	if (!isset($_REQUEST['Proyectos'])) $_REQUEST['Proyectos']="_";
	if (!isset($_REQUEST['Proveedores'])) $_REQUEST['Proveedores']="_";
	if (!isset($_REQUEST['PlanifEstrat'])) $_REQUEST['PlanifEstrat']="_";
	if (!isset($_REQUEST['Ans'])) $_REQUEST['Ans']="_";
	if (!isset($_REQUEST['Clasificacion'])) $_REQUEST['Clasificacion']="_";
	if (!isset($_REQUEST['Actas'])) $_REQUEST['Actas']="_";
	if (!isset($_REQUEST['Vacaciones'])) $_REQUEST['Vacaciones']="_";
	if (!isset($_REQUEST['FichasTecnicas'])) $_REQUEST['FichasTecnicas']="_";
	if (!isset($_REQUEST['MantFuera'])) $_REQUEST['MantFuera']="_";
	if (!isset($_REQUEST['Cronograma'])) $_REQUEST['Cronograma']="_";
	if (!isset($_REQUEST['DyM'])) $_REQUEST['DyM']="_";
	if (!isset($_REQUEST['PropyResp'])) $_REQUEST['PropyResp']="_";
	if (!isset($_REQUEST['ControlTyH'])) $_REQUEST['ControlTyH']="_";
	if (!isset($_REQUEST['ControlInvent'])) $_REQUEST['ControlInvent']="_";
	if (!isset($_REQUEST['UbicacRespal'])) $_REQUEST['UbicacRespal']="_";
	if (!isset($_REQUEST['Calendariza'])) $_REQUEST['Calendariza']="_";	
	if (!isset($_REQUEST['Produccion'])) $_REQUEST['Produccion']="_";
	if (!isset($_REQUEST['DesaMante'])) $_REQUEST['DesaMante']="_";
	if (!isset($_REQUEST['Planificacion'])) $_REQUEST['Planificacion']="_";
	if (!isset($_REQUEST['Ejecucion'])) $_REQUEST['Ejecucion']="_";
	if (!isset($_REQUEST['Evaluacion'])) $_REQUEST['Evaluacion']="_";
	if (!isset($_REQUEST['Calen_cont'])) $_REQUEST['Calen_cont']="_";
	if (!isset($_REQUEST['Usuarios'])) $_REQUEST['Usuarios']="_";
	if (!isset($_REQUEST['PistasAudi'])) $_REQUEST['PistasAudi']="_";
	if (!isset($_REQUEST['Hash'])) $_REQUEST['Hash']="_";
	if (!isset($_REQUEST['Riesgo'])) $_REQUEST['Riesgo']="_";
	if (!isset($_REQUEST['Modulos'])) $_REQUEST['Modulos']="_";
	if (!isset($_REQUEST['Archivos'])) $_REQUEST['Archivos']="_";
	if (!isset($_REQUEST['Repositorio'])) $_REQUEST['Repositorio']="_";
	if (!isset($_REQUEST['Copia_trabajo'])) $_REQUEST['Copia_trabajo']="_";
	if (!isset($_REQUEST['Replica'])) $_REQUEST['Replica']="_";
	if (!isset($_REQUEST['Revision'])) $_REQUEST['Revision']="_";
	if (!isset($_REQUEST['Backups'])) $_REQUEST['Backups']="_";
	if (!isset($_REQUEST['Pistas_fuentes'])) $_REQUEST['Pistas_fuentes']="_";
	if (!isset($_REQUEST['Pruebas'])) $_REQUEST['Pruebas']="_";
	if (!isset($_REQUEST['Maestro'])) $_REQUEST['Maestro']="_";
	if (!isset($_REQUEST['Parametros'])) $_REQUEST['Parametros']="_";
	if (!isset($_REQUEST['Telkey'])) $_REQUEST['Telkey']="_";

	$sql = "SELECT * FROM roles WHERE login_usr='$login_usr'";
	$result=mysql_query($sql);
       
	if(mysql_fetch_array($result)>0){
		$sql="UPDATE roles SET Contratos='$_REQUEST[Contratos]',Proyectos='$_REQUEST[Proyectos]',Proveedores='$_REQUEST[Proveedores]',".
		"PlanifEstrat='$_REQUEST[PlanifEstrat]',Ans='$_REQUEST[Ans]',Clasificacion='$_REQUEST[Clasificacion]',Actas='$_REQUEST[Actas]',".
		"Vacaciones='$_REQUEST[Vacaciones]',FichasTecnicas='$_REQUEST[FichasTecnicas]',MantFuera='$_REQUEST[MantFuera]',Cronograma='$_REQUEST[Cronograma]',".
		"DyM='$_REQUEST[DyM]',PropyResp='$_REQUEST[PropyResp]',ControlTyH='$_REQUEST[ControlTyH]',ControlInvent='$_REQUEST[ControlInvent]',UbicacRespal='$_REQUEST[UbicacRespal]',Calendariza='$_REQUEST[Calendariza]',Produccion='$_REQUEST[Produccion]',".
		"DesaMante='$_REQUEST[DesaMante]',Planificacion='$_REQUEST[Planificacion]',Ejecucion='$_REQUEST[Ejecucion]',Evaluacion='$_REQUEST[Evaluacion]',Calen_cont='$_REQUEST[Calen_cont]',Usuarios='$_REQUEST[Usuarios]',".
		"PistasAudi='$_REQUEST[PistasAudi]',Hash='$_REQUEST[Hash]',Riesgo='$_REQUEST[Riesgo]',".
		"Modulos='$_REQUEST[Modulos]',Archivos='$_REQUEST[Archivos]',Repositorio='$_REQUEST[Repositorio]',Copia_trabajo='$_REQUEST[Copia_trabajo]',Replica='$_REQUEST[Replica]',Revision='$_REQUEST[Revision]',Backups='$_REQUEST[Backups]',Pistas_fuentes='$_REQUEST[Pistas_fuentes]',Maestro='$_REQUEST[Maestro]',".
		"Pruebas='$_REQUEST[Pruebas]', Accion='$_REQUEST[Accion]', lectura='$_REQUEST[uslectura]', Parametros='$_REQUEST[Parametros]', Telkey='$_REQUEST[Telkey]' WHERE login_usr='$login_usr'";

                if (mysql_query($sql) ){
			header("location: usuarios_lista.php");
		}
		else {
			$msg="OCURRIO UN ERROR EN LA MIENTRAS CONECTABA".mysql_errno().": ".mysql_error();
		}
	}
	else {
		$sql="INSERT INTO roles (login_usr,Contratos,".
		"Proyectos,Proveedores,PlanifEstrat,Ans,Clasificacion,Actas,Vacaciones,FichasTecnicas,".	
		"MantFuera,Cronograma,DyM,PropyResp,ControlTyH,ControlInvent,UbicacRespal,Calendariza,Produccion,".
		"DesaMante,Planificacion,Ejecucion,Evaluacion,Calen_cont,Usuarios,PistasAudi,Hash,Riesgo,".
		"Modulos,Archivos,Repositorio,Copia_trabajo,Replica,Revision,Backups,Pistas_fuentes,Maestro,Pruebas, Accion, lectura, Parametros, Telkey".
		") VALUES(".
		"'$login_usr','$_REQUEST[Contratos]','$_REQUEST[Proyectos]','$_REQUEST[Proveedores]','$_REQUEST[PlanifEstrat]','$_REQUEST[Ans]',".
		"'$_REQUEST[Clasificacion]','$_REQUEST[Actas]','$_REQUEST[Vacaciones]','$_REQUEST[FichasTecnicas]',".
		"'$_REQUEST[MantFuera]','$_REQUEST[Cronograma]','$_REQUEST[DyM]','$_REQUEST[PropyResp]','$_REQUEST[ControlTyH]','$_REQUEST[ControlInvent]','$_REQUEST[UbicacRespal]','$_REQUEST[Calendariza]','$_REQUEST[Produccion]',".
		"'$_REQUEST[DesaMante]','$_REQUEST[Planificacion]','$_REQUEST[Ejecucion]','$_REQUEST[Evaluacion]','$_REQUEST[Calen_cont]','$_REQUEST[Usuarios]','$_REQUEST[PistasAudi]','$_REQUEST[Hash]','$_REQUEST[Riesgo]',".
		"'$_REQUEST[Modulos]','$_REQUEST[Archivos]','$_REQUEST[Repositorio]','$_REQUEST[Copia_trabajo]','$_REQUEST[Replica]','$_REQUEST[Revision]','$_REQUEST[Backups]','$_REQUEST[Pistas_fuentes]','$_REQUEST[Maestro]','$_REQUEST[Pruebas]','$_REQUEST[Accion]','$_REQUEST[uslectura]','$_REQUEST[Parametros]', '$_REQUEST[Telkey]')";
	
		if(mysql_query($sql)){
			header("location: usuarios_lista.php");
		}
		else {
			$msg="OCURRIO UN ERROR EN LA MIENTRAS CONECTABA ".mysql_errno().": ".mysql_error();
		}
	}
}

include ("top.php");
$sql = "SELECT * FROM roles WHERE login_usr='$login_usr'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);

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

<p>
<font color="#FF0000" face="Arial, Helvetica, sans-serif"><strong><?php if (isset($msg))echo $msg;?></strong></font>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
  <table width="95%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#F4F2EA" >
    <tr> 
    <td><table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
          <tr> 
            <th colspan="9" background="images/main-button-tileR2.jpg">ROLES<br>
              USUARIO:" 
              <?php 
	$sql2 = "SELECT * FROM users WHERE login_usr='$login_usr'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	echo "'".$row2['nom_usr'].' '.$row2['apa_usr'].' '.$row2['ama_usr']."'"; ?>
              "</th>
          </tr>
          <tr>
            <th colspan="9" background="images/main-button-tileR1.jpg">Generales</th>
          </tr>
          <tr>
            <th colspan="9" background="images/main-button-tileR2.jpg">Usuario Admin de Solo Lectura<br />
              <input name="uslectura" type="checkbox" value="r" <?php if ($row['lectura']=="r") echo "checked"?>></th>
          </tr>
          <tr align="center"> 
            <th width="130" class="menu" background="images/main-button-tileR1.jpg" height="20">GESTION- PRODAT</th>
            <th width="190" class="menu" background="images/main-button-tileR1.jpg" height="20">SOPORTE TECNICO - PROAST</th>
            <th width="130" class="menu" background="images/main-button-tileR1.jpg" height="20">D & M-PROADM </th>
            <th width="130" class="menu" background="images/main-button-tileR1.jpg" height="20">PRODUCCION -PROAPD</th>
            <th width="130" class="menu" background="images/main-button-tileR1.jpg" height="20">PROBLEMAS-PROAPI </th>
            <th width="140" class="menu" background="images/main-button-tileR1.jpg" height="20">CONTINGENCIA-PROAPC </th>
            <th width="130" class="menu" background="images/main-button-tileR1.jpg" height="20">SEGURIDAD-PROASI</th>
            <th width="165" class="menu" background="images/main-button-tileR1.jpg" height="20">CAMBIOS - PROACP</th>
          </tr>
          <tr align="center"> 
            <td width="130">CONTRATOS-PROACT<br> <input name="Contratos" type="checkbox" value="r" <?php if ($row['Contratos']=="r") echo "checked"?> ></td>
            <td width="190">FICHAS TECNICAS<br> <input name="FichasTecnicas" type="checkbox" value="r" <?php if ($row['FichasTecnicas']=="r") echo "checked"?>></td>
            <td width="130">D &amp; M<br> <input name="DyM" type="checkbox" value="r" <?php if ($row['DyM']=="r") echo "checked"?>></td>
            <td width="130">PROPIETARIOS Y RESPONSABLES<br> <input name="PropyResp" type="checkbox" value="r" <?php if ($row['PropyResp']=="r") echo "checked"?>></td>
            <td width="130">PRODUCCION<br> <input name="Produccion" type="checkbox" value="r" <?php if ($row['Produccion']=="r") echo "checked"?>>            </td>
            <td width="140">PLANIFICACION<br> <input name="Planificacion" type="checkbox" value="r" <?php if ($row['Planificacion']=="r") echo "checked"?>></td>
            <td width="130">USUARIOS<br> <input name="Usuarios" type="checkbox" value="r" <?php if ($row['Usuarios']=="r") echo "checked"?>></td>
            <td width="130" rowspan="6" align="center"><div align="CENTER"><font size="1"> 
                <table border="0" align="center">
                  <tr align="center">
                    <td> <font size="1"><strong> ADMINISTRACION DE FUENTES</strong><br>
                      </font> <br> </TD>
                  </TR>
                  <tr>
                    <td align="center"> REPOSITORIO<br> <input name="Repositorio" type="checkbox" value="r" <?php if ($row['Repositorio']=="r") echo "checked"?>>                    </td>
                  </TR>
                
                  <tr>
                    <td align="center">COPIA DE TRABAJO<br> <input name="Copia_trabajo" type="checkbox"  value="r" <?php if ($row['Copia_trabajo']=="r") echo "checked"?>>                    </td>
                  </tr>
                  <tr>
                    <td align="center"> REPLICA<br>
                      <input name="Replica" type="checkbox"  value="r" <?php if ($row['Replica']=="r") echo "checked"?>></td>
                  </tr>
                  <tr>
                    <td align="center"> REVISION<br>
                      <input name="Revision" type="checkbox"  value="r" <?php if ($row['Revision']=="r") echo "checked"?>>                    </td>
                  </tr>
                  <tr>
                    <td align="center"> MODULOS<br>
                      <input name="Modulos" type="checkbox" value="r" <?php if ($row['Modulos']=="r") echo "checked"?>>                    </td>
                  </tr>
                  <tr>
                    <td align="center"> ARCHIVOS<br>
                      <input name="Archivos" type="checkbox" value="r" <?php if ($row['Archivos']=="r") echo "checked"?>>                    </td>
                  </tr>
                  <tr>
                    <td align="center"> BACKUPS<br>
                      <input name="Backups" type="checkbox"  value="r" <?php if ($row['Backups']=="r") echo "checked"?>>                    </td>
                  </tr>
                  <tr>
                    <td align="center"> PISTAS DE AUDITORIA<br>
                      <input name="Pistas_fuentes" type="checkbox"  value="r" <?php if ($row['Pistas_fuentes']=="r") echo "checked"?>>                    </td>
                  </tr>
                </table>
                </font></div></td>
          </tr>
          <tr align="center"> 
            <td width="130">PROYECTOS<br> <input name="Proyectos" type="checkbox" value="r" <?php if ($row['Proyectos']=="r") echo "checked"; ?> ></td>
            <td width="190">MANTENIMIENTO FUERA<br> <input name="MantFuera" type="checkbox" value="r" <?php if ($row['MantFuera']=="r") echo "checked"; ?> ></td>
            <td width="130">&nbsp;</td>
            <td width="130">CONTROL DE TEMP &amp; HUMEDAD<br> <input name="ControlTyH" type="checkbox" value="r" <?php if ($row['ControlTyH']=="r") echo "checked"?> ></td>
            <td width="130">D &amp; M<br> <input name="DesaMante" type="checkbox" value="r" <?php if ($row['DesaMante']=="r") echo "checked"?> ></td>
            <td width="140">EJECUCION<br> <input name="Ejecucion" type="checkbox" value="r" <?php if ($row['Ejecucion']=="r") echo "checked"?>></td>
            <td width="130">BACKUP BD<br> <input name="PistasAudi" type="checkbox" value="r" <?php if ($row['PistasAudi']=="r") echo "checked"?>></td>
          </tr>
          <tr align="center"> 
            <td width="130">PROVEEDORES<br> <input name="Proveedores" type="checkbox" value="r" <?php if ($row['Proveedores']=="r") echo "checked"?>></td>
            <td width="190">CRONOGRAMA<br> <input name="Cronograma" type="checkbox" value="r" <?php if ($row['Cronograma']=="r") echo "checked"?>></td>
            <td width="130">&nbsp;</td>
            <td width="130">CONTROL INVENTARIOS<br> <input name="ControlInvent" type="checkbox" value="r" <?php if ($row['ControlInvent']=="r") echo "checked"?>></td>
            <td width="130">&nbsp;</td>
            <td width="140">EVALUACION <br> <input name="Evaluacion" type="checkbox"  value="r" <?php if ($row['Evaluacion']=="r") echo "checked"?>></td>
            <td width="130">CALCULADORA HASH<br> <input name="Hash" type="checkbox" value="r" <?php if ($row['Hash']=="r") echo "checked"?>></td>
          </tr>
          <tr align="center"> 
            <td width="130">PLANIFICACION ESTRATEGICA<br> <input name="PlanifEstrat" type="checkbox" value="r" <?php if ($row['PlanifEstrat']=="r") echo "checked"?>></td>
            <td width="190">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">UBICACION DE RESPALDOS<br> <input name="UbicacRespal" type="checkbox" value="r" <?php if ($row['UbicacRespal']=="r") echo "checked"?>>            </td>
            <td width="130">&nbsp;</td>
            <td width="140">CRONOGRAMA<br> <input name="Calen_cont" type="checkbox"  value="r" <?php if ($row['Calen_cont']=="r") echo "checked"?>></td>
            <td width="130">MENU PARAMETROS<br> <input name="Parametros" type="checkbox" value="r" <?php if ($row['Parametros']=="r") echo "checked"?>></td>
          </tr>
          <tr align="center"> 
            <td width="130"><br>
              ANS<br> <input name="Ans" type="checkbox" value="r" <?php if ($row['Ans']=="r") echo "checked"?>>            </td>
            <td width="190">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130"><br>
              CALENDARIZACION<br> <input type="checkbox" name="Calendariza" value="r" <?php if ($row['Calendariza']=="r") echo "checked"?>></td>
            <td width="130">&nbsp;</td>
            <td width="140">&nbsp;</td>
            <td width="130">TELKEY<br> <input name="Telkey" type="checkbox" value="r" <?php if ($row['Telkey']=="r") echo "checked"?>></td>
          </tr>
          <tr align="center"> 
            <td width="130"><br>
              CLASIFICACION<br> <input name="Clasificacion" type="checkbox" value="r" <?php if ($row['Clasificacion']=="r") echo "checked"?>></td>
            <td width="190">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="140">&nbsp;</td>
            <td width="130">&nbsp;</td>
          </tr>
          <tr align="center"> 
            <td width="130"><br>
              ACTAS<br> <input name="Actas" type="checkbox" value="r" <?php if ($row['Actas']=="r") echo "checked"?>>            </td>
            <td width="190">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="140">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">PRUEBAS<br> <input name="Pruebas" type="checkbox"  value="r" <?php if ($row['Pruebas']=="r") echo "checked"?>></td>
          </tr>
          <tr align="center"> 
            <td width="130"><br>
              AUSENCIA PROGRAMADA<br> <input name="Vacaciones" type="checkbox" value="r" <?php if ($row['Vacaciones']=="r") echo "checked"?>>            </td>
            <td width="190">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="140">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">MAESTRO DE CAMBIOS<br> <input name="Maestro" type="checkbox"  value="r" <?php if ($row['Maestro']=="r") echo "checked"?>></td>
          </tr>
          <tr align="center"> 
            <td width="130"><br>
              RIESGOS<br> <input name="Riesgo" type="checkbox" value="r" <?php if ($row['Riesgo']=="r") echo "checked"?>>            </td>
            <td width="190">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="140">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
          </tr>
          <tr align="center"> 
            <td width="130"><br>
              ACCIONISTAS<br> <input name="Accion" type="checkbox" value="r" <?php if ($row['Accion']=="r") echo "checked"?>>            </td>
            <td width="190">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="140">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
          </tr>
		  <tr align="center"> 
            <td width="130"><br>
              PMI<br> <input name="pmi" type="checkbox" value="r" <?php /*variable pmi no existe en la tabla*/if ($row['Pnps']=="r") echo "checked"?>>            </td>
            <td width="190">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="140">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="130">&nbsp;</td>
          </tr>
        </table></td>
  </tr>
</table>
<BR>
<input name="login_usr" type="hidden" value="<?php echo $login_usr; ?>">
<input name="GUARDAR" type="submit" value="GUARDAR">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <input name="RETORNAR" type="submit" value="RETORNAR">
</form>