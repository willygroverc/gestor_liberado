<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
require('conexion.php');
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include("datos_gral.php");
?>
<html>
<head>
<title>Dominios</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<div align="center"><strong><u><font face="Arial, Helvetica, sans-serif">SEGUNDO NIVEL</font></u></strong> <br> <br>
  <table width="75%" border="1">
    <tr bgcolor="#CCCCCC"> 
      <td width="7%"><div align="center" class="normal"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Nro.</strong></font></div></td>
      <td width="27%"><div align="center" class="normal"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NIVEL 1</strong></font></div></td>
	  <td width="27%"><div align="center" class="normal"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE</strong></font></div></td>
      <td width="35%"><div align="center" class="normal"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DESCRIPCION</strong></font></div></td>
    </tr>
    <?php
	$i=1;
        $cod=$_REQUEST['cod'];
        $var=  isset($_REQUEST['var']);
	if($cod!="0") $var="WHERE id_area='$cod'";
	$sql="SELECT * FROM dominio $var order by id_dominio";
	$datos=mysql_query($sql);
	while ($dominio=mysql_fetch_array($datos)) {
	?>
    <tr> 
      <td height="23"><div align="center"><?php echo $i; ?></div></td>
	  <td><div align="center">
	  <?php 	$sql_area="SELECT area_nombre FROM area WHERE area_cod='$dominio[id_area]'";
	  		$res_area=mysql_query($sql_area);
			$row=mysql_fetch_array($res_area);
			echo $row['area_nombre'];
	  ?></div></td>
      <td><div align="center"><?php echo $dominio['dominio']; ?></div></td>
      <td><div align="center"><?php echo $dominio['descripcion']; ?></div></td>
    </tr>
    <?php
	$i++;
	}
	?>
  </table>
</div>
</body>
</html>
