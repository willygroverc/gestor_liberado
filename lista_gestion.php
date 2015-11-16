<?php include ("top.php");
include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("ans","Acuerdo de Nivel de Servicio.");
	print $help->ToHtml();
 ?>
<table width="95%" border="2" align="center" cellpadding="2" cellspacing="0">
  <tr bgcolor="#006699" align="center" valign="middle">
    <?php
$sql="SELECT * FROM roles WHERE login_usr='$login'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);	

		  if ($row[Contratos]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
          echo "<td><a ".$clas." href=\"lista_contratos.php?Naveg=Gestion >> Contratos\">CONTRATOS</a></td>";
		  if ($row[Proyectos]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
          echo "<td><a ".$clas." href=\"lista_proyectos.php?Naveg=Gestion >> Proyectos\">PROYECTOS</a></td>";
		  if ($row[Proveedores]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"lista_proveed.php?Naveg=Gestion >> Proveedores\">PROVEEDORES</a></td>";
		  if ($row[PlanifEstrat]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"lista_planifes.php?Naveg=Gestion >> Planificacion Estrategica\">PLANIFICACION ESTRATEGICA</a></td>";
		  print "<td>";
		  if ($row[Ans]=="r") {$clas="class=\"menu\"";print $help->AddLink("ans", "ANS", "nservicio.php?Naveg=Gestion >> ANS", "menu"); //w
			} 
			else {
			$clas="class=\"menu2\"";
			print $help->AddLink("ans", "ANS", "nservicio.php?Naveg=Gestion >> ANS", "menu2"); //w
			} //COLOR DEL ROL
			print "</td>";
          //echo "<td><a ".$clas." href=\"nservicio.php\">ANS</a></td>";
		  if ($row[Clasificacion]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
          echo "<td><a ".$clas." href=\"ast11.php?Naveg=Gestion >> Clasificacion\">CLASIFICACION</a></td>";
		  if ($row[Actas]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"lista_agenda.php?Naveg=Gestion >> Actas\">ACTAS</a></td>";
		  if ($row[Vacaciones]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"lista_vacaciones.php?Naveg=Gestion >> Ausencia Programada\">AUSENCIA PROGRAMADA</a></td>";
		  if ($row[Riesgo]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"riesgo-opciones.php?Naveg=Gestion >> Riesgos\">RIESGOS</a></td>";
		  if($tipo=="A")
		  {
		  	echo "<td><a class=\"menu\" href=\"panel_control.php?Naveg=Gestion >> Reportes y Estadisticas\">REPORTES Y ESTADISTICAS</a></td>";
		  }
		  if ($row[Accion]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"accionistas.php?Naveg=Gestion >> Accionistas\">ACCIONISTAS</a></td>";
?>
  </tr>
</table>
<?php 
  include ("pagina_inicio2.php");
  include("top_.php");?>
