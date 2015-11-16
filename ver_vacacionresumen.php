<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		12/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require ("top_ver.php");
$Nombre=($_GET['Nombre']);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - AUSENCIA PROGRAMADA</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>
<body bgcolor="#FFFFFF"><p>
<?php
include("datos_gral.php");
?>
<table width="100%" border="0" align="center">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td> <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">CALENDARIZACION 
              DE AUSENCIA PROGRAMADA - INDIVIDUAL</font></u></b></div></td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<br>
<table width="97%" border="1" align="center" cellpadding="2" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
    <th width="140" rowspan="2" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Nombre</font></th>
    <th width="75" rowspan="2" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Estado</font></th>
	<th width="75" rowspan="2" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ausencia</font></th>
    <th colspan="4" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre1</font></th>
    <th colspan="4" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre2</font></th>
    <th colspan="4" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre3</font></th>
    <th width="88" rowspan="2" nowrap><font size="2" face="Arial, Helvetica, sans-serif">Gestion</font></th>
  </tr>
  <tr bgcolor="#006699"> 
    <th width="47" nowrap bgcolor="#CCCCCC"  id="1"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ene</font></th>
    <th width="52" nowrap bgcolor="#CCCCCC" id="2"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Feb</font></th>
    <th width="51" nowrap bgcolor="#CCCCCC" id="3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Mar</font></th>
    <th width="44" nowrap bgcolor="#CCCCCC" id="4"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Abr</font></th>
    <th width="43" nowrap bgcolor="#CCCCCC" id="5"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">May</font></th>
    <th width="41" nowrap bgcolor="#CCCCCC" id="6"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Jun</font></th>
    <th width="39" nowrap bgcolor="#CCCCCC" id="7"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Jul</font></th>
    <th width="42" nowrap bgcolor="#CCCCCC" id="8"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ago</font></th>
    <th width="37" nowrap bgcolor="#CCCCCC" id="9"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Sept</font></th>
    <th width="41" nowrap bgcolor="#CCCCCC" id="10"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Oct</font></th>
    <th width="47" nowrap bgcolor="#CCCCCC" id="11"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Nov</font></th>
    <th width="45" nowrap bgcolor="#CCCCCC" id="12"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Dic</font></th>
  </tr>
  <?php
		$sql = "SELECT * FROM vacaciones WHERE Nombre='$Nombre' ORDER BY id_vacac ASC";
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
  <input name="var" type="hidden" value="<?php echo $Nombre;?>">
  <tr align="center"> 
    <?php 
		$sql6 = "SELECT * FROM users WHERE login_usr='".$row['Nombre']."'";
	  	$result6 = mysql_query($sql6);
		$row6 = mysql_fetch_array($result6);
	echo "<td>".$row6['nom_usr']." ".$row6['apa_usr']." ".$row6['ama_usr']."</a></td>"; ?>
    <font size="1" face="Arial, Helvetica, sans-serif"></td></font>
    <td align="center">&nbsp;<?php echo $row['estado'];?></td>
	<td align="center">&nbsp;<?php echo $row['ausencia'];?></td>
    <td width="47" align="center"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="01"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa"; }}?>
        </font></div></td>
    <td width="52" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="02"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="51" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="03"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="44" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="04"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="43" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="05"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="41" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="06"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="39" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="07"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="42" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="08"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="37" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="09"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="41" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="10"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="47" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="11"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="45" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="12"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td width="88" align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif"><?php echo $anod; ?> 
        </font></div></td>
  </tr>
  <?php } ?>
</table>
<p>&nbsp;</p>
</body>
</html>