<?php
include ("top.php");
?>
  <TABLE WIDTH="80%" height="19" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">
    <TR bgcolor="#006699" align="center" valign="middle"> 
<?php
$sql ="SELECT * FROM roles WHERE login_usr='$login'";
$result = mysql_query($sql);
$row=mysql_fetch_array($result);
/*
  	      if ($row[PropyResp]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL		  
          echo "<td><a ".$clas." href=\"lista_sistemas.php?Naveg=Produccion >> Propietarios y Responsables\">PROPIETARIOS Y RESPONSABLES</a></td>";
		  if ($row[ControlTyH]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
          echo "<td><a ".$clas." href=\"lista_controltemp.php?Naveg=Produccion >> Control Temp. y Humedad\">CONTROL TEMP. Y HUMEDAD</a></td>";
		  if ($row[ControlInvent]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"lista_controlinvent.php?Naveg=Produccion >> Inventario de Medios\">INVENTARIO DE MEDIOS</a></td>";
		  if ($row[UbicacRespal]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
          echo "<td><a ".$clas." href=\"lista_ubicacionr.php?Naveg=Produccion >> Ubicacion de Respaldos\">UBICACION DE RESPALDOS</a></td>";
		  if ($row[Calendariza]=="r") {$clas="class=\"menu\"";} else {$clas="class=\"menu2\"";} //COLOR DEL ROL
		  echo "<td><a ".$clas." href=\"lista_progtareas.php?Naveg=Produccion >> Calendarizacion\">CALENDARIZACION</a></td>";*/
?>
</TR>
</TABLE>
<?php 
//include ("pagina_inicio2.php");
