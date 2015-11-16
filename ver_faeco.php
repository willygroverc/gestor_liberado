<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		23/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include("top_ver.php");
$idficha=($_GET['variable']);
$sql6="SELECT * FROM ana_facti WHERE id_ficha='$idficha'";
$resul6=mysql_query($sql6);
$row6=mysql_fetch_array($resul6);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - PROYECTOS</title>
</head>
<body>
<p><?php
include("datos_gral.php");
?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font size="4" face="Arial, Helvetica, sans-serif"><u>ANALISIS 
        DE FACTIBILIDAD ECONOMICA </u></font> </strong></div></td>
  </tr>
</table>

<br>
<table width="498" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="164"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NUMERO 
      DE PROYECTO :</strong></font></td>
    <td width="76"><?php echo $row6['id_ficha']; ?></td>
    <td width="258">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    
  </tr>
</table>
<br>
<table width="496" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="168"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE 
      DEL PROYECTO :</strong></font></td>
    <td width="249"><?php echo $row6['nomproy']; ?></td>
    <td width="79">&nbsp; </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
   
  </tr>
</table>
<br>
<table width="498" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="195"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE 
      DEL RESPONSABLE :</strong></font></td>
    <td width="220"><?php 
	$sql7="SELECT * FROM users WHERE login_usr='$row6[nomresp]'";
	$resul7=mysql_query($sql7);
	$row7=mysql_fetch_array($resul7);
	echo $row7['nom_usr']."&nbsp;".$row7['apa_usr']."&nbsp;".$row7['ama_usr']; ?></td>
    <td width="83">&nbsp;&nbsp; 
    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
   
  </tr>
</table>
<br>
<table width="654" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"  > 
    <th width="14" rowspan="2"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>N&deg;</strong></font></div></th>
    <th width="63" rowspan="2"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>RECURSO</strong></font></div></th>
    <th width="89" rowspan="2"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>DESCRIPCION</strong></font></div></th>
    <th width="79" rowspan="2"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>RELACION 
    CON EL PROYECTO</strong></font></div></th>
    <th colspan="2"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>COSTO 
    MES</strong></font></div></th>
    <th width="96" rowspan="2"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>%MENSUAL 
    DE DEDICACION AL PROYETO</strong></font></div></th>
    <th width="93" rowspan="2"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>DURACION 
    DE LA VINCULACION </strong></font></div></th>
    <th width="61" rowspan="2"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>VALOR 
    TOTAL</strong></font></div></th>
  </tr>
  <tr> 
    <th width="50" bgcolor="#CCCCCC"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>BASICO</strong></font></div></th>
    <th width="71" bgcolor="#CCCCCC"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>ADICIONAL</strong></font></div></th>
  </tr>
  <tr> 
    <td colspan="9"><div align="center"></div>
      <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></strong></div></td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td colspan="9"><div align="center"></div>
    <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">INFRAESTRUCTURA</font></strong></div></td>
  </tr>
  <?php
$sql="SELECT * FROM anfacecoplancost WHERE id_ficha='$idficha' AND tipo='Infraestructura'";
$resul=mysql_query($sql);
while($row=mysql_fetch_array($resul))
{
	echo "<tr align=\"center\">";
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['numero'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['recurso'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['descripcion'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['relac_proy'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['costo_bas_mes'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['costo_ad_mes'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['porcent_dedic_proy'].'% </font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['dur_vin'].' meses </font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['valor_total'].'</font></td>';
	echo '</tr>';
}
?>
  <tr> 
    <td colspan="9"><div align="center"></div>
      <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></strong></div></td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td colspan="9"><div align="center"></div>
    <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TECNOLOGIA</font></strong></div></td>
  </tr>
  <?php
$sql2="SELECT * FROM anfacecoplancost WHERE id_ficha='$idficha' AND tipo='Tecnologia'";
$resul2=mysql_query($sql2);
while($row2=mysql_fetch_array($resul2))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp; $row2[numero] </font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp; $row2[recurso] </font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp; $row2[descripcion] </font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp; $row2[relac_proy] </font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp; $row2[costo_bas_mes] </font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp; $row2[costo_ad_mes] </font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp; $row2[porcent_dedic_proy] % </font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp; $row2[dur_vin] meses </font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp; $row2[valor_total] </font></td>";
	echo "</tr>";
}
?>
  <tr> 
    <td colspan="9"><div align="center"></div>
      <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></strong></div></td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td colspan="9"><div align="center"></div>
      <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">APLICACIONES</font></strong></div></td>
  </tr>
  <?php
$sql3="SELECT * FROM anfacecoplancost WHERE id_ficha='$idficha' AND tipo='Aplicaciones'";
$resul3=mysql_query($sql3);
while($row3=mysql_fetch_array($resul3))
{
	echo '<tr align="center">';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row3['numero'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row3['recurso'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row3['descripcion'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row3['relac_proy'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row3['costo_bas_mes'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row3['costo_ad_mes'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row3['porcent_dedic_proy'].'% </font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row3['dur_vin'].' meses </font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row3['valor_total'].' </font></td>';
	echo "</tr>";
}
?>
  <tr> 
    <td colspan="9"><div align="center"></div>
      <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></strong></div></td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td colspan="9"><div align="center"></div>
    <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">DATOS</font></strong></div></td>
  </tr>
  <?php
$sql4="SELECT * FROM anfacecoplancost WHERE id_ficha='$idficha' AND tipo='Datos'";
$resul4=mysql_query($sql4);
while($row4=mysql_fetch_array($resul4))
{
	echo "<tr align=\"center\">";
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['numero'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['recurso'].' </font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['descripcion'].' </font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['relac_proy'].' </font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['costo_bas_mes'].' </font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['costo_ad_mes'].' </font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['porcent_dedic_proy'].' % </font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['dur_vin'].'meses </font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['valor_total'].'</font></td>';
	echo "</tr>";
}
?>
  <tr> 
    <td height="21" colspan="9"><div align="center"></div>
    <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></strong></div></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td colspan="9" bgcolor="#CCCCCC"><div align="center"></div>
    <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">GENTE</font></strong></div></td>
  </tr>
  <?php
$sql5="SELECT * FROM anfacecoplancost WHERE id_ficha='$idficha' AND tipo='Gente'";
$resul5=mysql_query($sql5);
while($row5=mysql_fetch_array($resul5))
{
	echo "<tr align=\"center\">";
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; '.$row5['numero'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; '.$row5['recurso'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; '.$row5['descripcion'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; '.$row5['relac_proy'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; '.$row5['costo_bas_mes'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; '.$row5['costo_ad_mes'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; '.$row5['porcent_dedic_proy'].' % </font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; '.$row5['dur_vin'].' meses </font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; '.$row5['valor_total'].' </font></td>';
	echo "</tr>";
}
?>
  <tr> 
    <td colspan="9"><div align="center"></div>
      <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></strong></div></td>
  </tr>
  <tr> 
    <td colspan="8"><div align="right"><strong><font size="2" face="Arial, Helvetica, sans-serif">TOTAL:</font></strong></div></td>
    <td bgcolor="#CCCCCC">&nbsp;<?php echo $row6['total']; ?></td>
  </tr>
  <tr> 
    <td height="2" colspan="8"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>

<p><br>
  <br>
</p>
</body>
</html>