<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		07/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require("conexion.php");
if (isset ($DA) && strlen($DA) == 1){ $DA = "0".$DA; }
if (isset($MA) && strlen($MA) == 1){ $MA = "0".$MA; }	 	 
@$fec1 = $AA."-".$MA."-".$DA;   
if (isset($DE) && strlen($DE) == 1){ $DE = "0".$DE; }
if (isset($ME) && strlen($ME) == 1){ $ME = "0".$ME; }
@$fec2 = $AE."-".$ME."-".$DE; 
?>
<html>
<head>
<title>Estadisticas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?php
if(isset($elab_por) && $elab_por=="GENERAL")
	$elab="%";
else 
	@$elab=$elab_por;
$cond="AND en_fecha BETWEEN '$fec1' AND '$fec2'";

$sql_tot="SELECT count(*) AS total_reunion FROM agenda WHERE elab_por LIKE '$elab' $cond";
$res_tot=mysql_query($sql_tot);
$row_tot=mysql_fetch_array($res_tot);

$sql_ord="SELECT count(*) AS total_reunion FROM agenda WHERE tipo_reu='Ordinaria' AND elab_por LIKE '$elab' $cond";
$res_ord=mysql_query($sql_ord);
$row_ord=mysql_fetch_array($res_ord);

$sql_ext="SELECT count(*) AS total_reunion FROM agenda WHERE tipo_reu='Extraordinaria' AND elab_por LIKE '$elab' $cond";
$res_ext=mysql_query($sql_ext);
$row_ext=mysql_fetch_array($res_ext);

$sql_eme="SELECT count(*) AS total_reunion FROM agenda WHERE tipo_reu='Emergencia' AND elab_por LIKE '$elab' $cond";
$res_eme=mysql_query($sql_eme);
$row_eme=mysql_fetch_array($res_eme);

$sql_otr="SELECT count(*) AS total_reunion FROM agenda WHERE tipo_reu='Otros' AND elab_por LIKE '$elab' $cond";
$res_otr=mysql_query($sql_otr);
$row_otr=mysql_fetch_array($res_otr);

$sql_csi="SELECT count(*) AS total_reunion FROM agenda WHERE codigo='CSI' AND elab_por LIKE '$elab' $cond";
$res_csi=mysql_query($sql_csi);
$row_csi=mysql_fetch_array($res_csi);

$sql_ccp="SELECT count(*) AS total_reunion FROM agenda WHERE codigo='CCP' AND elab_por LIKE '$elab' $cond";
$res_ccp=mysql_query($sql_ccp);
$row_ccp=mysql_fetch_array($res_ccp);

$sql_crc="SELECT count(*) AS total_reunion FROM agenda WHERE codigo='CRC' AND elab_por LIKE '$elab' $cond";
$res_crc=mysql_query($sql_crc);
$row_crc=mysql_fetch_array($res_crc);

$sql_otro="SELECT count(*) AS total_reunion FROM agenda WHERE codigo='OTRO' AND elab_por LIKE '$elab' $cond";
$res_otro=mysql_query($sql_otro);
$row_otro=mysql_fetch_array($res_otro);

if($row_tot['total_reunion']>0){
	$barr_tot=round($row_tot['total_reunion']/$row_tot['total_reunion']*100);
	$barr_ord=round($row_ord['total_reunion']/$row_tot['total_reunion']*100);
	$barr_ext=round($row_ext['total_reunion']/$row_tot['total_reunion']*100);
	$barr_eme=round($row_eme['total_reunion']/$row_tot['total_reunion']*100);
	$barr_otr=round($row_otr['total_reunion']/$row_tot['total_reunion']*100);
	$barr_csi=round($row_csi['total_reunion']/$row_tot['total_reunion']*100);
	$barr_ccp=round($row_ccp['total_reunion']/$row_tot['total_reunion']*100);
	$barr_crc=round($row_crc['total_reunion']/$row_tot['total_reunion']*100);
	$barr_otro=round($row_otro['total_reunion']/$row_tot['total_reunion']*100);
}else{
	$barr_tot=0;
	$barr_ord=0;
	$barr_ext=0;
	$barr_eme=0;
	$barr_otr=0;
	$barr_csi=0;
	$barr_ccp=0;
	$barr_crc=0;
	$barr_otro=0;
}
?>
<body>
<table width="60%" border="1" align="center"  background="images/fondo.jpg">
  <tr> 
    <td width="455"> <table border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr align="center"> 
          <th colspan="4"><font size="2" face="Arial, Helvetica, sans-serif"> 
            ELABORADO POR : 
            <?php
			if(isset($elab_por) && $elab_por=="GENERAL") echo $elab_por;
			else{
				@$sql_usr="SELECT CONCAT(nom_usr,' ',apa_usr,' ',ama_usr) AS nombre FROM users WHERE login_usr='$elab_por'";
				$res_usr=mysql_query($sql_usr);
				$row_usr=mysql_fetch_array($res_usr);
				echo $row_usr['nombre'];
			}
			?>
            </font></th>
        </tr>
        <tr align="center"> 
          <th width="237" bgcolor="#006699"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">AGENDAS 
            DE REUNION</font></th>
          <th width="97" bgcolor="#006699"><div align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">CANTIDAD</font></div></th>
          <th width="100" bgcolor="#006699"><div align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">%</font></div></th>
          <th width="145" bgcolor="#006699"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Ordinaria</font></div></td>
          <td width="97"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php echo $row_ord['total_reunion'];?>
              </font></strong></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;
              <?php echo $barr_ord;?>
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"> <?php echo "<IMG HEIGHT=15 WIDTH=$barr_ord% SRC=images/barra.jpg>"; ?> 
          </td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Extraordinaria</font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php $row_ext['total_reunion'];?>
              </font></strong></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php echo $barr_ext;?>
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$barr_ext% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Emergencia</font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php echo $row_eme['total_reunion'];?>
              </font></strong></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php echo $barr_eme;?>
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$barr_eme% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td width="237"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Otros</font></div></td>
          <td width="97"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php echo $row_otr['total_reunion'];?>
              </font></strong></font></div></td>
          <td width="100"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php echo $barr_otr?>
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$barr_otr% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
		<tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;CSI</font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php echo $row_csi['total_reunion'];?>
              </font></strong></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php echo $barr_csi;?>
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$barr_csi% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;CCP</font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php echo $row_ccp['total_reunion'];?>
              </font></strong></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php echo $barr_ccp;?>
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$barr_ccp% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;CRC</font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php echo $row_crc['total_reunion'];?>
              </font></strong></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php echo $barr_crc;?>
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$barr_crc% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;OTRO</font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php echo $row_otro['total_reunion'];?>
              </font></strong></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php echo $barr_otro;?>
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$barr_otro% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10"></td>
        </tr>
        <tr> 
          <th width="237" nowrap bgcolor="#CCCCCC"><font size="2" face="Arial, Helvetica, sans-serif">Nro 
            TOTAL DE REUNIONES</font></th>
          <td width="97" bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;
              <?php echo $row_tot['total_reunion'];?>
              </font></strong></div></td>
          <td width="100" nowrap bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">100%</font></strong></div></td>
          <td nowrap width="145" bgcolor="#006699"> 
            <?php if ($row_tot['total_reunion']>0) echo "<IMG HEIGHT=15 WIDTH=100% SRC=images/barra.jpg>";?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<div align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">NOTA 
  : </font></strong><font size="1" face="Arial, Helvetica, sans-serif">En algunos 
  casos, la suma estadistica tiene un error de 1% por motivos de redondeo.</font> 
</div>
</body>
</html>
