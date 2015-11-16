<?php
include ("top.php");
?>
  <TABLE WIDTH="70%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">	
	<TR bgcolor="#006699" align="center" valign="middle"> 
<?php
$sql="SELECT * FROM roles WHERE login_usr='$login'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);	

		  if ($row[Planificacion]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
          echo "<td><a ".$clas." href=\"lista_planifpru1.php?Naveg=Contingencia >> Planificacion\">PLANIFICACION</a></td>";
		  if ($row[Ejecucion]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"lista_pruebrecup.php?Naveg=Contingencia >> Ejecucion\">EJECUCION</a></td>";
		  if ($row[Evaluacion]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
          echo "<td><a ".$clas." href=\"lista_planifpru2.php?Naveg=Contingencia >> Evaluacion\">EVALUACION</a></td>";
		  if ($row[Calen_cont]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
          echo "<td><a ".$clas." href=\"lista_calen_cont.php?Naveg=Contingencia >> Calendarizacion\">CALENDARIZACION</a></td>";
?>
</TR>
</TABLE>
<?php
include ("pagina_inicio2.php");
include ("top_.php");
?>
