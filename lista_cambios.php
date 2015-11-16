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
		  if ($row[Modulos]=="r" OR $row[Archivos]=="r" OR $row[Repositorio]=="r" OR $row[Copia_trabajo]=="r" OR $row[Replica]=="r" OR $row[Revision]=="r" OR $row[Backups]=="r" OR $row[Pistas_fuentes]=="r") 
		  {$clas="class=\"menu\"";  //COLOR DEL ROL
          echo "<td><a ".$clas." href=\"admi_fuentes.php?Naveg=Cambios >> Administración de Fuentes\">ADMINISTRACION DE FUENTES</a></td>";
		  }
		  else 
		  {$clas="class=\"menu2\"";
		  echo "<td><a ".$clas." href=\"pagina_error.php?Naveg=Cambios >> Administracion de Fuentes\">ADMINISTRACION DE FUENTES</a></td>";
		  }
		  
		  if ($row[Pruebas]=="r") 
		  {$clas="class=\"menu\"";  //COLOR DEL ROL
          echo "<td WIDTH=\"30%\"><a ".$clas." href=\"lista_prueba_tipo.php?Naveg=Cambios >> Pruebas\">PRUEBAS</a></td>";
		  }
		  else 
		  {$clas="class=\"menu2\"";
		  echo "<td><a ".$clas." href=\"pagina_error.php?Naveg=Cambios >> Pruebas\">PRUEBAS</a></td>";
		  }
		  
		  /*if ($row[Solicitud]=="r") 
		  {$clas="class=\"menu\"";
		  echo "<td><a ".$clas." href=\"acp/lista_soliccambios.php?Naveg=Cambios >> Solicitud de Cambios\">SOLICITUD DE CAMBIOS</a></td>";
		  /*} 
		  else {$clas="class=\"menu2\""; //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"pagina_error.php?Naveg=Cambios >> Maestro de Cambios\">MAESTRO DE CAMBIOS</a></td>";}
		  		  
		  if ($row[Maestro]=="r") 
		  {$clas="class=\"menu\"";
		  echo "<td><a ".$clas." href=\"lista_maestro.php?Naveg=Cambios >> Maestro de Cambios\">MAESTRO DE CAMBIOS</a></td>";
		  } 
		  else {$clas="class=\"menu2\""; //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"pagina_error.php?Naveg=Cambios >> Maestro de Cambios\">MAESTRO DE CAMBIOS</a></td>";}
		  
		 */
?>
</TR>
</TABLE>
<?php
include ("pagina_inicio2.php");
include ("top_.php");
?>
