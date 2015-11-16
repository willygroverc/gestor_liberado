<?php
include("conexion.php");
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="80%" border="1" cellspacing="0" align="center">
  <tr> 
    <td width="20%"> <img src="images/imagen_ins.jpg"></td>
    <td colspan="4" width="80%"><img src="images/imagen.jpg"> </tr>
</table><br>
<table width="90%" border="2" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr bgcolor="#006699"> 
    <td width="9%" height="21"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>N&ordf;</strong></font></div></td>
    <td width="39%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">NOMBRE</font></strong></font></div></td>
    <td width="52%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">PROPOSICION</font></strong></font></div></td>
    <td width="52%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">ARCHIVO 
        ADJUNTO </font></strong></font></div></td>
  </tr>
  <?php
		$cont=0;	
		$sql24 = "SELECT * FROM asistentes WHERE id_minuta='$id_minuta' AND prop IS NOT NULL";
		$result24=mysql_db_query($db,$sql24,$link);
		while($row24=mysql_fetch_array($result24)) 
  		{
		$cont=$cont+1;
		 ?>
  <tr align="center"> 
    <td ><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $cont?></font></td>
    <?php 	$sql5 = "SELECT * FROM users WHERE login_usr='$row24[nombre]' ";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5[login_usr])
				{echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row24[nombre]</font></td>";}
				else
				{echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</font></td>";}?>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row24[prop]?></font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif"><a href="archivos proposiciones\<?php=$row24[adjunto]?>" target=\"_blank\"> 
      <?php=$row24[adjunto]?>
      </a>&nbsp;</font></td>
  </tr>
  <?php 
		
		 }
		 ?>
</table>
</body>
</html>
