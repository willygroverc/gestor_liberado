<?php
include ("top.php");
?>
<p>
 <TABLE WIDTH="100%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">
    <TR bgcolor="#006699" align="center"> 
<?php $sql="SELECT * FROM roles WHERE login_usr='$login'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);	

		if ($row['Usuarios']=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL	
		echo "<td><a ".$clas." href=\"lista_control_usr.php?Naveg=Seguridad >> Control de Usuarios\">CONTROL DE USUARIOS</a></td>";
		if ($row['PistasAudi']=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL	
        echo "<td><a ".$clas." href=\"auditoria.php?Naveg=Seguridad >> Backup de la Base de Datos\">BACKUP DE LA BASE DE DATOS</a></td>";
		if ($row['Hash']=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL	
        echo "<td><a ".$clas." href=\"calcula_hash.php?Naveg=Seguridad >> Calculadora Hash\">CALCULADORA HASH</a></td>";
		if ($tipo=="A" OR $tipo=="B")
		{	echo "<td><a class=\"menu\" href=\"menu_parametros.php?Naveg=Seguridad >> Menu de Parametros\">MENU DE PARAMETROS</a></td>";
		}
		if ($tipo=="A" OR $tipo=="B")
		{	echo "<td><a class=\"menu\" href=\"lista_telkey.php?Naveg=Seguridad >> TELKEY\">TELKEYS</a></td>";
		}
			
?>
	
</TR>
</TABLE>
</p>
<?php
 include ("pagina_inicio2.php"); 
 include ("top_.php"); ?>