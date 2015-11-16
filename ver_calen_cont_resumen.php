<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
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
$TipoPru=($_GET['TipoPru']);
$TipoPru=SanitizeString($TipoPru);
?>
<html>
<head>
<title> GesTor F1 - CONTINGENCIA-PROAPC - CALENDARIZACION</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="100%" border="0" align="center">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td> <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">CALENDARIZACION 
              DE CONTINGENCIA</font></u></b></div></td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<br>
<table width="97%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
    <th width="26" rowspan="2" nowrap><font size="2" face="Arial, Helvetica, sans-serif">No.</font></th>
    <th width="49" rowspan="2" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ord. 
      <br>
      Trabajo</font></th>
    <th width="220" rowspan="2" nowrap><font size="2" face="Arial, Helvetica, sans-serif">Incidencia</font></th>
    <th width="69" rowspan="2" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Estado</font></th>
    <th height="18" colspan="4" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre1</font></th>
    <th colspan="4" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre2</font></th>
    <th colspan="4" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre3</font></th>
    <th width="48" rowspan="2" nowrap><font size="2" face="Arial, Helvetica, sans-serif">Gestion</font></th>
  </tr>
  <tr bgcolor="#006699"> 
    <th width="47" nowrap bgcolor="#CCCCCC"  id="1"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ene</font></th>
    <th width="40" nowrap bgcolor="#CCCCCC" id="2"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Feb</font></th>
    <th width="40" nowrap bgcolor="#CCCCCC" id="3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Mar</font></th>
    <th width="39" nowrap bgcolor="#CCCCCC" id="4"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Abr</font></th>
    <th width="41" nowrap bgcolor="#CCCCCC" id="5"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">May</font></th>
    <th width="42" nowrap bgcolor="#CCCCCC" id="6"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Jun</font></th>
    <th width="38" nowrap bgcolor="#CCCCCC" id="7"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Jul</font></th>
    <th width="42" nowrap bgcolor="#CCCCCC" id="8"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ago</font></th>
    <th width="42" nowrap bgcolor="#CCCCCC" id="9"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Sept</font></th>
    <th width="43" nowrap bgcolor="#CCCCCC" id="10"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Oct</font></th>
    <th width="39" nowrap bgcolor="#CCCCCC" id="11"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Nov</font></th>
    <th width="46" nowrap bgcolor="#CCCCCC" id="12"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Dic</font></th>
  </tr>
  <?php
		if (!empty($fecha)) $sql = "SELECT * FROM calen_contingencia WHERE DATE_FORMAT(fecha_del, '%Y')=$fecha AND TipoPru='$TipoPru' ORDER BY id_cmant ASC";
		else $sql = "SELECT * FROM calen_contingencia WHERE TipoPru='$TipoPru' ORDER BY id_cmant ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
  <?php
				$anod=substr($row['fecha_del'],0,4);
				$mesd=substr($row['fecha_del'],5,2);
				$diad=substr($row['fecha_del'],8,2);
	
				$anoa=substr($row['fecha_al'],0,4);
				$mesa=substr($row['fecha_al'],5,2);
				$diaa=substr($row['fecha_al'],8,2);?>
  <?php if($mesd==$mesa) 
			$fechac="$diad-$diaa";
		 ?>
  <tr align="center"> 
    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row['id_cmant'];?></font></td>
    <td height="29" align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['TipoPru'];?></font></td>
    <?php
	$sql4 = "SELECT * FROM ordenes WHERE id_orden='".$row['TipoPru']."'";
	$result4=mysql_query($sql4);
	$row4=mysql_fetch_array($result4);
	echo '<td><font size="1" face="Arial, Helvetica, sans-serif">'.$row4['desc_inc'].'</td>';
	?>
	<td align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['estado'];?></font></td>
    <td width="69" align="center"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="01"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa"; }}?>
        </font></div></td>
    <td width="47" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="02"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="40" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="03"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="40" align="center"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="04"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="39" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="05"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="41" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="06"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="42" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="07"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="38" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="08"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="42" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="09"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="42" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="10"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="43" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="11"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="39" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="12"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="46" align="center"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $anod; ?> 
        </font></div></td>
  </tr>
  <?php } ?>
</table>
<p>&nbsp;</p>
</body>
</html>