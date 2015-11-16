<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
require ("conexion.php");
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($_REQUEST['RETORNAR'])) header("location: menu_parametros.php?Naveg=Seguridad >> Menu de Parametros");
if(isset($_REQUEST['GUARDAR'])){
	$sql="UPDATE parametros_dym SET etapa_1='$_REQUEST[etapa_1]',etapa_2='$_REQUEST[etapa_2]',etapa_3='$_REQUEST[etapa_3]',etapa_4='$_REQUEST[etapa_4]',etapa_5='$_REQUEST[etapa_5]',
		etapa_6='$_REQUEST[etapa_6]',etapa_7='$_REQUEST[etapa_7]',etapa_8='$_REQUEST[etapa_8]',etapa_9='$_REQUEST[etapa_9]',etapa_10='$_REQUEST[etapa_10]',etapa_11='$_REQUEST[etapa_11]',
		etapa_12='$_REQUEST[etapa_12]' WHERE id_etapa='1'";
		mysql_query($sql);
		header("location: menu_parametros.php");
}
include ("top.php");
?>
  <form name="form1" method="post" action="">
  <table width="52%" height="66" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
  <tr>
    <th colspan="2" background="images/main-button-tileR1.jpg" height="22">PARAMETRIZACION DE ETAPAS DE DESARROLLO </th>
  </tr>
  <tr>
  <td width="6%"><div align="center"><strong>ETAPA</strong></div></td>
  <td width="94%"><div align="center"><strong>DESCRIPCION</strong></div></td>
  </tr>
  <?php
  $sql="SELECT * FROM parametros_dym";
  $res=mysql_query($sql);
  $row=mysql_fetch_array($res);
  ?>
  <tr>  <td><div align="center">1</div></td>
  <td>
      <input name="etapa_1" type="text" id="etapa_1" value="<?php echo $row['etapa_1']?>" size="70">
    </td>
  </tr>
  <tr>  <td><div align="center">2</div></td>
  <td><input name="etapa_2" type="text" id="etapa_2" value="<?php echo $row['etapa_2']?>" size="70">    &nbsp;</td></tr>
  <tr>  <td><div align="center">3</div></td>
  <td><input name="etapa_3" type="text" id="etapa_3" value="<?php echo $row['etapa_3']?>" size="70">    &nbsp;</td></tr>
  <tr>  <td><div align="center">4</div></td>
  <td><input name="etapa_4" type="text" id="etapa_4" value="<?php echo $row['etapa_4']?>" size="70">    &nbsp;</td></tr>
  <tr>  <td><div align="center">5</div></td>
  <td><input name="etapa_5" type="text" id="etapa_5" value="<?php echo $row['etapa_5']?>" size="70">    &nbsp;</td></tr>
  <tr>  <td><div align="center">6</div></td>
  <td><input name="etapa_6" type="text" id="etapa_6" value="<?php echo $row['etapa_6']?>" size="70">    &nbsp;</td></tr>
  <tr>  <td><div align="center">7</div></td>
  <td><input name="etapa_7" type="text" id="etapa_7" value="<?php echo $row['etapa_7']?>" size="70">    &nbsp;</td></tr>
  <tr>  <td><div align="center">8</div></td>
  <td><input name="etapa_8" type="text" id="etapa_8" value="<?php echo $row['etapa_8']?>" size="70">    &nbsp;</td></tr>
  <tr>  <td><div align="center">9</div></td>
  <td><input name="etapa_9" type="text" id="etapa_9" value="<?php echo $row['etapa_9']?>" size="70">    &nbsp;</td></tr>
  <tr>  <td><div align="center">10</div></td>
  <td><input name="etapa_10" type="text" id="etapa_10" value="<?php echo $row['etapa_10']?>" size="70">    &nbsp;</td></tr>
  <tr>  <td><div align="center">11</div></td>
  <td><input name="etapa_11" type="text" id="etapa_11" value="<?php echo $row['etapa_11']?>" size="70">    &nbsp;</td></tr>
  <tr>  <td><div align="center">12</div></td>
  <td><input name="etapa_12" type="text" id="etapa_12" value="<?php echo $row['etapa_12']?>" size="70">    &nbsp;</td></tr>
</table>
  <p align="center">	
    <input name="GUARDAR" type="submit" id="GUARDAR" value="GUARDAR">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
</p>
  </form>