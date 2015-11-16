<?php
include("datos_gral.php");
?>
<?php
include("conexion.php");
?>
<html>
<head>
<title>AREAS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<div align="center">
  <p><u><strong><font size="4" face="Arial, Helvetica, sans-serif">PRIMER NIVEL</font></strong></u><br>
    <br>
  </p>
  <table width="75%" border="1">
    <tr bgcolor="#CCCCCC"> 
      <td width="7%"><div align="center" class="normal"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Nro.</strong></font></div></td>
      <td width="27%"><div align="center" class="normal"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE</strong></font></div></td>
      <td width="35%"><div align="center" class="normal"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DESCRIPCION</strong></font></div></td>
    </tr>
    <?php
	$i=1;
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);
	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}
	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM area";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);
	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM area";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);
	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql="SELECT * FROM area LIMIT $_pagi_inicial,$_pagi_cuantos";
	$datos=mysql_db_query($db,$sql,$link);
	while ($area=mysql_fetch_array($datos)) {
	?>
    <tr> 
      <td><div align="center"><?php echo $i; ?></div></td>
      <td><div align="center"><?php echo $area['area_nombre']; ?></div></td>
      <td><div align="center"><?php echo $area['area_desc']; ?></div></td>
    </tr>
    <?php
	$i++;
	}
	?>
  </table>
</div>
<div align="center"></div>
</body>
</html>
