<?php
include("datos_gral.php");
?>
<?php
include("conexion.php");
?>
<html>
<head>
<title>Niveles</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<style>
.tabla {
  border: 1px solid  #666666;
}
.fuente 
{
	font:Garamond;
	size: 10 px;
}
</style>

<body>
<div align="center"><font size="3" face="Garamond"><strong><u>REPORTE GENERAL POR NIVELES</u></strong></font><font size="3"><strong></strong></font> <br><br>
  <table width="90%" border="1">
    <tr bgcolor="#CCCCCC"> 
      <td width="5%"><div align="center" class="normal"><font size="2" face="Garamond"><strong>Nro.</strong></font></div></td>
      <td width="19%"><div align="center" class="normal"><font size="2" face="Garamond"><strong>NIVEL 1</strong></font></div></td>
	  <td width="76%">
	  			<table width='100%' cellpadding='0' cellspacing='0'>
			       <tr>
				   	 <td width='40%' align='center'><font size='2' face='Garamond'><strong>NIVEL 2</strong></font></td>
					 <td align='center'><font size='2' face='Garamond'><strong>NIVEL 3</strong></font></td>
				   </tr>
			     </table>
	
	  </td>
    </tr>
    <?php
	$i=1;  
	$sql_objetivo="SELECT * FROM area";
	$datos_obj=mysql_query($sql_objetivo);
	while($row=mysql_fetch_array($datos_obj)) {
	?>
    <tr> 
      <td width="5%"><div align="center"><font class="fuente"><?php echo "<font face='Garamond'>".$i."</font>"; ?></font></div></td>
      <td width="19%"><div align="justify">
		  <?php
			echo "<font face='Garamond'>".$row['area_nombre']."<br></font><font face='verdana' size='1'>". $row['area_desc']."</font>";
		  ?>
	  </div></td>
	  <td width="76%" valign="top"><div align="left">
	  <table width="100%">
	  <?php 
		$dom="select *from dominio where id_area=$row[area_cod]";
		$rd = mysql_query($dom);
		while($sd = mysql_fetch_array($rd))
		{
			echo '<tr>';
			echo '<td width="40%" valign="center" class="tabla">&nbsp;<font face="Garamond">'.$sd['dominio'].'</font><br><font face="verdana" size="1">'.$sd['descripcion'].'</font></td>';
			//
			echo"
				 <td>
				 	<table width='100%'>";
						$obj="select *from objetivos where id_dominio=$sd[id_dominio]";
						$resobj = mysql_query($obj);
						while($rowo = mysql_fetch_array($resobj)){	
							echo"<tr><td class='tabla'>&nbsp;<font face='Garamond'>$rowo[objetivo]</font></tr>";
						}
			echo "</table>";
			echo "</td>";
			echo "</tr>";
		}
		
	  ?> 
	  </table>
	  </div></td>

    </tr>
    <?php
	$i++;
	}
	?>
  </table>
</div>
</body>
</html>
