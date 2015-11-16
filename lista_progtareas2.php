<?php
require_once("funciones.php");
if (valida("Calendariza")=="bad") {header("location: pagina_error.php");}
if (isset($_REQUEST['RETORNAR'])){header("location: lista_produccion.php?Naveg=Produccion");}
if (isset($_REQUEST['TRIMESTRAL'])){header("location: prog_tareastrimestralp.php");}
if (isset($_REQUEST['SEMESTRAL'])){header("location: prog_tareassemestralp.php");}
if (isset($_REQUEST['ANUAL'])){header("location: prog_tareasanualp.php");}
include ("top.php");
?>
<?php 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num1","Numero");
	$help->AddHelp("num2","Numero");
/*	$help->AddHelp("conf","Conformidad de ...");
	$help->AddHelp("solu","Solucion a las ordenes de trabajo ...");
	$help->AddHelp("incidencia","Incidencia se refiere a...");*/
	print $help->ToHtml();
//print_r($_SESSION);
 ?>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr>
    <th colspan="3" background="images/main-button-tileR2.jpg">LISTA DE PROGRAMACION DE TAREAS</th>
  </tr>
  <tr align="center" valign="top">
    <th width="33%"><font size="1">TAREAS TRIMESTRALES</font></th>
    <th width="33%"><font size="1">TAREAS SEMESTRALES</font></th>
    <th width="33%"><font size="1">TAREAS ANUALES </font></th>
  </tr>
  <tr valign="top">
    <td align="center">
      <?php
	    $login_usr = $_SESSION["login"]; 
	    if($tipo == "T")
		{
			$sqlDiaria="SELECT * FROM progtareastrimestral where t_asig like '%$login_usr%' or t_asig = '0' ORDER BY Mes ASC, Dia ASC";
		}
		else if($tipo == "A")
		{
			$sqlDiaria="SELECT * FROM progtareastrimestral ORDER BY Mes ASC, Dia ASC";
		} 
	
	$rsDiaria=mysql_db_query($db, $sqlDiaria, $link);
	print "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">";
	print "<tr>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Mes / Dia</td>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Actividad</td>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Realizar</td>";
		if ($_SESSION["tipo"]=="A") print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Modificar</td>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Imprimir</td>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Asignado A</td>";
	print "</tr>";
	while($tmp=mysql_fetch_array($rsDiaria)) {
		print "<tr>";
			print "<td>Mes $tmp[Mes] / Dia $tmp[Dia]</td>";
			print "<td>$tmp[Actividad]</td>";
			print "<td align=\"center\"><a href=\"prog_tareastrimestralrev.php?IdProgTarea=$tmp[IdProgTarea]\"><img src=\"images/edi.gif\" border=\"0\" alt=\"Realizar\"></a></td>";
			if ($_SESSION["tipo"]=="A") print "<td align=\"center\"><a href=\"prog_tareastrimestralp.php?do=editar&IdProgTarea=$tmp[IdProgTarea]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Editar\"></a></td>";
			print "<td align=\"center\"><a href=\"javascript: void(0)\" onclick=\"openPrint(4, $tmp[IdProgTarea])\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";
		
//****************************Consulta para ingresar el nombre del usuario asignado********************************************
		$count = 0;
		$vector = explode("|",$tmp['t_asig']);
		$limite = count($vector)-1;
		for($i=0; $i<=count($vector)-1; $i++)
		{
			if($vector[$i] <> "") $count++;
		}

		if($count == 1)
		{
			$tmp['t_asig'] = $vector[0];
			$sCad = "select *from users where login_usr = '$tmp[t_asig]'";
			$sCon = mysql_db_query($db,$sCad,$link);
			$sFilas = mysql_fetch_array($sCon);
			$sNombre = $sFilas['apa_usr']." ".$sFilas['ama_usr']." ".$sFilas['nom_usr'];
		}
		else
		{
			$sNombre = "Varios";
		}
//************************Fin Consulta para ingresar el nombre del usuario asignado********************************************

		if( ($tmp['t_asig']!=0) or !(empty($tmp['t_asig'])) ){print "<td align='center'>$sNombre</td>";}
		else{ 
			if($tipo == 'T' or $tipo == 'C'){
				print "<td align='center'><img src=\"images/no3.gif\" border=\"0\" ></td>";
			}else{
				print "<td align='center'><img src=\"images/no3.gif\" border=\"0\" alt=\"No Asignado\"></td>";
			}
		}
				
		print "</tr>";
	}
	print "</table>";
?>
    </td>
    <td align="center"><?php
	 	if($tipo == "T")
		{
			$sqlDiaria="SELECT * FROM progtareassemestral where sm_asig like '%$login_usr%' or sm_asig = '0' ORDER BY Mes, Dia ASC";
		}
		else if($tipo == "A")
		{
			$sqlDiaria="SELECT * FROM progtareassemestral ORDER BY Mes, Dia ASC";
		} 
	$rsDiaria=mysql_db_query($db, $sqlDiaria, $link);
	print "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">";
	print "<tr>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Mes/Dia</td>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Actividad</td>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Realizar</td>";
		if ($_SESSION["tipo"]=="A") print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Modificar</td>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Imprimir</td>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Asignado A</td>";
	print "</tr>";
	while($tmp=mysql_fetch_array($rsDiaria)) {
		print "<tr>";
			print "<td>Mes $tmp[Mes]/Dia $tmp[Dia]</td>";
			print "<td>$tmp[Actividad]</td>";
			print "<td align=\"center\"><a href=\"prog_tareassemestralrev.php?IdProgTarea=$tmp[IdProgTarea]\"><img src=\"images/edi.gif\" border=\"0\" alt=\"Realizar\"></a></td>";
			if ($_SESSION["tipo"]=="A") print "<td align=\"center\"><a href=\"prog_tareassemestralp.php?do=editar&IdProgTarea=$tmp[IdProgTarea]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Editar\"></a></td>";
			print "<td align=\"center\"><a href=\"javascript: void(0)\" onclick=\"openPrint(5, $tmp[IdProgTarea])\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";
		
//****************************Consulta para ingresar el nombre del usuario asignado********************************************
		$count = 0;
		$vector = explode("|",$tmp['sm_asig']);
		$limite = count($vector)-1;
		for($i=0; $i<=count($vector)-1; $i++)
		{
			if($vector[$i] <> "") $count++;
		}

		if($count == 1)
		{
			$tmp['sm_asig'] = $vector[0];
			$sCad = "select *from users where login_usr = '$tmp[sm_asig]'";
			$sCon = mysql_db_query($db,$sCad,$link);
			$sFilas = mysql_fetch_array($sCon);
			$sNombre = $sFilas['apa_usr']." ".$sFilas['ama_usr']." ".$sFilas['nom_usr'];
		}
		else
		{
			$sNombre = "Varios";
		}
		
		/*$sCad = "select *from users where login_usr = '$tmp[sm_asig]'";
		$sCon = mysql_db_query($db,$sCad,$link);
		$sFilas = mysql_fetch_array($sCon);
		$sNombre = $sFilas[apa_usr]." ".$sFilas[ama_usr]." ".$sFilas[nom_usr];*/
//************************Fin Consulta para ingresar el nombre del usuario asignado********************************************

		if( ($tmp['sm_asig']!=0) or !(empty($tmp['sm_asig'])) ){print "<td align='center'>$sNombre</td>";}
		else{ 
			if($tipo == 'T' or $tipo == 'C'){
				print "<td align='center' background=\"images/main-button-tileR1.jpg\"><img src=\"images/no3.gif\" border=\"0\" ></td>";
			}else{
				print "<td align='center' background=\"images/main-button-tileR1.jpg\"><img src=\"images/no3.gif\" border=\"0\" alt=\"No Asignado\"></td>";
			}
		}
		
		print "</tr>";
	}
	print "</table>";
?></td>
    <td align="center"><?php
		if($tipo == "T")
		{
			$sqlDiaria="SELECT *, DATE_FORMAT(Dia, '%d/%m/%Y') AS Dia_1 FROM progtareasanual where a_asig like '%$login_usr%' or a_asig = '0' ORDER BY Dia ASC";
		}
		else if($tipo == "A")
		{
			$sqlDiaria="SELECT *, DATE_FORMAT(Dia, '%d/%m/%Y') AS Dia_1 FROM progtareasanual ORDER BY Dia ASC";
		} 
	
	$rsDiaria=mysql_db_query($db, $sqlDiaria, $link);
	print "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">";
	print "<tr>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Dia</td>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Actividad</td>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Realizar</td>";
		if ($_SESSION["tipo"]=="A") print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Modificar</td>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Imprimir</td>";
		print "<th class=\"th2\" background=\"images/main-button-tileR1.jpg\">Asignado A</td>";
	print "</tr>";
	while($tmp=mysql_fetch_array($rsDiaria)) {
		print "<tr>";
			print "<td>$tmp[Dia_1]</td>";
			print "<td>$tmp[Actividad]</td>";
			print "<td align=\"center\"><a href=\"prog_tareasanualrev.php?IdProgTarea=$tmp[IdProgTarea]\"><img src=\"images/edi.gif\" border=\"0\" alt=\"Realizar\"></a></td>";
			if ($_SESSION["tipo"]=="A") print "<td align=\"center\"><a href=\"prog_tareasanualp.php?do=editar&IdProgTarea=$tmp[IdProgTarea]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Editar\"></a></td>";
			print "<td align=\"center\"><a href=\"javascript: void(0)\" onclick=\"openPrint(6, $tmp[IdProgTarea])\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";
		
//****************************Consulta para ingresar el nombre del usuario asignado********************************************
		$count = 0;
		$vector = explode("|",$tmp['a_asig']);
		$limite = count($vector)-1;
		for($i=0; $i<=count($vector)-1; $i++)
		{
			if($vector[$i] <> "") $count++;
		}

		if($count == 1)
		{
			$tmp['a_asig'] = $vector[0];
			$sCad = "select *from users where login_usr = '$tmp[a_asig]'";
			$sCon = mysql_db_query($db,$sCad,$link);
			$sFilas = mysql_fetch_array($sCon);
			$sNombre = $sFilas['apa_usr']." ".$sFilas['ama_usr']." ".$sFilas['nom_usr'];
		}
		else
		{
			$sNombre = "Varios";
		}
		/*$sCad = "select *from users where login_usr = '$tmp[a_asig]'";
		$sCon = mysql_db_query($db,$sCad,$link);
		$sFilas = mysql_fetch_array($sCon);
		$sNombre = $sFilas[apa_usr]." ".$sFilas[ama_usr]." ".$sFilas[nom_usr];*/
//************************Fin Consulta para ingresar el nombre del usuario asignado********************************************

		if( ($tmp['a_asig']!=0) or !(empty($tmp['a_asig'])) ){print "<td align='center'>$sNombre</td>";}
		else{ 
			if($tipo == 'T' or $tipo == 'C'){
				print "<td align='center'><img src=\"images/no3.gif\" border=\"0\" ></td>";
			}else{
				print "<td align='center'><img src=\"images/no3.gif\" border=\"0\" alt=\"Asignar\"></td>";
			}
		}
		
		print "</tr>";
	}
	print "</table>";
?></td>
  </tr>
</table>
<form name="form1" method="post" action="">
  <div align="center">
    <table width="77%" align="center">
      <tr> 
        <td width="33%" height="70"> 
          <div align="center"> 
		  <?php if($tipo=="A" OR $tipo=="B"){?>
            <input name="TRIMESTRAL" type="submit" id="TRIMESTRAL" value="NUEVA TAREA TRIMESTRAL"><br> <br>
            <input name="IMPRIMIR1" type="button" id="TRIMESTRAL1" value="IMPRIMIR TAREAS TRIMESTRALES" onClick="pagina()">
		  <?php }?>
          </div></td>
        <td width="33%"><div align="center">
		<?php if($tipo=="A" OR $tipo=="B"){?>
            <input name="SEMESTRAL" type="submit" id="SEMESTRAL" value="NUEVA TAREA SEMESTRAL"><br> <br>
            <input name="IMPRIMIR2" type="button" id="SEMESTRAL1" value="IMPRIMIR TAREAS SEMESTRALES" onClick="pagina1()">
		<?php }?>
          </div></td>
        <td width="34%"><div align="center">
		<?php if($tipo=="A" OR $tipo=="B"){?>
            <input name="ANUAL" type="submit" id="ANUAL2" value="NUEVA TAREA ANUAL">
            <br><br>
            <input name="IMPRIMIR3" type="button" id="ANUAL3" value="IMPRIMIR TAREAS ANUALES" onClick="pagina2()">
        <?php }?>

          </div></td>
      </tr>
    </table>
    
    <br>
    <table width="76%">
      <tr>
        <td width="43%"><a href="lista_progtareas.php?Naveg=Produccion >> Calendarizacion"><font size="3" face="Arial, Helvetica, sans-serif">&lt;&lt; 
          Volver lista principal</font></a></td>
        <td width="52%"><!--<input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">--></td>
        <td width="5%">&nbsp;</td>
      </tr>
    </table>
    
  </div>
</form>

 
<?php include("top_.php"); ?> 
<script language="JavaScript">
<!--
function openPrint(type, IdProgTarea) {
	window.open("ver_lista_tareas.php?tipo="+type+"&IdProgTarea="+IdProgTarea,'GesTorF1', 'width=600,height=180,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}

function pagina() {
	window.open("ver_lista_tareastrimestral_pre.php",'Prog_tarea_trimestral', 'width=600,height=300,status=yes,resizable=no,top=200,left=180,dependent=yes,alwaysRaised=yes');
}
function pagina1() {
	window.open("ver_lista_tareassemestral_pre.php",'Prog_tarea_semestral', 'width=600,height=300,status=yes,resizable=no,top=200,left=180,dependent=yes,alwaysRaised=yes');
}
function pagina2() {
	window.open("ver_lista_tareasanual_pre.php",'Prog_tarea_anual', 'width=600,height=300,status=yes,resizable=no,top=200,left=180,dependent=yes,alwaysRaised=yes');
}
-->
</script>
