<?php include ("top.php");?>
<TABLE WIDTH="760" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">
<TR bgcolor="#006699" align="center" valign="middle"> 
<?php
$sql="SELECT * FROM roles WHERE login_usr='$login'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);	

          if ($row['FichasTecnicas']=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"lista_ficha.php?Naveg=Soporte Tecnico >> Fichas Tecnicas\">FICHAS TECNICAS</a></td>";
		  if ($row['MantFuera']=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
          echo "<td><a ".$clas." href=\"controlmantenprincipal.php?Naveg=Soporte Tecnico >> Control de Mantenimiento\">CONTROL DE MANTENIMIENTO</a></td>";
		  if ($row['Cronograma']=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"lista_calen.php?Naveg=Soporte Tecnico >> Cronograma\">CRONOGRAMA</a></td>";
?>
</TR>
</TABLE>
<?php 
include ("pagina_inicio2.php");
include("top_.php");?> 