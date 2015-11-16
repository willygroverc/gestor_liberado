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
?>
<html>
<head>
<title> GesTor F1 - ACCIONISTAS</title>
</head>
<STYLE type="text/css">
<!--
  A:link {COLOR: black; TEXT-DECORATION: none}
  A:visited {COLOR: black; TEXT-DECORATION: none}
  A:active {TEXT-DECORATION: none}
  A:hover {COLOR: black; TEXT-DECORATION: underline} -->
</STYLE>
<body>
<p><font size="3" face="Arial, Helvetica, sans-serif">
  <?php
include("datos_gral.php");
require("conexion.php");
if (isset($flag) && $flag==1) $flag=0;
else $flag=1;
$n_acc=0;
$g_total=0;
?>
</font>
<br>
<table width="100%" border="1" bordercolor="#000000">
  <tr>
    <td colspan="14" bgcolor="#CCCCCC"><div align="center"><font size="3" face="Geneva, Arial, Helvetica, sans-serif"><u><strong>REGISTRO DE ACCIONES </strong></u></font></div></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <th class="menu">Estado</th>
    <th class="menu"><font color="#000000" size="2" face="Geneva, Arial, Helvetica, sans-serif"><a  href="accionistas_print.php?ord_tab=nom_acc&flag=<?php=@$flag?>">NOMBRE / RAZON SOCIAL</a></font></th>
    <th class="menu"><font color="#000000" size="2" face="Geneva, Arial, Helvetica, sans-serif"><a  href="accionistas_print.php?ord_tab=num&flag=<?php=@$flag?>">ACCIONES</a></font></th>
    <th class="menu"><font color="#000000" size="2" face="Geneva, Arial, Helvetica, sans-serif"><a href="accionistas_print.php?ord_tab=num&flag=<?php=@$flag?>">% ACCIONARIO </a></font></th>
    <th class="menu"><font color="#000000" size="2" face="Geneva, Arial, Helvetica, sans-serif"><a  href="accionistas_print.php?ord_tab=mont&flag=<?php=@$flag?>">MONTO TOTAL</a></font></th>
  </tr>
  <?php
	$sql11 = "SELECT num_ord_pag FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}
	
if ($tipo=="A" || $tipo=="B")
{
    $_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM accionistas";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
if(!isset($ord_tab)) $ali='DESC';
elseif($flag==1) $ali='DESC';
else $ali='ASC';

if(!isset($ord_tab)) $ord_tab='id_acc';
    $sql = "SELECT a.*, DATE_FORMAT(fecha_acc, '%d/%m/%Y') AS fecha_acc, SUM(b.num_ac) AS num, SUM(b.valor_ac) AS mont FROM accionistas a, acciones b WHERE a.id_acc=b.id_acc GROUP BY b.id_acc ORDER BY $ord_tab $ali LIMIT $_pagi_inicial,$_pagi_cuantos";
	}
else  
{
    $_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM accionistas";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
if(!$ord_tab) $ord_tab='id_acc';
    $sql = "SELECT a.*, DATE_FORMAT(fecha_acc, '%d/%m/%Y') AS fecha_acc, SUM(b.num_ac) AS num FROM accionistas a, acciones b WHERE a.id_acc=b.id_acc GROUP BY b.id_acc ORDER BY $ord_tab $ali LIMIT $_pagi_inicial,$_pagi_cuantos";
	
} 
$result=mysql_query($sql);
$sql_ac="SELECT SUM(num_ac) AS num FROM acciones";
$res_ac=mysql_query($sql_ac);
$row_ac=mysql_fetch_array($res_ac);
while ($row=mysql_fetch_array($result)) {
	//nombre de accionista
  	echo "<tr align=\"center\">";
	echo "<td><font color=\"#000000\" size=\"2\" face=\"Geneva, Arial, Helvetica, sans-serif\">&nbsp;$row[estado]</font></td>";
	echo "<td><font color=\"#000000\" size=\"2\" face=\"Geneva, Arial, Helvetica, sans-serif\">&nbsp;$row[nom_acc]</font></td>";
	//%deaccionario
	echo "<td align=\"right\"><font color=\"#000000\" size=\"2\" face=\"Geneva, Arial, Helvetica, sans-serif\">&nbsp;".number_format($row['num'],0,'.',',')."</font></td>";
	$n_acc+=$row['num'];
		if($row['num']==0 || $row_ac['num']==0){ $prom=0;}
	else {$prom=round($row['num']/$row_ac['num']*100,2);}
	//acciones
	echo "<td align=\"right\"><font color=\"#000000\" size=\"2\" face=\"Geneva, Arial, Helvetica, sans-serif\">&nbsp;$prom %</font></td>";
	//monto
	$sql_mont="SELECT SUM(valor_ac*num_ac) AS mont FROM acciones WHERE id_acc='$row[id_acc]'";
	$res_mont=mysql_query($sql_mont);
	$row_mont=mysql_fetch_array($res_mont);
	$g_total+=$row_mont['mont'];
	echo "<td align=\"right\"><font color=\"#000000\" size=\"2\" face=\"Geneva, Arial, Helvetica, sans-serif\">&nbsp;".number_format($row_mont['mont'],2,'.',',')."</font></td>";
	echo "</tr>";
}
?>
<tr>
  <td align="right">&nbsp;</td>
  <td align="right"><strong>TOTAL</strong></td>
  <td align="right"><strong>
    <?php echo number_format($n_acc,0,'.',',');?>
  </strong></td>
  <td align="right"><strong>100%</strong></td>
  <td align="right"><strong><?php echo number_format($g_total,2,'.',',')?></strong></td>
  </tr>
</table>
</body>
</html>