<?php
include("conexion.php");
if (strlen($DA) == 1){ $DA = "0".$DA; }
if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
$fec1 = $AA."-".$MA."-".$DA;   
if (strlen($DE) == 1){ $DE = "0".$DE; }
if (strlen($ME) == 1){ $ME = "0".$ME; }
$fec2 = $AE."-".$ME."-".$DE; 
?>
<html>
<head>
<title>Estadisticas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?php
$sql_tot="SELECT count(*) AS total_reunion FROM minuta m, asistentes a WHERE m.id_minuta=a.id_minuta AND a.prop IS NOT NULL AND m.en_fecha BETWEEN '$fec1' AND '$fec2'";
$res_tot=mysql_db_query($db,$sql_tot,$link);
$row_tot=mysql_fetch_array($res_tot);
?>
<body>
<table width="60%" border="1" align="center"  background="images/fondo.jpg">
  <tr> 
    <td width="455"> <table border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr align="center"> 
          <th colspan="4"><font size="2" face="Arial, Helvetica, sans-serif"> 
            PROPOSICIONES</font></th>
        </tr>
        <tr align="center"> 
          <th width="237" bgcolor="#006699"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">USUARIO</font></th>
          <th width="97" bgcolor="#006699"><div align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">CANTIDAD</font></div></th>
          <th width="100" bgcolor="#006699"><div align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">%</font></div></th>
          <th width="145" bgcolor="#006699"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
		<?php
		$sql="SELECT count(*) AS numero,nombre,tipo FROM minuta m, asistentes a WHERE m.id_minuta=a.id_minuta AND a.prop IS NOT NULL AND m.en_fecha BETWEEN '$fec1' AND '$fec2' GROUP BY nombre";
		$res=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($res)){
		?>
        <tr> 
          <td> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<?php 
		  		if($row[tipo]=='Nuevo' || $row[tipo]=='Interno'){
				$sql_usr="SELECT CONCAT(nom_usr,' ',apa_usr,' ',ama_usr) AS nombre FROM users WHERE login_usr='$row[nombre]'";
				$res_usr=mysql_db_query($db,$sql_usr,$link);
				$row_usr=mysql_fetch_array($res_usr);
				echo $row_usr[nombre];
			} else echo $row[nombre];
		  ?></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php=$row[numero];?>
              </font></strong></font></div></td>
          <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php
			  if($row_tot[total_reunion]==0) $perc=0;
			  $perc=round($row[numero]/$row_tot[total_reunion]*100);
			  echo $perc;
			  ?>
              %</font></div></td>
          <td nowrap bgcolor="#006699"><?php echo "<IMG HEIGHT=15 WIDTH=$perc% SRC=images/barra.jpg>";?></td>
        </tr>
		<?php
		}
		?>
        <tr> 
          <td height="10"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10"></td>
        </tr>
        <tr> 
          <th width="237" nowrap bgcolor="#CCCCCC"><font size="2" face="Arial, Helvetica, sans-serif">Nro 
            TOTAL DE PROPOSICIONES</font></th>
          <td width="97" bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php=$row_tot[total_reunion];?>
              </font></strong></div></td>
          <td width="100" nowrap bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">100%</font></strong></div></td>
          <td nowrap width="145" bgcolor="#006699"> 
            <?php if ($row_tot[total_reunion]>0) echo "<IMG HEIGHT=15 WIDTH=100% SRC=images/barra.jpg>";?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<div align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">NOTA 
  : </font></strong><font size="1" face="Arial, Helvetica, sans-serif">En algunos 
  casos, la suma estadistica tiene un error de 1% por motivos de redondeo.</font> 
</div>
</body>
</html>
