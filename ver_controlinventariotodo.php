<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include ("top_ver.php");

?>
<html>
<head>
<title> GesTor F1 - PRODUCCI�N-PROAPD - INVENTARIO DE MEDIOS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<p>
<?php
include("datos_gral.php");
?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> 
      <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">INVENTARIO 
        DE MEDIOS DE RESPALDO - IMPRESION TOTAL</font></u></b></div>
    </td>
  </tr>
</table>
<br>
<br>
<table width="95%" border="1" cellpadding="0" cellspacing="0" align="center">
  <tr bgcolor="#CCCCCC"> 
    <td width="25%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CODIGO</strong></font></div></td>
    <td width="12%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
        ALTA </strong></font></div></td>
    <td width="12%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
        BAJA</strong></font></div></td>
    <td width="12%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
        DESTRUCCION </strong></font></div></td>
    <td width="35%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES</strong></font></div></td>
  </tr>
  <?php 
 	if(isset($_REQUEST['varia1']) && $_REQUEST['varia1']!="G"){$var1="codigo_usu='$_REQUEST[varia1]' AND ";}
	if(isset($_REQUEST['varia2']) && $_REQUEST['varia2']!="G"){$var2="tipo_medio='$_REQUEST[varia2]' AND ";}
	if(isset($_REQUEST['varia3']) && $_REQUEST['varia3']!="G"){$var3="tipo_dato='$_REQUEST[varia2]' AND ";}
	@$var_t=$var1.$var2.$var3." 1=1";
	
     $sql2 = "SELECT *,DATE_FORMAT(FechaAlta,'%d / %m / %Y') as FechaAlta,DATE_FORMAT(FechaBaja,'%d / %m / %Y') as FechaBaja,DATE_FORMAT(FechaDestruc,'%d / %m / %Y') as FechaDestruc 
  		  	  FROM controlinvent WHERE $var_t ORDER BY Codigo DESC";
  
	$result2=mysql_query($sql2);
	while($row2=mysql_fetch_array($result2)) 
  		{?>
    <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo "$row2[codigo_usu] - $row2[tipo_medio] - $row2[tipo_dato] - $row2[nro_cds] - $row2[nro_corre]"?> &nbsp;</font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row2['FechaAlta'];?></font></strong></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['FechaBaja'];?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['FechaDestruc'];?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['Observ'];?></font></div></td>
  </tr>
  <?php 
		 }
?>
</table>
<br>
<p>&nbsp;</p>
<p><br>
</p>
</body>
</html>