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
?>
<html>
<head>
<title> GesTor F1 - CONTINGENCIA-PROAPC - CALENDARIZACION</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
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
<table width="95%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC" align="center"> 
    <th width="22"  rowspan="2" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">No.</font></th>
    <th width="53"  rowspan="2" nowrap><div align="center"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ord. 
        <br>
        Trabajo </font></div></th>
    <th width="199"  rowspan="2" nowrap><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Incidencia</font></div></th>
    <th width="53"  rowspan="2" nowrap><div align="center"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Estado</font></div></th>
    <th colspan="4" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre1</font></th>
    <th colspan="4" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre2</font></th>
    <th colspan="4" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre3</font></th>
    <th width="51" rowspan="2" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Gestion</font></th>
  </tr>
  <tr bgcolor="#006699" align="center"> 
    <th width="41" height="19"  nowrap bgcolor="#CCCCCC"  id="1"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ene</font></th>
    <th width="40"  nowrap bgcolor="#CCCCCC" id="2"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Feb</font></th>
    <th width="43"  nowrap bgcolor="#CCCCCC" id="3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Mar</font></th>
    <th width="41"  nowrap bgcolor="#CCCCCC" id="4"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Abr</font></th>
    <th width="42"  nowrap bgcolor="#CCCCCC" id="5"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">May</font></th>
    <th width="46"  nowrap bgcolor="#CCCCCC" id="6"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Jun</font></th>
    <th width="43"  nowrap bgcolor="#CCCCCC" id="7"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Jul</font></th>
    <th width="44"  nowrap bgcolor="#CCCCCC" id="8"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ago</font></th>
    <th width="45"  nowrap bgcolor="#CCCCCC" id="9"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Sept</font></th>
    <th width="44"  nowrap bgcolor="#CCCCCC" id="10"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Oct</font></th>
    <th width="41"  nowrap bgcolor="#CCCCCC" id="11"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Nov</font></th>
    <th width="43"  nowrap bgcolor="#CCCCCC" id="12"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Dic</font></th>
  </tr>
  <?php
		$sql = "SELECT * FROM calen_contingencia WHERE DATE_FORMAT(fecha_del, '%Y')=$fecha AND id_cmant>='$cod' ORDER BY id_cmant, estado";
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
    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row['id_cmant']?></font></td>
    <td height="30" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row['TipoPru'];?></font></td>
    <?php	$sql4 = "SELECT * FROM ordenes WHERE id_orden='$row[TipoPru]'";
		$result4=mysql_query($sql4);
		$row4=mysql_fetch_array($result4);
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">$row4[desc_inc]</td>";?>
    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['estado'];?></font></td>
    <td width="53" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="01"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa"; }}?>
        </font></div></td>
    <td width="41" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="02"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="40" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="03"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="43" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="04"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="41" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="05"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="42" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="06"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="46" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="07"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="43" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="08"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="44" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="09"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="45" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="10"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="44" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="11"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="41" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="12"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="43" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $anod; ?> 
      </font> <div align="center"></div></td>
  </tr>
  <?php } ?>
</table>
<p>&nbsp;</p>
</body>
</html>