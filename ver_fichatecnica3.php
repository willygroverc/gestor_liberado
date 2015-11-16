<?php 
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
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" >
  <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="4" cellspacing="0">
        <tr align=\"center\" bgcolor="#FFFFFF"> 
          <th height="14"><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">FECHA REALIZACION</font></th>
          <th><font face="Arial, Helvetica, sans-serif" color="#000000" size="1">TIPO DE REGISTRO</font></th>
          <th><font face="Arial, Helvetica, sans-serif" color="#000000" size="1">CODIGO 
            ADICIONAL</font></th>
		  <th><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">CODIGO DE ACTIVOS FIJOS</font></th>
		  <th><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">NUMERO DE SERIE</font></th>		  
          <th><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">MARCA</font></th>
		  <th><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">MODELO</font></th>
          <th><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">ASIGNADO A</font></th>
		  <th><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">PROVEEDOR</font></th>
        </tr>
        <?php
				
		$sql = "SELECT IdProv, NombProv FROM proveedor";
		$rs = mysql_db_query($db,$sql,$link);
		while ($tmp = mysql_fetch_array($rs)) {
			$lstProveedor[$tmp[IdProv]]=$tmp[NombProv];
		}		
		 if (strlen($DA) == 1){ $DA = "0".$DA; }
		 if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
         $fec1 = $AA."-".$MA."-".$DA;   
		 if (strlen($DE) == 1){ $DE = "0".$DE; }
		 if (strlen($ME) == 1){ $ME = "0".$ME; }
		 $fec2 = $AE."-".$ME."-".$DE; 
		 //echo $fec1;
		 //echo "<br>".$fec2;
		 $sql = "SELECT *, DATE_FORMAT(FechPruFunc, '%d/%m/%Y') as FechPruFunc FROM datfichatec 
		 WHERE FechPruFunc BETWEEN '$fec1' AND '$fec2'  ORDER BY FechPruFunc ASC";
		
		$sql2="SELECT IdFicha, CONCAT(nom_usr, ' ', apa_usr, ' ', ama_usr) AS nombre FROM asigcustficha, users WHERE asigcustficha.NombAsig=users.login_usr AND tipo1 IS NULL";
		$rs=mysql_db_query($db,$sql2,$link);
		while ($tmp=mysql_fetch_array($rs)) {
		$lstTecnico[$tmp[IdFicha]]=$tmp[nombre];
		}

$result=mysql_db_query($db,$sql,$link); 
while ($row=mysql_fetch_array($result)) {	
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[FechPruFunc]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[TpRegFicha]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[AdicUSI]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[CodActFijo]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[NumSerie]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[Marca]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[Modelo]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".$lstTecnico[$row[IdFicha]]."</font></td>";	
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".$lstProveedor[$row[Proveedor]]."</font></td>";	
	echo "</tr>";
}?>
      </table></td>
  </tr>
</table>
</body> 
</html>  