<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
require("conexion.php");
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
$sql="SELECT DISTINCT(id_cmant) FROM calen_contingencia ORDER BY id_cmant ASC";
$rs=mysql_query($sql);
while ($tmp=mysql_fetch_array($rs)) {
	$sql="SELECT calen_contingencia.id_cmant, ordenes.id_orden, ordenes.desc_inc FROM calen_contingencia, ordenes WHERE calen_contingencia.TipoPru=ordenes.id_orden AND calen_contingencia.id_cmant=$tmp[id_cmant] ORDER BY id_cmant ASC";
	$rsCont=mysql_query($sql);
		while ($tmpCont=mysql_fetch_array($rsCont)) {
			if (strlen($tmpCont['desc_inc'])>30) $tmp1="...";
			else $tmp1="";
			$lstContingencia[$tmpCont['id_orden']]=$tmpCont['id_orden'].". ".substr($tmpCont['desc_inc'],0,30).$tmp1;
		}
}
$sql="SELECT DISTINCT(DATE_FORMAT(fecha_del,'%Y')) AS fecha FROM calen_contingencia ORDER BY fecha";
$rs=mysql_query($sql);
while ($tmp=mysql_fetch_array($rs)) {
	$lstFecha[$tmp['fecha']]=$tmp['fecha'];
}
?>
<html>
<head>
	<title>GesTor F1 - CONTINGENCIA-PROAPC - CALENDARIZACION</title>
</head>
<body>
<form action="report_ordenes2.php" method="POST" name="form1" target="_blank">
  <input name="var2" type="hidden" value="<?php if (isset($ficha)) echo $ficha?>">
  <table width="90%" border="1" align="center">
    <tr>
      <td>
	    <table width="100%" background="images/fondo.jpg">
          <tr> 
            <td colspan="4" background="images/main-button-tileR2.jpg"> 
              <div align="center"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">ELIJA 
                EL TIPO DE ESTADISTICA QUE DESEA</font><font size="3" face="Arial, Helvetica, sans-serif"><br>
                </font></strong></div></td>
          </tr>
          <tr> 
            <td width="33%" align="right"><font size="2" face="Arial, Helvetica, sans-serif">Agrupar 
              por:</font> </td>
            <td width="31%" align="left"><select name="menu" id="select">
				<option value="0">General</option>
                 <?php foreach ($lstContingencia as $k => $v) {
			  		print "<option value=\"$k\">$v</option>";
			  } ?>
              </select></td>
            <td width="7%" align="left"> <font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Gestion: 
              </font> </td>
            <td width="29%" align="left">
			<select name="fecha" id="fecha">
                <?php foreach ($lstFecha as $k => $v) {
			  		print "<option value=\"$k\">$v</option>";
			  } ?>
              </select></td>
          </tr>
          <tr> 
            <td colspan="4"><div align="center"> 
                <input name="IMPRE" type="button" value="   VER   " onClick="OpenPrint()">
                <br>
              </div></td>
          </tr>
        </table>
	  </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<script language="JavaScript">
	function OpenPrint () {
		var form=document.form1;
		if (form.fecha.value==''){
			alert ("Fecha, no puede ser vacio. \n\nMensaje generado por GesTor F1.");
			return false;
		}
		if (form.menu.value=="0") window.open ( "ver_calen_cont.php?menu=" + form.menu.value + "&fecha=" + form.fecha.value + "");
		else window.open ( "ver_calen_cont_resumen.php?TipoPru=" + form.menu.value + "&fecha=" + form.fecha.value + "");
		return false;	
	}
-->
</script>
<center>
</center>
</body>
</html>