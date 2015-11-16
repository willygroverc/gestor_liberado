<?php 
if(isset($nuevo))
{
	header("location: proced.php?id_pro=0");
}
?>

<html>
<head>
<title>Lista de Procedimientos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="100%" border="1" background="images/fondo.jpg">
  <tr> 
    <th colspan="6" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>LISTA 
      DE PROCEDIMIENTOS</strong></font></th>
  </tr>
  <tr> 
    <th width="6%" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Nro.</strong></font></th>
    <th width="35%" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Titulo</strong></font></th>
    <th width="20%" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Fecha 
      y Hora</strong></font></th>
    <th width="20%" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Responsable</strong></font></th>
    <th width="9%" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Modificar</font></th>
    <th width="10%" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Ver</strong></font></th>
  </tr>
  <?php 
  include("conexion.php");
  $sql="SELECT *, DATE_FORMAT(fecha_pro, '%d/%m/%Y') AS fecha_pro FROM proced ORDER BY id_pro";
  $result=mysql_db_query($db,$sql,$link);
  while($row=mysql_fetch_array($result))
  {
   ?>
  <tr align="center"> 
    <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row[id_pro];?>&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row[titulo_pro];?>&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "$row[fecha_pro] $row[hora_pro]";?>&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif"> 
      <?php 
	$sql_r="SELECT * FROM users WHERE login_usr='$row[resp_pro]'";
  	$result_r=mysql_db_query($db,$sql_r,$link);
  	while($row_r=mysql_fetch_array($result_r))
	echo "$row_r[nom_usr] $row_r[apa_usr] $row_r[ama_usr]";?>
      &nbsp;</font></td>
    <td><?php echo "<a href=\"proced.php?id_pro=$row[id_pro]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar Procedimiento\"></a>";?></td>
    <td><?php echo "<a href=\"ver_proced.php?id_pro=$row[id_pro]\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Procedimiento\"></a>";?></td></font>
  </tr>
  <?php }?>
</table>

<form name="form1" method="post" action="">
  <div align="center">
    <input type="submit" name="nuevo" value="NUEVO PROCEDIMIENTO">
  </div>
</form>
</body>
</html>
