<?php
if(isset($_REQUEST['retornar']))
{   //$pg=$_REQUEST['pg'];
		header("location: lista.php?pg=$pg&Naveg=Ordenes%20de%20Trabajo");

}
include("top.php");
?>
<table width="70%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
  <tr> 
  <?php
	include("conexion.php");
        $id_orden=$_REQUEST['id_orden'];
  	$sql="SELECT * FROM ordenes WHERE id_orden='$id_orden'";
	$res=mysql_db_query($db,$sql,$link);
	$row=mysql_fetch_array($res);
  ?>
    <th colspan="7" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
      ORDEN No. 
      <?php=$id_orden?>
      </font></th>
  </tr>
  <tr> 
    <td colspan="3">
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php=$row['desc_inc']?>
	<br><br>
	</td>
  </tr>
  <tr> 
    <th colspan="8" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
      ARCHIVOS ADJUNTOS</font></th>
  </tr>
  <tr> 
    <th width="20%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Archivo</font></th>
    <th width="32%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">MD5</font></th>
	<th width="48%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Observaciones</font></th>
  </tr>
<?php
$adj=explode("|",$row['nomb_archivo']);
$adj_hash=explode("|",$row['hash_archivo']);
$adj_obs=explode("|",$row['observaciones']);
$i=0;
foreach($adj as $valor){
	echo "<tr><td align=\"center\"><a href=\"Archivos Adjuntos/".$valor."\" target=\"_blank\">$valor</a></td><td>&nbsp;$adj_hash[$i]</td><td>&nbsp;$adj_obs[$i]</td></tr>";
	$i++;
}
?>
</table>
<form name="form1" method="post" action="">
<input name="tipificacion" type="hidden" value="<?php=$tipificacion?>">
<input name="pg" type="hidden" value="<?php=$pg?>">
<br \>
  <div align="center">
    <input name="retornar" type="submit" id="retornar" value="RETORNAR">
  </div>
</form>
<p>&nbsp;</p>
<?php
include("top_.php");
?>