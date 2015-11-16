<?php
if ($NAcuerdo)
	{   include("conexion.php");
		$sql5="SELECT MAX(id_servi) AS Id FROM nivservicio";
		$result5=mysql_db_query($db,$sql5,$link);
		$row5=mysql_fetch_array($result5);
		$r=$row5[Id]+1; 
        header("location: nivservicio.php?varia1=$r"); }
else 
{ include ("top.php");
include ("top_soptec.php");
?>
<table border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top"><table width="762" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="12" bgcolor="#006699"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">ACUERDO 
            DE NIVEL DE SERVICIO</font></th>
        </tr>
        <tr align=\"center\"> 
          <th width="74" height="13" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">N°</font></th>
		  <th width="146" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">N° ACTIVO FIJO</font></th>
          <th width="377" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></th>
          <th width="145" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">EMPRESA</font></th>
        </tr>
<?php
if ($tipo=="T") {
$sql = "SELECT * FROM NIVSERVICIO ORDER BY id_servi DESC";
}
else {
$sql = "SELECT * FROM NIVSERVICIO ORDER BY id_servi DESC";
}

$result=mysql_db_query($db,$sql,$link);
while ($row=mysql_fetch_array($result)) {
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">$row[id_servi]</font></td>";
	echo "<td><font size=\"1\">$row[desc_ser]</font></td>";
	echo "<td><font size=\"1\">$row[clie_ser]</td>";
	echo "<td><font size=\"1\">$row[vigencia]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"nivservicio_mod.php?IdServi=".$row[id_servi]."\">Modificar</a></font></td>";
	echo "</tr>";
}

?>
      </table></td>
  </tr>
</table>
<form action="" method="get">
  <div align="center">
    <input type="submit" name="NAcuerdo" value="NUEVO ACUERDO">
  </div>
</form> 
  

<p>&nbsp;</p>
<p>&nbsp; </p>
 <?php } ?>
  <?php include("top_.php");?> 