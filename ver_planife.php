<?php
if (isset($_REQUEST['Terminar'])) 
	header("location: actividades_pre_last.php?tip=$varia2&varia2=$varia2&numer=$NumPlanif&ObjNegocio=$objnegocioaux&actividad=1");	
  session_start();
  $login=$_SESSION["login"];

if (isset($_REQUEST['Terminar'])) 
	header("location: actividades_pre_last.php?tip=$varia2&varia2=$varia2&numer=$NumPlanif&ObjNegocio=$objnegocioaux&actividad=1");	
  session_start();
  $login=$_SESSION["login"];

include("top_ver.php");
if(isset($_GET['variable']))
	$idplanif=($_GET['variable']);
if(isset($_GET['variable1']))
$tipoplanif=($_GET['variable1']);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - PLANIFICACI�N ESTRAT�GICA</title>
<style> 
.let { FONT-FAMILY: ARIAL, VERDANA; FONT-SIZE: 9 pt;}
</style>
</head>
<body>
<p>
<?php
include("datos_gral.php");
$costo_total=0;
?>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><font size="4"><strong><font face="Arial, Helvetica, sans-serif">PLANIFICACION ESTRATEGICA</font><br>
        </strong></font></div></td>
  </tr>
  <tr> 
    <td height="19">&nbsp;</td>
  </tr>
</table>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="345"><strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>TIPO DE PLANIFICACION:</strong> </font><?php echo $tipoplanif; ?></strong></td>
    <td width="292"><div align="right">&nbsp;</div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table  width="99%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
    <th width="3%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Nro.</font></strong></div></th>
    <th width="15%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">OBJETIVO 
        DEL NEGOCIO</font></strong></div></th>
    <th width="15%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">OBJETIVO 
        TI</font></strong></div></th>
    <th width="15%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ACCION</font></strong></div></th>
    <th width="10%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">COSTO ($us)</font></strong></div></th>
    <th width="18%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABLE</font></strong></div></th>
    <th width="8%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA</font></strong></div></th>
  </tr>
  <?php
$sql2="SELECT *, DATE_FORMAT(FechaPlanifica, '%d/%m/%Y') AS FechaPlanifica FROM planif_estrategica WHERE TipoPlanifica='$tipoplanif' ORDER BY NumPlanif";
$resul2=mysql_query($sql2);
while ($row2=mysql_fetch_array($resul2))
{
	$num_filas=count(explode("|",$row2['costo']));
	$num_filas=$num_filas-1;
?>
  <td rowspan="<?php echo $num_filas;?>" align="center" class="let"><?php echo $row2['NumPlanif']?>&nbsp;</td>
  <td rowspan="<?php echo $num_filas;?>" align="center" class="let"><?php echo $row2['ObjNegocio']?>&nbsp;</td>
  <td rowspan="<?php echo $num_filas;?>" align="center" class="let"><?php echo $row2['ObjTi']?>&nbsp;</td>
<?php 
  $matriz_a=explode("|",$row2['Accion']);
  $matriz_c=explode("|",$row2['costo']);
  $costo_total+=$matriz_c[0];
  $s=1;
?>
  <td align="left" class="let"><?php if($num_filas>0){echo "$s. ";} echo $matriz_a[0];?>&nbsp;</td>
  <td align="center" class="let"><?php echo $matriz_c[0]?>&nbsp;</td>  
<?php 
	$sql5 = "SELECT * FROM users WHERE login_usr='$row2[RespPlanifica]'";
	$result5 = mysql_query($sql5);
	$row5 = mysql_fetch_array($result5);
	echo '<td rowspan="'.$num_filas.'">&nbsp;'.$row5['apa_usr'].' '.$row5['ama_usr'].' '.$row5['nom_usr'].'</td>';?>
  <td rowspan="<?php echo $num_filas;?>" align="center" class="let"><?php echo $row2['FechaPlanifica']?>&nbsp;</td>
  </tr>
<?php 
  if(count($matriz_c)>1){
	  for($i=1;$i<count($matriz_c)-1;$i++){
	  		$s=$i+1;
		  echo "<tr><td align=\"left\" class=\"let\">$s. $matriz_a[$i]&nbsp;</td><td align=\"center\" class=\"let\">$matriz_c[$i]&nbsp;</td></tr>";
		  $costo_total+=$matriz_c[$i];
	  }
  }
} ?>
</table>
<table width="94%" height="40" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr><td>&nbsp;</td></tr>
	<tr><td><div align="left"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong>COSTO TOTAL:&nbsp; <?php echo "$"."us ".$costo_total;?></strong></font></div></td>
</table>

</body>
</html>