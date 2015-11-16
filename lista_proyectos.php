<?php
require_once("funciones.php");
if (valida("Proyectos")=="bad") {header("location: pagina_error.php");}
include ("top.php");
?>
 <TABLE WIDTH="80%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">
	<TR bgcolor="#006699" align="center" valign="middle"> 
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
		  if ($row[Ans]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
          echo "<td><a ".$clas." href=\"nservicio.php?Naveg=Gestion >> ANS\">ANS</a></td>";
		  if ($row[Clasificacion]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
          echo "<td><a ".$clas." href=\"ast11.php?Naveg=Gestion >> Clasificacion\">CLASIFICACION</a></td>";
		  if ($row[Actas]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"lista_agenda.php?Naveg=Gestion >> Actas\">ACTAS</a></td>";
		  if ($row[Vacaciones]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"lista_vacaciones.php?Naveg=Gestion >> Vacaciones\">VACACIONES</a></td>";
		  if ($row[Riesgo]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"riesgo-opciones.php?Naveg=Gestion >> Riesgos\">RIESGOS</a></td>";
?>
</TR>
</TABLE>
<br>
  <TABLE WIDTH="70%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">	
	<TR bgcolor="#006699" align="center" valign="middle"> 
<?php
          echo "<td><a class=\"menu\" href=\"lista_solicproyecto.php?Naveg=Gestion >> Proyectos >> Solicitud de Proyectos\">SOLICITUD DE PROYECTOS</a></td>";
          echo "<td><a class=\"menu\" href=\"lista_admyaseg.php?Naveg=Gestion >> Proyectos >> Administracion y Aseguramiento\">ADMINISTRACION Y ASEGURAMIENTO</a></td>";
		  echo "<td><a class=\"menu\" href=\"lista_analisisriesgos.php?Naveg=Gestion >> Proyectos >> Analisis de Riesgos\">ANALISIS DE RIESGOS</a></td>";
		  echo "<td><a class=\"menu\" href=\"lista_anayplanifcostos.php?Naveg=Gestion >> Proyectos >> Factibilidad Economica\">FACTIBILIDAD ECONOMICA</a></td>";
?>
</TR>
</TABLE>
<?php
include ("pagina_inicio2.php");
include ("top_.php");
?>
