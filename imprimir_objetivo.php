<?php
include("datos_gral.php");
include("conexion.php");
include('funciones.php');
?>
<html>
<head>
<title>Niveles</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<div align="center"><font size="3" face="Arial, Helvetica, sans-serif"><strong><u>TERCER NIVEL</u></strong></font><font size="3"><strong></strong></font> <br><br>
  <table width="75%" border="1">
    <tr bgcolor="#CCCCCC"> 
      <td width="4%"><div align="center" class="normal"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Nro.</strong></font></div></td>
      <td width="29%"><div align="center" class="normal"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NIVEL 1</strong></font></div></td>
	  <td width="30%"><div align="center" class="normal"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NIVEL 2</strong></font></div></td>
	  <td width="37%"><div align="center" class="normal"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE DEL NIVEL</strong></font></div></td>
    </tr>
    <?php
	
	//$cod1=SanitizeString($cod1);
	//$cod=SanitizeString($cod);
	$i=1;  
	if($_REQUEST['cod1']!="0"){
		if($_REQUEST['cod']!="0") $var="AND a.id_dominio='$_REQUEST[cod]'";
		else $var="AND b.id_area='$_REQUEST[cod1]'";
        }else{$var='';}
	$sql_objetivo="SELECT * FROM objetivos a, dominio b WHERE a.id_dominio=b.id_dominio $var order by id_area asc";
	//print_r($sql_objetivo);exit;
        $datos_obj=mysql_db_query($db,$sql_objetivo,$link);
	while($objetivo=mysql_fetch_array($datos_obj)) {
	?>
    <tr> 
      <td width="4%"><div align="center"><?php echo $i; ?></div></td>
      <td width="29%"><div align="left">&nbsp;
	  <?php
		$sql_area="SELECT area_nombre,dominio FROM area a, dominio d WHERE d.id_area=a.area_cod AND d.id_dominio='$objetivo[id_dominio]'";
	  	$res_area=mysql_db_query($db,$sql_area,$link);
		$row=mysql_fetch_array($res_area);
		echo $row['area_nombre'];
	  ?></div></td>
	  <td width="30%"><div align="left">&nbsp;
	  <?php 
		echo $row['dominio'];
	  ?></div></td>
	  <td width="37%"><div align="left">&nbsp;<?php echo $objetivo['objetivo']; ?></div></td>
    </tr>
    <?php
	$i++;
	}
	?>
  </table>
</div>
</body>
</html>
