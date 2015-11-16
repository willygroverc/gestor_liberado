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
<title> GesTor F1 - FICHA TECNICA</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">FICHA TECNICA</font></u></b></div></td>
  </tr>
</table>
<br>

<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" >
  <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="4" cellspacing="0">
        <tr align=\"center\" bgcolor="#CCCCCC"> 
          <th height="14"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">FECHA REALIZACION</font></strong></th>
          <th><strong><font face="Arial, Helvetica, sans-serif" color="#000000" size="2">TIPO DE REGISTRO</font></strong></th>
          <th><strong><font face="Arial, Helvetica, sans-serif" color="#000000" size="2">CODIGO 
            ADICIONAL</font></strong></th>
		  <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">CODIGO DE ACTIVOS FIJOS</font></strong></th>
		  <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">NUMERO DE SERIE</font></strong></th>		  
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">MARCA</font></strong></th>
		  <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">MODELO</font></strong></th>
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">ASIGNADO A</font></strong></th>
		  <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">PROVEEDOR</font></strong></th>
        </tr>
        <?php
		$sql = "SELECT IdProv, NombProv FROM proveedor";
		$rs = mysql_query($sql);
		while ($tmp = mysql_fetch_array($rs)) {
			$lstProveedor[$tmp['IdProv']]=$tmp['NombProv'];
		}
		switch ($_REQUEST['menu']) {
			case "TODO":
				$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc FROM datfichatec ORDER BY CodUsr DESC";
				break;
			case "Computadores de Escritorio":
				$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc FROM datfichatec WHERE TpRegFicha='Computadores de Escritorio' and Elim <> 1 ORDER BY AdicUSI";
				break;
			case "Computadores Portatiles":
				$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc FROM datfichatec WHERE TpRegFicha='Computadores Portatiles' and Elim <> 1 ORDER BY AdicUSI";
				break;
			case "Servidores":
				$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc FROM datfichatec WHERE TpRegFicha='Servidores' and Elim <> 1 ORDER BY AdicUSI";
				break;
				case "Monitores":
				$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc FROM datfichatec WHERE TpRegFicha='Monitores' and Elim <> 1 ORDER BY AdicUSI";
				break;
				case "Multimedia":
				$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc FROM datfichatec WHERE TpRegFicha='Multimedia' and Elim <> 1 ORDER BY AdicUSI";
				break;
				case "Impresoras":
				$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc FROM datfichatec WHERE TpRegFicha='Impresoras' and Elim <> 1 ORDER BY AdicUSI";
				break;
				case "Red":
				$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc FROM datfichatec WHERE TpRegFicha='Red' and Elim <> 1 ORDER BY AdicUSI";
				break;
				case "Telefonia":
				$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc FROM datfichatec WHERE TpRegFicha='Telefonia' and Elim <> 1 ORDER BY AdicUSI";
				break;
				case "UPS":
				$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc FROM datfichatec WHERE TpRegFicha='UPS' and Elim <> 1 ORDER BY AdicUSI";
				break;
			case "Otros":
				$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc FROM datfichatec WHERE TpRegFicha='Otros' and Elim <> 1 ORDER BY AdicUSI";
				break;
			default:
				$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc FROM datfichatec ORDER BY AdicUSI";
				break;
		}
		
$sql2="SELECT IdFicha, CONCAT(nom_usr, ' ', apa_usr, ' ', ama_usr) AS nombre FROM asigcustficha, users WHERE asigcustficha.NombAsig=users.login_usr AND tipo1 IS NULL";
$rs=mysql_query($sql2);
while ($tmp=mysql_fetch_array($rs)) {
	$lstTecnico[$tmp['IdFicha']]=$tmp['nombre'];
}
/*$sql2="SELECT IdProv, NombProv FROM proveedor";
$rs=mysql_query($sql2);
while ($tmp=mysql_fetch_array($rs)) {
	$lstProveedor[$tmp[IdProv]]=$tmp[NombProv];
}
*/
$result=mysql_query($sql); 
while ($row=mysql_fetch_array($result)) {	
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[FechPruFunc]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[TpRegFicha]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[AdicUSI]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[CodActFijo]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[NumSerie]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[Marca]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[Modelo]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".isset($lstTecnico[$row['IdFicha']])."</font></td>";	
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".$lstProveedor[$row['Proveedor']]."</font></td>";	
	echo "</tr>";
}?>
      </table></td>
  </tr>
</table>
</body>    
</html>