<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

require("conexion.php");
$sql="SELECT login_usr, CONCAT(nom_usr, ' ', apa_usr, ' ', ama_usr) AS nombre FROM users WHERE tipo2_usr='T' ORDER BY apa_usr";
$rs=mysql_query($sql);
while ($tmp=mysql_fetch_array($rs)) {
	$lstTecnico[$tmp['login_usr']]=$tmp['nombre'];
}

$sql="SELECT DISTINCT area_usr as area FROM users ORDER BY area_usr";
$rs=mysql_query($sql);
while ($tmp=mysql_fetch_array($rs)) {
	$lstArea[$tmp['area']]=$tmp['area'];
}
?>
<html>
<head>
	<title>IMPRESION</title>
</head>
<body>
<form action="impresion_seleccionar.php" method="POST" name="form1" target="_blank">
  <table width="90%" border="1" align="center">
    <tr>
      <td>
	    <table width="100%" background="images/fondo.jpg">
          <tr> 
            <td colspan="4" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">ELIJA 
                EL TIPO DE IMPRESION QUE DESEA</font><font size="3" face="Arial, Helvetica, sans-serif"><br>
                </font></strong></div></td>
          </tr>
          <tr> 
            <td width="30%" align="right"> &nbsp;<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp; 
              Agrupar por:</font> </td>
            <td width="10%" align="left"><select name="menu" id="menu">
                <option value="TODO" selected>TODO</option>
				<option value="Computadores de Escritorio">Computadores de Escritorio</option>
                <option value="Computadores Portatiles">Computadores Portatiles</option>
                <option value="Servidores">Servidores</option>
				<option value="Monitores">Monitores</option>
				<option value="Multimedia">Multimedia</option>
				<option value="Impresoras">Impresoras</option>
				<option value="Red">Red</option>
				<option value="UPS">UPS</option>
				<option value="Telefonia">Telefonia</option>
				<option value="Otros">Otros</option>
              </select></td>
            <td width="30%" align="left">
<input name="IMPRE" type="button" value="IMPRIMIR" onClick="OpenPrint()">
            </td>
          </tr>
          <tr> 
            <td colspan="3"><div align="center"><br>
              </div></td>
          </tr>
        </table>
	  </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<script language="JavaScript">
<!--
	function OpenPrint () {
		var form=document.form1;
		window.open ( "ver_fichatecnica2.php?menu=" + form.menu.value + "");
		return false;	
	}
-->
</script>
<center>
</center>
</body>
</html>