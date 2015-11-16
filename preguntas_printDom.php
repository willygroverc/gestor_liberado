<?php
$link=mysql_connect("localhost","fubrecti","gruosi2005");
$db="fubrecti_bdcursoweb";
?>
<html>
<head>
<title>Yanapti</title>
</head>

<body>
<p align="center"> 
  <?php
$sql = "SELECT * FROM dominio WHERE dominio_idioma='$idioma' and dominio_codigo='$dominio'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);
$nro=1;
echo "<BR><strong> $row[dominio_nombre] </strong> <BR>";
$sqlpreg = "SELECT * FROM test WHERE test_idioma='$idioma' AND test_dominio='$dominio' ORDER BY test_num ASC LIMIT 0, $preguntas";
$resultpreg=mysql_db_query($db,$sqlpreg,$link);
while($rowpreg=mysql_fetch_array($resultpreg)){
?>
  <br>
<table width="100%" border="0">
  <tr> 
    <td height="24" colspan="3"><div align="justify"><strong><?php echo "$nro .- $rowpreg[test_pregunta]"?></strong></div></td>
  </tr>
  <tr> 
    <td width="3%" rowspan="4">&nbsp;</td>
    <td width="4%" valign="top"> <div align="center"><img src="images/NO1.GIF" border="1" width="11" height="11"></div></td>
    <td width="93%"><?php echo "$rowpreg[test_optA]"?> <div align="justify"></div></td>
  </tr>
  <tr> 
    <td valign="top"> <div align="center"><img src="images/NO1.GIF" border="1" width="11" height="11"></div></td>
    <td><?php echo "$rowpreg[test_optB]"?> <div align="justify"></div></td>
  </tr>
  <tr> 
    <td valign="top"> <div align="center"><img src="images/NO1.GIF" border="1" width="11" height="11"></div></td>
    <td><?php echo "$rowpreg[test_optC]"?> <div align="justify"></div></td>
  </tr>
  <tr> 
    <td valign="top"> <div align="center"><img src="images/NO1.GIF" border="1" width="11" height="11"></div></td>
    <td><?php echo "$rowpreg[test_optD]"?> <div align="justify"></div></td>
  </tr>
</table>
<?php
$nro++;}
?>
</body>
</html>
