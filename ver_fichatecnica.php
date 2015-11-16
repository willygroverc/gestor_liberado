<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Sanitizacion de variables para evitar ataques de SQL injection
// Fecha: 		02/OCT/2013
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include ("top_ver.php");
require_once('funciones.php');
$sql = "SELECT IdProv, NombProv FROM proveedor";
$rs = mysql_query($sql);
while ($tmp = mysql_fetch_array($rs)) {
	$lstProveedor[$tmp['IdProv']]=$tmp['NombProv'];
}
$IdFicha=SanitizeString($_GET['IdFicha']);
$sql = "SELECT *,DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc,DATE_FORMAT(FechAlta,'%d / %m / %Y') as FechAlta,".
       "DATE_FORMAT(GarantDe,'%d / %m / %Y') as GarantDe,DATE_FORMAT(GarantAl,'%d / %m / %Y') as GarantAl FROM datfichatec WHERE IdFicha='$IdFicha'";
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
  font-size: 9px;
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
    <td width="165" class="datos">REALIZADO POR:</td>
    <td colspan="3" class="valores">
	<?php 
		$sql4 = "SELECT * FROM users WHERE login_usr='$row[RealizFicha]'";
		$result4=mysql_query($sql4);
		$row4=mysql_fetch_array($result4);
		echo $row4['nom_usr']." ".$row4['apa_usr']." ".$row4['ama_usr'];
	?>
	</td>
  </tr>
  <tr> 
    <td width="136" class="datos">MARCA:</td>
    <td width="291" class="valores"><?php echo $row['Marca'];?></td>
    <td width="165" class="datos">CODIGO ADICIONAL:</td>
    <td colspan="3" class="valores"><?php echo $row['AdicUSI'];?></td>
  </tr>
  <tr> 
    <td width="136" class="datos">MODELO:</td>
    <td width="291" class="valores"><?php echo $row['Modelo'];?></td>
    <td width="165" class="datos">CODIGO DE ACTIVO FIJO:</td>
    <td colspan="3" class="valores"><?php echo $row['CodActFijo'];?></td>
  </tr>
  <tr> 
    <td width="136" class="datos" bgcolor="">NUMERO DE SERIE:</td>
    <td width="291" class="valores"><?php echo $row['NumSerie'];?></td>
    <td width="165" class="datos">FECHA DE ALTA: </td>
    <td colspan="3" class="valores"><?php echo $row['FechAlta'];?></td>
  </tr>
  <tr> 
    <td width="136" class="datos">PROVEEDOR:</td>
    <td width="291" class="valores"><?php echo $lstProveedor[$row['Proveedor']];?></td>
    <td width="165" class="datos">GARANTIA DEL:</td>
    <td width="141" class="valores"><?php echo $row['GarantDe'];?></td>
    <td width="31" class="datos">AL </td>
    <td width="155" class="valores"><?php echo $row['GarantAl'];?></div></td>
  </tr>
  <tr> 
    <td width="136" class="datos">ASIGNADO A:</td>
    <?php
		$sql2 = "SELECT MAX(IdCust) AS ID FROM asigcustficha WHERE IdFicha='$IdFicha'";
		$result2 = mysql_query($sql2);
		$row2 = mysql_fetch_array($result2);
		$sql3 = "SELECT *, DATE_FORMAT(Fecha, '%d/%m/%Y') AS Fecha FROM asigcustficha WHERE IdCust='$row2[ID]'"; //HERE
		$result3 = mysql_query($sql3);
		$row3 = mysql_fetch_array($result3);
		if (($row3['Tipo']=="Asignado" AND $row3['Tipo1']=="Devuelto")OR(!$row3['Tipo'] AND !$row3['Tipo1']))
		{	
			echo "<td class='valores'><font size=\"1\">Disponible</font></td>";	
		}
		else if ($row3['Tipo']=="Asignado" AND $row3['Tipo1']=="")
		{	
			$sql7="SELECT * FROM users WHERE login_usr='$row3[NombAsig]'";
			$result7=mysql_query($sql7);
			$row7=mysql_fetch_array($result7);	
			echo "<td class='valores'><font size=\"1\">$row7[nom_usr] $row7[apa_usr] $row7[ama_usr]</font></td>";	
		}
		
	?>
  </tr>
</table>
<br>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="titulo2">CARACTERISTICAS DEL EQUIPO (VELOCIDAD, HD, RAM)</td>
  </tr>
</table>
<hr>
<table width="100%" border="1" align="center">
  <tr bgcolor="#CCCCCC"> 
    <th width="33%" class="header">ACCESORIOS</th>
    <th width="14%" class="header">CAPACIDAD</th>
    <th width="13%" class="header">VELOCIDAD</th>
    <th width="13%" class="header">MARCA</th>
    <th width="14%" class="header">MODELO / SERIE</th>
    <th width="13%" class="header">ADICIONAL</th>
  </tr>
  <?php 	
  	  	$aux="info";
		$sql_aux="SELECT MAX(idTabla) AS nom FROM caracfichtec WHERE IdFicha='$IdFicha' GROUP BY idTabla";
		//echo $sql_aux;
		$result=mysql_query($sql_aux);
		while($row=mysql_fetch_array($result)){
		 	$aux.=",'".$row['nom']."'";
		}
		$aux=str_replace("info,","",$aux);
		$sql2 = "SELECT * FROM caracfichtec WHERE idTabla IN ($aux) ORDER BY IdFicha ASC";
		//echo $sql2;
	  $sql2 = "SELECT * FROM caracfichtec WHERE IdFicha='$IdFicha'";
	$result2=mysql_query($sql2);
	while ($row2=mysql_fetch_array($result2)) 
{ ?>
  <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['Accesorio'];?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['Capacid'];?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['Veloc'];?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['Marca'];?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['ModSerie'];?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['Adicio'];?></font></div></td>
  </tr>
  <?php }?>
</table>
<br><br>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center" class="titulo2">CARACTERISTICAS DEL SOFTWARE</td>
  </tr>
</table>
<hr>
<table width="100%" border="1" align="center">
  <tr bgcolor="#CCCCCC"> 
    <th width="33%" height="21" class="header">SOFTWARE</th>
    <th width="14%" class="header">TIPO</th>
    <th width="13%" class="header">PLATAFORMA</th>
    <th width="13%" class="header">COMPAÑIA</th>
    <th width="14%" class="header">VERSIÓN</th>
    <th width="13%" class="header">ADICIONAL</th>
  </tr>
  <?php 	
  	$aux="info";
	$sql_aux="SELECT MAX(idTabla) AS nom FROM ficha_software WHERE IdFicha='$IdFicha' GROUP BY idTabla";
	$result=mysql_query($sql_aux);
	while($row=mysql_fetch_array($result)){
	  	$aux.=",'".$row['nom']."'";
	}
	$aux=str_replace("info,","",$aux);
	$sql2 = "SELECT * FROM ficha_software WHERE idTabla IN ('".$aux."') ORDER BY IdFicha ASC";
//    $sql2 = "SELECT * FROM ficha_software WHERE IdFicha='$IdFicha'";
	$result2=mysql_query($sql2);
	while ($row2=mysql_fetch_array($result2)) 
{ ?>
  <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['soft'];?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['tipo'];?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['plataforma'];?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['comp'];?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['ver'];?></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['adicio'];?></font></div></td>
  </tr>
  <?php }?>
</table>
<br><br>
<table  width="637" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="4" align="center" class="titulo2">HISTORIAL MANTENIMIENTO</td>
  </tr>
</table>
<hr>
<table  width="637" align="center" border="1">
  <tr bgcolor="#CCCCCC"> 
    <td height="20" class="header">MANTENIMIENTO</td>
    <td class="header">TIPO DE MANTENIMIENTO</td>
    <td class="header">FECHA</td>
    <td class="header">REALIZADO POR</td>
  </tr>
  <?php
$sql_x="SELECT * FROM pcontrol WHERE AdicUSI='$row[AdicUSI]'";
$res_x=mysql_query($sql_x);
while($row_x=mysql_fetch_array($res_x)){
	echo "<tr align=\"center\">";
	if($row_x['tipo_mant2']=="E"){$tm="EXTERNO";}
	elseif($row_x['tipo_mant2']=="I"){$tm="INTERNO";}
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$tm</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$row_x[tipo_mant]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$row_x[fecha_s]</font></td>";
	$sel="SELECT CONCAT(nom_usr,' ',apa_usr,' ',ama_usr) AS nombre FROM users WHERE login_usr='$row_x[login_usr]'";
	$res_sel=mysql_query($sel);
	$row_sel=mysql_fetch_array($res_sel);
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$row_sel[nombre]</font></td>";
}
?>
</table>
</body>
</html>