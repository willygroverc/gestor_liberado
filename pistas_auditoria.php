<?php
include ("top.php");
?>
 <TABLE WIDTH="80%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">
    <TR bgcolor="#006699" align="center" valign="middle"> 
<?php
$sql="SELECT * FROM roles WHERE login_usr='$login'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);	
/*
		  if ($row[Repositorio]=="r") {
		  $clas="class=\"menu\"";
          echo "<td><a ".$clas." href=\"lista_carpetas.php?id=repositorio&Naveg=Cambios >> Administracion de Fuentes >> Repositorio\">REPOSITORIO</a></td>";
		  } else {
		  $clas="class=\"menu2\"";
          echo "<td><a ".$clas." href=\"pagina_error.php\">REPOSITORIO</a></td>";}
		  
		  if ($row[Copia_trabajo]=="r") {
		  $clas="class=\"menu\"";
          echo "<td><a ".$clas." href=\"lista_carpetas.php?id=ctrabajo&Naveg=Cambios >> Administracion de Fuentes >> Copia de Trabajo\">COPIA DE TRABAJO</a></td>";
		  } else {
		  $clas="class=\"menu2\"";
          echo "<td><a ".$clas." href=\"pagina_error.php\">COPIA DE TRABAJO</a></td>";}

 		  if ($row[Replica]=="r") {
		  $clas="class=\"menu\"";
		  echo "<td><a ".$clas." href=\"lista_carpetas.php?id=replica&Naveg=Cambios >> Administracion de Fuentes >> Replica\">REPLICA</a></td>";
		  } else {
		  $clas="class=\"menu2\"";
		  echo "<td><a ".$clas." href=\"pagina_error.php\">REPLICA</a></td>";}
		  
		  if ($row[Revision]=="r") {
		  $clas="class=\"menu\"";
		  echo "<td><a ".$clas." href=\"lista_carpetas.php?id=revision&Naveg=Cambios >> Administracion de Fuentes >> Revision\">REVISION</a></td>";
		  } else {
		  $clas="class=\"menu2\"";
		  echo "<td><a ".$clas." href=\"pagina_error.php\">REVISION</a></td>";}
		  
		  if ($row[Modulos]=="r") {
		  $clas="class=\"menu\"";
          echo "<td><a ".$clas." href=\"modulos.php?Naveg=Cambios >> Administracion de Fuentes >> Modulos\">MODULOS</a></td>";
		  } else {
		  $clas="class=\"menu2\"";
          echo "<td><a ".$clas." href=\"pagina_error.php\">MODULOS</a></td>";}
		  
		  if ($row[Archivos]=="r") {
		  $clas="class=\"menu\"";
		  echo "<td><a ".$clas." href=\"lista_archivos.php?Naveg=Cambios >> Administracion de Fuentes >> Archivos\">ARCHIVOS</a></td>";
		  } else {
		  $clas="class=\"menu2\"";
		  echo "<td><a ".$clas." href=\"pagina_error.php\">ARCHIVOS</a></td>";}
		  
		  if ($row[Backups]=="r") {
		  $clas="class=\"menu\"";
		  echo "<td><a ".$clas." href=\"lista_backups.php?Naveg=Cambios >> Administracion de Fuentes >> Backups\">BACKUPS</a></td>";
		  } else {
		  $clas="class=\"menu2\"";
		  echo "<td><a ".$clas." href=\"pagina_error.php\">BACKUPS</a></td>";}
 		  
		  if ($row[Pistas_fuentes]=="r") {
		  $clas="class=\"menu\"";
          echo "<td><a ".$clas." href=\"pistas_auditoria.php?Naveg=Cambios >> Administracion de Fuentes >> Pistas de Auditoria\">PISTAS DE AUDITORIA</a></td>";
		  } else {
		  $clas="class=\"menu2\"";
          echo "<td><a ".$clas." href=\"pagina_error.php\">PISTAS DE AUDITORIA</a></td>";}*/

?>
</TR>
</TABLE>
<br>
<TABLE WIDTH="40%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">
    <TR bgcolor="#006699" align="center" valign="middle"> 
<?php
		  $clas="class=\"menu\"";
          echo "<td background=\"images/main-button-tileR2.jpg\"><a ".$clas." href=\"pistas_fuentes.php?Naveg=Cambios >> Administracion de Fuentes >> Pistas de Auditoria >> Copia Pistas\">COPIA DE PISTAS DE AUDITORIA</a></td>";
          echo "<td background=\"images/main-button-tileR2.jpg\"><a ".$clas." href=\"pistas_fuentes2.php?Naveg=Cambios >> Administracion de Fuentes >> Pistas de Auditoria >> Ver Pistas\">VER PISTAS DE AUDITORIA</a></td>";

?>
</TR>
</TABLE>
  <?php 
  include ("pagina_inicio2.php");
  include("top_.php");?> 