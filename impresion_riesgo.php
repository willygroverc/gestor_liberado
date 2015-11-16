<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		13/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include("datos_gral.php");
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>GESTOR F1 - PCN</title>
</head>
<div align="center">
    <th colspan="10" <strong><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><strong><u>LISTA DE ALARMAS</u></strong></font></font></strong></div><br></th></tr>
  </tr>
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="2">
  <tr align="center">   <tr bgcolor="#CCCCCC"> 
    <th width="4%" class="menu style2 style3">Nro.</th>
    <th width="10%" class="menu style2 style3">TIPO DE RIESGO</th>
    <th width="16%" class="menu style2 style3">RIESGO</th>
    <th width="18%" class="menu style2 style3">MENSAJE USUARIOS</th>
    <th width="6%" class="menu style2 style3">FECHA CREACION</th>
    <th width="10%" class="menu style2 style3">TIPO DE ENVIO</th>
    <th width="5%" class="menu style2 style3" >ORDENES SIN SOLUCION</th>
	<?php 
		include("conexion.php");
		$c = 1;
		$sql3 = "SELECT *, DATE_FORMAT(fec_creacion, '%d/%m/%Y') AS fec_creacion FROM alarmas_riesgos ORDER BY id_alarma DESC";
		$res3 = mysql_query($sql3);
		while($row3 = mysql_fetch_array($res3)) 
		{	$sql4  = "SELECT id_riesgo, descripcion FROM riesgo_tipos WHERE id_riesgo='".$row3['tipo_alarma']."'";
			$row4  = mysql_fetch_array(mysql_query( $sql4));
			$sql5  = "SELECT id_riesgo, desc_riesgo  FROM riesgo_pregunta WHERE id_riesgo='".$row3['alarma']."'";
			$row5  = mysql_fetch_array(mysql_query( $sql5));
			echo "<tr align ='center'>";
			echo "<td class=\"style5\">".$row3['id_alarma']."</td>";
			echo "<td class=\"style5\">".$row4['descripcion']."</td>";
			echo "<td class=\"style5\">".$row5['desc_riesgo']."</td>";
			echo "<td class=\"style5\">".$row3['mensaje_u']."&nbsp;</td>";
			echo "<td class=\"style5\">".$row3['fec_creacion']."</td>";
			echo "<td class=\"style5\">";
			echo "Orden de Trabajo";
			if ($row3['msn_mail']==1){echo "<br>Correo Electronico";}
			if ($row3['msn_celu']==1){echo "<br>Mesaje a Celular";}
			echo "&nbsp;</td>";
			echo "<td class=\"style5\">";
			$numsol=0;
			$sql_o="SELECT id_orden FROM ordenes WHERE id_orden='$row3[id_alarma]'";
			$result_o1=mysql_query($sql_o);
			$result_o=mysql_query($sql_o);
			if(mysql_fetch_array($result_o1))
			{
				while($row_o=mysql_fetch_array($result_o))
				{
					$sql_s="SELECT id_orden FROM solucion WHERE id_orden='".$row_o['id_orden']."'";
					$result_s=mysql_query($sql_s);
					$row_s=mysql_fetch_array($result_s);
					if (!$row_s['id_orden']){$numsol=$numsol+1;}
				}
				if ($numsol=="0"){echo "<img src=\"images/ok.gif\" border=\"0\" alt=\"Solucionados\">";}
				else {echo $numsol;}
			}
			else
			{echo "<img src=\"images/ok.gif\" border=\"0\" alt=\"Solucionados\">";}	
		}
		?>

<body>

<p class="style2">&nbsp;</p>
</body>
</head>
</html>
