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
require_once('funciones.php');
$IdFicha=SanitizeString($_GET['IdFicha']);
$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc FROM datfichatec WHERE IdFicha='$IdFicha'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?>
<html>
<head>
<title> GesTor F1 - SOPORTE TÉCNICO-PROAST - FICHAS TÉCNICAS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<style>

.titulo{
  color: #000000;
  font-family:  verdana;
  font-size: 13px;
  font-weight: bold;
}

.titulo2{
  color: #000000;
  font-family:  verdana;
  font-size: 11px;
  font-weight: bold;
}


.subtitulo{
  color: #000000;
  font-family:  verdana;
  font-size: 11px;
  font-weight: bold;
}


.numero{
  color: #000000;
  font-family:  verdana;
  font-size: 13px;
  font-weight: bold;
}

.datos{
  color: #000000;
  font-family: verdana;
  font-size: 9px;
  font-weight: bold;
}

.header{
  color: #000000;
  font-family: verdana;
  font-size: 9px;
  font-weight: bold;
}


.info{
  color: #000000;
  font-family: verdana;
  font-size: 10px;
}
.valores{
  color: #000000;
  font-family: verdana;
  font-size: 10px;
}

</style>
<body bgcolor="#FFFFFF">
<p>
<?php
include("datos_gral.php");
?>
<br>
<table width="100%" align="center">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="79%" class="titulo" align="center">REGISTRO DE &quot;<?php echo strtoupper ($row['TpRegFicha']);?>&quot; - FICHA TECNICA</td>
          <td width="21%" class="titulo" align="right">NRO. FICHA : <?php echo $row['IdFicha'];?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<hr>
<table width="100%" align="center" cellpadding="2" cellspacing="2" style="border: solid 1px">
  <tr style="border:solid 2px"> 
    <td width="136" class="datos">FECHA DE PRUEBA DE FUNCIONAMIENTO:</td>
    <td class="valores"><?php echo $row['FechPruFunc'];?></td>
    <td width="149" class="datos">REALIZADO POR:</td>
    <td width="398" colspan="3" class="valores">
	<?php 
		$sql4 = "SELECT * FROM users WHERE login_usr='$row[RealizFicha]'";
		$result4=mysql_query($sql4);
		$row4=mysql_fetch_array($result4);
		echo $row4['nom_usr']." ".$row4['apa_usr']." ".$row4['ama_usr'];
	?>	</td>
  </tr>
  <tr> 
    <td width="136" class="datos">MODELO:</td>
    <td width="248" class="valores"><?php echo $row['Modelo'];?></td>
    <td width="149" class="datos">CODIGO DE ACTIVO FIJO:</td>
    <td colspan="3" class="valores"><?php echo $row['CodActFijo'];?></td>
  </tr>
</table>
<br>
<!------------------------------------------------------------------->
<br>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center" class="titulo">ASIGNADO A : / EN CUSTODIO DE :</td>
  </tr>
</table>
<hr>
<table width="100%" border="1" align="center">
  <tr bgcolor="#CCCCCC"> 
    <th width="26%" align="center" class="header">NOMBRE</th>
    <th width="20%" align="center" class="header">ÁREA</th>
    <th width="13%" align="center" class="header">FECHA RECEPCIÓN</th>
    <th width="14%" align="center" class="header">FIRMA DE RECEPCIÓN</th>
    <th width="13%" align="center" class="header">FECHA DEVOLUCIÓN</th>
    <th width="14%" align="center" class="header">FIRMA DEVOLUCIÓN</th>
  </tr>
  <?php 	
  $sql3 = "SELECT *,DATE_FORMAT(Fecha,'%d / %m / %Y') as Fecha,DATE_FORMAT(FechaD,'%d / %m / %Y') as FechaD FROM asigcustficha WHERE IdFicha='$IdFicha'";
  $result3=mysql_query($sql3);
  while ($row3=mysql_fetch_array($result3)) 
{ ?>
  <tr> 
    <td height="45" class="valores"> <div align="center"><font size="1"> 
        <?php 
	$sql4 = "SELECT * FROM users WHERE login_usr='$row3[NombAsig]'";
	$result4=mysql_query($sql4);
	$row4=mysql_fetch_array($result4);
	echo $row4['nom_usr']." ".$row4['apa_usr']." ".$row4['ama_usr'];
	?>
        </font></div></td>
    <td height="45" class="valores"> <div align="center"><font size="1"><?php echo $row3['Area'];?></font></div></td>
    <td height="45" class="valores"> <div align="center"><font size="1">&nbsp;<?php echo $row3['Fecha'];?></font></div></td>
    <td height="45" class="valores"><font size="2">&nbsp;</font></td>
    <td height="45" class="valores"> <div align="center"><font size="1">&nbsp;<?php echo $row3['FechaD'];?></font></div></td>
    <td height="45" class="valores"><font size="2">&nbsp;</font></td>
  </tr>
  <?php  } ?>
</table>
</body>
</html>