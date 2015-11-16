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
include ('funciones.inc.php');
?>
<html>
<head>
	<title> GesTor F1 - PRODUCCI�N-PROAPD - UBICACI�N DE RESPALDOS</title>
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
      <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">UBICACION DE RESPALDOS</font></u></b></div>
    </td>
  </tr>
</table>
<br>
<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
    <td width="9%" rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CODIGO</strong></font></div></td>
    <td width="12%" rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>TIPO</strong></font></div></td>
    <td width="12%" rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA</strong></font></div></td>
    <td width="31%" rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CONTENIDO</strong></font></div></td>
    <td colspan="4"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>UBICACION</strong></font></div></td>
	<td width="12%" rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES</strong></font></div></td>
  </tr>
  
  <tr bgcolor="#CCCCCC"> 
    <td width="11%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SISTEMA</strong></font></div></td>
    <td width="11%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NEGOCIO</strong></font></div></td>
    <td width="11%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>EXTERNO1</strong></font></div></td>
    <td width="11%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>EXTERNO2</strong></font></div></td>
  </tr>
  <?php   $general=$_REQUEST['general'];
          $sistema=$_REQUEST['sistema'];
          $negocio=$_REQUEST['negocio'];
          $SE1=$_REQUEST['SE1'];
          $SE2=$_REQUEST['SE2'];
  		if ($general=="1" or ($general=="0" and $sistema=="0" and $negocio=="0" and $SE1=="0" and $SE2=="0"))
		{	
			$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp ORDER BY codigo DESC";
		}
		else
  		{											
			if  ($sistema == "1" && $negocio=="0" && $SE1=="0" && $SE2=="0")	
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_sistema='$sistema'  ORDER BY codigo DESC";			
				
			if ($sistema == "1" && $negocio=="1" && $SE1=="0" && $SE2=="0")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 	
				WHERE ubi_sistema='$sistema' AND ubi_Negocio='$negocio' ORDER BY codigo DESC";			
			if ($sistema == "1" && $negocio=="1" && $SE1=="1" && $SE2=="0")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_sistema='$sistema' AND ubi_Negocio='$negocio'  AND ubi_SE1='$SE1' ORDER BY codigo DESC";			
			if ($sistema == "1" && $negocio=="1" && $SE1=="1" && $SE2=="1")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_sistema='$sistema' AND ubi_Negocio='$negocio'  AND ubi_SE1='$SE1' AND ubi_SE2='$SE2' ORDER BY codigo DESC";			
			
			if  ($negocio == "1" && $sistema=="0" && $SE1=="0" && $SE2=="0")	
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_Negocio='$negocio' ORDER BY codigo DESC";				
		
			if  ( $SE1 == "1" && $sistema=="0" && $negocio=="0" && $SE2=="0")	
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE1='$SE1' ORDER BY codigo DESC";				

			if  ( $SE2 == "1" && $sistema=="0" && $negocio=="0" && $SE1=="0")	
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE2='$SE2' ORDER BY codigo DESC";				

			if ($sistema == "1" && $negocio=="0" && $SE1=="1" && $SE2=="0")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_sistema='$sistema'  AND ubi_SE1='$SE1' ORDER BY codigo DESC";				
							
			if ($sistema == "1" && $negocio=="0" && $SE1=="0" && $SE2=="1")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_sistema='$sistema'  AND ubi_SE2='$SE2' ORDER BY codigo DESC";				
			
			if ($negocio == "1" && $sistema=="0" && $SE1=="1" && $SE2=="0")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_Negocio='$negocio' AND ubi_SE1='$SE1' ORDER BY codigo DESC";				
			
			if ($negocio == "1" && $sistema=="0" && $SE1=="0" && $SE2=="1")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_Negocio='$negocio' AND ubi_SE2='$SE2' ORDER BY codigo DESC";				
			
			if ($SE1 == "1" && $sistema=="0" && $negocio=="1" && $SE2=="0")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE1='$SE1' AND  ubi_Negocio='$negocio' ORDER BY codigo DESC";				
			
			if ($SE1 == "1" && $sistema=="0" && $negocio=="0" && $SE2=="1")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE1='$SE1' AND ubi_SE2='$SE2' ORDER BY codigo DESC";				
			
			if ($SE2 == "1" && $sistema=="0" && $SE1=="0" && $negocio=="1")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE2='$SE2' AND ubi_Negocio='$negocio' ORDER BY codigo DESC";				
			
			if ($SE2 == "1" && $sistema=="1" && $SE1=="0" && $Snegocio=="0")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE2='$SE2' AND ubi_sistema='$sistema' ORDER BY codigo DESC";							
			if ($sistema == "1" && $negocio=="0" && $SE1=="1" && $SE2=="1")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE2='$SE2' AND ubi_sistema='$sistema' AND ubi_SE1='$SE1' ORDER BY codigo DESC";							
			if ($sistema == "1" && $negocio=="1" && $SE1=="0" && $SE2=="1")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE2='$SE2' AND ubi_sistema='$sistema' AND ubi_Negocio='$negocio' ORDER BY codigo DESC";
			if ($sistema == "0" && $negocio=="1" && $SE1=="1" && $SE2=="1")
				$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp 
				WHERE ubi_SE2='$SE2' AND ubi_SE1='$SE1' AND ubi_Negocio='$negocio' ORDER BY codigo DESC";											
			
		}

		$result2=mysql_query($sql2);
		
		while($row2=mysql_fetch_array($result2)) 
  		{	?>
					<tr align="center"> 
					<td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $row2['codigo'];?></strong></font></div></td>
					<?php 
					$sql0="SELECT * FROM controlinvent WHERE Codigo='$row2[codigo]'";
					$result0=mysql_query($sql0);
					$row0=mysql_fetch_array($result0);
					?>
					<td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>&nbsp;<?php echo $row0['Tipo'];?></strong></font></div></td>
					<td><div align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['fecha'];?></font></strong></div></td>
					<td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>&nbsp;<?php echo $row2['contenido'];?></strong></font></div></td>
					<?php
							//echo "<br>".$row2[ubi_sistema];
						if  ($row2['ubi_sistema']=="1") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
						else{ echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}
						
						if  ($row2['ubi_negocio']=="1") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
						else{ echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}
												  
						if  ($row2['ubi_SE1']=="1") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
						else{ echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";} 
					
						if  ($row2['ubi_SE2']=="1") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
						else{ echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}
						echo "<td><font size='1' face='Arial, Helvetica, sans-serif'><strong>&nbsp;$row2[observ]</strong</font></td>";
						echo "</tr>";
					}//end while
					?>
</table>
<br>
<p>&nbsp;</p>
<p><br>
</p>
</body>
</html>