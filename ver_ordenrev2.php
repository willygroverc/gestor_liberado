<?php 
include ("top_ver.php");
include("datos_gral.php");


if(!empty($campos))
{	
	$campos="*".$campos."*";
	$campos=str_replace('*',',', $campos);
}
if($DA AND $MA AND $AA AND $DE AND $ME AND $AE)
{
	if (strlen($DA) == 1){ $DA = "0".$DA; }
	if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
    $fec1 = $AA."-".$MA."-".$DA;  
	$fec1_1 = $DA."/".$MA."/".$AA;    
	if (strlen($DE) == 1){ $DE = "0".$DE; }
	if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fec2 = $AE."-".$ME."-".$DE;
	$fec2_1 = $DE."/".$ME."/".$AE; 
}
function saca_nomb ($log)
{
	include("conexion.php");
	$sql_n="SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$log'";
	$row_n=mysql_fetch_array(mysql_db_query($db,$sql_n,$link));
	$nomb_comp="$row_n[nom_usr] $row_n[apa_usr] $row_n[ama_usr]";
	return $nomb_comp;
}
?>
<html>
<head>
<title> GesTor F1 - PROBLEMAS-PROAPI - PRODUCCIÓN</title>
</head>
<body>
<font size="2" face="Arial, Helvetica, sans-serif"><br>
<?php 
if($DA AND $MA AND $AA AND $DE AND $ME AND $AE)
{
	echo "&nbsp;<strong>Del:</strong> $fec1_1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Al:</strong> $fec2_1";
}
?>
</font> 
<table  width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699">
  <tr> 
    <td valign="top">
	<table width="100%"  border="1" align="center" cellpadding="0" cellspacing="2">
        <tr> 
          <th colspan="10"><font size="3" face="Arial, Helvetica, sans-serif">PROBLEMAS PRODUCCION - REVISION DEL DIA SIGUIENTE</font></th>
        </tr>
        <tr align=\"center\"> 
          <?php if(ereg(",1,", $campos)|| !$campos){?><th width="1%"><font size="2" face="Arial, Helvetica, sans-serif">Nro.Orden</font></th><?php }?>
          <?php if(ereg(",2,", $campos)|| !$campos){?><th width="15%"><font size="2" face="Arial, Helvetica, sans-serif">FECHA Y HORA DE ENVIO</font></th><?php }?>
          <?php if(ereg(",3,", $campos)|| !$campos){?><th width="20%"><font size="2" face="Arial, Helvetica, sans-serif">DESCRIPCION INCIDENCIA</font></th><?php }?>
          <?php if(ereg(",4,", $campos)|| !$campos){?><th width="13%"><font size="2" face="Arial, Helvetica, sans-serif">FECHA INICIO</font></th><?php }?>
          <?php if(ereg(",5,", $campos)|| !$campos){?><th width="12%"><font size="2" face="Arial, Helvetica, sans-serif">FECHA FIN</font></th><?php }?>
          <?php if(ereg(",6,", $campos)|| !$campos){?><th width="11%"><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABLE DE REVISION</font></th><?php }?>
          <?php if(ereg(",7,", $campos)|| !$campos){?><th width="13%"><font size="2" face="Arial, Helvetica, sans-serif">FECHA - REVISION</font></th><?php }?>
          <?php if(ereg(",8,", $campos)|| !$campos){?><th width="11%"><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABLE DE AUDITORIA</font></th><?php }?>
          <?php if(ereg(",9,", $campos)|| !$campos){?><th width="11%"><font size="2" face="Arial, Helvetica, sans-serif">FECHA - AUDITORIA</font></th><?php }?>
		  <?php if(ereg(",10,", $campos)|| !$campos){?><th width="11%"><font size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></th><?php }?>
        </tr>
<?php
if($DA AND $MA AND $AA AND $DE AND $ME AND $AE){$sql="SELECT * FROM detaller WHERE (Fecha_ini BETWEEN '$fec1' AND '$fec2') OR (Fecha_fin BETWEEN '$fec1' AND '$fec2') GROUP BY id_orden ORDER BY id_orden DESC";}
else{$sql = "SELECT * FROM detaller GROUP BY id_orden ORDER BY id_orden DESC";}
$result=mysql_db_query($db,$sql,$link);
while($row=mysql_fetch_array($result))
{
		echo "<tr align=\"center\">";
	// Nro de Orden
	if(ereg(",1,", $campos)|| !$campos)
	{
		echo "<td><font size=\"1\">$row[id_orden]</td>";
	}
		
	// Fecha y Hora de Envio
	
		$sql_o = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes WHERE id_orden='$row[id_orden]' ORDER BY id_orden DESC";
		$result_o=mysql_db_query($db,$sql_o,$link);
		$row_o=mysql_fetch_array($result_o);
		$fechahora="$row_o[fecha] - $row_o[time]";
	if(ereg(",2,", $campos)|| !$campos)
	{
		echo "<td><font size=\"1\">$fechahora</td>";
	}
	
	//Descripcion de Incidencia
	if(ereg(",3,", $campos)|| !$campos)
	{
		echo "<td><font size=\"1\">$row_o[desc_inc]</font></td>";
	}
	
	//Fecha de Inicio
	if(ereg(",4,", $campos)|| !$campos)
	{
		$sql_p = "SELECT DATE_FORMAT(MIN(Fecha_ini),'%d / %m / %Y') as Limberg FROM detaller WHERE id_orden='$row[id_orden]'";
		$result_p=mysql_db_query($db,$sql_p,$link);
		$row_p=mysql_fetch_array($result_p);
		
		echo "<td><font size=\"1\">$row_p[Limberg]</font></td>";
	}
	
	//Fecha de Fin
	if(ereg(",5,", $campos)|| !$campos)
	{
		$sql_p = "SELECT DATE_FORMAT(MAX(Fecha_fin),'%d / %m / %Y') as Limberg2 FROM detaller WHERE id_orden='$row[id_orden]'";
		$result_p=mysql_db_query($db,$sql_p,$link);
		$row_p=mysql_fetch_array($result_p);
		
		echo "<td><font size=\"1\">$row_p[Limberg2]</font></td>";
	}
	
	//Responsable de Revision
	if(ereg(",6,", $campos)|| !$campos)
	{
		$sql_r = "SELECT nomb_rrevision FROM revision WHERE id_orden='$row[id_orden]'";
		$result_r=mysql_db_query($db,$sql_r,$link);
		if($row_r=mysql_fetch_array($result_r))
		{
			$nombre=saca_nomb($row_r[nomb_rrevision]);
			echo "<td><font size=\"1\">$nombre</font></td>";
		}
		else
		{	
			echo "<td><font size=\"1\">SIN REVISION</font></td>";
		}
	}
	
	//Fecha de Reviison
	if(ereg(",7,", $campos)|| !$campos)
	{
		$sql_r = "SELECT DATE_FORMAT(fecha_rr ,'%d / %m / %Y') as Limberg3 FROM revision WHERE id_orden='$row[id_orden]'";
		$result_r=mysql_db_query($db,$sql_r,$link);
		if($row_r=mysql_fetch_array($result_r))
		{
			echo "<td><font size=\"1\">$row_r[Limberg3]</font></td>";
		}
		else
		{
			echo "<td><font size=\"1\">SIN REVISION</font></td>";
		}   
	}
	
	//Responsable de Auditoria
	if(ereg(",8,", $campos)|| !$campos)
	{
		$sql_r = "SELECT nomb_rauditoria FROM revision WHERE id_orden='$row[id_orden]'";
		$result_r=mysql_db_query($db,$sql_r,$link);
		if($row_r=mysql_fetch_array($result_r))
		{
			$nombre=saca_nomb($row_r[nomb_rauditoria]);
			echo "<td><font size=\"1\">$nombre</font></td>";
		}
		else
		{	
			echo "<td><font size=\"1\">SIN REVISION</font></td>";
		}
	}
	
	//Fecha de Revision
	if(ereg(",9,", $campos)|| !$campos)
	{
		$sql_r = "SELECT DATE_FORMAT(fecha_ra ,'%d / %m / %Y') as Limberg4 FROM revision WHERE id_orden='$row[id_orden]'";
		$result_r=mysql_db_query($db,$sql_r,$link);
		if($row_r=mysql_fetch_array($result_r))
		{
			echo "<td><font size=\"1\">$row_r[Limberg4]</font></td>";
		}
		else
		{
			echo "<td><font size=\"1\">SIN REVISION</font></td>";
		}   
	}
	
	//Observaciones
	if(ereg(",10,", $campos)|| !$campos)
	{
		$sql_r = "SELECT observaciones FROM revision WHERE id_orden='$row[id_orden]'";
		$result_r=mysql_db_query($db,$sql_r,$link);
		if($row_r=mysql_fetch_array($result_r))
		{
			echo "<td><font size=\"1\">$row_r[observaciones]</font></td>";
		}
		else
		{
			echo "<td><font size=\"1\">SIN REVISION</font></td>";
		}   
	}
}
echo "</tr>";
?>
      </table></td>
  </tr>
</table>
<div align="center"></div>
</body>
</html>

