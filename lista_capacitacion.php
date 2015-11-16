<?php
require_once("funciones.php");
if (valida("Capacitacion")=="bad") {header("location: pagina_error.php");}
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
		   if ($row[Capacitacion]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"lista_capacitacion.php?Naveg=Gestion >> Capacitacion\">CAPACITACION</a></td>";

?>
</TR>
</TABLE>
<br>
<TABLE WIDTH="60%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">	
<TR bgcolor="#006699" align="center" valign="middle"> 
<?php
       
         if ($tipo=="A" OR $tipo=="B")
		  { ?>
		  
    <td><a class="menu" href="prueba/listasusu.php?Naveg=Gestion >> Capacitacion >> Lista">LISTA DE EVALUACIONES REALIZADAS</a></td>
		  <td><a class="menu" href="preguntas.php?Naveg=Gestion >> Capacitacion >> Ingresar Preguntas">INGRESAR NUEVAS PREGUNTAS</a></td>
		  <td><div style="cursor:hand"><a class="menu" onClick="generar()"><u>GENERAR PREGUNTAS</u></a></td>
		  <?php }
		  if ($tipo=="T")
		  { ?>
		  <td><a class="menu" href="prueba\listas.php?Naveg=Gestion >> Capacitacion >> Lista">LISTA DE EVALUACIONES REALIZADAS</a></td>
		  <td><div style="cursor:hand"><a class="menu" onClick="inicioexa()"><u>INGRESO A LA EVALUACIÓN</u></a></div></td>
<?php		  }
		  
?>
</TR>
</TABLE>
<?php
include ("pagina_inicio2.php");
include ("top_.php");
?>
<script language="JavaScript">
<!--
function inicioexa(url_pop) {
	window.open('login.php','YanapTI','toolbar=no,status=no,menubar=no,location=no,directories=no,resizable=yes,scrollbars=yes');
}
function generar() {
	window.open('preguntas_generadom.php',"YanapTI",'toolbar=no,status=no,menubar=no,top=300,left=100,location=no,directories=no,scrollbars=no, width=740, height=200');
}
-->
</script>