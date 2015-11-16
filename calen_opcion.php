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
require ("conexion.php");

$sql="SELECT login_usr, CONCAT(apa_usr,' ',ama_usr,' ',nom_usr) AS nombre FROM users WHERE tipo2_usr<>'C' ORDER BY apa_usr ASC";
$rs=mysql_query($sql);
while ($tmp=mysql_fetch_array($rs)) {
	$lstTecnico[$tmp['login_usr']]=$tmp['nombre'];
}

$sql="SELECT login_usr, CONCAT(apa_usr,' ',ama_usr,' ',nom_usr) AS nombre FROM users WHERE tipo2_usr='C' ORDER BY apa_usr ASC";
$rs=mysql_query($sql);
while ($tmp=mysql_fetch_array($rs)) {
	$lstCliente[$tmp['login_usr']]=$tmp['nombre'];
}

$sql="SELECT DISTINCT area_usr as area FROM users ORDER BY area_usr";
$rs=mysql_query($sql);
while ($tmp=mysql_fetch_array($rs)) {
	$lstArea[$tmp['area']]=$tmp['area'];
}

$sql="SELECT DISTINCT ciu_usr as ciudad FROM users ORDER BY ciu_usr";
$rs=mysql_query($sql);
while ($tmp=mysql_fetch_array($rs)) {
	$lstCiudad[$tmp['ciudad']]=$tmp['ciudad'];
}

$sql1="SELECT * FROM control_parametros";
$rs1=mysql_query($sql1);
$row1=mysql_fetch_array($rs1);
if ($row1['agencia']=="si") {
	$sql="SELECT DISTINCT nombre_dadicional as NomAdicional FROM datos_adicionales";
	$rs=mysql_query($sql);
	while ($tmp=mysql_fetch_array($rs)) {
		$lstNomAdicional[$tmp['NomAdicional']]=$tmp['NomAdicional'];
	}
}
?>

<html>
<head>
<script lenguaje="javascript" type="text/javascript">
<!--
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function cambio(numero){        
		 if (!foco_texto){
				 irapagina("orden_estadistica.php?op="+numero);
		 } 
}
var foco_texto=false;
-->
</script>
<title>GesTor F1 - Estadisticas</title></head>
<body topmargin="0" >
<script language="JavaScript" src="calendar.js"></script>
<?php
if ( isset($op) && $op == "F"){ 
	require_once ( "ValidatorJs.php" );
	$valid = new Validator ( "form2" );
	$valid->addIsDate   ( "DA", "MA", "AA", "Fecha de Inicio, $errorMsgJs[date]" );
	$valid->addIsDate   ( "DE", "ME", "AE", "Fecha de Conclusion, $errorMsgJs[date]" );
	$valid->addCompareDates   ( "DA", "MA", "AA","DE", "ME", "AE", "Fecha Del y Fecha Al, $errorMsgJs[compareDates]");
	$valid->addFunction("OpenPrint7","");
	print $valid->toHtml ();
}
?>

<table background="images/fondo.jpg" width="98%"  align="center" border="1">
<tr><td  bgcolor="#006699" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica"><b>CALENDARIZACIÓN</b></font></td>
</tr>
<tr><td align="center"><br>
</td>
</tr>
<tr><form action="" method="POST" name="form2">
	<input type="hidden" name="op" value=<?phpif (isset($op)) echo $op;?>>
	<td height="84"> 
		<table border="1"><tr><td>
		<table width="100%" border="0">
		<tr>				
          <td width="28" height="40"></td>
				<td width="121"><font size="2" face="Arial, Helvetica"><B>GESTION: </B></font></td>
				<td width="143">
				<select name="gestion" id="select">
				<option value="T">GENERAL</option>
				<?php 
					for($i=1999; $i<=2015; $i++ )
					{
				?>
					<option value=<?php=$i?>><?php=$i?></option>
				<?php
				    }
				?>                
				</select>
				</td>	
				<td width="600">
					<input name="IMPRE" type="button" value="    VER    " onClick="OpenPrint()">
				</td>	
			</tr>		

				
			
				<tr><td height="20"></td></tr>
			</table>
		</td></tr>
		</table>	</td>
</form>
</tr>
</table>
<script>
	function OpenPrint () {
		gestion = document.form2.gestion.value;
		window.open ("ver_calendarizacion.php?idges=" + gestion);
		close();
		return false;	
	}

</script>
</body>
</html>