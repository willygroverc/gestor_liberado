<?php
if ($Retornar)
{ header("location: lista_ficha.php");
}
else 
{ include ("top.php");
$IdFi=($_GET['IdFicha']);
?>
<input name="var" type="hidden" value="<?php echo $IdFi;?>">
<table border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top"><table width="762" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="16" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF">REGISTRO 
            DE FICHAS TECNICAS</font></th>
        </tr>
        <tr align=\"center\"> 
          <th width="31" height="25" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">N° 
            FICHA</font></th>
          <th width="62" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">FECHA 
            REALIZACION</font></th>
          <th width="63" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">REALIZADO 
            POR</font></th>
          <th width="106" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">TIPO 
            REGISTRO</font></th>
          <th width="79" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">COD. 
            ACTIVO FIJO</font></th>
          <th width="98" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">MODELO</font></th>
          <th width="50" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">ASIGNADO 
            A </font></th>
          <th width="97" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">AREA</font></th>
          <th width="63" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECH. 
            RECEPCION</font></th>
          <th width="69" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECH. 
            DEVOLUC.</font></th>
        </tr>
        <?php
$sql = "SELECT * FROM datfichatec WHERE IdFicha='$IdFi'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result); 
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">&nbsp;$row[IdFicha]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[FechPruFunc]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[RealizFicha]</td>";
	echo "<td><font size=\"1\">&nbsp;$row[TpRegFicha]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[CodActFijo]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[Modelo]</font></td>";
	
	$sql3 = "SELECT * FROM asigcustficha WHERE IdFicha='$IdFi'";
    $result3 = mysql_db_query($db,$sql3,$link);
	while ($row3=mysql_fetch_array($result3)){
		//if(!$IdFi)
		echo "<td><font size=\"1\">&nbsp;$row3[NombAsig]</font></td>";	
		echo "<td><font size=\"1\">&nbsp;$row3[Area]</font></td>";	
		echo "<td><font size=\"1\">&nbsp;$row3[Fecha]</font></td>";	
		echo "<td><font size=\"1\">&nbsp;$row3[FechaD]</font></td>";
		echo "</tr>";
		echo "<tr align=\"center\">";
		echo "<td>&nbsp;</font></td>";
		echo "<td>&nbsp;</font></td>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</font></td>";
		echo "<td>&nbsp;</font></td>";
		echo "<td>&nbsp;</font></td>";
}
		echo "<td><font size=\"1\">&nbsp;</font></td>";	
		echo "<td><font size=\"1\">&nbsp;</font></td>";	
		echo "<td><font size=\"1\">&nbsp;</font></td>";	
		echo "<td><font size=\"1\">&nbsp;</font></td>";
		echo "</tr>"
?>
      </table></td>
  </tr>
</table>
  
  
<form name="form1" method="post" action="lista_ficha.php">
  <input name="Retornar" type="submit" id="reg_form3" value="RETORNAR">
</form>

 <?php } ?>
  <?php include("top_.php");?> 