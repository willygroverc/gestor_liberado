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
?>
<html>
<head>
<title>Estadisticas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?php
if(isset($_REQUEST['elab_por']) && $_REQUEST['elab_por']=="GENERAL") $elab="%";
else $elab=$_REQUEST['elab_por'];

$sql_tot="SELECT count(*) AS total_reunion FROM agenda WHERE elab_por LIKE '$elab'";
$res_tot=mysql_query($sql_tot);
$row_tot=mysql_fetch_array($res_tot);

$sql_ord="SELECT count(*) AS total_reunion FROM agenda WHERE tipo_reu='Ordinaria' AND elab_por LIKE '$elab'";
$res_ord=mysql_query($sql_ord);
$row_ord=mysql_fetch_array($res_ord);

$sql_ext="SELECT count(*) AS total_reunion FROM agenda WHERE tipo_reu='Extraordinaria' AND elab_por LIKE '$elab'";
$res_ext=mysql_query($sql_ext);
$row_ext=mysql_fetch_array($res_ext);

$sql_eme="SELECT count(*) AS total_reunion FROM agenda WHERE tipo_reu='Emergencia' AND elab_por LIKE '$elab'";
$res_eme=mysql_query($sql_eme);
$row_eme=mysql_fetch_array($res_eme);

$sql_otr="SELECT count(*) AS total_reunion FROM agenda WHERE tipo_reu='Otros' AND elab_por LIKE '$elab'";
$res_otr=mysql_query($sql_otr);
$row_otr=mysql_fetch_array($res_otr);

function cantidad($codigo, $elab){
	include ("conexion.php");
	$sql_cai="SELECT count(*) AS total_reunion FROM agenda WHERE codigo='$codigo' AND elab_por LIKE '$elab'";
	$res_cai=mysql_query($sql_cai);
	$row_cai=mysql_fetch_array($res_cai);
	return $row_cai['total_reunion'];
}

function porcentaje($num, $total){
	if($total>0) return round($num/$total*100);
	else  return 0;
}
if($row_tot['total_reunion']>0){
	$barr_tot=round($row_tot['total_reunion']/$row_tot['total_reunion']*100);
	$barr_ord=round($row_ord['total_reunion']/$row_tot['total_reunion']*100);
	$barr_ext=round($row_ext['total_reunion']/$row_tot['total_reunion']*100);
	$barr_eme=round($row_eme['total_reunion']/$row_tot['total_reunion']*100);
	$barr_otr=round($row_otr['total_reunion']/$row_tot['total_reunion']*100);
}else{
	$barr_tot=0;
	$barr_ord=0;
	$barr_ext=0;
	$barr_eme=0;
	$barr_otr=0;
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
			if(isset($_REQUEST['elab_por']) && $_REQUEST['elab_por']=="GENERAL") echo $_REQUEST['elab_por'];
			else{   
                                $elab_por=$_REQUEST['elab_por'];
                            
				$sql_usr="SELECT CONCAT(nom_usr,' ',apa_usr,' ',ama_usr) AS nombre FROM users WHERE login_usr='$elab_por'";
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
              <?php echo $barr_ord?>
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"> <?php echo "<IMG HEIGHT=15 WIDTH=$barr_ord% SRC=images/barra.jpg>"; ?> 
          </td>
        </tr>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Extraordinaria</font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php echo $row_ext['total_reunion'];?>
              </font></strong></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php echo $barr_ext?>
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
              <?php echo $barr_otr;?>
              %</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$barr_otr% SRC=images/barra.jpg>";?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
		<?php
		$sqlxcod="SELECT agenda_cod FROM agenda_cod ORDER BY agenda_cod";
		$resxcod=mysql_query($sqlxcod);
		while($rowxcod=mysql_fetch_array($resxcod)){
		?>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<?php echo $rowxcod['agenda_cod'];?></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php $num=cantidad($rowxcod['agenda_cod'],$elab); echo $num?> </font></strong></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php $porc=porcentaje($num,$row_tot['total_reunion']); echo $porc?>
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$porc% SRC=images/barra.jpg>";?></td>
        </tr>
		<?php }?>
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