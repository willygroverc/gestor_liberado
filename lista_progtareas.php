<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		17/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require_once("funciones.php");
if (valida("Calendariza") == "bad") {
    header("location: pagina_error.php");
} 
if (isset($_REQUEST['DIARIA'])) {
    header("location: prog_tareasdiariap.php");
} 
if (isset($_REQUEST['SEMANAL'])) {
    header("location: prog_tareassemanalp.php");
} 
if (isset($_REQUEST['MENSUAL'])) {
    header("location: prog_tareasmensualp.php");
} 

include ("top.php");
// ======================================== Recordatorio de Calendarizacion ==============
include ("recordatorio_func.php");
// ========================================== END Recordatorio =====================
?>
<?php
include_once ("help.class.php");
$help = new Help();
$help->AddHelp("num1", "Numero");
$help->AddHelp("num2", "Numero");
/*	$help->AddHelp("conf","Conformidad de ...");
	$help->AddHelp("solu","Solucion a las ordenes de trabajo ...");
	$help->AddHelp("incidencia","Incidencia se refiere a...");*/ 
echo $help->ToHtml();

?><head>
<link rel=stylesheet href="general.css" type="text/css">
</head>
<body>
<form method="post" action="prog_tareasgrupo_dia.php">
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
      <th height="20" colspan="3" background="images/main-button-tileR2.jpg">LISTA DE PROGRAMACION DE TAREAS</th>
  </tr>
  <tr> 
    <th width="33%"><font size="1">TAREAS DIARIAS </font></th>
    <th width="33%"><font size="1">TAREAS SEMANALES </font></th>
    <th width="33%"><font size="1">TAREAS MENSUALES </font></th>
  </tr>
  <tr> 
    <td align="center" valign="top">
	<?php
	 $login_usr = $_SESSION["login"]; 
	//Solo el usuario puede ver sus asignaciones de tareas
		if(isset($tipo) && $tipo == "T")
		{
			$sqlDiaria = "SELECT * FROM progtareasdiaria where d_asig like '%$login_usr%' or d_asig = '0' ORDER BY HoraDe ASC";
		}
		else if(isset($tipo) && $tipo == "A")
		{
			$sqlDiaria = "SELECT * FROM progtareasdiaria ORDER BY HoraDe ASC";
		}
	//fin de asignaciones
	$rsDiaria  = mysql_query( $sqlDiaria);
	echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">";
	echo "<tr>";
		echo "<th class=\"th2\">&nbsp;</td>";
		echo "<th class=\"th2\">Hora</td>";
		echo "<th class=\"th2\">Actividad</td>";
		echo "<th class=\"th2\">Realizar</td>";
		if (($_SESSION["tipo"]=="A") or ($_SESSION["tipo"]=="B")) echo "<th class=\"th2\">Modificar</td>";
		echo "<th class=\"th2\">Imprimir</td>";
		echo "<th class=\"th2\">Asignado A</td>";
	echo "</tr>";
	while($tmp=mysql_fetch_array($rsDiaria)) {
		echo "<tr>";
			echo "<td><input type='checkbox' name=valores[]  value='$tmp[IdProgTarea]' class='check1'></input></td>";						
			echo "<td>$tmp[HoraDe]-$tmp[HoraA]</td>";			
			echo "<td>$tmp[Actividad]</td>";
			echo "<td align=\"center\"><a href=\"prog_tareasdiariarev.php?IdProgTarea=$tmp[IdProgTarea]\"><img src=\"images/edi.gif\" border=\"0\" alt=\"Realizar\"></a></td>";
			if (($_SESSION["tipo"]=="A") or ($_SESSION["tipo"]=="B")) echo "<td align=\"center\"><a href=\"prog_tareasdiariap.php?do=editar&IdProgTarea=$tmp[IdProgTarea]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Editar\"></a></td>";
			echo "<td align=\"center\"><a href=\"javascript: void(0)\" onclick=\"openecho(1, $tmp[IdProgTarea])\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";
		
//****************************Consulta para ingresar el nombre del usuario asignado********************************************
		
		$count = 0;
		$vector = explode("|",$tmp['d_asig']);
		$limite = count($vector)-1;

		for($i=0; $i<=count($vector)-1; $i++)
		{
			if($vector[$i] <> "") $count++;
		}

		if($count == 1)
		{
			$tmp['d_asig'] = $vector[0];
			$sCad = "select *from users where login_usr = '$tmp[d_asig]'";
			$sCon = mysql_query($sCad);
			$sFilas = mysql_fetch_array($sCon);
			$sNombre = $sFilas['apa_usr']." ".$sFilas['ama_usr']." ".$sFilas['nom_usr'];
		}
		else
		{
			$sNombre = "Varios";
		}
//************************Fin Consulta para ingresar el nombre del usuario asignado********************************************

		if( ($tmp['d_asig']!=0) or !(empty($tmp['d_asig'])) ){echo "<td align='center'>$sNombre</td>";}
		else
		{ 
			if(isset($tipo) && $tipo == 'T' or $tipo == 'C')
			{
				echo "<td align='center'><img src=\"images/no3.gif\" border=\"0\" ></td>";
			}
			else
			{
				echo "<td align='center'><img src=\"images/no3.gif\" border=\"0\" alt=\"No Asignado\"></td>";
			}
		}
		
		echo "</tr>";
	}
	echo "</table>";
?>
	</td>
    <td align="center" valign="top"><?php
		if(isset($tipo) && $tipo == "T")
		{
			$sqlDiaria="SELECT * FROM progtareassemanal where s_asig like '%$login_usr%' or s_asig = '0' ORDER BY Dia ASC";
		}
		else if(isset($tipo) && $tipo == "A")
		{
			$sqlDiaria="SELECT * FROM progtareassemanal ORDER BY Dia ASC";
		}
	
	$rsDiaria=mysql_query($sqlDiaria);
	echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">";
	echo "<tr>";
		echo "<th class=\"th2\">Dia</td>";
		echo "<th class=\"th2\">Actividad</td>";
		echo "<th class=\"th2\">Realizar</td>";
		if (($_SESSION["tipo"]=="A") or ($_SESSION["tipo"]=="B")) echo "<th class=\"th2\">Modificar</td>";
		echo "<th class=\"th2\">Imprimir</td>";
		echo "<th class=\"th2\">Asignado A</td>";
	echo "</tr>";
	while($tmp=mysql_fetch_array($rsDiaria)) {
		echo "<tr>";
			echo "<td>$tmp[Dia]</td>";
			echo "<td>$tmp[Actividad]</td>";
			echo "<td align=\"center\"><a href=\"prog_tareassemanalrev.php?IdProgTarea=$tmp[IdProgTarea]\"><img src=\"images/edi.gif\" border=\"0\" alt=\"Realizar\"></a></td>";
			if (($_SESSION["tipo"]=="A") or ($_SESSION["tipo"]=="B")) echo "<td align=\"center\"><a href=\"prog_tareassemanalp.php?do=editar&IdProgTarea=$tmp[IdProgTarea]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Editar\"></a></td>";
			echo "<td align=\"center\"><a href=\"javascript: void(0)\" onclick=\"openecho(2, $tmp[IdProgTarea])\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";
		
		
//****************************Consulta para ingresar el nombre del usuario asignado********************************************
		$count = 0;
		$vector = explode("|",$tmp['s_asig']);
		$limite = count($vector)-1;
		for($i=0; $i<=count($vector)-1; $i++)
		{
			if($vector[$i] <> "") $count++;
		}

		if($count == 1)
		{
			$tmp['s_asig'] = $vector[0];
			$sCad = "select *from users where login_usr = '$tmp[s_asig]'";
			$sCon = mysql_query($sCad);
			$sFilas = mysql_fetch_array($sCon);
			$sNombre = $sFilas['apa_usr']." ".$sFilas['ama_usr']." ".$sFilas['nom_usr'];
		}
		else
		{
			$sNombre = "Varios";
		}

//************************Fin Consulta para ingresar el nombre del usuario asignado********************************************

		if( ($tmp['s_asig']!=0) or !(empty($tmp['s_asig'])) ){echo "<td align='center'>$sNombre</td>";}
		else{ 
			if(isset($tipo) && $tipo == 'T' or $tipo == 'C'){
				echo "<td align='center'><img src=\"images/no3.gif\" border=\"0\" ></td>";
			}else{
				echo "<td align='center'><img src=\"images/no3.gif\" border=\"0\" alt=\"No Asignado\"></td>";
			}
		}
		
		echo "</tr>";
	}
	echo "</table>";
?></td>
    <td align="center" valign="top"><?php
		if($tipo == "T")
		{
			$sqlDiaria="SELECT * FROM progtareasmensual where m_asig like '%$login_usr%' or m_asig = '0' ORDER BY Dia ASC";
		}
		else if($tipo == "A")
		{
			$sqlDiaria="SELECT * FROM progtareasmensual ORDER BY Dia ASC";
		}
	
	$rsDiaria=mysql_query( $sqlDiaria);
	echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">";
	echo "<tr>";
		echo "<th class=\"th2\">Dia</td>";
		echo "<th class=\"th2\">Actividad</td>";
		echo "<th class=\"th2\">Realizar</td>";
		if (($_SESSION["tipo"]=="A") or ($_SESSION["tipo"]=="B")){echo "<th class=\"th2\">Modificar</td>";}
		echo "<th class=\"th2\">Imprimir</td>";
		echo "<th class=\"th2\">Asignado A</td>";
		echo "</tr>";
	while($tmp=mysql_fetch_array($rsDiaria)) {
		echo "<tr>";
			echo "<td>$tmp[Dia]</td>";
			echo "<td>$tmp[Actividad]</td>";
			echo "<td align=\"center\"><a href=\"prog_tareasmensualrev.php?IdProgTarea=$tmp[IdProgTarea]\"><img src=\"images/edi.gif\" border=\"0\" alt=\"Realizar\"></a></td>";
			if (($_SESSION["tipo"]=="A") or ($_SESSION["tipo"]=="B")) echo "<td align=\"center\"><a href=\"prog_tareasmensualp.php?do=editar&IdProgTarea=$tmp[IdProgTarea]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Editar\"></a></td>";
			echo "<td align=\"center\"><a href=\"javascript: void(0)\" onclick=\"openecho(3, $tmp[IdProgTarea])\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";
			
//****************************Consulta para ingresar el nombre del usuario asignado********************************************
		$count = 0;
		$vector = explode("|",$tmp['m_asig']);
		$limite = count($vector)-1;
		for($i=0; $i<=count($vector)-1; $i++)
		{
			if($vector[$i] <> "") $count++;
		}

		if($count == 1)
		{
			$tmp['m_asig'] = $vector[0];
			$sCad = "select *from users where login_usr = '$tmp[m_asig]'";
			$sCon = mysql_query($sCad);
			$sFilas = mysql_fetch_array($sCon);
			$sNombre = $sFilas['apa_usr']." ".$sFilas['ama_usr']." ".$sFilas['nom_usr'];
		}
		else
		{
			$sNombre = "Varios";
		}
//************************Fin Consulta para ingresar el nombre del usuario asignado********************************************

		if( ($tmp['m_asig']!=0) or !(empty($tmp['m_asig'])) ){echo "<td align='center'>$sNombre</td>";}
		else{ 
			if($tipo == 'T' or $tipo == 'C'){
				echo "<td align='center'><img src=\"images/no3.gif\" border=\"0\" ></td>";
			}else{
				echo "<td align='center'><img src=\"images/no3.gif\" border=\"0\" alt=\"No Asignado\"></td>";
			}
		}
		echo "</tr>";
	}
	echo "</table>";
?></td>
  </tr>
</table>  
<table align="center" width="90%">
<tr>
  	<td width="33%" height="25" align="center" background="images/fondo.jpg"> 
	 <table border="1" width="100%" cellspacing=0><tr><td align="center">
      <input type="submit" name="GRUPO_DIAS" value="AGRUPAR T/DIAS" class="boton2">
	  </td></tr>
	  </table>
	  </td>
	<td width="33%" align="center"> 
	</td>
	<td width="33%" align="center"> </td>
  </tr>
</table>
</form>
<form name="form1" method="post" action="">
  <div align="center">
    <table width="90%" align="center">
      <tr> 
        <td width="33%"><div align="center"> 
			<?php if(isset($tipo) && ($tipo=="A" OR $tipo=="B")){?>
            <input name="DIARIA" type="submit" id="reg_form3" value="NUEVA TAREA DIARIA">
            <br>
            <br>
            <input name="IMPRIMIR1" type="button" id="reg_form4" value="IMPRIMIR TAREAS DIARIAS" onClick="pagina_pre()">
			<?php }?>
          </div></td>
        <td width="34%"><div align="center"> 
            <?php if($tipo=="A" OR $tipo=="B"){?>
			<input name="SEMANAL" type="submit" id="NueFicha" value="NUEVA TAREA SEMANAL">
			<br><br>
            <input name="IMPRIMIR2" type="button" id="NueFicha2" value="IMPRIMIR TAREAS SEMANALES" onClick="pagina1()">
			<?php }?>
          </div></td>
        <td width="33%"> <div align="center">
			<?php if($tipo=="A" OR $tipo=="B"){?>
            <input name="MENSUAL" type="submit" id="NueFicha2" value="NUEVA TAREA MENSUAL">
			<br><br>
            <input name="IMPRIMIR3" type="button" id="NueFicha3" value="IMPRIMIR TAREAS MENSUALES" onClick="pagina2()">
			<?php }?>
          </div></td>
      </tr>
    </table>
    <br>
    <table width="76%">
      <tr>
        <td width="42%">&nbsp;</td>
        <td width="34%"><!--<input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">--></td>
        <td width="24%"><a href="lista_progtareas2.php?Naveg=Produccion >> Calendarizacion"><font size="3" face="Arial, Helvetica, sans-serif">Continuar 
          con la lista &gt;&gt;</font></a></td>
      </tr>
    </table>
    
  </div>
</form>
</body>
</html>
 
<script language="JavaScript">
<!--
function openecho(type, IdProgTarea) {
	window.open("ver_lista_tareas.php?tipo="+type+"&IdProgTarea="+IdProgTarea,'GesTorF1', 'width=600,height=180,status=no,resizable=no,top=200,left=180,dependent=yes,alwaysRaised=yes');
}

function pagina_pre() {
	window.open("ver_lista_tareasdiaria_pre.php",'Prog_tarea_diaria', 'width=600,height=230,status=yes,resizable=no,top=200,left=180,dependent=yes,alwaysRaised=yes');
}
function pagina1() {
	window.open("ver_lista_tareassemanal_pre.php",'Prog_tarea_semanal', 'width=600,height=300,status=yes,resizable=no,top=200,left=180,dependent=yes,alwaysRaised=yes');
}
function pagina2() {
	window.open("ver_lista_tareasmensual_pre.php",'Prog_tarea_mensual', 'width=600,height=300,status=yes,resizable=no,top=200,left=180,dependent=yes,alwaysRaised=yes');
}

-->
</script>
<script language="JavaScript">
		<!-- 
		<?php
			if (isset($msg)) {
			echo "var msg=\"$msg\";\n";
			echo "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
			
		} ?>
//-->
</script>