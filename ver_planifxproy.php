<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

include("datos_gral.php");
$variable1=$_REQUEST['variable1'];
$numer=$_REQUEST['numer'];
$sql="SELECT * FROM planif_estrategica WHERE TipoPlanifica='$variable1' AND NumPlanif='$numer' ORDER BY NumPlanif ASC LIMIT 1";
$res=mysql_query($sql);
$row=mysql_fetch_array($res);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - PLANIFICACI�N ESTRAT�GICA</title>
<style> 
.let { FONT-FAMILY: ARIAL, VERDANA; FONT-SIZE: 9 pt;}
</style>
</head>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><div align="center"><font size="4"><strong><font face="Arial, Helvetica, sans-serif">PLANIFICACION 
        ESTRATEGICA</font><br>
        </strong></font></div></td>
  </tr>
  <tr> 
    <td height="19">&nbsp;</td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="345"><font size="2" face="Arial, Helvetica, sans-serif"><strong>TIPO 
      DE PLANIFICACION: </strong><?php echo $variable1; ?></font></td>
    <td width="292"><div align="right">&nbsp;</div></td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBJETIVO GENERAL: </strong>
      <?php echo $row['ObjNegocio'];?></font></td>
    <td>&nbsp;</td>
  </tr>
</table>
<div align="center"><br>
  <table width="90%" border="1" cellspacing="0">
    <tr> 
      <td><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">OBJETIVO 
          ESPECIFICO</font></strong></font></div></td>
      <td><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">RESPONSABLE</font></strong></font></div></td>
      <td><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">FECHA</font></strong></font></div></td>
      <td><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">COSTO 
          ($us)</font></strong></font></div></td>
      <td><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">ACCIONES</font></strong></font></div></td>
    </tr>
    <?php
$sql="SELECT *, DATE_FORMAT(FechaPlanifica, '%d/%m/%Y') AS FechaPlanifica2, CONCAT(nom_usr,' ',apa_usr,' ',ama_usr) AS nombre FROM planif_estrategica a, users b WHERE TipoPlanifica='$variable1' AND NumPlanif='$numer' AND a.RespPlanifica=b.login_usr ORDER BY NumPlanif ASC";
$res=mysql_query($sql);
while($row=mysql_fetch_array($res))
{
	$acc=explode("|",$row['Accion']);
	$cos=explode("|",$row['costo']);
	$num=count($cos)-1;
?>
    <tr> 
      <td rowspan="<?php echo $num?>"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
          <?php echo $row['ObjTi']?>
          </font></div></td>
      <td rowspan="<?php echo $num?>"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
          <?php echo $row['nombre']?>
          </font></div></td>
      <td rowspan="<?php echo $num?>"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
          <?php echo $row['FechaPlanifica2']?>
          </font></div></td>
          <?php
		if($num=="0")
		{
			echo "<td>&nbsp;</td>
	 			  <td>&nbsp;</tr>";
		}
		else
		{
			for($i=0;$i<$num;$i++)
			{
				$s=$i+1;
				if($i==0) echo "<td><div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">".number_format($cos[$i],2)."&nbsp;</font></div></td>
							<td><div align=\"left\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">".$s.". $acc[$i]&nbsp;</font></div></td></tr>";
				else echo "<tr><td><div align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">".number_format($cos[$i],2)."&nbsp;</font></div></td>
							<td><div align=\"left\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">".$s.". $acc[$i]&nbsp;</font></div></td></tr>";
			}
		}
}?>
  </table>
</div>
