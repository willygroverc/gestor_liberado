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
<style type="text/css">
<!--
.Estilo4 {color: #000000; font-weight: bold; }
.Estilo9 {font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 12px}
.Estilo10 {font-weight: bold; font-size: 12px; color: #000000;}
.Estilo12 {color: #000000; font-weight: bold; font-size: 14px; }
-->
</style>
</head>
<body>
<p class="Estilo9"><?php
include("datos_gral.php");
?>
</span>
<table width="100%" border="0">
  <tr>
    <td class="Estilo9"><div align="center"><font size="4"><u><strong>REGISTRO DE ACCIONES </strong></u></font></div></td>
  </tr>
</table>
<span class="Estilo9"><br>
</span>
<table width="70%" border="1" align="center">
  <tr bgcolor="#CCCCCC">
    <th class="Estilo9"><span class="Estilo10"><font size="2">DATOS DEL ACCIONISTA</font> </span></th>
  </tr>
  <tr>
    <td height="52" class="Estilo9"><table width="100%" border="0">
      <tr>
        <?php
				$sql_acc="SELECT * FROM accionistas WHERE id_acc = '$num'";
				$res_acc=mysql_query($sql_acc);
				$row_acc=mysql_fetch_array($res_acc);
				?>
        <td width="2%">&nbsp;</td>
        <td><strong><font size="2">Nombre o Raz&oacute;n Social: </font></strong></td>
        <td width="39%"><font size="2"><?php echo $row_acc['nom_acc'];?></font></td>
        <td width="20%"><font size="2"><strong>Fecha de Registro:</strong></font></td>
        <td width="16%"><font size="2">&nbsp;<?php echo $row_acc['fecha_acc'];?></font></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="23%"><font size="2"><strong>Nacionalidad:</strong></font></td>
        <td><font size="2"><?php echo $row_acc['nac_acc'];?>&nbsp;</font></td>
        <td><font size="2"><strong>Telefono:</strong></font></td>
        <td><font size="2">&nbsp;<?php echo $row_acc['tel_acc'];?></font></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="23%"><font size="2"><strong>Direcci&oacute;n:</strong></font></td>
        <td><font size="2"><?php echo $row_acc['dom_acc'];?>&nbsp;</font></td>
        <td><font size="2"><strong>Estado:</strong></font></td>
        <td><font size="2"> <?php echo $row_acc['estado'];?> </font></td>
      </tr>
    </table></td>
  </tr>
</table>
<span class="Estilo9"><br>
</span>
<table width="95%" border="1" align="center" bordercolor="#000000">
  <tr>
    <th colspan="7" bgcolor="#CCCCCC" class="Estilo9"><span class="Estilo4"><font size="2">DETALLE DE ACIONES</font></span> </th>
  </tr>
  <tr bgcolor="#CCCCCC">
    <th nowrap class="Estilo9"><span class="Estilo12">N&ordm; de Partida </span></th>
    <th nowrap class="Estilo9"><span class="Estilo12">Nro. de Titulo y<br> Serie de la Accion</span></th>
    <th nowrap class="Estilo9"><span class="Estilo12">Valor Nominal </span></th>
    <th nowrap class="Estilo9"><span class="Estilo12">Fecha de Asiento </span></th>
    <th nowrap class="Estilo9"><span class="Estilo12">Numero de Acciones<br>del Titulo</span></th>
	<th nowrap class="Estilo9"><span class="Estilo12">Valor Total de Acciones<br>(en Bolivianos)</span></th>
    <th nowrap class="Estilo9"><span class="Estilo12">Clase</span></th>
  </tr>
  <?php
  		$g_total=0;
		$n_acc=0;
		$sql = "SELECT * FROM acciones WHERE id_acc='$num' ORDER BY id_ac ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
	?>
  <tr align="center">
    <td class="Estilo9">&nbsp;<?php echo $row['id_ac'];?></td>
    <td class="Estilo9">&nbsp;<?php echo $row['serie_ac'];?></td>
	<td class="Estilo9" align="right">&nbsp;<?php echo number_format($row['valor_ac'],2,'.',',');?></td>
	<td class="Estilo9">&nbsp;<?php echo $row['fecas_ac']?></td>
	<td class="Estilo9" align="right">&nbsp;<?php echo number_format($row['num_ac'],0,'.',',')?></td>
	  <?php
	  $n_acc+=$row['num_ac'];
	  $sb_total=$row['valor_ac']*$row['num_ac'];
	  $g_total+=$sb_total;
	  ?>
	<td class="Estilo9" align="right">&nbsp;<?php echo number_format($sb_total,2,'.',',')?></td>
	<td class="Estilo9">&nbsp;<?php echo $row['class_ac'];?></td>
  </tr>
  <?php }?>
  <tr>
  <td align="right" colspan="4"><strong>TOTAL</strong></td>
  <td align="right"><strong>
    <?php echo number_format($n_acc,0,'.',',');?>
  </strong></td>
  <td align="right"><strong><?php echo number_format($g_total,2,'.',',')?></strong></td>
  </tr>
</table>
</body>
</html>